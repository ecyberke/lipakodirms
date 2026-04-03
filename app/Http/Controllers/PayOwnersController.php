<?php

namespace App\Http\Controllers;

use App\PayOwners;
use App\Apartment;
use App\Invoice;
use App\Landlord;
use App\User;
use App\Http\Requests\PayOwnersRequest;
use App\ServiceRequests;
use Illuminate\Http\Request;
use App\Traits\UtilTrait;

class PayOwnersController extends Controller
{
    use UtilTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function list()
    {
     
        return view('payowners.list');
    }
    public function totals()
    {
     
        return view('payowners.totals');
    }
    public function payowners( $id)
    {
        $payowners = PayOwners::find($id)->where('approval','==', 1);
        // $payowners = PayOwners::where('apartment_id',$id)->selectRaw('SUM(total_owned) as smnt, SUM(paid_in) as paidtotal, SUM(balance) as bal, apartment_id')
        // ->groupBy('apartment_id')->get();
        //$invoice = Invoice::where('apartment_id', $id)->get();
        // $payowners = PayOwners::selectRaw('SUM(total_owned) as smnt, SUM(paid_in) as paidtotal, SUM(balance) as bal, landlord_id')
        // ->groupBy('landlord_id')->get();
        // $apartments = Apartment::pluck('id','landlord_id','name', 'town', 'management_fee_percentage');
        // $landlords = Landlord::pluck('id','full_name', $id);
        // return response()->json([$pay]);

        return view('payowners.pay', compact('payowners'));
    }
    public function payment($id, $amount)
    {
        // $apartments = Apartment::pluck('id','landlord_id','name', 'town', 'management_fee_percentage');
        $landlord_billables = PayOwners::where('id',$id)->get();

        $balance = $amount;
        foreach($landlord_billables as $bill){
            if($balance > 0){
                $paid_in = $amount > $bill->total_owned ? $bill->total_owned : $amount;
                $balance = $amount > $bill->total_owned ? 0 : $bill->total_owned - $amount;
                $bill->update([
                    'paid_in'=>$paid_in,
                    'balance'=>$balance,
                    // 'is_paid' => ($balance - $request->paid_in <= 0) ? true : false,
                    // 'transaction_type' => $request->transaction_type,
                ]);
                $balance = $balance - $paid_in;
            }
        }


        return view('owner.pay');
    }
    public function pay(Request $request)
    {
        // dd($request);

        // DB::beginTransaction();
        // try {
        // $landlord_billables = PayOwners::where('landlord_id',$request->landlord_id)->selectRaw('SUM(total_owned) as smnt, SUM(paid_in) as paidtotal, SUM(balance) as bal, landlord_id')
        // ->groupBy('landlord_id')->get();

        $landloard_billables = PayOwners::with('apartment')->where('apartment_id', $request->apartment_id)->get();
        //grab current invoice balance
        $balance = $request->paid_in;
        $length = count($landloard_billables);
        $x = 1;
        foreach($landloard_billables as $bill){
            if($balance > 0){
                $paid_in = $balance > $bill->total_owned ? $bill->total_owned : $balance;
                $balance_to_update = $balance > $bill->total_owned ? 0 : $bill->total_owned - $balance;
                $bill->update([
                    'paid_in' => $paid_in,
                    'balance' => $balance_to_update,
                    'pay_status' => ($balance_to_update - $request->paid_in <= 0) ? true : false,
                    'transaction_code' => $request->transaction_code,
                ]);
                $balance = $balance - $paid_in;
                
                if($x === $length && $balance > $bill->balance){
                    $bill->update([
                        'overpayment' => ($balance - $bill->balance)
                    ]);
                }
                
                $x++;
            }

        }
       
        
        // $invoice->save();

        // if ($request->current_overpayment > 0) {
        //     $overpayment = Overpayment::where('tenant_id', $request->tenant_id)->update([
        //         'amount' => 0,
        //     ]);
        // }

        // if ($request->filled('new_overpayment')) {
        //     $overpayment_2 = Overpayment::updateOrCreate(
        //         ['tenant_id' => $request->tenant_id],
        //         ['amount' => $request->new_overpayment]
        //     );

        // }
       
 $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Payed bills',
            'more_info' => 'Payed bills for apartment:' . $landloard_billables[0]->apartment->name , $landloard_billables[0]->landlord->full_name,
            'bill_id' => '1',
            'tenant_id' =>  '0',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
           
            
        ]);
        
       // $this->sendEmail((object) $notificationBody);
        return redirect()->route('payowners.list')
            ->with('success', 'Payment for ' . $landloard_billables[0]->landlord->full_name . ' has been successfully paid');

        // } catch (\Exception $th) {
        //     DB::rollback();
        //     return back()->with('error', 'Error with database');

        //  }

    }

    /**
     * Show the form for creating a new resource. 
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PayOwners  $payOwners
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payowners = PayOwners::findOrFail($id);
        return view('payowners.payowners', compact('payowners'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PayOwners  $payOwners
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {
        
        $payowners = PayOwners::findOrFail($id);
       
        $apartments = Apartment::pluck('id', 'name');
        // $tenants = Tenant::pluck('id', 'full_name');
        $service_requests = ServiceRequests::where('status', null)->get();
        $users = User::all();
        return view('payowners.edit', compact('payowners','apartments', 'service_requests', 'users'));
    }
     
    public function update(Request $request, $id)
    {    
         $payowners = PayOwners::find($id);
        $payowners->id = $request->id;
        
        $payowners->approval = $request->approval;
         if ( $payowners->approval == 0) {
       
        
        $payowners->total_owned_edit = $request->bill_amount_edit;
         
        $payowners->description_edit = $request->bill_description_edit;
        $amount = $payowners->total_owned_edit - $payowners->paid_in;
        $payowners->balance_edit = $amount;
        $payowners->notification = 'Your Update is awaiting approval from the Administrator';
        $payowners->agency_user = $request->agency_user;
         }
         elseif ( $payowners->approval == 1 && $payowners->total_owned_edit != 0) {
       
        
        $payowners->total_owned = $payowners->total_owned_edit;
         
        $payowners->description= $payowners->description_edit;
        $amount = $payowners->total_owned_edit - $payowners->paid_in;
        $payowners->balance = $amount;
        $payowners->notification = 'Your Update is approved';
         }
         elseif ( $payowners->approval == 1 && $payowners->total_owned_edit == 0) {
       
        
        $payowners->total_owned = $request->bill_amount;
         
        $payowners->description= $request->bill_description;
        $amount = $payowners->total_owned - $payowners->paid_in;
        $payowners->balance = $amount;
         }
          elseif ( $payowners->approval == 3 ) {
       
        
        $payowners->total_owned = $request->bill_amount;
         
        $payowners->description= $request->bill_description;
        $amount = $payowners->total_owned - $payowners->paid_in;
        $payowners->balance = $amount;
        $payowners->notification = 'Administrator has requested amendments on your update.';
         }
         else{
       
        
        $payowners->total_owned = $payowners->total_owned;
         
        $payowners->description=  $payowners->description;
        $amount = $payowners->total_owned - $payowners->paid_in;
        $payowners->balance = $amount;
        $payowners->notification = 'Your Update is declined';
         }
        
        
       
       
        $payowners->save();
        if($payowners->apartment_id == null){
         $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Edited bill' . $payowners->id,
            'more_info' => 'Type: Agency Bill Month: ' . $payowners->rent_month,
            'bill_id' => $payowners->id,
            'tenant_id' =>  '0',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
           
            
        ]);}
        else{
           $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Edited bill' . $payowners->id . 'Apartment:' .$payowners->apartment->name ,
            'more_info' => 'Type ' . $payowners->type . ' Month:' . $payowners->rent_month,
            'bill_id' => $payowners->id,
            'tenant_id' =>  '0',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
           
            
        ]);  
        }
        
        return back()->with('success', 'The selected bill is successfully updated');

    
}
    
   
    // public function edit(PayOwners $payOwners)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PayOwners  $payOwners
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, PayOwners $payOwners)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PayOwners  $payOwners
     * @return \Illuminate\Http\Response
     */
    // public function destroy(PayOwners $payOwners)
    // {
        
    // }
    public function destroy($id)
    {
        $tenant = PayOwners::findOrFail($id);
         $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Deleted bill' . $tenant->id,
            'more_info' => 'Type ' . $tenant->type . ' Month:' . $tenant->rent_month,
            'bill_id' => $tenant->id,
            'tenant_id' =>  '0',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
           
            
        ]);
        $tenant->delete();

        return back()->with('success', 'Bill has been deleted from system');

    }
}
