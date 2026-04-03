<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Apartment;
use App\Bills;
use App\BillsPayment;
use App\BillManagerPayments;
use App\Http\Requests\BillsRequest;
use App\PayOwners;
use App\Invoice;
use App\Landlord;
use App\ServiceRequests;
use App\Tenant;
use App\Traits\UtilTrait;
use App\Traits\DocTrait;
use App\User;
use Carbon\Carbon as CarbonCarbon;

class BillsController extends Controller
{
    use UtilTrait;
    use DocTrait;

    public function create()
    {
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $service_requests = ServiceRequests::where('status', 0)->get();
        $users = User::all();
        return view('bills.create', compact('tenants', 'apartments', 'service_requests', 'users'));

    }

    public function pay()
    {
        $apartment = Apartment::pluck('id', 'name');
        $grouped_apartments = Payowners::with('landlord')->where('apartment_id','>', 0)->where('pay_status', '==', 0)->where('rent','>', 0)->where('balance','>', 0)->get()->groupBy('apartment_id');
        // $grouped_apartment = Invoice::with('tenant')->where('apartment_id','>', 0)->where('paid_in', '>', 0)->where('rent','>', 0)->get()->groupBy('apartment_id');
        $apt_grouped= [];
        foreach( $grouped_apartments as $grp_apt){
            $rent = $this->sumArrayOfObjects($grp_apt,'rent');
            $electricity = $this->sumArrayOfObjects($grp_apt,'electricity');
            $water = $this->sumArrayOfObjects($grp_apt,'water');
            $compound = $this->sumArrayOfObjects($grp_apt,'compound');
            $litter = $this->sumArrayOfObjects($grp_apt,'litter');
            $security = $this->sumArrayOfObjects($grp_apt,'security');
             $amount = $this->sumArrayOfObjects($grp_apt,'balance');
            array_push($apt_grouped,[
                'id'=>$grp_apt[0]['apartment_id'],
              'rent'=>$rent,
              'electricity'=>$electricity,
              'water'=>$water,
              'compound'=>$compound,
              'litter'=>$litter,
              'security'=>$security,
              'amount' => $amount,
                'apartment_name'=>$grp_apt[0]['apartment']['name'],
                'landlord_name'=>$grp_apt[0]['landlord']['full_name'],
                ]);
        }
       
        
        //dd((object)$apt_grouped);
        $payowners = PayOwners::where('type', '--select--')->where('approval', '1')->get();
        $payowner = PayOwners::where('type','!=', '--select--')->where('type','!=', 'Rent Collection')->where('approval', '1')->get();
        return view('bills.pay', compact('apartment', 'payowners', 'payowner', 'apt_grouped'));
    }

    function list() {
        return view('bills.list');
    }
     function payments() {
        return view('bills.payments');
    }
    function paymentlist() {
        return view('bills.paymentlist');
    }

