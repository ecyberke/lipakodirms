<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\Invoice;
use App\Landlord;
use App\PlacementFee;
use DB;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function companyIncome()
    {
        return view('reports.companyincome');
    }

    public function getAllIncomes(Request $request)
    {

        if ($request->ajax()) {
            $month = $request->month . '-' . $request->year;

            $placementfees = PlacementFee::selectRaw('SUM(amount) as smnt,apartment_id')
                ->where('placement_month', $month)
                ->groupBy('apartment_id')
                ->get();

            $rents = Invoice::selectRaw('SUM(paid_in) as rent_paid,apartment_id')
                ->paid()
                ->where('rent_month', $month)
                ->groupBy('apartment_id')
                ->get();

            $total_placement_fee = PlacementFee::where('placement_month', $month)->sum('amount');
            $total_rent = Invoice::where('rent_month', $month)->paid()->sum('paid_in');

            $company_placement = $total_placement_fee / 2;
            // $total_placement_fee = PlacementFee::selectRaw('SUM(amount) as smnt')
            //     ->where('placement_month', $month)
            //     ->get();

            $rents = view('partials.table_rent', compact('rents'))->render();

            $placements = view('partials.table_placement', compact('placementfees'))->render();

            return response()->json([
                'total_placement' => number_format($total_placement_fee),
                'company_placement' => number_format($company_placement),
                'total_rent' => number_format($total_rent),
                'placement_view' => $placements,
                'rent_view' => $rents,
            ]);

        }

    }

    public function landlordIncome()
    {

        $landlords = Landlord::pluck('id', 'full_name');
        return view('reports.landlordincome', compact('landlords'));
    }

    public function computeLandlordIncome(Request $request)
    {

        $landlord_placement = 0;

        if ($request->ajax()) {
            $month = $request->month . '-' . $request->year;
            $landlord_id = $request->landlord_id;

            //get total deposits for apartments owned by specified landlord
            $net_deposit = Deposit::selectRaw('SUM(amount) as totals')
                ->where('start_month', $month)
                ->whereIn('apartment_id', function ($query) use ($landlord_id) {
                    $query->select('id')
                        ->from('apartments')
                        ->where('apartments.landlord_id', $landlord_id);
                })
                ->get();
            //get deposit from array
            $landlord_deposit = (isset($net_deposit[0]->totals)) ? $net_deposit[0]->totals : 0.00;

            // Get total placements fees to for apartments owned by specified landlord

            $net_placement_fee = Placementfee::selectRaw('SUM(amount) as totals')
                ->where('placement_month', $month)
                ->whereIn('apartment_id', function ($query) use ($landlord_id) {
                    $query->select('id')
                        ->from('apartments')
                        ->where('apartments.landlord_id', $landlord_id);
                })
                ->get();
              
            //get placement from array
            $landlord_placement = (isset($net_placement_fee[0]->totals)) ? $net_placement_fee[0]->totals / 2 : 0.00;

            $rents = Invoice::selectRaw('SUM(paid_in) as rent_paid,apartment_id')
                ->paid()
                ->where('rent_month', $month)
                ->groupBy('apartment_id')
                ->whereIn('apartment_id', function ($query) use ($landlord_id) {
                    $query->select('id')
                        ->from('apartments')
                        ->where('apartments.landlord_id', $landlord_id);

                })
                ->get();

            $landlord_rents = view('partials.landlord_rent', compact('rents'))->render();

            return response()->json([
                'rent_collections' => $landlord_rents,
                'landlord_deposits' => number_format($landlord_deposit),
                'landlord_placements' => number_format($landlord_placement),

            ]);

        }

    }

}
