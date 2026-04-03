<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\Deposit;
use App\Owner_invoices;
use App\Tenant_bill;
use App\Repair;
use App\HouseView;
use App\Events\NewHouseTenant;
use App\Events\VacateHouseTenant;
use App\House;
use App\Receipt;
use App\HouseTenant;
use App\TenantBillPayment;
use App\ServiceRequests;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\CreateHouseTenantRequest;
use App\Http\Requests\CreateMissingInvoicesRequest;
use App\Http\Requests\UpdateHouseTenantRequest;
use App\Http\Requests\DepositRefundRequest;
use App\Http\Requests\TenantRequest;
use App\Http\Requests\UpdateTenantRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Requests\InvoiceRequest;
use App\Invoice;
use App\ManualPayment;
use App\Overpayment;
use App\PlacementFee;
use App\Tenant;
use App\Traits\FileManager;
use App\Traits\NotifyClient;
use App\Traits\UtilTrait;
use Carbon\Carbon;
use DB;
use Hash;
use PDF;
use Illuminate\Http\Request;

class TenantsController extends Controller
{
    use NotifyClient;
    use UtilTrait;
    use FileManager;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
        return view('tenants.register');
    }
      public function houseview()
    {
        return view('houseviewing.create');
    }
      public function houseview_list()
    {
        return view('houseviewing.list');
    }
       public function houseviewingstore(Request $request)
    {
      try{
         $date = date("M-Y", strtotime($request->tarehe));
        $tenant = new HouseView;
        // $tenant->id = $request->id;
        $tenant->user_id = auth()->user()->org_id;
        $tenant->name = $request->name;
        $tenant->email = $request->email;
        $tenant->phone = $request->phone;
        $tenant->id_number = $request->id_number;
        $tenant->amount = 500;
        $tenant->tarehe = $request->tarehe;
        $tenant->type = $request->type;
        $tenant->account_number = $this->generateProspectiveTenantAccountNumber();
        

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Created Prospective Tenant ' . $tenant->full_name,
            'more_info' => 'New temporary account number generated and assigned:  ' . $tenant->account_number,
            'tenant_id' =>  '200',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);
        $tenant->save();
        $invoice = new Invoice;
            
            
            $invoice->tenant_acc = $tenant->account_number;
            $invoice->type = 'House Viewing';
            $invoice->other_bill  = $tenant->amount;
            $invoice->rent_month = $date;
            $total_payable = $tenant->amount;
            $tenant_name = $tenant->name;
            $tenant_phone = $tenant->phone;
            $invoice->total_payable = $total_payable;
            $invoice->balance = $total_payable;
            $invoice->tenant_name = $tenant_name; 
            $invoice->tenant_phone = $tenant_phone; 
            $invoice->user_id = auth()->user()->org_id;
            $invoice->save();
            
            
        $tenant_being_placed = HouseView::where('id', $tenant->id)->first();
        
        if( $tenant_being_placed){
            $smses = [];
        $sms_object = $this->welcomeHouseView([
            // 'phone' => $inv[0]->tenant->phone,
            'name' => $tenant_being_placed->name,
            'phone' => (int) $tenant_being_placed->phone,
            'account_number' => $tenant_being_placed->account_number,
        ]);
        array_push($smses, $sms_object);
        // $this->sendMessage($smses);
        }
        
        
        return back()->with('success', 'New prospective tenant has been added to the system for house viewing');
        }
        
        catch (\Exception $e) {
         DB::rollback();
         return back()->with('error', 'System error adding tenant for viewing, please contact the System Administrator.');
}
            
    }

    public function store(TenantRequest $request)
    {
    
        // $response = $this->generateUserAccountNumber();
        
        // dd($response);
        if($request->type_select == 'Company'){
        $request->validate([
            'filenames' => 'nullable',
            'filenames.*' => 'mimes:doc,pdf,docx,zip,jpeg,png,PNG,JPG,jpg',
            'company_name' => 'required',
            'contact_person' => 'required',
            'company_phone' => 'required|unique:tenants,phone',
        ]);
        }
         if($request->type_select == 'Tenant'){
        $request->validate([
            'filenames' => 'nullable',
            'filenames.*' => 'mimes:doc,pdf,docx,zip,jpeg,png,PNG,JPG,jpg',
            'full_name' => 'required',
            'phone' => 'required|unique:tenants,phone',
        ]);
        }
        $tenant = new Tenant;
        // $tenant->id = $request->id;
         if($request->type_select == 'Tenant'){
        $tenant->full_name = $request->full_name;
         $tenant->phone = $request->phone;
         }
          if($request->type_select == 'Company'){
        $tenant->full_name = $request->company_name;
         $tenant->phone = $request->company_phone;
            $tenant->person = $request->contact_person;
         }
     
        $tenant->type_select = $request->type_select;
        $tenant->email = $request->email;
        $tenant->user_id = auth()->user()->org_id;
        $tenant->password = Hash::make('$request->password');
        // $tenant->physical_address = $request->physical_address;
        $tenant->occupation = $request->occupation;
        // $tenant->occupied_at = $request->occupied_at;
        // $tenant->job_contact = $request->job_contact;
        $tenant->emergency_person = $request->emergency_person;
        $tenant->emergency_number = $request->emergency_number;
        $tenant->kin_id = $request->kin_id;
        $tenant->relationship = $request->relationship;
        $tenant->account_number = $this->generateUserAccountNumber();
        
        

        $files = $request->filenames;
        if ($files) {
            $response = $this->uploadFile($files, 'tenantContracts', $tenant->phone);
        }

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Created Tenant ' . $tenant->full_name,
            'more_info' => 'New account number generated and assigned:  ' . $tenant->account_number,
            'tenant_id' =>  '200',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);
        $tenant->save();
        
     
        
        return back()->with('success', 'New tenant has been added to the system');