    public function store(BillsRequest $request)
    { 

        try{
        $var = CarbonCarbon::now()->format('M-Y');
        
        if($request->bill_type === 'property'){
                   $bills = new PayOwners;
        $bills->id = $request->id;
        $bills->type = $request->type;
        $bills->new_type = $request->new_type;
        $bills->bill_type = $request->bill_type;
        
        $bills->apartment_id = $request->apartment_id;
        
        $landlord = $bills->apartment->landlord_id;
        $bills->landlord_id = $landlord;
        if($request->approval == 0){
        $bills->total_owned_edit = $request->bill_amount;
        }else{
          $bills->total_owned = $request->bill_amount;  
        }
         $bills->approval = $request->approval;
        $bills->rent_month = $var;
         $amount = $bills->total_owned - $bills->paid_in;
         $amount2 = $bills->total_owned_edit - $bills->paid_in;
       if($request->approval == 0){
          $bills->balance_edit = $amount2;
          $bills->description_edit = $request->bill_description;
       }else{
           $bills->balance = $amount;
           $bills->description = $request->bill_description;
       }
       
        // $bills->description = $request->bill_description;
        $bills->agency_user = $request->agency_user;
        $bills->save();
            
        }else{
            
            
        $bills = new PayOwners;
        
        if($request->proof){
            $file = $request->proof;
             $fl_name = time() . '_' . 'agency_file' . '.' . $file->getClientOriginalExtension();
            \Storage::disk('local')->putFileAs('agency_files/', $file, $fl_name);
            $bills->proof =  $fl_name;
        }
        $bills->id = $request->id;
        $bills->type = $request->type;
        $bills->bill_type = $request->bill_type;

        $bills->apartment_id = null;
        if($request->approval == 0){
        $bills->total_owned_edit = $request->bill_amount;
        }else{
          $bills->total_owned = $request->bill_amount;  
        }
        
        $bills->rent_month = $var;
        $amount = $bills->total_owned - $bills->paid_in;
        $amount2 = $bills->total_owned_edit - $bills->paid_in;
        
         if($request->approval == 0){
          $bills->balance_edit = $amount2;
          $bills->description_edit = $request->bill_description;
       }else{
           $bills->balance = $amount;
           $bills->description = $request->bill_description;
       }
        $bills->approval = $request->approval;
        
        $bills->agency_user = $request->agency_user;
        $bills->save();
        }
    

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Bill Created',
            'more_info' => 'Bill Type ' . $request->type,
            'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => $request->id,
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
        ]);

        

