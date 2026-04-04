<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\ManualPayment;
use App\MonthlyBilling;
use App\Overpayment;
use App\PayOwners;
use App\Landlord;
use App\Onboarding;
use App\Tenant;
use App\Apartment;
use App\Traits\DocTrait;
use App\Traits\UtilTrait;
use Illuminate\Http\Request;
use PDF;
use DB;
use Carbon\Carbon;

class DocController extends Controller
{
    use UtilTrait;
    use DocTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function tenant_statement(Request $request)
    {

        $fields = $request->validate([
            'tenant_id' => 'required',
            'from' => 'nullable',
            'to' => 'nullable',
            'download'=>'nullable',
        ]);
        $dates = [];
        if ($request->from) {
            $dates = [
                'from' => $fields['from'],
                'to' => $fields['to'],
            ];
        }
        if ($request->download) {
            $download ='yes';
        }else{
            $download='no';
        }
        
        $info = $this->getTenantData($fields['tenant_id'], $dates);
        //return response()->json($info);
        $tnt = Tenant::where('id',$request->tenant_id)->first();
        $date_of_statement = date('jS M Y');
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Tenant Statement Generated',
            'more_info' => 'Tenant Name: ' .  $tnt->full_name,
             'tenant_id' => $request->tenant_id,
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
        ]);
 
        
        return $this->viewTester($info,$download);
        return response()->json($info);
    }

    public function testInvoice(Request $request)
    {
        $invoices = Invoice::all();
        $manual_invoices = PayOwners::all();

        $main_array = [];

        foreach ($invoices as $inv) {
            array_push($main_array, [
                'id' => $inv->id,
                'table_type' => 'invoices',
                'amount' => $inv->balance,
                'amount_type' => 'rent',
            ]);
        }

        foreach ($manual_invoices as $inv) {
            array_push($main_array, [
                'id' => $inv->id,
                'table_type' => 'manual_invoices',
                'amount' => $inv->balance,
                'amount_type' => 'deposit',
            ]);
        }
        return response()->json($main_array);
    }
    public function property_owner_statement(Request $request)
    {

        $fields = $request->validate([
            'owner_id' => 'required',
            'from' => 'nullable',
            'to' => 'nullable',
            'download'=>'nullable'
        ]);
        $dates = [];
        if ($request->from) {
            $dates = [
                'from' => $fields['from'],
                'to' => $fields['to'],
            ];
        }
        
        if ($request->download) {
            $download ='yes';
        }else{
            $download='no';
        }
        
        $info = $this->getPropertyOwnerData($fields['owner_id'], $dates);

        //return response()->json($info); 
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Property Owner Statement Generated',
            'more_info' => 'Owner Phone: ' . $request->owner_id,
            'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => $request->owner_id,
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
        ]);
         
        return $this->propertyOwnerViewTester($info, $download);
        return response()->json($info);
        // $date_of_statement = date('jS M Y');
    }
    public function agency_statement(Request $request)
    {

        $fields = $request->validate([
            'from' => 'nullable',
            'to' => 'nullable',
            'download'=>'nullable',
        ]);
        $dates = [];
        if ($request->from) {
            $dates = [
                'from' => $fields['from'],
                'to' => $fields['to'],
            ];
        }
        if ($request->download) {
            $download ='yes';
        }else{
            $download='no';
        }
        $info = $this->getAgencyData($dates);

        // $date_of_statement = date('jS M Y');
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Agency Statement Generated',
            'more_info' => 'General Agency Statement',
            'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
        ]);

        
        return $this->agencyStatementViewTester($info,$download);
        return response()->json($info);
    }
  public function property_status_report(Request $request)
{
    $fields = $request->validate([
        'rent_month' => 'required',
        'apartment_id' => 'required'
    ]);

    $rent_month = date("M-Y", strtotime($fields['rent_month']));
    $previous_rent_month = date("M-Y", strtotime('-1 month', strtotime($fields['rent_month'])));

    // Fetch invoices for the current and previous month
    $month_invoices = Invoice::with('tenant', 'house')
        ->where('rent_month', $rent_month)
        ->where('type', '!=', 'House Viewing')
        ->where('apartment_id', $fields['apartment_id'])
        ->get()
        ->sortBy('house_id');

    $previous_month_invoices = Invoice::with('tenant', 'house')
        ->where('rent_month', '<=', $previous_rent_month)
        ->where('type', '!=', 'House Viewing')
        ->where('apartment_id', $fields['apartment_id'])
        ->get()
        ->sortBy('house_id');
     $aprt = Apartment::where('id', $fields['apartment_id'])->first();
    // Check if there are any invoices for the month
    if ($month_invoices->isEmpty()) {
        
         $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $hasReport = false;
        $message = 'INACTIVE PROPERTY! No invoice found for ' . $aprt->name . ' in the month of ' . $rent_month;
      return view('report.property_status', compact('message','tenants', 'apartments','hasReport'));
       
    }

    // Fetch property info if there's at least one invoice
    $property_info = Apartment::with('landlord')->where('id', $fields['apartment_id'])->first();
    // if (!$property_info) {
    //      return back()->with('error', 'No Apartment in the month chosen.');
       
    // }

    // Process each invoice
    foreach ($month_invoices as $invoice) {
        $prev_arrears = Invoice::where('tenant_id', $invoice->tenant_id)
            ->where('rent_month', '!=', $rent_month)->where('house_id', $invoice->house_id)
            ->sum('total_payable');

        $all_invs = Invoice::where('tenant_id', $invoice->tenant_id)
            ->where('type', '!=', 'House Viewing')->where('house_id', $invoice->house_id)
            ->get();

        $total_current_month = Invoice::where('tenant_id', $invoice->tenant_id)
            ->where('rent_month', $rent_month)->where('house_id', $invoice->house_id)
            ->where('type', '!=', 'House Viewing')
            ->sum('balance');

        // Filter invoices for previous months
        $all_invs = $all_invs->filter(function ($value) use ($rent_month) {
            return strtotime($value['rent_month']) <= strtotime($rent_month);
        });

        $prev_invs = $all_invs->filter(function ($value) use ($rent_month) {
            return strtotime($value['rent_month']) < strtotime($rent_month);
        });

        $invoice['total_payable'] = $total_current_month + $prev_invs->sum('balance');
        $invoice['balance'] = $all_invs->sum('balance');
    }

    // Calculate totals
    $total_paid_in = $month_invoices->sum('paid_in');
    $total_rent = $month_invoices->sum('rent');
    $total_payable = $month_invoices->sum('total_payable');
    $total_carryforward = $month_invoices->sum('deposit_paid');
    $total_balance = $total_payable - $total_paid_in;
    $total_bills = $month_invoices->sum('electricity_bill') +
                   $month_invoices->sum('litter_bill') +
                   $month_invoices->sum('water_bill') +
                   $month_invoices->sum('security') +
                   $month_invoices->sum('compound_bill') +
                   $month_invoices->sum('other_bill');

    $property_name = $property_info->name;
    $property_owner = $property_info->landlord->full_name;
    $message = '';

    $filled = 'yes';
    $download = 'no';
    if ($request->download) {
        $download = 'yes';
        if ($request->filled === 'no') {
            $filled = 'no';
        }
    }

    $info = [
        'entries' => $month_invoices,
        'rent_month' => $rent_month,
        'total_paid_in' => $total_paid_in,
        'total_rent' => $total_rent,
        'total_bills' => $total_bills,
        'total_payable' => $total_payable,
        'total_carryforward' => $total_carryforward,
        'total_balance' => $total_balance,
        'property_owner' => $property_owner,
        'property_name' => $property_name,
        'message' => $message,
    ];

    return $this->propertyStatusViewTester($info, $download, $filled);
}

  public function property_income_expense_report(Request $request)
{
    $fields = $request->validate([
        'rent_month' => 'required',
        'apartment_id' => 'required'
    ]);

    $rent_month = date("M-Y", strtotime($fields['rent_month']));
    $previous_rent_month = date("M-Y", strtotime('-1 month', strtotime($fields['rent_month'])));

    // Fetch invoices for the current and previous month
    $month_invoices = Invoice::with('tenant', 'house')
        ->where('rent_month', $rent_month)
        ->where('type', '!=', 'House Viewing')
        ->where('apartment_id', $fields['apartment_id'])
        ->get()
        ->sortBy('house_id');

    $previous_month_invoices = Invoice::with('tenant', 'house')
        ->where('rent_month', '<=', $previous_rent_month)
        ->where('type', '!=', 'House Viewing')
        ->where('apartment_id', $fields['apartment_id'])
        ->get()
        ->sortBy('house_id');
     $aprt = Apartment::where('id', $fields['apartment_id'])->first();
    // Check if there are any invoices for the month
    if ($month_invoices->isEmpty()) {
        
         $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $hasReport = false;
        $message = 'INACTIVE PROPERTY! No invoice found for ' . $aprt->name . ' in the month of ' . $rent_month;
      return view('report.property_status', compact('message','tenants', 'apartments','hasReport'));
       
    }

    // Fetch property info if there's at least one invoice
    $property_info = Apartment::with('landlord')->where('id', $fields['apartment_id'])->first();
    // if (!$property_info) {
    //      return back()->with('error', 'No Apartment in the month chosen.');
       
    // }

    // Process each invoice
    foreach ($month_invoices as $invoice) {
        $prev_arrears = Invoice::where('tenant_id', $invoice->tenant_id)
            ->where('rent_month', '!=', $rent_month)->where('house_id', $invoice->house_id)
            ->sum('total_payable');

        $all_invs = Invoice::where('tenant_id', $invoice->tenant_id)
            ->where('type', '!=', 'House Viewing')->where('house_id', $invoice->house_id)
            ->get();

        $total_current_month = Invoice::where('tenant_id', $invoice->tenant_id)
            ->where('rent_month', $rent_month)->where('house_id', $invoice->house_id)
            ->where('type', '!=', 'House Viewing')
            ->sum('balance');

        // Filter invoices for previous months
        $all_invs = $all_invs->filter(function ($value) use ($rent_month) {
            return strtotime($value['rent_month']) <= strtotime($rent_month);
        });

        $prev_invs = $all_invs->filter(function ($value) use ($rent_month) {
            return strtotime($value['rent_month']) < strtotime($rent_month);
        });

        $invoice['total_payable'] = $total_current_month + $prev_invs->sum('balance');
        $invoice['balance'] = $all_invs->sum('balance');
    }
    // dd($month_invoices->sum('total_payable'));
    //service bills
    $service_bill_water = $property_info->water;
    $service_bill_sewer = $property_info->sewer;
    $service_bill_electricity = $property_info->electricity;
    $service_bill_internet = $property_info->internet;
    $service_bill_garbage = $property_info->garbage;
    $service_bill_cleaning = $property_info->cleaning;
    $service_bill_security = $property_info->security;
    $sum_service_bill = $service_bill_water + $service_bill_sewer + $service_bill_electricity +   $service_bill_internet +  $service_bill_garbage +  $service_bill_cleaning +  $service_bill_security;
    
    //service requests
    $expenses = PayOwners::where('bill_category', 'service_request')->where('apartment_id', $property_info->id )->get();
    
     //remittance_bills
     $paidforbills = PayOwners::where('bill_type', 'rent')->where('apartment_id', $property_info->id )->where('bill_category','!=', 'Remits')->get();
     $remittance = PayOwners::where('bill_type', 'rent')->where('apartment_id', $property_info->id )->where('bill_category', 'Remits')->get();
     

    // Calculate totals
    $total_paid_in = $month_invoices->sum('paid_in');
    $expense_total = $expenses->sum('paid_in') ?? 0;
    $expense_balance = $expenses->sum('balance') ?? 0;
    $expense_total_owned = $expenses->sum('total_owned') ?? 0;
    $paidforbills_total = $paidforbills->sum('paid_in') ?? 0;
    $paidforbills_balance = $paidforbills->sum('balance') ?? 0;
    $paidforbills_total_owned = $paidforbills->sum('total_owned') ?? 0;
    $service_bill_total = $sum_service_bill ?? 0;
    $remittance_total =  $remittance->sum('paid_in') ?? 0;
    $total_rent = $month_invoices->sum('rent') ?? 0;
    $total_payable = $month_invoices->sum('total_payable');
    $total_carryforward = $month_invoices->sum('deposit_paid');
    $total_balance =$month_invoices->sum('balance');
    $total_bills = $month_invoices->sum('electricity_bill') +
                   $month_invoices->sum('litter_bill') +
                   $month_invoices->sum('water_bill') +
                   $month_invoices->sum('security') +
                   $month_invoices->sum('compound_bill') +
                   $month_invoices->sum('other_bill');

    $property_name = $property_info->name;
    $property_owner = $property_info->landlord->full_name;
    $property_mgt = $property_info->management_fee_percentage;
    $message = '';

    $filled = 'yes';
    $download = 'no';
    if ($request->download) {
        $download = 'yes';
        if ($request->filled === 'no') {
            $filled = 'no';
        }
    }

    $info = [
        'income_entries' => $month_invoices,
        'service_request_entries' => $expenses,
        'bill_entries' => $paidforbills,
        'rent_month' => $rent_month,
        'total_paid_in' => $total_paid_in,
        'expense_total' => $expense_total,
        'expense_balance' => $expense_balance,
        'expense_total_owned' => $expense_total_owned,
        'paidforbills_total' => $paidforbills_total,
        'paidforbills_balance' => $paidforbills_balance,
        'paidforbills_total_owned' => $paidforbills_total_owned,
        'service_bill_total' => $sum_service_bill ,
        'remittance_total' => $remittance_total,
        'total_rent' => $total_rent,
        'total_bills' => $total_bills,
        'total_payable' => $total_payable,
        'total_carryforward' => $total_carryforward,
        'total_balance' => $total_balance,
        'property_owner' => $property_owner,
        'property_name' => $property_name,
        'property_mgt' => $property_mgt,
        'service_bill_water' => $service_bill_water ?? 0,
        'service_bill_electricity' => $service_bill_electricity ?? 0,
        'service_bill_sewer' => $service_bill_sewer ?? 0,
        'service_bill_internet' => $service_bill_internet ?? 0,
        'service_bill_garbage' => $service_bill_garbage ?? 0,
        'service_bill_cleaning' => $service_bill_cleaning ?? 0,
        'service_bill_security' => $service_bill_security ?? 0,
        'message' => $message,
    ];

    return $this->propertyIncomeExpenseViewTester($info, $download, $filled);
}

  public function occupancy_expense_report(Request $request)
{
    $fields = $request->validate([
        'rent_month' => 'required',
        'apartment_id' => 'required'
    ]);

    $rent_month = date("M-Y", strtotime($fields['rent_month']));
    $previous_rent_month = date("M-Y", strtotime('-1 month', strtotime($fields['rent_month'])));

    // Fetch invoices for the current and previous month
    $month_invoices = Invoice::with('tenant', 'house')
        ->where('rent_month', $rent_month)
        ->where('type', '!=', 'House Viewing')
        ->where('apartment_id', $fields['apartment_id'])
        ->get()
        ->sortBy('house_id');

    $previous_month_invoices = Invoice::with('tenant', 'house')
        ->where('rent_month', '<=', $previous_rent_month)
        ->where('type', '!=', 'House Viewing')
        ->where('apartment_id', $fields['apartment_id'])
        ->get()
        ->sortBy('house_id');
     $aprt = Apartment::where('id', $fields['apartment_id'])->first();
    // Check if there are any invoices for the month
    if ($month_invoices->isEmpty()) {
        
         $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $hasReport = false;
        $message = 'INACTIVE PROPERTY! No invoice found for ' . $aprt->name . ' in the month of ' . $rent_month;
      return view('report.property_status', compact('message','tenants', 'apartments','hasReport'));
       
    }

    // Fetch property info if there's at least one invoice
    $property_info = Apartment::with('landlord')->where('id', $fields['apartment_id'])->first();
    // if (!$property_info) {
    //      return back()->with('error', 'No Apartment in the month chosen.');
       
    // }

    // Process each invoice
    foreach ($month_invoices as $invoice) {
        $prev_arrears = Invoice::where('tenant_id', $invoice->tenant_id)
            ->where('rent_month', '!=', $rent_month)->where('house_id', $invoice->house_id)
            ->sum('total_payable');

        $all_invs = Invoice::where('tenant_id', $invoice->tenant_id)
            ->where('type', '!=', 'House Viewing')->where('house_id', $invoice->house_id)
            ->get();

        $total_current_month = Invoice::where('tenant_id', $invoice->tenant_id)
            ->where('rent_month', $rent_month)->where('house_id', $invoice->house_id)
            ->where('type', '!=', 'House Viewing')
            ->sum('balance');

        // Filter invoices for previous months
        $all_invs = $all_invs->filter(function ($value) use ($rent_month) {
            return strtotime($value['rent_month']) <= strtotime($rent_month);
        });

        $prev_invs = $all_invs->filter(function ($value) use ($rent_month) {
            return strtotime($value['rent_month']) < strtotime($rent_month);
        });

        $invoice['total_payable'] = $total_current_month + $prev_invs->sum('balance');
        $invoice['balance'] = $all_invs->sum('balance');
    }
    // dd($month_invoices->sum('total_payable'));
    //service bills
    $service_bill_water = $property_info->water;
    $service_bill_sewer = $property_info->sewer;
    $service_bill_electricity = $property_info->electricity;
    $service_bill_internet = $property_info->internet;
    $service_bill_garbage = $property_info->garbage;
    $service_bill_cleaning = $property_info->cleaning;
    $service_bill_security = $property_info->security;
    $sum_service_bill = $service_bill_water + $service_bill_sewer + $service_bill_electricity +   $service_bill_internet +  $service_bill_garbage +  $service_bill_cleaning +  $service_bill_security;
    
    //service requests
    $expenses = PayOwners::where('bill_category', 'service_request')->where('apartment_id', $property_info->id )->get();
    
     //remittance_bills
     $paidforbills = PayOwners::where('bill_type', 'rent')->where('apartment_id', $property_info->id )->where('bill_category','!=', 'Remits')->get();
     $remittance = PayOwners::where('bill_type', 'rent')->where('apartment_id', $property_info->id )->where('bill_category', 'Remits')->get();
     

    // Calculate totals
    $total_paid_in = $month_invoices->sum('paid_in');
    $expense_total = $expenses->sum('paid_in') ?? 0;
    $expense_balance = $expenses->sum('balance') ?? 0;
    $expense_total_owned = $expenses->sum('total_owned') ?? 0;
    $paidforbills_total = $paidforbills->sum('paid_in') ?? 0;
    $paidforbills_balance = $paidforbills->sum('balance') ?? 0;
    $paidforbills_total_owned = $paidforbills->sum('total_owned') ?? 0;
    $service_bill_total = $sum_service_bill ?? 0;
    $remittance_total =  $remittance->sum('paid_in') ?? 0;
    $total_rent = $month_invoices->sum('rent') ?? 0;
    $total_payable = $month_invoices->sum('total_payable');
    $total_carryforward = $month_invoices->sum('deposit_paid');
    $total_balance =$month_invoices->sum('balance');
    $total_bills = $month_invoices->sum('electricity_bill') +
                   $month_invoices->sum('litter_bill') +
                   $month_invoices->sum('water_bill') +
                   $month_invoices->sum('security') +
                   $month_invoices->sum('compound_bill') +
                   $month_invoices->sum('other_bill');

    $property_name = $property_info->name;
    $property_owner = $property_info->landlord->full_name;
    $property_mgt = $property_info->management_fee_percentage;
    $message = '';

    $filled = 'yes';
    $download = 'no';
    if ($request->download) {
        $download = 'yes';
        if ($request->filled === 'no') {
            $filled = 'no';
        }
    }

    $info = [
        'income_entries' => $month_invoices,
        'service_request_entries' => $expenses,
        'bill_entries' => $paidforbills,
        'rent_month' => $rent_month,
        'total_paid_in' => $total_paid_in,
        'expense_total' => $expense_total,
        'expense_balance' => $expense_balance,
        'expense_total_owned' => $expense_total_owned,
        'paidforbills_total' => $paidforbills_total,
        'paidforbills_balance' => $paidforbills_balance,
        'paidforbills_total_owned' => $paidforbills_total_owned,
        'service_bill_total' => $sum_service_bill ,
        'remittance_total' => $remittance_total,
        'total_rent' => $total_rent,
        'total_bills' => $total_bills,
        'total_payable' => $total_payable,
        'total_carryforward' => $total_carryforward,
        'total_balance' => $total_balance,
        'property_owner' => $property_owner,
        'property_name' => $property_name,
        'property_mgt' => $property_mgt,
        'service_bill_water' => $service_bill_water ?? 0,
        'service_bill_electricity' => $service_bill_electricity ?? 0,
        'service_bill_sewer' => $service_bill_sewer ?? 0,
        'service_bill_internet' => $service_bill_internet ?? 0,
        'service_bill_garbage' => $service_bill_garbage ?? 0,
        'service_bill_cleaning' => $service_bill_cleaning ?? 0,
        'service_bill_security' => $service_bill_security ?? 0,
        'message' => $message,
    ];

    return $this->propertyOccupancyExpenseViewTester($info, $download, $filled);
}


  public function rent_report(Request $request)
{
    $fields = $request->validate([
        'rent_month' => 'required',
        'apartment_id' => 'required'
    ]);

    // Get inputs from the form
   $rent_month = date("M-Y", strtotime($fields['rent_month'])); // e.g., 'Oct-2020'
    $property_id = $request->input('apartment_id'); // 0 = All properties

    // Convert rent_month to proper date range (e.g., 2020-10-01 to 2020-10-31)
    $startDate = date('Y-m-01', strtotime($rent_month));
    $endDate = date('Y-m-t', strtotime($rent_month));

    // Build query
    $query = DB::table('pay_owners as po')
        ->join('apartments as p', 'po.apartment_id', '=', 'p.id')
        ->select(
            DB::raw("DATE_FORMAT(po.created_at, '%b-%Y') as month"),
            'p.name as property_name',
            'po.apartment_id',
            DB::raw("SUM(CASE WHEN po.bill_type = 'rent' THEN po.total_owned ELSE 0 END) as total_rent_collected"),
            DB::raw("AVG(CASE WHEN po.bill_type = 'rent' THEN po.mgt ELSE NULL END) as management_fee_percentage"),
            DB::raw("GROUP_CONCAT(DISTINCT CASE WHEN po.bill_type = 'property' THEN po.bill_category ELSE NULL END SEPARATOR ', ') as bill_names"),
            DB::raw("SUM(CASE WHEN po.bill_type = 'property' THEN po.total_owned ELSE 0 END) as total_bill_amount_paid"),
            DB::raw("(SUM(CASE WHEN po.bill_type = 'rent' THEN po.total_owned ELSE 0 END) 
                        - SUM(CASE WHEN po.bill_type = 'property' THEN po.total_owned ELSE 0 END)
                        - (SUM(CASE WHEN po.bill_type = 'rent' THEN po.total_owned ELSE 0 END) 
                           * (AVG(CASE WHEN po.bill_type = 'rent' THEN po.mgt ELSE NULL END) / 100))
                    ) as net_rent_remitted")

        )
        ->whereBetween('po.created_at', [$startDate, $endDate]);

    // Apply property filter only if a specific property is selected
    if ($property_id != 0) {
        $query->where('po.apartment_id', $property_id);
    }

    // Final grouping and sorting
    $report = $query
        ->groupBy(DB::raw("DATE_FORMAT(po.created_at, '%b-%Y')"), 'po.apartment_id', 'p.name')
        ->orderByRaw("STR_TO_DATE(DATE_FORMAT(po.created_at, '%b-%Y'), '%b-%Y') DESC")
        ->get();




    $filled = 'yes';
    $download = 'no';
    if ($request->download) {
        $download = 'yes';
        if ($request->filled === 'no') {
            $filled = 'no';
        }
    }

    $info = [
        'entries' => $report,
        'rent_month' => $rent_month,
       
    ];

    return $this->rentViewTester($info, $download, $filled);
}

    public function agency_status_report(Request $request)
    {
        $fields = $request->validate([
            'rent_month' => 'required'
        ]);
        // dd($fields['rent_month']);
        $rent_month = date("M-Y", strtotime($fields['rent_month']));
        $month_invoices = Invoice::with('apartment')->where('rent_month',   $rent_month)->orderBy('apartment_id', 'ASC')->get();
                            
        $entries = array();
        // foreach($month_invoices->groupBy('apartment_id') as $month_invoice){
        foreach($month_invoices as $month_invoice){
            // $entries[] = [
            //     'apartment_name'=>$month_invoice[0]['apartment_name'],
            //     'land_lord'=>Landlord::where('id',$month_invoice[0]['apartment']['landlord_id'])->first()->full_name,
            //     'total_payable'=>$month_invoice->sum('total_payable'),
            //     'house_list'=>$month_invoice->pluck(['house_name'])->implode(' , '),
            //     'tenant_list'=>$month_invoice->pluck(['tenant_name'])->implode(' , '),
            //     'carryforward'=>$month_invoice->sum('carryforward'),
            //     'tenant_name'=>$month_invoice[0]['tenant_name'],
            //     'paid_in'=>$month_invoice->sum('paid_in'),
            //     'rent'=>$month_invoice->sum('rent'),
            //     'balance'=>$month_invoice->sum('balance')
            //     ];
             if($month_invoice->apartment_id != null)   {
            $entries[] = [
                'apartment_name'=>$month_invoice['apartment_name'],
                'land_lord'=>Landlord::where('id',$month_invoice['apartment']['landlord_id'])->first()->full_name,
                // 'land_lord'=>$month_invoice['apartment_name'],
                 'total_payable'=>$month_invoice->total_payable,
                 'acc_no'=>$month_invoice->tenant->account_number,
                'house_name'=>$month_invoice->house_name,
                'tenant_name'=>$month_invoice->tenant_name,
                'carryforward'=>$month_invoice->carryforward,
                'tenant_name'=>$month_invoice->tenant_name,
                'paid_in'=>$month_invoice->paid_in,
                'rent'=>$month_invoice->rent,
                'balance'=>$month_invoice->balance,
                'house_list'=>'house list',
                'tenant_list'=>'tenant_list',
                ];
             }
             if($month_invoice->apartment_id == null){
                   $entries[] = [
                'apartment_name'=>'Properties Viewed',
                // 'land_lord'=>Landlord::where('id',$month_invoice['apartment']['landlord_id'])->first()->full_name,
                'land_lord'=>'Properties Viewed Owners',
                 'total_payable'=>$month_invoice->total_payable,
                'house_name'=>'Properties Viewed Houses',
                'acc_no'=>'No account number assigned',
                'tenant_name'=>$month_invoice->tenant_name,
                'carryforward'=>$month_invoice->carryforward,
                'tenant_name'=>$month_invoice->tenant_name,
                'paid_in'=>$month_invoice->total_payable - $month_invoice->balance,
                'rent'=>$month_invoice->total_payable,
                'balance'=>$month_invoice->balance,
                'house_list'=>'house list',
                'tenant_list'=>'tenant_list',
                ];
             }
        }
        // ['rent_month','apartment_name','house_name','rent','total_payable','carryforward','paid_in']
        $total_paid_in =  $month_invoices->sum('paid_in');
        $total_rent =  $month_invoices->sum('rent');
        $total_payable =  $month_invoices->sum('total_payable');
        $total_carryforward =  $month_invoices->sum('carryforward');
        $total_balance =  $month_invoices->sum('balance');
        // dd($month_invoices);
        // dd($total_paid_in);
        if ($request->download) {
            $download ='yes';
        }else{
            $download='no';
        }
        $info = [
            'entries'=>$entries,
            'rent_month'=> $rent_month,
            'total_paid_in'=>$total_paid_in,
            'total_rent'=>$total_rent,
            'total_payable'=>$total_payable,
            'total_carryforward'=>$total_carryforward,
            'total_balance'=>$total_balance,
            ];

        // $date_of_statement = date('jS M Y');
        // $this->createLog([
        //     'username' => auth()->user()->username,
        //     'operation' => 'Agency Statement Generated',
        //     'more_info' => 'General Agency Statement',
        //     'tenant_id' => '0',
        //             'house_id' => '0',
        //             'apartment_id' => '0',
        //             'landlord_id' => '0',
        //             'bill_id' => '0',
        //             'invoice_id' => '0',
        //             'sms_id' => '0',
        //             'user_id' => '0',
        //             'servicerequest_id' => '0',
        // ]);

        
        return $this->agencyStatusViewTester($info,$download);
        return response()->json($info);
    }
    
    public function agency_income_expense_report(Request $request)
    {
     $fields = $request->validate([
        'rent_month' => 'required'
    ]);

    $rent_month = date("M-Y", strtotime($fields['rent_month']));

    // Fetch invoices for the selected rent month
    $month_invoices = Invoice::with(['apartment', 'tenant'])
        ->where('rent_month', $rent_month)
        ->orderBy('apartment_id', 'ASC')
        ->get();
        
    

    // 1. List of Properties and Their Total Paid Rent
    $properties_paid_rent = $month_invoices->filter(fn($inv) => $inv->apartment_id !== null)->groupBy('apartment_id')->map(function ($group) {
            $apartment_name = optional($group->first()->apartment)->name ?? 'Unknown Apartment';
            $apartment_commission = optional($group->first()->apartment)->management_fee_percentage ?? 0;
            $total_paid_in = $group->sum('paid_in');
            $agency_commission = ($apartment_commission / 100) * $total_paid_in;
            return [
                'apartment_name' => $apartment_name,
                'total_paid_in' => $total_paid_in,
                'commission' => $apartment_commission,
                'agency_commission' => $agency_commission,
                
            ];
        })->values();

    // 2. List of Agency Bills from payowners table
    $agency_bills = Payowners::where('bill_type', 'agency')
        ->where('rent_month', $rent_month)
        ->orderBy('created_at', 'DESC')
        ->get(['id', 'total_owned', 'description', 'created_at', 'rent_month']);
        
        
      //agency crm income
  $now = Carbon::now();
$agency_income = Onboarding::whereMonth('created_at', $now->month)
    ->whereYear('created_at', $now->year)
    ->orderBy('created_at', 'DESC')
    ->get();
       
   $total_CRM = $agency_income->sum('fee');
        
 $total_paid_rent = $properties_paid_rent->sum('total_paid_in');
$total_agency_bills = $agency_bills->sum('total_owned');
  $total_agency_commission = $properties_paid_rent->sum('agency_commission');
   if ($request->download) {
            $download ='yes';
        }else{
            $download='no';
        }
    $info = [
        'rent_month' => $rent_month,
        'properties_paid_rent' => $properties_paid_rent,
        'agency_bills' => $agency_bills,
        'agency_income' => $agency_income,
        'total_paid_rent' => $total_paid_rent,
        'total_agency_bills' => $total_agency_bills,
        'total_agency_commission' => $total_agency_commission,
        'total_CRM' => $total_CRM,
    ];

        
        return $this->agencyIncomeExpenseViewTester($info,$download);
        return response()->json($info);
    }
    
    
    
    public function all_property_report(Request $request)
    {
       
        // $fields = $request->validate([
        //     'rent_month' => 'required'
        // ]);
        // dd($fields['rent_month']);
         $fields = $request->validate([
            'from' => 'required',
            'to' => 'required',
         ]);
          $from = $this->dateFormater('d/m/Y H:i:s',  $request->from, 'Y-m-d');
            $to = $this->dateFormater('d/m/Y H:i:s',  $request->to, 'Y-m-d');
        
       
        $month_invoices = Invoice::selectRaw('SUM(paid_in) as smnt,apartment_id')->where('apartment_id', '!=', null)->where('created_at', '>=', $from. " 00:00:00")->where('created_at', '<=', $to. " 23:59:59")->groupBy('apartment_id')->get();
     
          
        $entries = array();
        // foreach($month_invoices->groupBy('apartment_id') as $month_invoice){
        foreach($month_invoices as $month_invoice){
             $total_sum = Invoice::where('apartment_id', $month_invoice->apartment_id)->where('created_at', '>=', $from. " 00:00:00")->where('created_at', '<=', $to. " 23:59:59")->sum('total_payable');
            $total_com = ($month_invoice->smnt) * (($month_invoice->apartment->management_fee_percentage)/100);
            $paid_sum = $month_invoice->smnt;
            $balance_sum = $total_sum - $paid_sum;
            // $entries[] = [
            //     'apartment_name'=>$month_invoice[0]['apartment_name'],
            //     'land_lord'=>Landlord::where('id',$month_invoice[0]['apartment']['landlord_id'])->first()->full_name,
            //     'total_payable'=>$month_invoice->sum('total_payable'),
            //     'house_list'=>$month_invoice->pluck(['house_name'])->implode(' , '),
            //     'tenant_list'=>$month_invoice->pluck(['tenant_name'])->implode(' , '),
            //     'carryforward'=>$month_invoice->sum('carryforward'),
            //     'tenant_name'=>$month_invoice[0]['tenant_name'],
            //     'paid_in'=>$month_invoice->sum('paid_in'),
            //     'rent'=>$month_invoice->sum('rent'),
            //     'balance'=>$month_invoice->sum('balance')
            //     ];
             if($month_invoice->apartment_id != null)   {
            $entries[] = [
                'apartment_name'=> $month_invoice->apartment->name,
                'land_lord'=>Landlord::where('id',$month_invoice['apartment']['landlord_id'])->first()->full_name,
                // 'land_lord'=>$month_invoice['apartment_name'],
                'commission'=>$total_com,
                'remittance' => $paid_sum - $total_com,
                'paid_in'=>$paid_sum,
                'balance'=>$balance_sum,
                ];
             }
           
        }
        // ['rent_month','apartment_name','house_name','rent','total_payable','carryforward','paid_in']
       
        $commission =  $this->sumArrayOfObjects($entries, 'commission');
        $remittance =  $this->sumArrayOfObjects($entries, 'remittance');
        $total_paid_in =  $this->sumArrayOfObjects($entries, 'paid_in');
        $total_balance =  $this->sumArrayOfObjects($entries, 'balance');
        $period = $from. ' to ' . $to;
        
        // dd($period);
      
        // dd($month_invoices);
        // dd($total_paid_in);
        if ($request->download) {
            $download ='yes';
        }else{
            $download='no';
        }
        $info = [
            'entries'=>$entries,
            'total_paid_in'=>$total_paid_in,
            'commission'=>$commission,
            'remittance'=>$remittance ,
            'total_balance'=>$total_balance,
            'period' => $period,
            ];

        // $date_of_statement = date('jS M Y');
        // $this->createLog([
        //     'username' => auth()->user()->username,
        //     'operation' => 'Agency Statement Generated',
        //     'more_info' => 'General Agency Statement',
        //     'tenant_id' => '0',
        //             'house_id' => '0',
        //             'apartment_id' => '0',
        //             'landlord_id' => '0',
        //             'bill_id' => '0',
        //             'invoice_id' => '0',
        //             'sms_id' => '0',
        //             'user_id' => '0',
        //             'servicerequest_id' => '0',
        // ]);

        
        return $this->allPropertyViewTester($info,$download);
        return response()->json($info);
        
    }
    
      public function all_tenant_report(Request $request)
    {
         $fields = $request->validate([
            'from' => 'required',
            'to' => 'required',
         ]);
          $from = $this->dateFormater('d/m/Y H:i:s',  $request->from, 'Y-m-d');
            $to = $this->dateFormater('d/m/Y H:i:s',  $request->to, 'Y-m-d');
        
 
        
       
        // $month_invoices = Invoice::where('created_at', '>=', $from. " 00:00:00")->where('created_at', '<=', $to. " 23:59:59")->where('tenant_id', '!=', null)->where('house_id', '!=', null)->where('apartment_id', '!=', null)->where('deleted_at', null)->get();
       $month_invoices = Invoice::selectRaw('SUM(paid_in) as smnt,tenant_id')->where('tenant_id', '!=', null)->where('created_at', '>=', $from. " 00:00:00")->where('created_at', '<=', $to. " 23:59:59")->groupBy('tenant_id')->get();
 
          
        $entries = array();
        // foreach($month_invoices->groupBy('apartment_id') as $month_invoice){
        foreach($month_invoices as $month_invoice){
            $total_sum = Invoice::where('tenant_id', $month_invoice->tenant_id)->where('created_at', '>=', $from. " 00:00:00")->where('created_at', '<=', $to. " 23:59:59")->sum('total_payable');
            $paid_sum = Invoice::where('tenant_id', $month_invoice->tenant_id)->where('created_at', '>=', $from. " 00:00:00")->where('created_at', '<=', $to. " 23:59:59")->sum('paid_in');
            $balance_sum = $total_sum - $paid_sum;
            $house= Invoice::where('tenant_id', $month_invoice->tenant_id)->where('created_at', '>=', $from. " 00:00:00")->where('created_at', '<=', $to. " 23:59:59")->first();
    
            
            // $entries[] = [
            //     'apartment_name'=>$month_invoice[0]['apartment_name'],
            //     'land_lord'=>Landlord::where('id',$month_invoice[0]['apartment']['landlord_id'])->first()->full_name,
            //     'total_payable'=>$month_invoice->sum('total_payable'),
            //     'house_list'=>$month_invoice->pluck(['house_name'])->implode(' , '),
            //     'tenant_list'=>$month_invoice->pluck(['tenant_name'])->implode(' , '),
            //     'carryforward'=>$month_invoice->sum('carryforward'),
            //     'tenant_name'=>$month_invoice[0]['tenant_name'],
            //     'paid_in'=>$month_invoice->sum('paid_in'),
            //     'rent'=>$month_invoice->sum('rent'),
            //     'balance'=>$month_invoice->sum('balance')
            //     ];
            
            
           
            
            
            
             if($month_invoice->tenant_id != null)   {
            $entries[] = [
                'tenant_name'=> $month_invoice->tenant->full_name ,
                'total_payable'=>$total_sum,
                'paid_in'=>$paid_sum,
                'balance'=>$balance_sum,
                'house_name' =>  $house->house->house_no,
                'property_name' => $house->apartment->name,
                ];
             }
           
        }
        
        
        // ['rent_month','apartment_name','house_name','rent','total_payable','carryforward','paid_in']
       
        $total_payable =  $this->sumArrayOfObjects($entries, 'total_payable');
         $total_paid_in =  $this->sumArrayOfObjects($entries, 'paid_in');
        $total_balance =  $this->sumArrayOfObjects($entries, 'balance');
        $period = $from. ' to ' . $to;
        
        // dd($total_paid_in);
        if ($request->download) {
            $download ='yes';
        }else{
            $download='no';
        }
        $info = [
            'entries'=>$entries,
            'total_paid_in'=>$total_paid_in,
            'total_payable'=>$total_payable,
            'total_balance'=>$total_balance,
            'period' => $period,
            ];

        // $date_of_statement = date('jS M Y');
        // $this->createLog([
        //     'username' => auth()->user()->username,
        //     'operation' => 'Agency Statement Generated',
        //     'more_info' => 'General Agency Statement',
        //     'tenant_id' => '0',
        //             'house_id' => '0',
        //             'apartment_id' => '0',
        //             'landlord_id' => '0',
        //             'bill_id' => '0',
        //             'invoice_id' => '0',
        //             'sms_id' => '0',
        //             'user_id' => '0',
        //             'servicerequest_id' => '0',
        // ]);

        
        return $this->allTenantViewTester($info,$download);
        return response()->json($info);
        
    }
    
    public function all_tenants(Request $request)
    {

        $tenants = Tenant::all();
        $data['tenants'] = $tenants;
        $fl_nm = 'LesaAgenciesTenants';
        // return view('docs.alltenants', $data);
        $pdf = \PDF::loadView('docs.alltenants', $data);
        return $pdf->stream($fl_nm);
    }

    public function viewTester($info,$download='')
    {

        $invoice = Invoice::with('tenant', 'house')->findOrFail(83);

        $overpayment = 0;
        $overpayments = Overpayment::where('tenant_id', $invoice->tenant_id)->get();

        if (count($overpayments) > 0) {
            $overpayment = Overpayment::where('tenant_id', $invoice->tenant_id)->first()->value('amount');
        }

        $billings = MonthlyBilling::where('billing_month', $invoice->rent_month)
            ->where('house_id', $invoice->house_id)
            ->get();

        $data['entries'] = $info['entries'];
        $data['deposit_sum'] = $info['deposit_sum'];
        $data['electricity_deposit_sum'] = $info['electricity_deposit_sum'];
        $data['others_sum'] = $info['others_sum'];
        $data['rent_sum'] = $info['rent_sum'];
        $data['payments'] = $info['payments'];
        $data['total'] = $info['total'];
        $data['balance'] = $info['balance'];
        $data['invoice'] = $invoice;
        $data['other_info'] = $info['other_info'];

        $fl_nm = $info['other_info']['file_name'];
        
        if($download == 'yes'){
        $pdf = \PDF::loadView('docs.tenantStatement', $data);
        return $pdf->stream($fl_nm);
        // return view('docs.tenantStatement', $data); 
        }
        //form data
        $data['apartments'] = Apartment::pluck('id', 'name');
        $data['tenants'] = Tenant::pluck('id', 'full_name');
        $data['hasReport'] = true;
        
        return view('report.tenantform', $data);
        

    }
    public function propertyOwnerViewTester($info, $download)
    {

        $data['entries'] = $info['entries'];
        $data['property_owner_info_array_info'] = $info['property_owner_info_array_info'];
        $data['other_info'] = $info['other_info'];
        $data['totals'] = $info['totals'];

        $fl_nm = $info['other_info']['file_name'];
        
        if($download == 'yes'){
        $pdf = \PDF::loadView('docs.propertyOwnerStatement', $data);
        return $pdf->stream($fl_nm);
        // return view('docs.tenantStatement', $data); 
        }
        //form data
        $data['apartments'] = Apartment::pluck('id', 'name');
        $data['landlords'] = Landlord::pluck('id', 'full_name');
        $data['hasReport'] = true;
        
        // return view('docs.propertyOwnerStatement', $data);
        return view('report.landlordform', $data);
    }
    public function agencyStatementViewTester($info, $download = '')
    {

        $data['entries'] = $info['entries'];
        $data['other_info'] = $info['other_info'];
        $data['rent_collection_commission'] = $info['rent_collection_commission'];
        $data['placement_fee_income'] = $info['placement_fee_income'];
        $data['total_expense'] = $info['total_expense'];
        $data['other_incomes_totals'] = $info['other_incomes_totals'];
        $data['balance'] = $info['balance'];
        $data['income_total'] = $info['income_total'];
        
        if($download == 'yes'){
        $fl_nm = $info['other_info']['file_name'];
        $pdf = \PDF::loadView('docs.agencyStatement', $data);
        return $pdf->stream($fl_nm);
        // return view('docs.tenantStatement', $data); 
        }

        $data['apartments'] = Apartment::pluck('id', 'name');
        $data['tenants'] = Tenant::pluck('id', 'full_name');
        $data['landlords'] = Landlord::pluck('id', 'full_name');
        $data['hasReport'] = true;
        
        
        return view('report.agencyform', $data);
    }
    public function propertyStatusViewTester($info, $download = '',$filled="yes")
    {
        
        $data['apartments'] = Apartment::pluck('id', 'name');
        $data['entries'] = $info['entries'];
        $data['rent_month'] = $info['rent_month'];
        $data['totals'] = $info;
        $data['property_owner'] = $info['property_owner'];
        $data['property_name'] = $info['property_name'];
         $data['message'] = $info['message'];
        
        
        if($download == 'yes'){
        $fl_nm = 'Property Status Report - '.$info['rent_month'];
        if($filled === 'no'){
        $pdf = \PDF::loadView('docs.property_status_unfilled', $data);
            
        }else{
        $pdf = \PDF::loadView('docs.property_status', $data);
            
        }
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream($fl_nm);
        }

        $data['hasReport'] = true;
        
        
        return view('report.property_status', $data);
    }
    
    
     public function propertyIncomeExpenseViewTester($info, $download = '',$filled="yes")
    {
        
        $data['apartments'] = Apartment::pluck('id', 'name');
        $data['income_entries'] = $info['income_entries'];
        $data['service_request_entries'] = $info['service_request_entries'];
        $data['bill_entries'] = $info['bill_entries'];
        $data['rent_month'] = $info['rent_month'];
        $data['totals'] = $info;
        $data['expense_total'] = $expense_total ?? 0;
        $data['paidforbills_total'] = $paidforbills_total ?? 0;
        $data['service_bill_total'] = $service_bill_total ?? 0;
        $data['remittance_total'] = $remittance_total ?? 0;
        $data['total_paid_in'] = $total_paid_in ?? 0;
        $data['property_owner'] = $info['property_owner'];
        $data['property_name'] = $info['property_name'];
        $data['property_mgt'] = $info['property_mgt'] ?? 0;
         $data['message'] = $info['message'];
        
        
        if($download == 'yes'){
        $fl_nm = 'Property Income Expense Report - '.$info['rent_month'];
       
        $pdf = \PDF::loadView('docs.prop_income_expense', $data);
            
        
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream($fl_nm);
        }

        $data['hasReport'] = true;
        
        
        return view('report.property_income_expense', $data);
    }
    
         public function propertyOccupancyExpenseViewTester($info, $download = '',$filled="yes")
    {
        
        $data['apartments'] = Apartment::pluck('id', 'name');
        $data['income_entries'] = $info['income_entries'];
        $data['service_request_entries'] = $info['service_request_entries'];
        $data['bill_entries'] = $info['bill_entries'];
        $data['rent_month'] = $info['rent_month'];
        $data['totals'] = $info;
        $data['expense_total'] = $expense_total ?? 0;
        $data['paidforbills_total'] = $paidforbills_total ?? 0;
        $data['service_bill_total'] = $service_bill_total ?? 0;
        $data['remittance_total'] = $remittance_total ?? 0;
        $data['total_paid_in'] = $total_paid_in ?? 0;
        $data['property_owner'] = $info['property_owner'];
        $data['property_name'] = $info['property_name'];
        $data['property_mgt'] = $info['property_mgt'] ?? 0;
         $data['message'] = $info['message'];
        
        
        if($download == 'yes'){
        $fl_nm = 'Property Occupancy Expense Report - '.$info['rent_month'];
       
        $pdf = \PDF::loadView('docs.occupancy_expense', $data);
            
        
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream($fl_nm);
        }

        $data['hasReport'] = true;
        
        
        return view('report.occupancy', $data);
    }
      public function rentViewTester($info, $download = '',$filled="yes")
    {
        
        $data['apartments'] = Apartment::pluck('id', 'name');
        $data['entries'] = $info['entries'];
        $data['rent_month'] = $info['rent_month'];
  
        
        
        if($download == 'yes'){
        $fl_nm = 'Rent Report - '.$info['rent_month'];
       
        $pdf = \PDF::loadView('docs.rent', $data);
            
        
        $pdf->setPaper('A4', 'landscape');
        return response()->streamDownload(function () use ($pdf) {
    echo $pdf->output();
}, $fl_nm);

        // return $pdf->download($fl_nm);
        }

        $data['hasReport'] = true;
        
        
        return view('report.rent', $data);
    }
        public function agencyIncomeExpenseViewTester($info, $download = '')
    { 

        $data['rent_month'] = $info['rent_month'];
        $data['properties_paid_rent'] = $info['properties_paid_rent'];
        $data['agency_bills'] = $info['agency_bills'];
        $data['agency_income'] = $info['agency_income'];
        $data['total_paid_rent'] = $info['total_paid_rent'];
        $data['total_agency_bills'] = $info['total_agency_bills'];
        $data['total_agency_commission'] = $info['total_agency_commission'];
        $data['total_CRM'] = $info['total_CRM'];
        
        if($download == 'yes'){
        $fl_nm = 'Agency Income Expense Report - '.$info['rent_month']. '.pdf';
        $pdf = \PDF::loadView('docs.agency_income_expense', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream($fl_nm);
        // return view('docs.tenantStatement', $data); 
        }

        $data['hasReport'] = true;
        
        
        return view('report.income_expense', $data);
    }
    public function agencyStatusViewTester($info, $download = '')
    {

        $data['entries'] = $info['entries'];
        $data['rent_month'] = $info['rent_month'];
        $data['totals'] = $info;
        $data['total_paid_in'] = $info['total_paid_in'];
        
        if($download == 'yes'){
        $fl_nm = 'Agency Status Report - '.$info['rent_month']. '.pdf';
        $pdf = \PDF::loadView('docs.agency_status', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream($fl_nm);
        // return view('docs.tenantStatement', $data); 
        }

        $data['hasReport'] = true;
        
        
        return view('report.agency_status', $data);
    }
    public function allPropertyViewTester($info, $download = '')
    {

        $data['entries'] = $info['entries'];
        $data['totals'] = $info;
        $data['total_paid_in'] = $info['total_paid_in'];
        $data['period'] = $info['period'];
        
        if($download == 'yes'){
        $fl_nm = 'All Properties Income Report.pdf';
        $pdf = \PDF::loadView('docs.prop_income', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download($fl_nm);
        // return view('docs.tenantStatement', $data); 
        }

        $data['hasReport'] = true;
        
        
        return view('report.prop_income', $data);
    }
    
    public function monthViewTester($info, $download = '')
    {

        $data['entries'] = $info['entries'];
        $data['rent_month'] = $info['rent_month'];
        $data['totals'] = $info;
        $data['total_paid_in'] = $info['total_paid_in'];
        
        if($download == 'yes'){
        $fl_nm = 'Monthly Income Report - '.$info['rent_month'];
        $pdf = \PDF::loadView('docs.month_income', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream($fl_nm);
        // return view('docs.tenantStatement', $data); 
        }

        $data['hasReport'] = true;
        
        
        return view('report.month_income', $data);
    }
    
     public function allTenantViewTester($info, $download = '')
    {

        $data['entries'] = $info['entries'];
        $data['totals'] = $info;
        $data['total_paid_in'] = $info['total_paid_in'];
        $data['period'] = $info['period'];
        
        if($download == 'yes'){
        $fl_nm = 'All Tenants Payment Report.pdf';
        $pdf = \PDF::loadView('docs.tenant_income', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download($fl_nm);
        // return view('docs.tenantStatement', $data); 
        }

        $data['hasReport'] = true;
        
        
        return view('report.tenant_income', $data);
    }
    
    public function monthTenantViewTester($info, $download = '')
    {

        $data['entries'] = $info['entries'];
        $data['rent_month'] = $info['rent_month'];
        $data['totals'] = $info;
        $data['total_paid_in'] = $info['total_paid_in'];
        
        if($download == 'yes'){
        $fl_nm = 'Monthly Tenant Payment Report - '.$info['rent_month'];
        $pdf = \PDF::loadView('docs.tenant_month_income', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream($fl_nm);
        // return view('docs.tenantStatement', $data); 
        }

        $data['hasReport'] = true;
        
        
        return view('report.tenant_month_income', $data);
    }
    

    public function testViewInvoicesss()
    {
        $tenants = Tenant::where('account_number','!=','282172')->get();

        foreach ($tenants as $tenant) {
            $all_tenant_invoices = Invoice::where('tenant_id', $tenant->id)->get();
            $all_tenant_payments = ManualPayment::where('InvoiceNumber', $tenant->account_number)->orWhere('MSISDN', $tenant->phone)->get();
            $tenant['oct_payment'] = $all_tenant_payments->filter(function ($item) {
                $date2 = date('m', strtotime($item['created_at']));
                $date1 = date('10');
                $date2year = date('y', strtotime($item['created_at']));
                $date1year = date('20');
                return $date1 === $date2 && $date1year === $date2year;
            })->sum('TransAmount');
            $tenant['nov_payment'] = $all_tenant_payments->filter(function ($item) {
                $date2 = date('m', strtotime($item['created_at']));
                $date1 = date('11');
                $date2year = date('y', strtotime($item['created_at']));
                $date1year = date('20');
                return $date1 === $date2 && $date1year === $date2year;
            })->sum('TransAmount');
            $tenant['dec_payment'] = $all_tenant_payments->filter(function ($item) {
                $date2 = date('m', strtotime($item['created_at']));
                $date1 = date('12');
                $date2year = date('y', strtotime($item['created_at']));
                $date1year = date('20');
                return $date1 === $date2 && $date1year === $date2year;
            })->sum('TransAmount');
            $tenant['jan_payment'] = $all_tenant_payments->filter(function ($item) {
                $date2 = date('m', strtotime($item['created_at']));
                $date1 = date('01');
                return $date1 === $date2;
            })->sum('TransAmount');
            $tenant['feb_payment'] = $all_tenant_payments->filter(function ($item) {
                $date2 = date('m', strtotime($item['created_at']));
                $date1 = date('02');
                return $date1 === $date2;
            })->sum('TransAmount');
            $tenant['march_payment'] = $all_tenant_payments->filter(function ($item) {
                $date2 = date('m', strtotime($item['created_at']));
                $date1 = date('03');
                return $date1 === $date2;
            })->sum('TransAmount');
            $tenant['april_payment'] = $all_tenant_payments->filter(function ($item) {
                $date2 = date('m', strtotime($item['created_at']));
                $date1 = date('04');
                return $date1 === $date2;
            })->sum('TransAmount');
            $tenant['total_paid_mpesa'] = $all_tenant_payments->sum('TransAmount');
            $tenant['total_paid_in'] = $all_tenant_invoices->sum('paid_in');
            $tenant['total_payable'] = $all_tenant_invoices->sum('total_payable');
           
            $tenant['balance'] = $tenant['total_payable'] -$tenant['total_paid_mpesa'] ;
        }
        $data['tenants'] = $tenants;
        $data['date'] = date('d-m-Y');
        $fl_nm = 'Tenant_Summary.pdf';
        //return view('docs.testInvoiceView', $data);
        $pdf = \PDF::loadView('docs.testInvoiceView', $data);
         $pdf->setPaper('A3', 'landscape');
        return $pdf->stream($fl_nm);
       
    }
    public function preprinted(Request $request)
    {
         $fields = $request->validate([
            
            'apartment_id' => 'required'
        ]);
        $var1 = Carbon::now()->format('M-Y');
         $var = Carbon::now()->subMonth(1)->format('M-Y');
        $tenants = Invoice::where('apartment_id', $fields['apartment_id'])->where('rent_month', $var1)->where('type','!=','House Viewing')->get();
         $ten = Invoice::where('apartment_id', $fields['apartment_id'])->where('rent_month', $var1)->where('type','!=','House Viewing')->first();
        $all_rents = Invoice::where('rent_month', $var1)->where('apartment_id', $fields['apartment_id'])->where('type','!=','House Viewing')->sum('rent');
         $all_tenant_inv = Invoice::where('apartment_id', $fields['apartment_id'])->where('type','!=','House Viewing')->get();
         $all_tenant_view = Invoice::where('apartment_id', $fields['apartment_id'])->where('type','House Viewing')->get();
          $all_tenant_pay = Invoice::where('apartment_id', $fields['apartment_id'])->where('type','!=','House Viewing')->sum('paid_in');
        
        $all_sum = $all_tenant_inv->sum('rent') + $all_tenant_inv->sum('carryforward') + $all_tenant_inv->sum('electricity_bill') + $all_tenant_inv->sum('water_bill') + $all_tenant_inv->sum('compound_bill') + $all_tenant_inv->sum('litter_bill') + $all_tenant_inv->sum('security') + $all_tenant_inv->sum('other_bill') + $all_tenant_inv->sum('deposit_paid') ;
        $total_balance= $all_sum - $all_tenant_pay;
        foreach ($tenants as $tenant) {
            $all_tenant_invoices = Invoice::where('tenant_id', $tenant->tenant_id)->where('type','!=','House Viewing')->get();
           
            $all_tenant_rents = Invoice::where('tenant_id', $tenant->tenant_id)->where('rent_month', $var1)->where('type','!=','House Viewing')->get();
            
            $all_tenant_payments = ManualPayment::where('InvoiceNumber', $tenant->tenant->account_number)->orWhere('MSISDN', $tenant->tenant->phone)->get();
           $sum_view = $all_tenant_view->where('balance','<=',0)->sum('paid_in');
         
            $tenant['total_paid_mpesa'] = $all_tenant_payments->sum('TransAmount') - $sum_view;
            
            $tenant['rent'] = $all_tenant_rents->sum('rent');
            
            $tenant['total_paid_in'] = $all_tenant_invoices->sum('paid_in');
            $tenant['total_payable'] = $all_tenant_invoices->sum('rent') + $all_tenant_invoices->sum('carryforward') + $all_tenant_invoices->sum('electricity_bill') + $all_tenant_invoices->sum('water_bill') + $all_tenant_invoices->sum('compound_bill') + $all_tenant_invoices->sum('litter_bill') + $all_tenant_invoices->sum('security') + $all_tenant_invoices->sum('other_bill') + $all_tenant_invoices->sum('deposit_paid') ;
            
            $tenant['balance'] = $tenant['total_payable'] - $tenant['total_paid_mpesa']  ;
            
        }
      
        $data['tenants'] = $tenants;
        $data['ten'] = $ten;
        $data['all_rents'] = $all_rents;
        $data['total_balance'] = $total_balance;
        $data['date'] = date('d-m-Y');
        $fl_nm = $ten->apartment->name.' Preprinted Form.pdf';
        //return view('docs.testInvoiceView', $data);
        $pdf = \PDF::loadView('docs.preprinted', $data);
         $pdf->setPaper('A4', 'landscape');
        return $pdf->download($fl_nm);
       
    }
    // Public wrapper for tenant portal access
    public function getTenantDataPublic($tenant_id, $dates = [])
    {
        return $this->getTenantData($tenant_id, $dates);
    }
}
