<?php

namespace App\Http\Controllers;

use App\Overpayment;
use Illuminate\Http\Request;

class OverpaymentController extends Controller
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
    public function edit($id)
    {
        $overpayment = Overpayment::findOrFail($id);

        return view('invoices.editoverpayment', compact('overpayment'));
    }

    public function delete($id)
    {
        $overpayment = Overpayment::findOrFail($id);
        $overpayment->delete();

        return back()->with('success', 'Overpayment has been deleted from system');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $overpayment = Overpayment::findOrFail($id);
        $overpayment->amount = $request->amount;

        $overpayment->save();

        return back()->with('success', 'Overpayment has been updated');

    }
}
