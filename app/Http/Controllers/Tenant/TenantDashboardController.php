<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\ServiceRequests;
use App\Tenant;
use App\HouseTenant;
use App\ManualPayment;
use App\ManagerPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TenantDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:tenant');
    }

    public function index()
    {
        $tenantUser = Auth::guard('tenant')->user();
        $org = config('app.organization');
        $tenant = Tenant::where('account_number', $tenantUser->account_number)
            ->where('org_id', config('app.org_id', 1))->first();

        if (!$tenant) {
            return view('tenant.dashboard', compact('tenantUser', 'org'))
                ->with('error', 'Tenant profile not found');
        }

        // Current invoice
        $currentMonth = Carbon::now()->format('M-Y');
        $currentInvoice = Invoice::where('tenant_id', $tenant->account_number)
            ->where('rent_month', $currentMonth)->first();

        // All unpaid invoices
        $unpaidInvoices = Invoice::where('tenant_id', $tenant->account_number)
            ->where('balance', '>', 0)->latest()->get();

        // Recent payments
        $recentPayments = ManagerPayment::where('InvoiceNumber', $tenant->account_number)
            ->latest()->take(5)->get();

        // Total balance
        $totalBalance = Invoice::where('tenant_id', $tenant->account_number)
            ->sum('balance');

        // House assignment
        $assignment = HouseTenant::where('tenant_id', $tenant->account_number)
            ->with('house.apartment')->latest()->first();

        // Service requests
        $serviceRequests = ServiceRequests::where('tenant_id', $tenant->account_number)
            ->latest()->take(5)->get();

        return view('tenant.dashboard', compact(
            'tenantUser', 'org', 'tenant', 'currentInvoice',
            'unpaidInvoices', 'recentPayments', 'totalBalance',
            'assignment', 'serviceRequests'
        ));
    }

    public function invoices()
    {
        $tenantUser = Auth::guard('tenant')->user();
        $tenant = Tenant::where('account_number', $tenantUser->account_number)->first();
        $invoices = Invoice::where('tenant_id', $tenant->account_number ?? '')
            ->latest()->paginate(20);
        $org = config('app.organization');
        return view('tenant.invoices', compact('invoices', 'tenant', 'org'));
    }

    public function serviceRequests()
    {
        $tenantUser = Auth::guard('tenant')->user();
        $tenant = Tenant::where('account_number', $tenantUser->account_number)->first();
        $requests = ServiceRequests::where('tenant_id', $tenant->account_number ?? '')
            ->latest()->paginate(20);
        $org = config('app.organization');
        return view('tenant.service_requests', compact('requests', 'tenant', 'org'));
    }

    public function submitServiceRequest(Request $request)
    {
        $request->validate([
            'request_type' => 'required|string',
            'description' => 'required|string|min:10',
        ]);

        $tenantUser = Auth::guard('tenant')->user();
        $tenant = Tenant::where('account_number', $tenantUser->account_number)->first();
        $assignment = HouseTenant::where('tenant_id', $tenant->account_number)->latest()->first();

        ServiceRequests::create([
            'org_id' => config('app.org_id', 1),
            'tenant_id' => $tenant->account_number,
            'house_id' => $assignment?->house_id,
            'apartment_id' => $assignment?->house?->apartment_id,
            'request_type' => $request->request_type,
            'description' => $request->description,
            'approval' => 0,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Service request submitted successfully. We will get back to you shortly.');
    }

    public function submitNotice(Request $request)
    {
        $request->validate([
            'vacating_date' => 'required|date|after:today',
            'reason' => 'required|string|min:10',
        ]);

        $tenantUser = Auth::guard('tenant')->user();
        $tenant = Tenant::where('account_number', $tenantUser->account_number)->first();
        $assignment = HouseTenant::where('tenant_id', $tenant->account_number)->latest()->first();

        ServiceRequests::create([
            'org_id' => config('app.org_id', 1),
            'tenant_id' => $tenant->account_number,
            'house_id' => $assignment?->house_id,
            'apartment_id' => $assignment?->house?->apartment_id,
            'request_type' => 'Vacating Notice',
            'description' => "Vacating Date: {$request->vacating_date}\nReason: {$request->reason}",
            'approval' => 0,
            'status' => 'notice',
        ]);

        return back()->with('success', 'Vacating notice submitted. The management will be in touch.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $tenantUser = Auth::guard('tenant')->user();

        if (!Hash::check($request->current_password, $tenantUser->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $tenantUser->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password changed successfully');
    }
}
