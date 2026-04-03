<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\Http\Requests\CreateApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Landlord;
use App\House;
use App\HouseTenant;
use App\ServiceRequests;
use App\PayOwners;
use App\Deposit;
use App\Invoice;
use App\Traits\UtilTrait;
use DB;

class ApartmentsController extends Controller
{
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

    public function create()
    {
        //Populate Availabe LandLords
        $landlords = Landlord::pluck('id', 'full_name');
        return view('apartments.crate', compact('landlords'));
    }

    public function store(CreateApartmentRequest $request)
    {
        $apartment = new Apartment;
        $apartment->name = $request->name;
        $apartment->type = $request->type;
        $apartment->town = $request->town;
        $apartment->reference_no = $request->reference_no;
        $apartment->houses_qty = $request->houses_qty;
        $apartment->location = $request->location;
        $apartment->description = $request->description;
        $apartment->landlord_id = $request->landlord_id;
        $apartment->management_fee_percentage = $request->management_fee;

       
        $apartment->save();
         $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'New Property Created',
            'more_info' => 'Name: ' . $request->name . 'owned by' . $apartment->landlord->full_name,
              'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => $apartment->id,
                    'landlord_id' => $apartment->landlord_id,
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
        ]);


        return back()->with('success', 'Apartment has been added to the system.');
    }

    function list() {
        return view('apartments.list');
    }

    public function show($id)
    {
        $apartment = Apartment::findOrFail($id);
        return view('apartments.show', compact('apartment'));
    }

    public function edit($id)
    {
         $landlords = Landlord::pluck('id', 'full_name');
        $apartment = Apartment::findOrFail($id);
        return view('apartments.edit', compact('apartment', 'landlords'));

    }

    public function update(UpdateApartmentRequest $request, $id)
    {
        $apartment = Apartment::findOrFail($id);
        $apartment->name = $request->name;
        $apartment->type = $request->type;
        $apartment->town = $request->town;
        $apartment->reference_no = $request->reference_no;
        $apartment->houses_qty = $request->houses_qty;
        $apartment->landlord_id = $request->landlord_id;
        $apartment->active = $request->active;
        
        $apartment->description = $request->description;
        $apartment->management_fee_percentage = $request->management_fee;

       

        $apartment->save();
         $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Property Updated',
            'more_info' => 'Name: ' . $apartment->name . 'owned by' . $apartment->landlord->full_name,
              'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => $apartment->id,
                    'landlord_id' => $apartment->landlord_id,
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
        ]);

        return redirect()->route('apartment.show', $apartment)->with('success', 'apartment has been updated');

    }

    public function delete($id)
    {   
      try{
        $apartments = Apartment::findOrFail($id);
        $house = House::where('apartment_id', $id)->get();

       
         foreach ($house as $house_tenant) {
          HouseTenant::where('house_id', $house_tenant->id)
                ->forceDelete(); 
        }
         foreach ($house as $house_tenant) {
          
            Rent ::where('house_id', $house_tenant->id)->forceDelete();
        }
       
           $house = House::where('apartment_id', $id)->forceDelete();
           $invoices = Invoice::where('apartment_id', $id)->forceDelete();
           $deposit = Deposit ::where('apartment_id', $id)->forceDelete();;
           $service_request = ServiceRequests ::where('apartment_id', $id)->forceDelete();
           $pay_owner = PayOwners::where('apartment_id', $id)->forceDelete();
      
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Property Deleted',
            'more_info' => 'Name: ' . $apartments->name . ' was owned by ' . $apartments->landlord->full_name,
              'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => $apartments->id,
                    'landlord_id' => $apartments->landlord_id,
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
        ]);
        
        $apartments->forceDelete();

        return redirect()->route('apartment.list')
            ->with('success', 'You have permanently deleted the property with all information linked to it.');
      
    }
     catch (\Exception $e) {
         DB::rollback();
         return back()->with('error', 'System error deleting the property, please contact the System Administrator.');
}
    }

}