        return back()->with('success', 'Bill has been raised to the system');
        }
         catch (\Exception $e) {
         DB::rollback();
         return back()->with('error', 'System error adding bill, please contact the developer.');
}

    }
    public function paymentdelete($id)
    {
        $payments = BillManagerPayments::findOrFail($id);
       $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Manual Bill Payment Deleted',
            'more_info' => 'It was a pending bill payment',
            'servicerequest_id' => '0',
            'tenant_id' => '0',
            'house_id' => '0',
            'apartment_id' => '1',
            'landlord_id' => '1',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
         
        ]);
        $payments->delete();

        return back()->with('success', 'Pending Payment has been deleted from system');

    }
     public function paymentedit($id)
    {
        
        $managerpayment = BillManagerPayments::findOrFail($id);
        $payowners = PayOwners::pluck('id', 'apartment_id','landlord_id');
       
        $tenants = Tenant::pluck('id', 'full_name');
        
        return view('payowners.paymentedit', compact('managerpayment', 'payowners', 'tenants'));
    }
    public function payManagerNow(Request $request)
    {
        $attributes = $request->validate([
            'apartment_id' => 'nullable',
            'type' => 'nullable',
            'reference' => 'required',
            'amount' => 'required',
            'payment_date' =>'required',
            'agency_user' =>'nullable',
            'service_Provider' =>'nullable',
            'agency_service_provider' => 'nullable',
            'agency_bill_for' => 'nullable',
            'bill_for' =>'nullable',
            'payment_type' =>'required',
            'landlord_id' =>'nullable',
            'id' =>'nullable',
            
        ]);
        if ($attributes['type'] === 'agency') {
            $pay = PayOwners::where('id', $attributes['landlord_id'])->first();
            if ($pay) {
                $payment = BillManagerPayments::create([
                    'TransactionType' => $attributes['payment_type'],
                    'MSISDN' => $attributes['landlord_id'],
                    'TransID' => $attributes['reference'],
                    'bill_for' => $attributes['agency_bill_for'],
                    'service_provider' => $attributes['agency_service_provider'],
                    'TransAmount' => $attributes['amount'],
                    'full_name' => 'Agency Bill',
                    'InvoiceNumber' => $attributes['reference'],
                    'Manager' => auth()->user()->username,
                    'payment_date' => $attributes['payment_date'],
                    'bill_type' => 'agency',
                    'status' => '0',
                ]);
                // $pay_status = $pay->balance - $attributes['amount'] > 0 ? 0 : 1;
                // $balance = $pay->balance - $attributes['amount'];
                // $pay->update([
                //     'pay_status' => $pay_status,
                //     'balance' => $balance,
                //     'paid_in' => $attributes['amount'],
                    
                // ]);
               if($pay->landlord_id == null){
                $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Manager Bill Payment',
                    'more_info' => 'Bill Type: Agency Bill',
                     'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '1',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]);
                }
                else{
                   $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Manager Bill Payment',
                    'more_info' => 'Bill Type: Agency Bill '  . $pay->landlord->full_name,
                     'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => $pay->landlord_id,
                    'bill_id' => '1',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]); 
                }
            }

            return back()->with('success', 'Payment added successfully pending authorization from the Administrator');
        }elseif ($attributes['type'] === 'owner_expense') {
            $pay = PayOwners::where('id', $attributes['landlord_id'])->first();
            if ($pay) {
                $payment = BillManagerPayments::create([
                    'TransactionType' => $attributes['payment_type'],
                    'MSISDN' => $attributes['landlord_id'],
                    'TransID' => $attributes['reference'],
                    'TransAmount' => $attributes['amount'],
                    'bill_for' => $attributes['bill_for'],
                    'service_provider' => $attributes['service_provider'],
                    'full_name' => $pay->apartment->name,
                    'InvoiceNumber' => $attributes['reference'],
                    'Manager' => auth()->user()->username,
                    'payment_date' => $attributes['payment_date'],
                    'bill_type' => 'agency',
                    'status' => '0',
                ]);
                // $pay_status = $pay->balance - $attributes['amount'] > 0 ? 0 : 1;
                // $balance = $pay->balance - $attributes['amount'];
                // $pay->update([
                //     'pay_status' => $pay_status,
                //     'balance' => $balance,
                //     'paid_in' => $attributes['amount'],
                    
                // ]);
               if($pay->landlord_id == null){
                $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Manager Owner Expense Bill Payment',
                    'more_info' => 'Bill Type: Owner Expense Bill',
                     'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '1',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]);
                }
                else{
                   $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Manager Bill Payment',
                    'more_info' => 'Bill Type: Agency Bill '  . $pay->landlord->full_name,
                     'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => $pay->landlord_id,
                    'bill_id' => '1',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]); 
                }
            }

            return back()->with('success', 'Payment added successfully pending authorization from the Administrator');
        }else{
             $pay = PayOwners::where('id', $attributes['apartment_id'])->first();
            $payment = BillManagerPayments::create([
                'TransactionType' => $attributes['payment_type'],
                'MSISDN' => $attributes['apartment_id'],
                'TransID' => $attributes['reference'],
                'TransAmount' => $attributes['amount'],
                'full_name' => $pay->apartment->name,
                'Manager' => auth()->user()->username,
                'InvoiceNumber' => $attributes['reference'],
                'payment_date' => $attributes['payment_date'],
                'bill_type' => 'property',
                'status' => '0',
            ]);
             $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Bill Payment',
                    'more_info' => 'Bill Type: Property Bill ' . $pay->apartment->name . ' Amount: Ksh.' . $payment->TransAmount,
                     'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => $pay->apartment->id,
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]);
            // $payment = ManualPayment::where('MSISDN', '254700088168')->first();
            // $landlord_invoices_to_pay =PayOwners::where('apartment_id', $attributes['apartment_id'])->get();
            // $balance_reached = $this->updateClientInvoices($landlord_invoices_to_pay, $payment->TransAmount);
            return back()->with('success', 'Payment added successfully pending authorization from the Administrator');
        }
        

    }
    
     public function payNowUpdate(Request $request, $id)
    {
        $approve_pymt = BillManagerPayments::find($id);
        $pay = PayOwners::where('id', $approve_pymt->MSISDN)->first(); 
        // $tenant = Tenant::where('id', $approve_pymt->tenant_id)->first();
        $pymt = BillsPayment::where('TransID', $approve_pymt->TransID)->first();
        

        if ($pymt) {
            return back()->with('error', 'Payment with transaction code ' . $approve_pymt->TransID . ' has already been added');
        }
        if ($pay->bill_type === 'agency') {
            // $pay = PayOwners::where('id', $attributes['landlord_id'])->first();
            if ($pay) {
                 $approve_pymt->update([
                    'status' => $request->approval,
                   
                ]);
                $status = $request->approval;
                if($status == 1){
                $payment = BillsPayment::create([
                    'TransactionType' => $approve_pymt->TransactionType,
                    'MSISDN' => $approve_pymt->MSISDN,
                    'TransID' => $approve_pymt->TransID,
                    'TransAmount' => $approve_pymt->TransAmount,
                    'service_provider' => $approve_pymt->service_provider,
                    'bill_for'=> $approve_pymt->bill_for,
                    'InvoiceNumber' => $approve_pymt->InvoiceNumber,
                    'payment_date' => $approve_pymt->payment_date,
                    'full_name' => $approve_pymt->full_name,
                ]);
                
                $pay_status = $pay->balance - $approve_pymt->TransAmount > 0 ? 0 : 1;
                $balance = $pay->balance - $approve_pymt->TransAmount;
                $pay->update([
                    'pay_status' => $pay_status,
                    'balance' => $balance,
                    'paid_in' => $pay->paid_in + $approve_pymt->TransAmount,
                    
                ]);
               
                if($pay->landlord_id == null){
                $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Approve Owner Expense Bill Payment',
                    'more_info' => 'Bill Type: Owner Expense Bill',
                     'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '1',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]);
                }
                else{
                   $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Approve Owner Expense Bill Payment',
                    'more_info' => 'Bill Type: Owner Expense Bill '  . $pay->landlord->full_name,
                     'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => $pay->landlord_id,
                    'bill_id' => '1',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]); 
                }
                 return back()->with('success', 'Payment added successfully');   
                }else{
                  return back()->with('error', 'Payment not added successfully');   
                }
            }
                elseif ($pay->bill_type === 'owner_expense') {
            // $pay = PayOwners::where('id', $attributes['landlord_id'])->first();
            if ($pay) {
                 $approve_pymt->update([
                    'status' => $request->approval,
                   
                ]);
                $status = $request->approval;
                if($status == 1){
                $payment = BillsPayment::create([
                    'TransactionType' => $approve_pymt->TransactionType,
                    'MSISDN' => $approve_pymt->MSISDN,
                    'TransID' => $approve_pymt->TransID,
                    'TransAmount' => $approve_pymt->TransAmount,
                    'InvoiceNumber' => $approve_pymt->InvoiceNumber,
                    'payment_date' => $approve_pymt->payment_date,
                    'full_name' => $approve_pymt->full_name,
                ]);
                
                $pay_status = $pay->balance - $approve_pymt->TransAmount > 0 ? 0 : 1;
                $balance = $pay->balance - $approve_pymt->TransAmount;
                $pay->update([
                    'pay_status' => $pay_status,
                    'balance' => $balance,
                    'paid_in' => $pay->paid_in + $approve_pymt->TransAmount,
                    
                ]);
               
                if($pay->landlord_id == null){
                $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Approve Owner Expense Bill Payment',
                    'more_info' => 'Bill Type: Owner Expense Bill',
                     'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '1',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]);
                }
                else{
                   $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Approve Owner Expense Bill Payment',
                    'more_info' => 'Bill Type: Owner Expense Bill '  . $pay->landlord->full_name,
                     'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => $pay->landlord_id,
                    'bill_id' => '1',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]); 
                }
                 return back()->with('success', 'Payment added successfully');   
                }else{
                  return back()->with('error', 'Payment not added successfully');   
                }
            }

            
        }else{
             $pay = PayOwners::where('id', $approve_pymt->MSISDN)->first();
             $approve_pymt->update([
                    'status' => $request->approval,
                   
                ]);
                $status = $request->approval;
                if($status == 1){
                
            $payment = BillsPayment::create([
                
                'TransactionType' => $approve_pymt->TransactionType,
                    'MSISDN' => $approve_pymt->MSISDN,
                    'TransID' => $approve_pymt->TransID,
                    'TransAmount' => $approve_pymt->TransAmount,
                    'InvoiceNumber' => $approve_pymt->InvoiceNumber,
                    'payment_date' => $approve_pymt->payment_date,
                    'full_name' => $approve_pymt->full_name,
            ]);
            
             $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Approved Rent Collection Bill Payment',
                    'more_info' => 'Bill Type: Property Bill ' . $pay->apartment->name . ' Amount: Ksh.' . $payment->TransAmount,
                     'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => $pay->apartment->id,
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]);
               
            // $payment = ManualPayment::where('MSISDN', '254700088168')->first();
            $landlord_invoices_to_pay =PayOwners::where('apartment_id', $approve_pymt->MSISDN)->get();
            $balance_reached = $this->updateClientInvoices($landlord_invoices_to_pay, $payment->TransAmount);
               
            return back()->with('success', 'Payment authorized successfully');
                }
                else
                {
                    return back()->with('error', 'Payment not authorized to the system ');
                    
                }
           }
        }
        

    }


    
    public function payNow(Request $request)
    {
        $attributes = $request->validate([
            'apartment_id' => 'nullable',
            'type' => 'nullable',
            'reference' => 'required',
            'amount' => 'required',
            'payment_date' =>'required',
            'service_provider' => 'nullable',
            'bill_for' => 'nullable',
            'agency_service_provider' => 'nullable',
            'agency_bill_for' => 'nullable',
            'agency_user' =>'nullable',
            'payment_type' =>'required',
            'landlord_id' =>'nullable',
            'id' =>'nullable',
            
        ]);
        if ($attributes['type'] === 'agency') {
            $pay = PayOwners::where('id', $attributes['landlord_id'])->first();
            if ($pay) {
                $payment = BillsPayment::create([
                    'TransactionType' => $attributes['payment_type'],
                    'MSISDN' => $attributes['landlord_id'],
                    'TransID' => $attributes['reference'],
                    'TransAmount' => $attributes['amount'],
                    'bill_for' => $attributes['agency_bill_for'],
                    'service_provider' => $attributes['agency_service_provider'],
                    'InvoiceNumber' => $attributes['reference'],
                    'payment_date' => $attributes['payment_date'],
                    'full_name' => 'Agency',
                ]);
                $pay_status = $pay->balance - $attributes['amount'] > 0 ? 0 : 1;
                $balance = $pay->balance - $attributes['amount'];
                $pay->update([
                    'pay_status' => $pay_status,
                    'balance' => $balance,
                    'paid_in' =>$pay->paid_in + $attributes['amount'],
                    
                ]);
                if($pay->landlord_id == null){
                $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Approve Owner Expense Bill Payment',
                    'more_info' => 'Bill Type: Owner Expense Bill',
                     'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '1',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]);
                }
                else{
                   $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Approve Owner Expense Bill Payment',
                    'more_info' => 'Bill Type: Owner Expense Bill '  . $pay->landlord->full_name,
                     'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => $pay->landlord_id,
                    'bill_id' => '1',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]); 
                }
                 return back()->with('success', 'Payment added successfully');   }else{
                  return back()->with('error', 'Payment not added successfully');   
                }
        }
                elseif ($attributes['type'] === 'owner_expense') {
            $pay = PayOwners::where('id', $attributes['landlord_id'])->first();
         
            if ($pay) {
                $payment = BillsPayment::create([
                    'TransactionType' => $attributes['payment_type'],
                    'MSISDN' => $attributes['landlord_id'],
                    'TransID' => $attributes['reference'],
                    'TransAmount' => $attributes['amount'],
                    'bill_for' => $attributes['bill_for'],
                    'service_provider' => $attributes['service_provider'],
                    'InvoiceNumber' => $attributes['reference'],
                    'payment_date' => $attributes['payment_date'],
                    'full_name' => $pay->apartment->name,
                ]);
                $pay_status = $pay->balance - $attributes['amount'] > 0 ? 0 : 1;
                $balance = $pay->balance - $attributes['amount'];
                $pay->update([
                    'pay_status' => $pay_status,
                    'balance' => $balance,
                    'paid_in' =>$pay->paid_in + $attributes['amount'],
                    
                ]);
                if($pay->landlord_id == null){
                $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Owner Expense Bill Payment by Administrator',
                    'more_info' => 'Bill Type: Owner Expense Bill ' ,
                     'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '1',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]);
                }
                else{
                   $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Owner Expense Bill Payment by Administrator',
                    'more_info' => 'Bill Type: Owner Expense Bill '  . $pay->landlord->full_name,
                     'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => $pay->landlord_id,
                    'bill_id' => '1',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]); 
                }
            }
            return back()->with('success', 'Payment added successfully');
                }

         
            else{
             $pay = PayOwners::where('apartment_id', $attributes['apartment_id'])->first();
            //  dd($pay);
            $payment = BillsPayment::create([
                'TransactionType' => $attributes['payment_type'],
                'MSISDN' => $attributes['apartment_id'],
                'TransID' => $attributes['reference'],
                'TransAmount' => $attributes['amount'],
                'InvoiceNumber' => $attributes['reference'],
                'payment_date' => $attributes['payment_date'],
                'full_name' => $pay->apartment->name,
            ]);
            
             $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Bill Payment',
                    'more_info' => 'Bill Type: Property Bill ' . $pay->apartment->name . ' Amount: Ksh.' . $payment->TransAmount,
                     'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => $pay->apartment->id,
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]);
            // $payment = ManualPayment::where('MSISDN', '254700088168')->first();
            $landlord_invoices_to_pay =PayOwners::where('apartment_id', $attributes['apartment_id'])->get();
            $balance_reached = $this->updateClientInvoices($landlord_invoices_to_pay, $payment->TransAmount);
            return back()->with('success', 'Payment done successfully');
        }
        

    }
        
  

    

    public function bills()
    {
        $bills = Bills::all();
        // $var = CarbonCarbon::now()->format('M-Y');

        //Auto calculate the remaining balance to be paid
        $this->setBalance($bills);

        $this->billMonth($bills);

    }

    public function billMonth($id)
    {
        $var = CarbonCarbon::now()->format('M-Y');

        $billmonth = Bills::where('id', $id);

        foreach ($billmonth as $bill) {
            Bills::where('id', $bill->id)
                ->update(['bill_month' => $var]);

        }

    }

    public function setBalance($id)
    {
        $var = CarbonCarbon::now()->format('M-Y');

        $balance = Bills::where('id', $id);

        foreach ($balance as $bal) {
            Bills::where('id', $id)
                ->update(['balance' => ($bal->bill_amount - $bal->paid_in)]);

        }

    }
    
    private function updateClientInvoices($client_invoices, $total_amt_for_month_paid)
    {
        $x = 1;
        $balance_wallet = $total_amt_for_month_paid;
        $length = count($client_invoices);

        foreach ($client_invoices as $client_invoice) {

            if ($balance_wallet > 0) {
                $paid_in = $balance_wallet >= $client_invoice->balance ? $client_invoice->balance : $balance_wallet;
                $balance = $balance_wallet >= $client_invoice->balance ? 0 : $client_invoice->balance - $balance_wallet;
                $client_invoice->update([
                    'paid_in' => $client_invoice->paid_in + $paid_in,
                    'balance' => $balance,
                    'pay_status' => ($balance <= 0) ? true : false,
                    // 'payment_method' => 'Cash',
                ]);
                $balance_wallet = $balance_wallet - $paid_in;

                if ($x === $length && $balance_wallet > $client_invoice->balance) {
                    $client_invoice->update([
                        'balance' => $client_invoice->balance - $balance_wallet,
                    ]);
                }
                $x++;
            }

        }
    }

}
