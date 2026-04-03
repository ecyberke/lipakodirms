<?php

namespace App\Http\Controllers;

use App\Apartment;
use Illuminate\Http\Request;
use App\Landlord;
use Hash;

class clientController extends Controller
{
     public function index()
    {   
        $client = Landlord::whereHas('apartments')->get();
    }
}