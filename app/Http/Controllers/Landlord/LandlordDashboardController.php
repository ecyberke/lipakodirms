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

        // Houses on notice
        $onNoticeList = House::whereIn('apartment_id', $apartmentIds)
            ->where('on_notice', 1)->with('apartment')->get();

        // Recent remittances
        $recentRemittances = PayOwners::whereIn('apartment_id', $apartmentIds)
            ->where('bill_type', 'remittence')->latest()->take(5)->get();

        return view('landlord.dashboard', compact(
            'landlordUser', 'org', 'landlord', 'apartments',
            'totalHouses', 'occupiedHouses', 'vacantHouses', 'onNoticeHouses',
            'monthlyIncome', 'totalArrears', 'serviceRequests', 'recentPayments',
            'onNoticeList', 'recentRemittances'
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
        $apartments = Apartment::where('landlord_id', $landlord->id ?? 0)->get();
        $apartmentIds = $apartments->pluck('id');

        $hasReport = request()->has('generate') && request('owner_id');
        $payments = collect();
        $selectedApartment = null;

        if ($hasReport) {
            $selectedApartment = Apartment::find(request('owner_id'));
            $query = PayOwners::where('apartment_id', request('owner_id'));
            if (request('from')) $query->where('created_at', '>=', request('from'));
            if (request('to')) $query->where('created_at', '<=', request('to') . ' 23:59:59');
            $payments = $query->with('house')->latest()->get();
        }

        return view('landlord.statements', compact('apartments', 'payments', 'landlord', 'org', 'hasReport', 'selectedApartment'));
    }

    public function maintenanceReport()
    {
        $landlordUser = Auth::guard('landlord')->user();
        $org = config('app.organization');
        $orgId = config('app.org_id', 1);
        $landlord = Landlord::where('account_number', $landlordUser->account_number)->where('org_id', $orgId)->first();
        $apartments = Apartment::where('landlord_id', $landlord->id ?? 0)->get();
        $apartmentIds = $apartments->pluck('id');

        $hasMaintenanceReport = request()->has('generate') && request('apartment_id');
        $maintenanceRequests = collect();
        $selectedApartment = null;

        if ($hasMaintenanceReport) {
            $selectedApartment = Apartment::find(request('apartment_id'));
            $query = ServiceRequests::where('apartment_id', request('apartment_id'))->with('house');
            if (request('rent_month')) {
                $month = request('rent_month');
                $query->whereYear('created_at', substr($month, 0, 4))
                      ->whereMonth('created_at', substr($month, 5, 2));
            }
            $maintenanceRequests = $query->latest()->get();
        }

        return view('landlord.maintenance_report', compact(
            'apartments', 'maintenanceRequests', 'landlord', 'org',
            'hasMaintenanceReport', 'selectedApartment'
        ));
    }

    public function remittance()
    {
        $landlordUser = Auth::guard('landlord')->user();
        $org = config('app.organization');
        $orgId = config('app.org_id', 1);
        $landlord = Landlord::where('account_number', $landlordUser->account_number)->where('org_id', $orgId)->first();
        $apartments = Apartment::where('landlord_id', $landlord->id ?? 0)->get();
        $apartmentIds = $apartments->pluck('id');

        $remittances = PayOwners::whereIn('apartment_id', $apartmentIds)
            ->where('bill_type', 'remittence')
            ->with('apartment')->latest()->get();

        return view('landlord.remittance', compact('remittances', 'landlord', 'org', 'apartments'));
    }

    public function propertyStatus(\Illuminate\Http\Request $request)
    {
        $landlordUser = Auth::guard('landlord')->user();
        $org = config('app.organization');
        $orgId = config('app.org_id', 1);
        $landlord = Landlord::where('account_number', $landlordUser->account_number)->where('org_id', $orgId)->first();
        $apartments = Apartment::where('landlord_id', $landlord->id ?? 0)->with('houses.house_tenant')->get();

        $hasReport = false;
        $entries = [];
        $totals = [];
        $rent_month = null;
        $selectedApartment = null;

        if ($request->has('generate') && $request->apartment_id && $request->rent_month) {
            $rent_month = date("M-Y", strtotime($request->rent_month));
            $selectedApartment = Apartment::find($request->apartment_id);

            // Verify apartment belongs to this landlord
            if ($selectedApartment && $selectedApartment->landlord_id == $landlord->id) {
                $month_invoices = \App\Invoice::with('tenant', 'house')
                    ->where('rent_month', $rent_month)
                    ->where('type', '!=', 'House Viewing')
                    ->where('apartment_id', $request->apartment_id)
                    ->get()->sortBy('house_id');

                if ($month_invoices->isNotEmpty()) {
                    $hasReport = true;
                    $total_rent = 0; $total_payable = 0; $total_paid_in = 0;
                    $total_carryforward = 0;

                    foreach ($month_invoices as $invoice) {
                        $all_invs = \App\Invoice::where('tenant_id', $invoice->tenant_id)
                            ->where('type', '!=', 'House Viewing')
                            ->where('house_id', $invoice->house_id)->get();
                        $all_invs = $all_invs->filter(fn($v) => strtotime($v->rent_month) <= strtotime($rent_month));
                        $prev_invs = $all_invs->filter(fn($v) => strtotime($v->rent_month) < strtotime($rent_month));

                        $deposit = \App\Deposit::where('tenant_id', $invoice->tenant_id)
                            ->where('house_id', $invoice->house_id)->sum('deposit_paid');

                        $total_payable_val = $invoice->balance + $prev_invs->sum('balance');
                        $balance_val = $all_invs->sum('balance');

                        $entries[] = [
                            'tenant' => [
                                'account_number' => $invoice->tenant->account_number ?? 'N/A',
                                'phone' => $invoice->tenant->phone ?? 'N/A',
                                'full_name' => $invoice->tenant->full_name ?? 'N/A',
                            ],
                            'house' => ['house_no' => $invoice->house->house_no ?? 'N/A'],
                            'rent' => $invoice->rent ?? 0,
                            'total_payable' => $total_payable_val,
                            'paid_in' => $invoice->paid_in ?? 0,
                            'deposit_paid' => $deposit,
                            'balance' => $balance_val,
                        ];

                        $total_rent += $invoice->rent ?? 0;
                        $total_payable += $total_payable_val;
                        $total_paid_in += $invoice->paid_in ?? 0;
                        $total_carryforward += $deposit;
                    }

                    $totals = compact('total_rent', 'total_payable', 'total_paid_in', 'total_carryforward');
                } else {
                    return redirect()->route('landlord.property-status')
                        ->with('error', 'No invoices found for the selected property and month.');
                }
            }
        }

        return view('landlord.property_status', compact(
            'apartments', 'landlord', 'org', 'hasReport',
            'entries', 'totals', 'rent_month', 'selectedApartment'
        ));
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
