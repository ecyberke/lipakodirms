<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\Landlord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLandlordController extends Controller
{

      /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:landlord');
    }

    public function index()
    {
        $landlord = Auth::guard('landlord')->user();
        $id=$landlord->id;
        $apartments = Apartment::where('landlord_id', $id)->get();

        return view('users.landlord.index', compact('landlord', 'apartments'));
    }
}
