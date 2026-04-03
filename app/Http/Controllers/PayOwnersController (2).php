<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\Invoice;
use App\ServiceRequests;
use App\User;
use App\Http\Requests\PayOwnersRequest;

use App\Landlord;
use App\PayOwners;
use App\Traits\UtilTrait;
use Illuminate\Http\Request;

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
    function list() {

        return view('payowners.list');
    }
    public function totals()
    {

        return view('payowners.totals');
    }
    public function payowners($id)
    {
        $payowners = PayOwners::find($id);
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
        $landlord_billables = PayOwners::where('id', $id)->get();

        $balance = $amount;
        foreach ($landlord_billables as $bill) {
            if ($balance > 0) {
                $paid_in = $amount > $bill->total_owned ? $bill->total_owned : $amount;
                $balance = $amount > $bill->total_owned ? 0 : $bill->total_owned - $amount;
                $bill->update([
                    'paid_in' => $paid_in,
                    'balance' => $balance,
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
        foreach ($landloard_billables as $bill) {
            if ($balance > 0) {
                $paid_in = $balance > $bill->total_owned ? $bill->total_owned : $balance;
                $balance_to_update = $balance > $bill->total_owned ? 0 : $bill->total_owned - $balance;
                $bill->update([
                    'paid_in' => $paid_in,
                    'balance' => $balance_to_update,
                    'pay_status' => ($balance_to_update - $request->paid_in <= 0) ? true : false,
                    'transaction_code' => $request->transaction_code,
                ]);
                $balance = $balance - $paid_in;

                if ($x === $length && $balance > $bill->balance) {
                    $bill->update([
                        'overpayment' => ($balance - $bill->balance),
                    ]);
                }

                $x++;
            }

        }

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Bill Paid',
            'more_info' => 'Type ' . $landloard_billables->type . 'Amount Paid: ' . $request->paid_in,
        ]);
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
        $payowners->type = $request->type;
        $payowners->apartment_id = $request->apartment_id;
        $payowners->apartment_id = $request->apartment_id;
        $payowners->total_owned = $request->bill_amount;
        $payowners->balance = $request->bill_amount;
        
        
       
       
        $payowners->save();
        
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
    public function destroy(PayOwners $payOwners)
    {
        //
    }
}
