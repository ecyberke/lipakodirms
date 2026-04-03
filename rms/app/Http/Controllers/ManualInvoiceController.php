<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManualInvoiceRequest;
use App\Invoice;
use App\ManualPayment;
use App\ManagerPayment;
use App\Tenant;
use Carbon\Carbon as CarbonCarbon;
use App\Traits\FileManager;
use App\Traits\NotifyClient;
use App\Traits\UtilTrait;
use Illuminate\Http\Request;

class ManualInvoiceController extends Controller
{
    use NotifyClient;
    use UtilTrait;
    use FileManager;
    public function create()
    {
        return view('manualinvoices.create');
    }

    public function pay()
    {
        $tenants = Tenant::pluck('id', 'full_name');
        $invoices = Invoice::where('rent', 0)->get();
        return view('manualinvoices.pay', compact('tenants', 'invoices'));
    }
   

    function list() {
        return view('manualinvoices.list');
    }
    function payments() {
        return view('manualinvoices.payments');
    }
    function paymentlist() {
        return view('manualinvoices.paymentlist');
    }

    public function destroy($id)
    {
        $payments = ManualPayment::findOrFail($id);
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Manual Payment Deleted',
            'more_info' => 'It was an approved payment',
            'servicerequest_id' => '0',
            'tenant_id' => '1',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
         
        ]);
        $payments->delete();

        return back()->with('success', 'Approved Payment has been deleted from system');

    }
    public function paymentdelete($id)
    {
        $payments = ManagerPayment::findOrFail($id);
       $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Manual Payment Deleted',
            'more_info' => 'It was a pending payment',
            'servicerequest_id' => '0',
            'tenant_id' => '1',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
         
        ]);
        $payments->delete();

        return back()->with('success', 'Pending Payment has been deleted from system');

    }
    public function store(ManualInvoiceRequest $request)
    {
        // return response()->json($request->all());
        $attributes = $request->validate([
            'type' => 'required',
            'tenant_name' => 'required',
            'apartment_name' => 'required',
            'house_name' => 'required',
            'total_payable' => 'required',
            'description' => 'required',
        ]);
        // return response()->json($request->all());
        $var = CarbonCarbon::now()->format('M-Y');

        Invoice::create([
            'rent' => 0,
            'type' => $request->type,
            'total_payable' => $request->total_payable,
            'balance' => $request->total_payable,
            'tenant_name' => $request->tenant_name,
            'apartment_name' => $request->apartment_name,
            'house_name' => $request->house_name,
            'description' => $request->description,
            'rent_month' => $var,
            'tenant_phone' => $request->tenant_phone,
            //'source_tenant_phone'=>$request->source_tenant_phone, //should add column to db then uncomment
            // 'house_id' => 1, //should make house id nullable for now I used 1
            // 'apartment_id' => 1, //should make apartment id nullable for now I used 1
            // 'tenant_id' => 1, //should make tenant id nullable for now I used 1
        ]);

        return back()->with('success', 'An invoice has been raised to the system awaiting payment');

    }
     public function paymentedit($id)
    {
        
        $managerpayment = ManagerPayment::findOrFail($id);
        $invoices = Invoice::pluck('id', 'tenant_id');
       
        $tenants = Tenant::pluck('id', 'full_name');
        
        return view('manualinvoices.paymentedit', compact('managerpayment', 'tenants'));
    }
     public function accountedit($id)
    {
        $account = ManualPayment::findOrFail($id);
        $tenant = Tenant::where('account_number', $account->InvoiceNumber)->first();
        $tenants = Tenant::all();
        return view('manualinvoices.rerouting', compact('tenant','account','tenants'));
    }
    public function accountupdate(Request $request, $id)
    {
        $tenant = ManualPayment::find($id);
        $tenant->InvoiceNumber = $request->InvoiceNumber;
        
        $tenant->save();


       

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Rerouted Payment to ' . $tenant->InvoiceNumber,
            'more_info' => 'The payment was made to a wrong account and successfully rerouted to account ' . $tenant->InvoiceNumber,
            'servicerequest_id' => '0',
            'tenant_id' => '1',
            'house_id' => '1',
            'apartment_id' => '1',
            'landlord_id' => '1',
            'bill_id' => '0',
            'invoice_id' => '1',
            'sms_id' => '0',
            'user_id' => '0',
        ]);

     return back()->with('success', 'Payment Rerouted Successfully');

    }

}
