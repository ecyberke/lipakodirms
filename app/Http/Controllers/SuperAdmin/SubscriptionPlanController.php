<?php
namespace App\Http\Controllers\SuperAdmin;

use App\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends SuperAdminController
{
    public function index()
    {
        $plans = SubscriptionPlan::all();
        return view('super_admin.plans.index', compact('plans'));
    }

    public function update(Request $request, $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->update($request->validate([
            'name' => 'required|string',
            'units_min' => 'required|integer',
            'units_max' => 'nullable|integer',
            'price_per_unit' => 'required|numeric',
            'is_active' => 'boolean',
        ]));
        return back()->with('success', 'Plan updated');
    }
}