//         }
        
//         catch (\Exception $e) {
//          DB::rollback();
//          return back()->with('error', 'System error adding tenant, please contact the System Administrator.');
// }
            
    }
     //start deposit refund //repair form
    public function deposit_refund($id)
    {
        $deposit_data = Invoice::findOrFail($id);
        return view('tenants.deposit_refund', compact('deposit_data'));
    }
 
    public function deposit_refund_store(DepositRefundRequest $request, $id)
    {
       $invoice = Invoice::find($id);
       
    //   try{
        
        // $request->validate([
        //     'filenames' => 'nullable',
        //     'filenames.*' => 'mimes:doc,pdf,docx,zip,jpeg,png,PNG,JPG,jpg',
        // ]);
        $repair = new Repair;
        // $tenant->id = $request->id;
        $repair->repaired_items = $request->repaired_items;
        $repair->total_repair_amount = $request->total_repair_amount;
        $repair->house_name = $request->house_name;
        $repair->house_id = $invoice->house_id;
        $repair->deposit_invoice_id = $request->deposit_invoice_id;
        $repair->tenant_name = $request->tenant_name;
        $repair->tenant_id = $invoice->tenant_id;
        $repair->apartment_name = $request->apartment_name;
        $repair->apartment_id = $invoice->apartment_id;
        $repair->repair_date = $request->repair_date;
        $repair->user_id = auth()->user()->org_id;
        $repair->deposit = $invoice->deposit_paid + $invoice->electricity_deposit_paid;
        $repair->save();
        
        $tnt_bills = new Tenant_bill;
        
        $tnt_bills->deposit_amount = $invoice->deposit_paid + $invoice->electricity_deposit_paid ;
        $tnt_bills->total_repair_amount = $request->total_repair_amount;
        $tnt_bills->deposit_invoice_id = $request->deposit_invoice_id;
        $tnt_bills->house_name = $request->house_name;
        $tnt_bills->house_id = $invoice->house_id;
        $tnt_bills->tenant_name = $request->tenant_name;
        $tnt_bills->tenant_id = $invoice->tenant_id;
        $tnt_bills->apartment_name = $request->apartment_name;
        $tnt_bills->apartment_id = $invoice->apartment_id;
        $tnt_bills->status = '0';
        $tnt_bills->user_id = auth()->user()->org_id;
        $tnt_bills->save();
       
        
        $owner = new Owner_invoices;
        
        $owner->deposit_amount = $invoice->deposit_paid + $invoice->electricity_deposit_paid ;
        $owner->owner_id = $invoice->apartment->landlord_id;
        $owner->deposit_invoice_id = $request->deposit_invoice_id;
        $owner->owner_name = $invoice->apartment->landlord->full_name;
        $owner->house_name = $request->house_name;
        $owner->house_id = $invoice->house_id;
        $owner->tenant_name = $request->tenant_name;
        $owner->tenant_id = $invoice->tenant_id;
        $owner->apartment_name = $request->apartment_name;
        $owner->apartment_id = $invoice->apartment_id;
        $owner->status = '0';
        $owner->user_id = auth()->user()->org_id;
        $owner->save();
        

        // $files = $request->filenames;
        // if ($files) {
        //     $response = $this->uploadFile($files, 'tenantContracts', $tenant->id);
        // }

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Tenant Deposit Bill ' . $invoice->tenant_name,
            'more_info' => 'New tenant bill with repair amount of :  ' . $request->total_repair_amount . 'created. Deposit Invoice number INV'.$invoice->id ,
            'tenant_id' =>  '200',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);
        
        Invoice::where('id', $invoice->id)->update(['locking' => '1']);

        
       $inv = Invoice::where('id', $request->deposit_invoice_id)->first();
             $inv->update([
                    'total_payable' => ($inv->total_payable - $inv->deposit_paid - $inv->electricity_deposit_paid),
                    'deposit_paid' => 0,
                    'electricity_deposit_paid' => 0,
                    'balance' => $inv->total_payable - $inv->deposit_paid - $inv->electricity_deposit_paid - $inv->paid_in,
                ]);
        
        
      
        return redirect()->route('tenant.show', [$invoice->tenant_id])
            ->with('success', 'New tenant bill and repair amount of ' . $request->total_repair_amount . ' has been added to the system');
//         }
        
//         catch (\Exception $e) {
//          DB::rollback();
//          return back()->with('error', 'System error adding tenant, please contact the System Administrator.');
// }
            
    }
    public function payBill($id)
    {
        $deposit_data = Tenant_bill::findOrFail($id);
        return view('tenants.pay_bill', compact('deposit_data'));
    }
