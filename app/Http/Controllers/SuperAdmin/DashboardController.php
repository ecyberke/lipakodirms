<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Organization;
use App\Subscription;
use App\SubscriptionPlan;
use App\User;

class DashboardController extends SuperAdminController
{
    public function index()
    {
        $stats = [
            'total_orgs' => Organization::count(),
            'active_orgs' => Organization::where('status', 'active')->count(),
            'suspended_orgs' => Organization::where('status', 'suspended')->count(),
            'pending_orgs' => Organization::where('status', 'pending')->count(),
            'total_units' => Organization::where('status', 'active')->sum('total_units'),
            'monthly_revenue' => $this->monthlyRevenue(),
            'annual_revenue' => $this->monthlyRevenue() * 12,
        ];

        $recent_orgs = Organization::latest()->take(10)->get();
        $expiring_soon = Subscription::where('status', 'active')
            ->whereBetween('ends_at', [now(), now()->addDays(14)])
            ->with('organization')
            ->get();
        $plans = SubscriptionPlan::all();

        return view('super_admin.dashboard', compact('stats', 'recent_orgs', 'expiring_soon', 'plans'));
    }

    private function monthlyRevenue()
    {
        return Subscription::where('status', 'active')->get()
            ->sum(function($sub) {
                $months = match($sub->billing_cycle) {
                    'monthly' => 1, 'quarterly' => 3,
                    'half_yearly' => 6, 'annual' => 12, default => 1
                };
                return $sub->amount / $months;
            });
    }
}
