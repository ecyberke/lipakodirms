<?php

namespace App\Http\Controllers;

use App\Incomes;
use Illuminate\Http\Request;
use App\Http\Requests\IncomesRequest;
use App\Http\Requests\UpdateIncomesRequest;


class IncomesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('incomes.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('incomes.index1');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IncomesRequest $request)
    {
        $incomes = new Incomes;
        $incomes->id = $request->id;
        $incomes->source = $request->source;
        
        $incomes->amount = $request->amount;
        $incomes->description = $request->description;
        $incomes->income_date = $request->income_date;
        $incomes->save();

        return back()->with('success', 'New Income has been added to the system');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Incomes  $incomes
     * @return \Illuminate\Http\Response
     */
    public function show(Incomes $incomes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Incomes  $incomes
     * @return \Illuminate\Http\Response
     */
    // public function edit(Incomes $incomes)
    // {
        
    // }
    public function edit($id)
    {
        $incomes = Incomes::findOrFail($id);
        return view('incomes.edit', compact('incomes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Incomes  $incomes
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, Incomes $incomes)
    public function update(UpdateIncomesRequest $request, $id)
    {
        $incomes = Incomes::find($id);
       // $incomes->id = $request->id;
        $incomes->source = $request->source;
        $incomes->amount = $request->amount;
        $incomes->description = $request->description;
       
        $incomes->date = $request->date;
        
     
        $incomes->save();

        return redirect()->route('incomes.list', [$incomes])
            ->with('success', 'incomes details has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Incomes  $incomes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incomes $incomes)
    {
        //
    }
}
