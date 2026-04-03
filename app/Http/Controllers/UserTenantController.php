<?php

namespace App\Http\Controllers;

use App\Deposit;
use App\HouseTenant;
use App\Overpayment;
use App\PlacementFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTenantController extends Controller
{

      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:tenant');
    }


    public function index()
    {

        $tenant = Auth::guard('tenant')->user();
        $id=$tenant->id;
        $houzez = HouseTenant::where('tenant_id', $id)->get();
        $overpayment = 0;
        $overpayment = Overpayment::where('tenant_id', $id)->value('amount');

        $deposits = Deposit::where('tenant_id', $id)->get();
        $placements = PlacementFee::where('tenant_id', $id)->get();

        return view('users.tenant.index', compact('tenant', 'houzez', 'overpayment', 'deposits', 'placements'));
    }
}