public function payInvoiceNowadmin(Request $request, $id)
    {   
        $deposit_data = Tenant_bill::findOrFail($id);
        
        $attributes = $request->validate([
            'invoice_type' => 'required',
            'tenant_id' => 'required',
            'payment_type' => 'required',
            'reference' => 'required',
            'amount' => 'required',
            'payment_date' => 'required',
        ]);
       
        $pymt = TenantBillPayment::where('TransID', $attributes['reference'])->first();
        $tenant = Tenant_bill::where('id', $request->tenant_bill_id)->get();
        // dd( $deposit_data->deposit_invoice_id);
        $inv = Invoice::where('id', $deposit_data->deposit_invoice_id)->first();
        $repair = Repair::where('deposit_invoice_id', $deposit_data->deposit_invoice_id)->first();
        $owner = Owner_invoices::where('deposit_invoice_id', $deposit_data->deposit_invoice_id)->first();

        if ($pymt) {
            return back()->with('error', 'Payment with transaction code ' . $attributes['reference'] . ' has already been added');
        }
        else{
        $payment = TenantBillPayment::create([
                    'TransactionType' => $attributes['payment_type'],
                    'MSISDN' => $deposit_data->tenant->phone,
                    'TransID' => $attributes['reference'],
                    'TransAmount' => $attributes['amount'],
                    'InvoiceNumber' => $deposit_data->tenant->account_number,
                    'full_name' => $deposit_data->tenant_name,
                    'payment_date' => $attributes['payment_date'],
                    'tenant_id' => $deposit_data->tenant_id,
                    'invoice_type' => $attributes['invoice_type'],
                    'user_id' => auth()->user()->org_id,
                ]);
         
                $repair->update([
                    'status' => '1',
                    'balance' => '0',
                    'paid_in' => $repair->deposit_amount,
                ]);
                $owner->update([
                    'status' => '1',
                    'balance' => '0',
                    'paid_in' => $owner->deposit_amount,
                ]);
                $deposit_data->update([
                    'status' => '1',
                    'balance' => '0',
                    'paid_in' => $deposit_data->deposit_amount,
                ]);
                $inv->update([
                    'locking' => '2',
                ]);
               
                
                $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Invoice Manual Payment by Administrator:' . auth()->user()->username,
            'more_info' => 'Invoice Type: Deposit Refund ',
            'tenant_id' => '1',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
        ]);
            }

         return redirect()->route('tenant.show', [$deposit_data->tenant_id])
            ->with('success', 'Deposit refunded successfully');
 
    }
    public function showBill($id, $action = null)
    {
        $invoice = Tenant_bill::findOrFail($id);


        switch ($action) {
            case 'print':
                return view('tenants.invoiceprint', compact('invoice'));
        //     case 'message':
        //         $current_invoice = Invoice::with('tenant')->where('id',$id)->first();
                
        //     $smses = [];
        //     $sms_object = $this->invoiceMessageFormat([
        //         // 'phone' => $inv[0]->tenant->phone,
        //         'tenant' => $current_invoice->tenant,
        //         'to_pay' =>  $current_invoice->balance,
        //         'phone' => (int) $current_invoice->tenant->phone,
        //     ]);
        // array_push($smses, $sms_object);
        // $this->sendMessage($smses);
        //         return back()->with('success', 'Message sent successfully'); 
            case 'pdf':
                // return view('invoices.invoicepdf', compact('invoice', 'billings', 'overpayment'));

                $pdf = PDF::loadView('tenants.invoicepdf', compact('invoice'));
                return $pdf->download($invoice->tenant_name. 'Deposit_Bill_#'.$id.'.pdf');
            default:
                return view('tenants.tenant_invoice_view', compact('invoice'));
                break;
        }

    }
    
    
    
    
    public function contract(Request $request){
        
        $request->validate([
            'filenames' => 'nullable',
            'filenames.*' => 'mimes:doc,pdf,docx,zip,jpeg,png,PNG,JPG,jpg',
        ]);
        $files = $request->filenames;
        if ($files) {
            $response = $this->uploadFileContracts($files, 'agencyDoc');
        }
        return back()->with('success', 'New Document uploaded');
       
    }

    public function report($idd)
    {
        $tenant_payments = ManualPayment::where('MSISDN', $idd)->get();
        $invoices = Invoice::with('tenant')->where('tenant_id', $idd)->get();

        // return response()->json([$tenant_payments, $invoicee,$idd]);
        $pdf = PDF::loadView('report.tenant_reportpdf', compact('invoices', 'tenant_payments'));
        return $pdf->stream('Tenant' . $idd . '.pdf');
    }

    public function show($id)
    {
        $tenant = Tenant::findOrFail($id);
        $houzez = HouseTenant::where('tenant_id', $id)->where('user_id', auth()->user()->org_id)->get();
        $houzes = HouseTenant::where('tenant_id', $id)->where('user_id', auth()->user()->org_id)->first();
        $overpayment = 0;
        $overpayment = Overpayment::where('tenant_id', $id)->where('user_id', auth()->user()->org_id)->value('amount');
        $tenant_payment = ManualPayment::where('InvoiceNumber', $tenant->account_number)->get();
          
        $deposits = Deposit::where('tenant_id', $id)->where('user_id', auth()->user()->org_id)->get();
        $placements = PlacementFee::where('tenant_id', $id)->where('user_id', auth()->user()->org_id)->get();
        $invoiz = Invoice::where('deposit_paid', '!=', '0')->where('user_id', auth()->user()->org_id)->where('tenant_id', $id)->get();
        $repairs = Repair::where('tenant_id', $id)->where('user_id', auth()->user()->org_id)->get();
        $tenant_bill = Tenant_bill::where('tenant_id', $id)->where('user_id', auth()->user()->org_id)->get();
        foreach($tenant_payment as $payment){
         $receipt = Receipt::where('transaction_code', $payment->TransID)->where('user_id', auth()->user()->org_id)->first();
         if($receipt){
             $payment['receipt'] =$receipt->id;
         }else{
             $payment['receipt'] =false;
         }
        }
        return view('tenants.show', compact('tenant','tenant_payment','houzes', 'houzez', 'overpayment', 'deposits', 'placements', 'invoiz', 'repairs', 'tenant_bill'));

    }

    public function edit($id)
    {
        $tenant = Tenant::findOrFail($id);
        return view('tenants.edt', compact('tenant'));
    }

    public function update(UpdateTenantRequest $request, $id)
    {
       
        
        
        
        
        
        $tenant = Tenant::find($id);
        if($request->type_select == 'Tenant'){
        $tenant->full_name = $request->full_name;
         $tenant->phone = $request->phone;
         }
          if($request->type_select == 'Company'){
        $tenant->full_name = $request->company_name;
         $tenant->phone = $request->company_phone;
            $tenant->person = $request->contact_person;
         }
       
        $tenant->type_select = $request->type_select;
        $tenant->id_number = $request->id_number;
        $tenant->email = $request->email;
        $tenant->physical_address = $request->physical_address;
        $tenant->occupation = $request->occupation;
        $tenant->emergency_person = $request->emergency_person;
        $tenant->emergency_number = $request->emergency_number;
        $tenant->kin_id = $request->kin_id;
        $tenant->relationship = $request->relationship;
        $tenant->save();


        $files = $request->filenames;
        if ($files) {
            $response = $this->uploadFile($files, 'tenantContracts', $tenant->id);
        }

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Edited Tenant ' . $tenant->full_name,
            'more_info' => 'Tenant Account Number ' . $tenant->account_number,
            'tenant_id' =>  $tenant->id,
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);

        return redirect()->route('tenant.show', [$tenant])
            ->with('success', 'Tenant details has been updated');

    }
    public function destroy($idd)
    {
        try{
        $tenant = Tenant::findOrFail($idd);
        $invoices = Invoice::where('tenant_id', $idd)->get();
        if($invoices){
        $invoices = Invoice::where('tenant_id', $idd)->forceDelete();
        }
        $service_request = ServiceRequests ::where('tenant_id', $idd)->get();
        if($service_request){
        $service_request = ServiceRequests ::where('tenant_id', $idd)->forceDelete();
        }
        $deposit = Deposit ::where('tenant_id', $idd)->get();
        if($deposit){
         $deposit = Deposit ::where('tenant_id', $idd)->forceDelete();
        }
        $house_tenant = HouseTenant::where('tenant_id', $idd)->get();
        if($house_tenant){
        foreach ($house_tenant as $house) {
            House::where('id', $house->house_id)
                ->update(['is_occupied' => '0']);
        }

        }
        $house_tenant = HouseTenant::where('tenant_id', $idd)->forceDelete();
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Deleted Tenant ' . $tenant->full_name,
            'more_info' => 'Tenant Account Number ' . $tenant->account_number,
            'tenant_id' =>  $tenant->id,
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);
     
        $tenant->forceDelete();

        return back()->with('success', 'Tenant has been permanently deleted from system and all information about the tenant will never be recovered.');
        }
        catch (\Exception $e) {
         DB::rollback();
         return back()->with('error', 'System error deleting tenant, please contact the System Administrator.');
}
    

    }

    public function deActivate()
    {

    }

    function list() {
        $tenants = House::get();

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
                $date1 = date('m');
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
        // return view('docs.testInvoiceView', );

        return view('tenants.all', $data);
  
    }

    public function assignRoom($house_id = null)
    {

        if ($house_id) {

            $house = House::findOrFail($house_id);
            $tenants = Tenant::pluck('id', 'full_name');
            return view('tenants.assign_vacant_room', compact('house', 'tenants'));
            // return response() -> json([$house, $tenants]);
            // return view('tenants.assign_vacant_room', compact('house','apartments', 'tenants'));

        } else {
            $apartments = Apartment::pluck('id', 'name');
            $tenants = Tenant::pluck('id', 'full_name');
            return view('tenants.asign_room', compact('apartments', 'tenants'));
        }

    }
    public function assignp_tenantRoom()
    {

        
            $apartments = Apartment::pluck('id', 'name');
           $tenants = HouseView::pluck('id', 'name');
        return view('houseviewing.asign_room', compact('apartments', 'tenants'));
        

    }
    public function assignRoomedit($house_id)
    {
        
        $house_tenants = HouseTenant::findOrFail($house_id);
         $date = date("M-Y", strtotime($house_tenants->placement_date));
        
        $tenants = Tenant::pluck('id', 'full_name');
        $apartments = Apartment::pluck('id', 'name');
        $placement_fee = PlacementFee::pluck('id', 'tenant_id', 'placement_month');
        $house = House::pluck('id', 'house_no');
        $invoice = Invoice::where('house_id', $house_tenants->house_id)->where('tenant_id', $house_tenants->tenant_id)->where('rent_month', $date)->get();
        return view('tenants.assign_roomedit', compact('apartments', 'house', 'tenants', 'placement_fee', 'house_tenants','invoice'));
    }
   
  public function missingInvoices(CreateMissingInvoicesRequest $request, $id)
    {
             
             
        $house_tenants = HouseTenant::find($id);
        // $houses = House::with('rent', 'house_tenant')->occupied()->get();
        // DB::beginTransaction();
        // try {
          // $invoices = new Invoice;
           $var = Carbon::now()->format('M-Y');
           $date = Carbon::createFromFormat('Y-m-d', $house_tenants->placement_date)->format('M-Y');
           $date1 = Carbon::createFromFormat('Y-m-d', $house_tenants->placement_date)->addMonthsNoOverflow()->format('M-Y');
           

$dates = [1,2,3,4,5,6,7,8];
//$today = date();
$start_date = date('Y-m-d', strtotime('2020-10-1'));
foreach( $dates as $key => $value ){
    $date_new = date('M-Y',strtotime($start_date . ' +'.$value.' month'));
    //echo $key."\t=>\t".$date_new."\n";
    
    
     $current_month_invoice = Invoice::where('rent_month', $date_new)
                ->where('house_id', $house_tenants->house->id)
                ->where('apartment_id', $house_tenants->house->apartment_id)
                ->where('tenant_id', $house_tenants->tenant->id)->first();
            
   

            if (!$current_month_invoice) {
                $current_month_invoice =  Invoice::create([
                    'rent' => $house_tenants->house->rent->amount,
                    'electricity_bill' => $house_tenants->house->rent->electricity_bill,
                    'water_bill' => $house_tenants->house->rent->water_bill,
                    'litter_bill' => $house_tenants->house->rent->litter_bill,
                    'compound_bill' => $house_tenants->house->rent->compound_bill,
                    'security' => $house_tenants->house->rent->security,
                    'other_bill' => $house_tenants->house->rent->others,
                    'type' => 'Monthly Rent',
                    'rent_month' => $date_new,
                    'house_id' => $house_tenants->house->id,
                    'apartment_id' => $house_tenants->house->apartment_id,
                    'tenant_id' => $house_tenants->tenant_id,
                    'house_name' => $house_tenants->house->house_no,
                    'apartment_name' => $house_tenants->house ->apartment->name,
                    'tenant_name' => $house_tenants->tenant->full_name]
                );
            }


  
        
        //add sms body here

        //DB::commit();
        // $this->storedeposit($request->id, $request->tenant_id);
        //Artisan::call('invoice:initialize');
        // return back()->with('success', 'All invoices have been generated, .');

        //return redirect()->route('invoice.prepare', $invoices)->with('success', 'New Tenant has been assigned a house, proceed to adding bill then generate invoice');

        // } catch (\Exception $e) {
        //     DB::rollback();
        //     Log::info($e);
        //     return back()->with('error', 'Internal Error occured during this process.Contact Admin for more info');

        // }
        
        //  $monthly_bills = MonthlyBilling::selectRaw('SUM(billing_amount) as sum_bills,house_id')
        //     ->where('billing_month', $date1)
        //     ->groupBy('house_id')
        //     ->get();

        // foreach ($monthly_bills as $bill) {
        //     Invoice::where('house_id', $bill->house_id)
        //         ->where('rent_month', $date1)
        //         ->update(['bills' => $bill->sum_bills]);
        // }

        //Query to compute carry overs from previous month
        // $this->generateCarryForwards($x);

        //Query to compute overpayments from previous month
        $overpayments = Invoice::where('rent_month','<', $date_new)->where('balance', '<', 0)->get();

        foreach ($overpayments as $overpayment) {
            Invoice::where('house_id', $overpayment->house_id)
                ->where('tenant_id', $overpayment->tenant_id)
                ->where('rent_month', $date_new)
                ->update(['paid_in' => $overpayment->balance*-1]);

        }
        $balance = Invoice::where('rent_month', '<', $date_new)->where('balance', '<', 0)->get();

        foreach ($balance as $overpayment) {
            Invoice::where('house_id', $overpayment->house_id)
                ->where('rent_month', '<', $date_new)
                ->where('tenant_id', $overpayment->tenant_id)
                ->update(['balance' => ($overpayment->balance - $overpayment->balance)]);

        }
       
        // $this->generateOtherBill($x);
        
        
        
        // $this->generateElectricityBill($var);
        
        // $this->generateCompoundBill($var);
        
        // $this->generateLitterBill($var);
        
        //Autofill Total Payable
         $invoices = Invoice::where('rent_month', $date_new)->get();

        foreach ($invoices as $invoice) {
            Invoice::where('house_id', $invoice->house_id)
                ->where('tenant_id', $invoice->tenant_id)
                ->where('rent_month', $date_new)
                ->update(['total_payable' => ($invoice->rent + $invoice->electricity_bill + $invoice->compound_bill + $invoice->litter_bill + $invoice->other_bill + $invoice->deposit_paid)]);

        }
         $invoices = Invoice::where('rent_month', $date_new)->get();

        foreach ($invoices as $invoice) {
            Invoice::where('house_id', $invoice->house_id)
                ->where('tenant_id', $invoice->tenant_id)
                ->where('rent_month', $date_new)
                ->update(['balance' => ($invoice->total_payable - $invoice->paid_in)]);

        }

         
        //Auto calculate the remaining balance to be paid
      
        
        //Bulk mark invoices as paid,update Overpayment
        $invoices = Invoice::where('rent_month', $date_new)->where('balance', '<=', 0)->get();

        foreach ($invoices as $invoice) {
            Invoice::where('house_id', $invoice->house_id)
                ->where('tenant_id', $invoice->tenant_id)
                ->where('rent_month', $date_new)
                ->update(['is_paid' => 1,
                    'payment_method' => 'Reconciled']);

        }
}
            return back()->with('success', 'Tenant invoices '.$date_new.' have been generated');
    }
     public function allocatep_tenantHouse(CreateHouseTenantRequest $request)
    {
        $p_tenant = HouseView::where('id', $request->tenant_id)->first();
         $request->validate([
            'filenames' => 'nullable',
            'filenames.*' => 'mimes:doc,pdf,docx,zip,jpeg,png,PNG,JPG,jpg',
        ]);
        $tenant = new Tenant;
        // $tenant->id = $request->id;
        $tenant->full_name = $p_tenant->name;
        $tenant->email = $p_tenant->email;
        $tenant->phone = $p_tenant->phone;
        $tenant->user_id = auth()->user()->org_id;
        $tenant->occupation = $request->occupation;
        $tenant->password = Hash::make('$request->password');
        $tenant->emergency_person = $request->emergency_person;
        $tenant->emergency_number = $request->emergency_number;
        $tenant->relationship = $request->relationship;
        $tenant->account_number = $this->generateUserAccountNumber();
        
        

        $files = $request->filenames;
        if ($files) {
            $response = $this->uploadFile($files, 'tenantContracts', $tenant->phone);
        }

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Turned a Prospective Tenent to Tenant ' . $tenant->full_name,
            'more_info' => 'New account number generated and assigned:  ' . $tenant->account_number,
            'tenant_id' =>  '200',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);
        $tenant->save();
        
      
        
  
        
        
        
        //dd($request->placement_date);

        // DB::beginTransaction();
        // try {
      
           $var = Carbon::now()->format('M-Y');
            // // Associate Tenant with Vacant Room
            $house_tenant = new HouseTenant;
            $house_tenant->user_id = auth()->user()->org_id;
            $house_tenant->house_id = $request->house_id;
            $house_tenant->tenant_id = $tenant->id;
            $house_tenant->placement_date = $request->placement_date;
            $house_tenant->save();
           

            //Record the deposit tenant pays

            if ($request->deposit_amount > 0) {
                $deposit = new Deposit;
                $deposit->user_id = auth()->user()->org_id;
                $deposit->house_id = $request->house_id;
                $deposit->tenant_id = $tenant->id;
                $deposit->amount = $request->deposit_amount;
                $deposit->apartment_id = $request->apartment;
                $deposit->start_month = $var;
                $deposit->save();
            }

            //First rent is recorded as placement fee
            $date = date("M-Y", strtotime($request->placement_date));
           // return response()->json($request->placement_date);
            $placement_fee = new PlacementFee;
            $placement_fee->tenant_id = $tenant->id;
            $placement->user_id = auth()->user()->org_id;
            $placement_fee->house_id = $request->house_id;
            $placement_fee->amount = $request->rent_amount;
            $placement_fee->apartment_id = $request->apartment;
            $placement_fee->placement_month = $date;
            $placement_fee->save();
            //First rent and deposit invoice record
            
            $fee = Apartment::where('id',$request->apartment )->first();
            $invoice = new Invoice;
            
            
            $invoice->tenant_id = $tenant->id;
            $invoice->type = 'rent and deposit';
            $invoice->rent = $request->rent;
            // $invoice->deposit = $request->rent;
                $invoice->placementfee = $request->rent * ($fee->management_fee_percentage / 100);
            $invoice->carryforward  = $request->arrears;
            $invoice->deposit_paid = $request->deposit_amount;
            $invoice->electricity_deposit_paid = $request->electricity_deposit_amount;
            $invoice->electricity_bill  = $request->electricity_bill;
            $invoice->water_bill  = $request->water_bill;
            $invoice->compound_bill  = $request->compound_bill;
            $invoice->litter_bill  = $request->litter_bill; 
            $invoice->security  = $request->security;
            $invoice->other_bill  = $request->other_bill;
            $invoice->house_id = $request->house_id;
            $invoice->user_id = auth()->user()->org_id;
            
            $invoice->apartment_id = $request->apartment;
            $invoice->rent_month = $date;
            $total_payable = $invoice->rent + $invoice->deposit_paid + $invoice->carryforward + $invoice->electricity_deposit_paid + $invoice->security + $invoice->electricity_bill + $invoice->water_bill + $invoice->compound_bill + $invoice->litter_bill + $invoice->other_bill;
            
            $house_name = $invoice->house->house_no;
            $tenant_name = $invoice->tenant->full_name;
            $apartment_name = $invoice->apartment->name;
            $invoice->total_payable = $total_payable;
            $invoice->balance = $total_payable;
            $invoice->house_name = $house_name; 
            $invoice->tenant_name = $tenant_name; 
            $invoice->tenant_phone = $invoice->tenant->phone; 
            $invoice->apartment_name = $apartment_name; 
            $invoice->save();

        // Trigger event to make house as occupied
        event(new NewHouseTenant($house_tenant->house_id));
        
        //add sms body here
    
        //DB::commit();
        // $this->storedeposit($request->id, $request->tenant_id);
        //Artisan::call('invoice:initialize');
          
        $p_payment = ManualPayment::where('InvoiceNumber', $p_tenant->account_number )->get();
        if($p_payment){
        foreach($p_payment as $payment){
           $payment->update([
                    'InvoiceNumber' => $tenant->account_number,
                  
                ]);   
        }
        }
        
          $p_invoice = Invoice::where('tenant_acc', $p_tenant->account_number)->first();  
          $p_invoice->update([
                    'tenant_id' => $tenant->id,
                    'house_id' => $request->house_id,
                    'apartment_id' => $request->apartment,
                  
                ]);
        
        
        
        $tenant_being_placed = Tenant::where('id', $tenant->id)->first();
        
        if( $tenant_being_placed){
            $smses = [];
        $sms_object = $this->welcomeMessageFormat([
            // 'phone' => $inv[0]->tenant->phone,
            'tenant' => $tenant_being_placed,
            'phone' => (int) $tenant_being_placed->phone,
        ]);
        array_push($smses, $sms_object);
        // $this->sendMessage($smses);
        }
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Assigned Prospective Tenant House ' . $house_name . ' in ' . $invoice->apartment->name,
            'more_info' => 'Tenant assigned house is:  ' . $tenant_name,
            'tenant_id' =>  $invoice->tenant_id,
            'invoice_id' =>  $invoice->id,
            'house_id' =>  $invoice->house_id,
            'apartment_id' => $invoice->apartment_id,
            'landlord_id' => $invoice->apartment->landlord_id,
            'servicerequest_id' => '0',
            'bill_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);
        
        $p_tenant->delete();
        return back()->with('success', 'New tenant has been assigned a house and invoice generated');

        //return redirect()->route('invoice.prepare', $invoices)->with('success', 'New Tenant has been assigned a house, proceed to adding bill then generate invoice');

        // } catch (\Exception $e) {
        //     DB::rollback();
        //     Log::info($e);
        //     return back()->with('error', 'Internal Error occured during this process.Contact Admin for more info');

        // }

    }

    public function allocateHouse(CreateHouseTenantRequest $request)
    {
        //dd($request->placement_date);
         $houses = House::where('id', $request->house_id)->first();
        // DB::beginTransaction();
        // try {
          // $invoices = new Invoice;
           $var = Carbon::now()->format('M-Y');
           //$date = Carbon::parse($request->placement_date)->format('M-Y');
            // // Associate Tenant with Vacant Room
            $house_tenant = new HouseTenant;
            $house_tenant->house_id = $request->house_id;
            $house_tenant->tenant_id = $request->tenant_id;
            $house_tenant->placement_date = $request->placement_date;
            $house_tenant->user_id = auth()->user()->org_id;
            $house_tenant->save();
           

            //Record the deposit tenant pays

            if ($request->deposit_amount > 0) {
                $deposit = new Deposit;$request->tenant_id;
                $deposit->house_id = $request->house_id;
                $deposit->tenant_id = $request->tenant_id;
                $deposit->amount = $request->deposit_amount;
                $deposit->apartment_id = $request->apartment;
                $deposit->start_month = $var;
                $deposit->user_id = auth()->user()->org_id;
                $deposit->save();
            }

            //First rent is recorded as placement fee
            $date = date("M-Y", strtotime($request->placement_date));
           // return response()->json($request->placement_date);
            $placement_fee = new PlacementFee;
            $placement_fee->tenant_id = $request->tenant_id;
            $placement_fee->house_id = $request->house_id;
            $placement_fee->amount = $request->rent_amount;
            $placement_fee->apartment_id = $request->apartment;
            $placement_fee->placement_month = $date;
            $placement_fee->user_id = auth()->user()->org_id;
            $placement_fee->save();
            //First rent and deposit invoice record
            
            $fee = Apartment::where('id',$request->apartment )->first();
            $invoice = new Invoice;
            
            
            $invoice->tenant_id = $request->tenant_id;
            $invoice->type = 'rent and deposit';
            $invoice->rent = $request->rent;
            // $invoice->deposit = $request->rent;
            $invoice->placementfee = $request->rent * ($fee->management_fee_percentage / 100);
            $invoice->carryforward  = $request->arrears;
            $invoice->deposit_paid = $request->deposit_amount;
            $invoice->electricity_deposit_paid = $request->electricity_deposit_amount;
            $invoice->electricity_bill  = $request->electricity_bill;
            $invoice->water_bill  = $request->water_bill;
            $invoice->compound_bill  = $request->compound_bill;
            $invoice->litter_bill  = $request->litter_bill; 
            $invoice->security  = $request->security;
            $invoice->other_bill  = $request->other_bill;
            $invoice->house_id = $request->house_id;
            $invoice->user_id = auth()->user()->org_id;
            $invoice->apartment_id = $request->apartment;
            $invoice->rent_month = $date;
            $total_payable = ($invoice->rent + $invoice->deposit_paid + $invoice->carryforward + $invoice->electricity_deposit_paid + $invoice->security + $invoice->electricity_bill + $invoice->water_bill + $invoice->compound_bill + $invoice->litter_bill + $invoice->other_bill) * $invoice->house->rent_const;
            
            $house_name = $invoice->house->house_no;
            $tenant_name = $invoice->tenant->full_name;
            $apartment_name = $invoice->apartment->name;
            $invoice->total_payable = $total_payable;
            $invoice->balance = $total_payable;
            $invoice->house_name = $house_name; 
            $invoice->tenant_name = $tenant_name; 
            $invoice->apartment_name = $apartment_name; 
            $invoice->save();

        // Trigger event to make house as occupied
        event(new NewHouseTenant($house_tenant->house_id));
        
        //add sms body here
    
        //DB::commit();
        // $this->storedeposit($request->id, $request->tenant_id);
        //Artisan::call('invoice:initialize');
        $tenant_being_placed = Tenant::where('id', $request->tenant_id)->first();
        
        if( $tenant_being_placed){
            $smses = [];
        $sms_object = $this->welcomeMessageFormat([
            // 'phone' => $inv[0]->tenant->phone,
            'tenant' => $tenant_being_placed,
            'phone' => (int) $tenant_being_placed->phone,
        ]);
        array_push($smses, $sms_object);
        // $this->sendMessage($smses);
        }
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Assigned Tenant House ' . $house_name . ' in ' . $invoice->apartment->name,
            'more_info' => 'Tenant assigned house is:  ' . $tenant_name,
            'tenant_id' =>  $invoice->tenant_id,
            'invoice_id' =>  $invoice->id,
            'house_id' =>  $invoice->house_id,
            'apartment_id' => $invoice->apartment_id,
            'landlord_id' => $invoice->apartment->landlord_id,
            'servicerequest_id' => '0',
            'bill_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);
        return back()->with('success', 'New tenant has been assigned a house and invoice generated, .');

        //return redirect()->route('invoice.prepare', $invoices)->with('success', 'New Tenant has been assigned a house, proceed to adding bill then generate invoice');

        // } catch (\Exception $e) {
        //     DB::rollback();
        //     Log::info($e);
        //     return back()->with('error', 'Internal Error occured during this process.Contact Admin for more info');

        // }

    }
    
      public function welcome_sms(Request $request, $id)
    {
        
        
        $tenant_being_placed = Tenant::where('id', $id)->first();
        
        if( $tenant_being_placed){
            $smses = [];
        $sms_object = $this->welcomeMessageFormat([
            // 'phone' => $inv[0]->tenant->phone,
            'tenant' => $tenant_being_placed,
            'phone' => (int) $tenant_being_placed->phone,
        ]);
        array_push($smses, $sms_object);
        // return response()->json($smses);
        // $this->sendMessage($smses);
        }
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Resend Welcoming Message to ' . $tenant_being_placed->full_name,
            'more_info' => 'Message sent successfully ',
            'tenant_id' =>  $tenant_being_placed->id,
            'invoice_id' =>  '0',
            'house_id' =>  '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'servicerequest_id' => '0',
            'bill_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);
        return back()->with('success', 'Welcoming message has been resend successfully');

       

    }
    
    
    
    public function updateallocateHouse(UpdateHouseTenantRequest $request, $id)
    {   
        
         $house_tenants = HouseTenant::find($id);
         $date1 = date("M-Y", strtotime($request->placement_date));
        
        $invoices = Invoice::where('house_id', $house_tenants->house_id)->where('rent_month', $date1)->delete();
        $house_tenant = HouseTenant::where('house_id', $house_tenants->house_id)->delete();
            //fire event to make house as Vacant
            event(new VacateHouseTenant($house_tenants->house_id));
            DB::commit();
        
        
        $house_tenant = new HouseTenant;
        $house_tenant->house_id = $request->house_id;
        $house_tenant->tenant_id = $request->tenant_id;
        $house_tenant->placement_date = $request->placement_date;
        $house_tenant->save();
        
        $invoice = new Invoice;
            
            $date = date("M-Y", strtotime($request->placement_date));
            $invoice->tenant_id = $request->tenant_id;
            $invoice->type = 'rent and deposit';
            $invoice->rent = $request->rent;
            // $invoice->deposit = $request->rent;
            $invoice->placementfee = $request->rent * 0.1;
            $invoice->carryforward  = $request->arrears;
            $invoice->deposit_paid = $request->deposit_amount;
            $invoice->electricity_deposit_paid = $request->electricity_deposit_amount;
            $invoice->electricity_bill  = $request->electricity_bill;
            $invoice->water_bill  = $request->water_bill;
            $invoice->compound_bill  = $request->compound_bill;
            $invoice->litter_bill  = $request->litter_bill; 
            $invoice->other_bill  = $request->other_bill;
            $invoice->house_id = $request->house_id;
            
            $invoice->apartment_id = $request->apartment;
            $invoice->rent_month = $date;
            $total_payable = $invoice->rent + $invoice->deposit_paid + $invoice->carryforward + $invoice->electricity_deposit_paid + $invoice->electricity_bill + $invoice->water_bill + $invoice->compound_bill + $invoice->litter_bill + $invoice->other_bill;
            
            $house_name = $invoice->house->house_no;
            $tenant_name = $invoice->tenant->full_name;
            $apartment_name = $invoice->apartment->name;
            $invoice->total_payable = $total_payable;
            $invoice->balance = $total_payable;
            $invoice->house_name = $house_name; 
            $invoice->tenant_name = $tenant_name; 
            $invoice->apartment_name = $apartment_name; 
            $invoice->save();
            
            
        // Trigger event to make house as occupied
        event(new NewHouseTenant($house_tenant->house_id));
       

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Tenant Reassigned' . $house_tenant->tenant->full_name,
            'more_info' => 'Tenant Account Number ' . $house_tenant->tenant->account_number,
             'tenant_id' =>  $invoice->tenant_id,
            'invoice_id' =>  $invoice->id,
            'house_id' =>  $invoice->house_id,
            'apartment_id' => $invoice->apartment_id,
            'landlord_id' => $invoice->apartment->landlord_id,
            'servicerequest_id' => '0',
            'bill_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);

        return redirect()->route('house.occupied')
            ->with('success', 'Tenant has been reassigned and a new invoice is generated');

    }

    

    public function showPasswordForm($id)
    {
        return view('tenants.change_pass')->with('tenant_id', $id);
    }
    public function updatePassword(ChangePasswordRequest $request, $id)
    {
        $tenant = Tenant::find($id);
        $tenant->password = Hash::make($request->new_password);
        $tenant->save();

        return redirect()->route('tenant.show', [$tenant])
            ->with('success', 'Tenant password has been reset.');

    }

    public function vacateHouse($house_id)
    {

        DB::beginTransaction();
          try{
            $house_tenant = HouseTenant::where('house_id', $house_id)->first();
            //fire event to make house as Vacant
             $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Tenant vacated from house ' . $house_tenant->house->house_no. ' in ' . $house_tenant->house->apartment->name ,
            'more_info' => 'Tenant vacated is:  ' . $house_tenant->tenant->full_name,
            'tenant_id' =>  $house_tenant->tenant_id,
            'house_id' =>  $house_tenant->house_id,
            'apartment_id' => $house_tenant->house->apartment_id,
            'landlord_id' => $house_tenant->house->apartment->landlord_id,
            'servicerequest_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);
        $house_tenant->delete();
            event(new VacateHouseTenant($house_id));
           
            DB::commit();
            return redirect()->back()->with('success', 'Tenant has been vacated from the house');
          }
         catch (\Exception $e) {
         DB::rollback();
         return back()->with('error', 'System error Vacating Tenant, please contact the System Administrator.');
      }
         
    }
    private function dateFormater($date_format, $date, $converted_format)
    {
        return \DateTime::createFromFormat($date_format, $date)->format($converted_format);
    }
    
    private function welcomeMessageFormat($notificationBody)
    {
        $userData = (object) $notificationBody;
        $account_number = $userData->tenant->account_number;

        // $amount = $userData->to_pay;

        $tenant_full_name = $userData->tenant->full_name;
        $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
        $tenant_first_name = $arr_names[0]; // will print Test

        $format = "Dear %s,\nWelcome to Lipa Kodi.\nYour tenant account number is %d:\nMake all payments on or before 5th of every month via Mpesa using: \nPaybill:  \nAccount: %s";
        $message_text = sprintf($format, $tenant_first_name, $account_number, $account_number);

        $message_text .= "\nFor enquiries call 0718095463.";

        $data = [
            'from' => config('app.sms_client'),
            'to' => (int) config('app.sms_admin_phone'),
            'text' => $message_text,
        ];

        return $data;

    }
     private function welcomeHouseView($notificationBody)
    {
        $userData = (object) $notificationBody;
        $account_number = $userData->account_number;

        // $amount = $userData->to_pay;

        $tenant_full_name = $userData->name;
        $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
        $tenant_first_name = $arr_names[0]; // will print Test

        $format = "Dear %s,\nWelcome to Lipakodi Management System.\nYour temporary tenant account number is %d:\nMake the payment via Mpesa using: \nPaybill: 000000 \nAccount: %s";
        $message_text = sprintf($format, $tenant_first_name, $account_number, $account_number);

        $message_text .= "\nFor enquiries call 0718095463.";

         $data = [
            'from' => config('app.sms_client'),
            'to' => (int) config('app.sms_admin_phone'),
            'text' => $message_text,
        ];

        return $data;

    }

}
