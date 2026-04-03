<?php

namespace App\Http\Controllers;

use App\AgencyExpenses;

use Illuminate\Http\Request;

class AgencyExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('expenses.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenses.agency');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function stor(Request $request)
    {
        //
    }
    public function store(Request $request)
    {
        $agencyexpenses = new AgencyExpenses;
        $agencyexpenses->id = $request->id;
        $agencyexpenses->type = $request->type;
        
        $agencyexpenses->description = $request->description;
        $agencyexpenses->requested_date = $request->requested_date;
        $agencyexpenses->transaction_code = $request->transaction_code;
        $agencyexpenses->amount = $request->amount;
        $agencyexpenses->status = $request->status;
        //$service_requests->amount = $request->amount;
        //$service_requests->pay_status = $request->pay_status;
        //$agencyexpenses->attachment = $request->attachment;
        
        $agencyexpenses->save();

        return back()->with('success', 'New Agency Expenses has been added to the system');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AgencyExpenses  $agencyExpenses
     * @return \Illuminate\Http\Response
     */
    public function show(AgencyExpenses $agencyExpenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AgencyExpenses  $agencyExpenses
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agency_expenses= AgencyExpenses::findOrFail($id);
        return view('expenses.edit', compact('agency_expenses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AgencyExpenses  $agencyExpenses
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request, $id)
    {
        $agency_expenses = AgencyExpenses::find($id);
        $agency_expenses->status = $request->status;
        $agency_expenses->amount = $request->amount;
       $agency_expenses->transaction_code = $request->transaction_code;
       //$service_requests->attachment = $request->attachment;
       $agency_expenses->save();

        return redirect()->route('expenses.list', [ $agency_expenses])
            ->with('success', 'Expense payment status has been changed successfully to the system ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AgencyExpenses  $agencyExpenses
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgencyExpenses $agencyExpenses)
    {
        //
    }
}
