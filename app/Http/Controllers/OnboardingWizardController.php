<?php
namespace App\Http\Controllers;

use App\Apartment;
use App\House;
use App\Landlord;
use App\Tenant;
use Illuminate\Support\Facades\DB;

class OnboardingWizardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orgId = config('app.org_id', 1);

        $steps = [
            1 => [
                'title' => 'Add Property Owner',
                'description' => 'Register the property owner/landlord',
                'icon' => 'fe fe-user-check',
                'route' => 'landlord.create',
                'section' => 'property',
                'completed' => Landlord::where('org_id', $orgId)->count() > 0,
                'count' => Landlord::where('org_id', $orgId)->count(),
            ],
            2 => [
                'title' => 'Add Property',
                'description' => 'Add the apartment/building details',
                'icon' => 'fe fe-home',
                'route' => 'apartment.create',
                'section' => 'property',
                'completed' => Apartment::where('org_id', $orgId)->count() > 0,
                'count' => Apartment::where('org_id', $orgId)->count(),
            ],
            3 => [
                'title' => 'Add Units',
                'description' => 'Add individual units/houses to the property',
                'icon' => 'fe fe-grid',
                'route' => 'apartment.add_unit',
                'section' => 'property',
                'completed' => House::whereHas('apartment', fn($q) => $q->where('org_id', $orgId))->count() > 0,
                'count' => House::whereHas('apartment', fn($q) => $q->where('org_id', $orgId))->count(),
            ],
            4 => [
                'title' => 'Add Tenant Details',
                'description' => 'Register the tenant information',
                'icon' => 'fe fe-user-plus',
                'route' => 'tenant.create',
                'section' => 'tenant',
                'completed' => Tenant::where('org_id', $orgId)->count() > 0,
                'count' => Tenant::where('org_id', $orgId)->count(),
            ],
            5 => [
                'title' => 'Assign Tenant to Unit',
                'description' => 'Place the tenant in their unit',
                'icon' => 'fe fe-link',
                'route' => 'tenant.assign_room',
                'section' => 'tenant',
                'completed' => DB::table('house_tenants')->where('org_id', $orgId)->count() > 0,
                'count' => DB::table('house_tenants')->where('org_id', $orgId)->count(),
            ],
        ];

        $completedSteps = collect($steps)->filter(fn($s) => $s['completed'])->count();
        $totalSteps = count($steps);
        $progressPercent = round(($completedSteps / $totalSteps) * 100);
        $nextStep = collect($steps)->first(fn($s) => !$s['completed']);

        return view('onboarding.wizard', compact(
            'steps', 'completedSteps', 'totalSteps', 'progressPercent', 'nextStep'
        ));
    }
}
