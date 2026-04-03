<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\Deposit;
use Illuminate\Http\Request;

class DepositsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('deposits.index');
    }

    public function sumByApartments()
    {
        return view('deposits.sum_apartments');
    }

    public function sortByApartments()
    {
        $apartments = Apartment::pluck('id', 'name');
        return view('deposits.sort_apartment', compact('apartments'));

    }

    public function edit($id)
    {
        $deposit = Deposit::findOrFail($id);

        return view('deposits.edit', compact('deposit'));
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $deposit = Deposit::findOrFail($id);

        $deposit->amount = $request->amount;

        $deposit->save();
   
        return redirect()->route('deposit.list')
            ->with('success', 'Deposit has been updated ');
 
    }
    public function delete($id)
    {
        $deposit = Deposit::findOrFail($id);
        $deposit->delete();

        return back()->with('success', 'Deposit has been deleted from the system');
    }

}
