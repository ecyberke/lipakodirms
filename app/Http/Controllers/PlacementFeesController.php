<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\PlacementFee;
use Illuminate\Http\Request;

class PlacementFeesController extends Controller
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
    public function sumByApartments()
    {
        return view('placementfees.sum_apartments');
    }

    public function sortByApartments()
    {
        $apartments = Apartment::pluck('id', 'name');
        return view('placementfees.sort_apartment', compact('apartments'));

    }

    public function edit($id)
    {
        $placement = PlacementFee::findOrFail($id);

        return view('placementfees.edit', compact('placement'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        $placement = PlacementFee::findOrFail($id);
        $placement->amount = $request->amount;

        $placement->save();

        return back()->with('success', 'Placement fee has been updated');

    }

    public function delete($id)
    {
        $placement = PlacementFee::findOrFail($id);

        $placement->delete();

        return back()->with('success', 'Specified placement fee has been deleted from system');
    }
}
