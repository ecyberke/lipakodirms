<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Organization;
use App\Subscription;
use App\SubscriptionPlan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends SuperAdminController
{
    public function index()
    {
        $organizations = Organization::withTrashed()->latest()->paginate(20);
        $stats = [
            'total' => Organization::count(),
            'active' => Organization::where('status', 'active')->count(),
            'suspended' => Organization::where('status', 'suspended')->count(),
            'pending' => Organization::where('status', 'pending')->count(),
            'monthly_revenue' => $this->calculateMonthlyRevenue(),
        ];
        return view('super_admin.organizations.index', compact('organizations', 'stats'));
    }

    public function create()
    {
        $plans = SubscriptionPlan::where('is_active', true)->get();
        return view('super_admin.organizations.create', compact('plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:50|unique:organizations|alpha_dash',
            'type' => 'required|in:agency,individual',
            'phone' => 'required|string',
            'email' => 'required|email',
            'total_units' => 'required|integer|min:1',
            'admin_name' => 'required|string',
            'admin_email' => 'required|email',
            'admin_password' => 'required|min:8',
        ]);

        // Create organization
        $org = Organization::create([
            'name' => $request->name,
            'slug' => strtolower($request->slug),
            'type' => $request->type,
            'contact_person' => $request->contact_person,
            'phone' => $request->phone,
            'email' => $request->email,
            'kra_pin' => $request->kra_pin,
            'county' => $request->county,
            'town' => $request->town,
            'total_units' => $request->total_units,
            'currency' => $request->currency ?? 'KES',
            'status' => 'active',
            'currency_set' => false,
        ]);

        // Create admin user for this organization
        User::create([
            'org_id' => $org->id,
            'name' => $request->admin_name,
            'username' => strtolower(str_replace(' ', '', $request->admin_name)),
            'email' => $request->admin_email,
            'password' => Hash::make($request->admin_password),
            'is_admin' => 1,
            'is_super' => 0,
        ]);

        // Create initial subscription
        $this->createSubscription($org, $request->billing_cycle ?? 'monthly');

        return redirect()->route('super.organizations.index')
            ->with('success', "Organization {$org->name} created successfully. Subdomain: {$org->slug}.lipakodi.co.ke");
    }

    public function show($id)
    {
        $org = Organization::findOrFail($id);
        $subscriptions = Subscription::where('organization_id', $id)->latest()->get();
        $users = User::where('org_id', $id)->get();
        $plan = SubscriptionPlan::where('units_min', '<=', $org->total_units)
            ->where(function($q) use ($org) {
                $q->where('units_max', '>=', $org->total_units)->orWhereNull('units_max');
            })->first();
        return view('super_admin.organizations.show', compact('org', 'subscriptions', 'users', 'plan'));
    }

    public function edit($id)
    {
        $org = Organization::findOrFail($id);
        $plans = SubscriptionPlan::where('is_active', true)->get();
        return view('super_admin.organizations.edit', compact('org', 'plans'));
    }

    public function update(Request $request, $id)
    {
        $org = Organization::findOrFail($id);
        $org->update($request->except(['_token', '_method', 'admin_password']));

        if ($request->filled('admin_password')) {
            User::where('org_id', $id)->where('is_admin', 1)->first()
                ?->update(['password' => Hash::make($request->admin_password)]);
        }

        return redirect()->route('super.organizations.show', $id)
            ->with('success', 'Organization updated successfully');
    }

    public function suspend($id)
    {
        $org = Organization::findOrFail($id);
        $org->update(['status' => 'suspended']);
        $sub = $org->subscription;
        if ($sub) {
            $graceDays = $sub->getGraceDays();
            $sub->update([
                'status' => 'grace',
                'grace_ends_at' => now()->addDays($graceDays)
            ]);
        }
        return back()->with('success', 'Organization suspended with grace period');
    }

    public function activate($id)
    {
        $org = Organization::findOrFail($id);
        $org->update(['status' => 'active']);
        $org->subscription?->update(['status' => 'active', 'grace_ends_at' => null]);
        return back()->with('success', 'Organization activated');
    }

    public function impersonate($id)
    {
        $org = Organization::findOrFail($id);
        $adminUser = User::where('org_id', $id)->where('is_admin', 1)->first();
        if (!$adminUser) {
            return back()->with('error', 'No admin user found for this organization');
        }
        // Store super admin session
        session(['impersonating_org' => $id, 'super_admin_id' => Auth::id()]);
        Auth::login($adminUser);
        return redirect("http://{$org->slug}.lipakodi.ecyber.co.ke/")
            ->with('success', "Logged in as {$org->name}");
    }

    public function stopImpersonating()
    {
        $superAdminId = session('super_admin_id');
        session()->forget(['impersonating_org', 'super_admin_id']);
        $superAdmin = User::find($superAdminId);
        if ($superAdmin) Auth::login($superAdmin);
        return redirect()->route('super.dashboard');
    }

    private function createSubscription($org, $cycle)
    {
        $plan = SubscriptionPlan::where('units_min', '<=', $org->total_units)
            ->where(function($q) use ($org) {
                $q->where('units_max', '>=', $org->total_units)->orWhereNull('units_max');
            })->first();

        if (!$plan) return;

        $months = match($cycle) {
            'monthly' => 1, 'quarterly' => 3,
            'half_yearly' => 6, 'annual' => 12,
        };

        $amount = $plan->price_per_unit * $org->total_units * $months;
        // Apply discount for longer cycles
        $discount = match($cycle) {
            'quarterly' => 0.05, 'half_yearly' => 0.08, 'annual' => 0.12,
            default => 0
        };
        $amount = $amount * (1 - $discount);

        Subscription::create([
            'organization_id' => $org->id,
            'subscription_plan_id' => $plan->id,
            'billing_cycle' => $cycle,
            'amount' => $amount,
            'units' => $org->total_units,
            'starts_at' => now(),
            'ends_at' => now()->addMonths($months),
            'status' => 'active',
        ]);
    }

    private function calculateMonthlyRevenue()
    {
        return Subscription::where('status', 'active')
            ->whereMonth('ends_at', '>=', now()->month)
            ->get()
            ->sum(function($sub) {
                $months = match($sub->billing_cycle) {
                    'monthly' => 1, 'quarterly' => 3,
                    'half_yearly' => 6, 'annual' => 12, default => 1
                };
                return $sub->amount / $months;
            });
    }
}
