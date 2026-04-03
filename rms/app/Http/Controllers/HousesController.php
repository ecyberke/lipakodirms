<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\House;
use App\HouseTenant;
use App\Http\Requests\CreateHouseRequest;
use App\Http\Requests\UpdateHouseRequest;
use App\Rent;
use App\Deposit;
use App\Tenant;
use App\PayOwners;
use App\ServiceRequests;
use App\Invoice;
use App\Traits\FileManager;
use App\Traits\UtilTrait;

class HousesController extends Controller
{
    use FileManager;
    use UtilTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create($var = null)
    {
        // $bills = Bill::pluck('id', 'name');
        $apartments = Apartment::pluck('id', 'name');

        //Assign apartment to null
        $apartment_name = null;

        //if apartment id is provided in the route,find the associated apartment
        if ($var) {
            $apartment_name = Apartment::findOrFail($var);

        }

        return view('apartments.add_uit')
        //->with('bills', $bills)
        ->with('apartments', $apartments)
            ->with('var', $var)
            ->with('apartment_name', $apartment_name);
    }

    public function store(CreateHouseRequest $request)
    {
         $houses_qty= Apartment::where('id',$request->apartment_id)->first();
         
         $total_houses= House::where('apartment_id',$request->apartment_id)->count();
         
         if($total_houses >= $houses_qty->houses_qty){
            return back()->with('error', 'Property number of houses limit has been reached.'); 
         } else{
        // $house = new House();
        // $house->house_no = $request->house_no;
        // $house->house_type = $request->house_type;
        // $house->description = $request->house_description;
        // $house->apartment_id = $request->apartment_id;
        // $house->save();
        $house = House::create([
            'house_no' => $request->house_no,
            'house_type' => $request->house_type,
            'description' => $request->house_description,
            'apartment_id' => $request->apartment_id,
            'rent_const' => $request->rent_period,
            'rent_period' => $request->rent_period,
        ]);

        $rent = new Rent();
        $rent->amount = $request->rent_amount;
        $rent->electricity_bill = $request->electricity_bill;
        $rent->water_bill = $request->water_bill;
        $rent->litter_bill = $request->litter_bill;
        $rent->compound_bill = $request->compound_bill;
        $rent->security = $request->security;
        $rent->others = $request->others;
        $rent->house_id = $house->id;
        $rent->save();

        $files = $request->filenames;
        if ($files && count($files) > 0) {
            $response = $this->uploadFiles($files, 'houseImages', $house->id);
        }
        // Code to attach units to bills. WIll utilize this later,
        // i had to refactor the code
        // for ($i = 0; $i < count($request->bill_amount); $i++) {
        //     $house->bills()->attach($request->bill_id[$i], ['amount' => $request->bill_amount[$i]]);
        // }
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'New House Created',
            'more_info' => $house->apartment->name . ' House Number: ' . $request->house_no . ' Type: ' . $request->house_type,
            'tenant_id' => '0',
                    'house_id' => $house->id,
                    'apartment_id' => $house->apartment_id,
                    'landlord_id' => $house->apartment->landlord_id,
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
        ]);
        return redirect()->route('apartment.add_unit', $house->apartment_id)
            ->with('success', 'A new House has been added')
        ;
    }
    }

    function list() {
        return view('houses.list');
    }
    public function listVacant()
    {
        return view('houses.vacant');

    }
    public function listOccupied()
    {
        $house_tenants = HouseTenant::with('tenant', 'house')->get();
        return view('houses.occupied', compact('house_tenants'));
    }
    public function listUnpaid()
    {
        return view('houses.unpaid');
    }

    public function edit($id)
    {
        $house = House::findOrFail($id);
        return view('houses.edit', compact('house'));

    }
    public function show($id)
    {
        $house = House::with('rent')->findOrFail($id);
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $houzes = HouseTenant::where('house_id', $id)->get();
        $invoices = Invoice::where('house_id', $id)->get();
        return view('houses.show', compact('house', 'apartments', 'tenants', 'invoices', 'houzes'));

    }

    public function update(UpdateHouseRequest $request, $id)
    {
        $request->validate([
            'filenames' => 'nullable|array',
            'filenames.*' => 'mimes:doc,pdf,docx,zip,jpeg,png,PNG,JPG,jpg',
        ]);
        $house = House::with('rent')->findOrFail($id);
        $house->house_no = $request->house_no;
        $house->house_type = $request->house_type;
        $house->description = $request->house_description;
        $house->notice = $request->notice;
        $house->rent_const = $request->rent_period;
        $house->rent_period = $request->rent_period;

        $house->save();

        $house->rent->update(['amount' => $request->rent_amount, 
                              'electricity_bill' => $request->electricity, 
                              'water_bill' => $request->water, 
                              'litter_bill' => $request->litter, 
                              'compound_bill' => $request->compound,]);
   

        $files = $request->filenames;
        if ($files && count($files) > 0) {
            $response = $this->uploadFiles($files, 'houseImages', $house->id);
        }
        

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'House Details Updated',
            'more_info' => 'House Number: ' . $request->house_no . ' Type: ' . $request->house_type,
            'tenant_id' => '0',
                    'house_id' => $house->id,
                    'apartment_id' => $house->apartment_id,
                    'landlord_id' => $house->apartment->landlord_id,
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
        ]);

        return redirect()->route('house.list')
            ->with('success', 'House details for House - ' . $house->house_no . '  has been updated');

    }

    public function destroy($id)
    {
        try{
        $house = House::find($id);
        $invoices = Invoice::where('house_id', $id)->forceDelete();
        $house_tenant = HouseTenant ::where('house_id', $id)->forceDelete();
        $rent = Rent ::where('house_id', $id)->forceDelete();
        $deposit = Deposit ::where('house_id', $id)->forceDelete();
        $service_request = ServiceRequests ::where('house_id', $id)->forceDelete();
        $pay_owner = PayOwners::where('house_id', $id)->forceDelete();
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'House Deleted',
            'more_info' => 'House Number: ' . $house->house_no . ' Type: ' . $house->house_type,
            'tenant_id' => '0',
                    'house_id' => $house->id,
                    'apartment_id' => $house->apartment_id,
                    'landlord_id' => $house->apartment->landlord_id,
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
        ]);
       
        $house->forceDelete();
        

        return back()->with('success', 'House has been permanently deleted along with all associated information and will never be recovered');
        }
         catch (\Exception $e) {
         DB::rollback();
         return back()->with('error', 'System error deleting house, please contact the System Administrator.');
}
    }
}
