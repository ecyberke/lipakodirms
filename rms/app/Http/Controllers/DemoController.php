<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Demo;
use DB;
use App\Traits\UtilTrait;
use Illuminate\Support\Facades\Validator;

class DemoController extends Controller
{

 use UtilTrait;

       public function create()
    {
   
        return view('demo_request.register');

    }



    public function store(Request $request)
    { 

    
     $request->validate([
        
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required',  'min:12'],
            
        ]);
        
    
        $bills = new Demo;
        $bills->name = $request->name;
        $bills->email = $request->email;
        $bills->phone = $request->phone;
        $bills->save();
       
        
    

        $this->createLog([
            'username' => 'New User Demo Request',
            'operation' => 'Demo Request Created',
            'more_info' => 'Request by ' . $request->name,
            'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '1',
                    'servicerequest_id' => '0',
        ]);

        

        return back()->with('success', 'Your Request is submitted successfully, we will be in touch soon!');
        }
   

    
 


}

