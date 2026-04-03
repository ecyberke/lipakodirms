<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\ManualPayment;
use App\MonthlyBilling;
use App\Overpayment;
use App\PayOwners;
use App\Landlord;
use App\Tenant;
use App\Apartment;
use App\Traits\DocTrait;
use App\Traits\UtilTrait;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;

class DocController extends Controller
{
    use DocTrait;
    use UtilTrait;

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
        // dd($request);
        $fields = $request->validate([
            'rent_month' => 'required',
            'apartment_id' => 'required'
        ]);
        
        $rent_month = date("M-Y", strtotime($fields['rent_month']));
     
        $previous_rent_month = date("M-Y", strtotime ( '-1 month' , strtotime ( $fields['rent_month'] ) )) ;
      
        $month_invoices = Invoice::with('tenant','house')->where('rent_month', $rent_month)->where('type','!=','House Viewing')->where('apartment_id', $fields['apartment_id'])->get()->sortBy('house_id');
        $previous_month_invoices = Invoice::with('tenant','house')->where('rent_month','<=', $previous_rent_month)->where('type','!=','House Viewing')->where('apartment_id', $fields['apartment_id'])->get()->sortBy('house_id');

        $property_info = Apartment::with('landlord')->where('id',$month_invoices[0]['apartment_id'])->first();
        // ['rent_month','apartment_name','house_name','rent','total_payable','carryforward','paid_in']
        
        foreach ($month_invoices as $invoice) {
            $prev_arreas = Invoice::where('tenant_id', $invoice->tenant_id)->where('rent_month', '!=', $rent_month)->sum('total_payable');
            $all_invs = Invoice::where('tenant_id', $invoice->tenant_id)->where('type','!=','House Viewing')->get();
            $total_current_month = Invoice::where('tenant_id', $invoice->tenant_id)->where('rent_month', $rent_month)->where('type','!=','House Viewing')->sum('total_payable');
           
            
            $all_invs = $all_invs->filter(function ($value, $key) use ($rent_month) {
                if (strtotime($value['rent_month']) <= strtotime($rent_month)) {
                    return true;
                }
            });
            $prev_invs = $all_invs->filter(function ($value, $key) use ($rent_month) {
                if (strtotime($value['rent_month']) < strtotime($rent_month)) {
                    return true;
                }
            });
            
            $invoice['total_payable'] = $total_current_month + $prev_invs->sum('balance');
            $invoice['balance'] = $all_invs->sum('balance');
        }
        $total_paid_in =  $month_invoices->sum('paid_in');
        $total_rent =  $month_invoices->sum('rent');
        $total_payable =  $month_invoices->sum('total_payable');
        $total_carryforward =  $month_invoices->sum('deposit_paid');
        $total_balance =  $total_payable-$total_paid_in;
        $total_bills =  $month_invoices->sum('electricity_bill') + $month_invoices->sum('litter_bill') + $month_invoices->sum('water_bill') + $month_invoices->sum('security') +$month_invoices->sum('compound_bill') + $month_invoices->sum('other_bill');
        
        $property_name =  $property_info->name;
        $property_owner =  $property_info->landlord->full_name;
        // dd($month_invoices);
        // dd($total_paid_in);

        
        $filled ='yes';
        if ($request->download) {
            $download ='yes';
            if($request->filled === 'no'){
            $filled ='no';
            }
        }else{
            $download='no';
        }
        $info = [
            'entries'=>$month_invoices,
            'rent_month'=> $rent_month,
            'total_paid_in'=>$total_paid_in,
            'total_rent'=>$total_rent,
            'total_bills'=>$total_bills,
            'total_payable'=>$total_payable,
            'total_carryforward'=>$total_carryforward,
            'total_balance'=>$total_balance,
            'property_owner'=>$property_owner,
            'property_name'=>$property_name,
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

        
        return $this->propertyStatusViewTester($info,$download,$filled);
        return response()->json($info);
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
}
