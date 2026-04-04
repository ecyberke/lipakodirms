<?php
namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Landlord;
use App\Apartment;
use App\House;
use App\Invoice;
use App\PayOwners;
use App\ServiceRequests;
use App\Tenant;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LandlordDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:landlord');
    }

    public function index()
    {
        $landlordUser = Auth::guard('landlord')->user();
        $org = config('app.organization');
        $orgId = config('app.org_id', 1);

        $landlord = Landlord::where('account_number', $landlordUser->account_number)
            ->where('org_id', $orgId)->first();

        if (!$landlord) {
            return view('landlord.dashboard', compact('landlordUser', 'org'));
        }

        // Properties
        $apartments = Apartment::where('landlord_id', $landlord->id)
            ->where('org_id', $orgId)->get();
        $apartmentIds = $apartments->pluck('id');

        // House stats
        $totalHouses = House::whereIn('apartment_id', $apartmentIds)->count();
        $occupiedHouses = House::whereIn('apartment_id', $apartmentIds)->where('is_occupied', 1)->count();
        $vacantHouses = House::whereIn('apartment_id', $apartmentIds)->where('is_occupied', 0)->count();
        $onNoticeHouses = House::whereIn('apartment_id', $apartmentIds)->where('on_notice', 1)->count();

        // Income this month
        $currentMonth = Carbon::now()->format('M-Y');
        $monthlyIncome = PayOwners::whereIn('apartment_id', $apartmentIds)
            ->where('rent_month', $currentMonth)
            ->where('bill_type', 'rent')
            ->sum('paid_in');

        // Total arrears
        $tenantAccounts = Tenant::whereIn('apartment_id', $apartmentIds)->pluck('account_number');
        $totalArrears = Invoice::whereIn('tenant_id', $tenantAccounts)->sum('balance');

        // Recent service requests
        $serviceRequests = ServiceRequests::whereIn('apartment_id', $apartmentIds)
            ->latest()->take(5)->get();

        // Recent payments
        $recentPayments = PayOwners::whereIn('apartment_id', $apartmentIds)
            ->latest()->take(5)->get();

        return view('landlord.dashboard', compact(
            'landlordUser', 'org', 'landlord', 'apartments',
            'totalHouses', 'occupiedHouses', 'vacantHouses', 'onNoticeHouses',
            'monthlyIncome', 'totalArrears', 'serviceRequests', 'recentPayments'
        ));
    }

    public function properties()
    {
        $landlordUser = Auth::guard('landlord')->user();
        $org = config('app.organization');
        $orgId = config('app.org_id', 1);
        $landlord = Landlord::where('account_number', $landlordUser->account_number)->where('org_id', $orgId)->first();
        $apartments = Apartment::where('landlord_id', $landlord->id ?? 0)
            ->with('houses')->get();
        return view('landlord.properties', compact('apartments', 'landlord', 'org'));
    }

    public function statements()
    {
        $landlordUser = Auth::guard('landlord')->user();
        $org = config('app.organization');
        $orgId = config('app.org_id', 1);
        $landlord = Landlord::where('account_number', $landlordUser->account_number)->where('org_id', $orgId)->first();
        $apartments = Apartment::where('landlord_id', $landlord->id ?? 0)->pluck('id');
        $payments = PayOwners::whereIn('apartment_id', $apartments)
            ->latest()->paginate(20);
        return view('landlord.statements', compact('payments', 'landlord', 'org'));
    }

    public function serviceRequests()
    {
        $landlordUser = Auth::guard('landlord')->user();
        $org = config('app.organization');
        $orgId = config('app.org_id', 1);
        $landlord = Landlord::where('account_number', $landlordUser->account_number)->where('org_id', $orgId)->first();
        $apartments = Apartment::where('landlord_id', $landlord->id ?? 0)->pluck('id');
        $requests = ServiceRequests::whereIn('apartment_id', $apartments)->latest()->paginate(20);
        return view('landlord.service_requests', compact('requests', 'landlord', 'org'));
    }
}
