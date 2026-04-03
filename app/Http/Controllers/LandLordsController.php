<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\House;
use App\HouseTenant;
use App\ServiceRequests;
use App\Deposit;
use App\Rent;
use App\Repair;
use App\Owner_invoices;
use App\Invoice;
use App\PayOwners;
use App\Http\Requests\CreateLandLordRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateLandlordRequest;
use App\Landlord;
use App\Traits\FileManager;
use App\Traits\NotifyClient;
use App\Traits\UtilTrait;
use Hash;
use DB;

class LandLordsController extends Controller
{
    use NotifyClient;
    use UtilTrait;
    use FileManager;
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
        return view('landlords.all');
    }
    public function create()
    {
        return view('landlords.register');
    }
    public function store(CreateLandLordRequest $request)
    {
        try{
        $landlord = new Landlord;
       
        //$landlord->full_name = $request->first_name . ' ' . $request->middle_name;
        $landlord->full_name = $request->full_name;
        $landlord->id = $request->id;
        //$landlord->other_names = $request->other_names;
        $landlord->email = $request->email;
        $landlord->landlordid_number = $request->landlordid_number;
       // $landlord->phone_no = $request->phone_no;
        $landlord->password = Hash::make($request->password);
        $landlord->address = $request->address;
        $landlord->town = $request->town;
        $landlord->country = $request->country;
        $landlord->bank_name = $request->bank_name;
        $landlord->bank_branch = $request->bank_branch;
        $landlord->bank_acc_name = $request->bank_acc_name;
        $landlord->bank_acc_no = $request->bank_acc_no;
        $landlord->emergency_person = $request->emergency_person;
        $landlord->emergency_id = $request->emergency_id;
        $landlord->emergency_number = $request->emergency_number;
        $landlord->relationship = $request->relationship;
        

        $files = $request->filenames;
        if ($files) {
            $response = $this->uploadFile($files, 'landlordContracts', $landlord->id);
        }
         $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Created Owner ' . $landlord->full_name,
            'more_info' => 'New Owner with phone:  +' . $landlord->id,
            'tenant_id' =>  '0',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => $landlord->id,
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);
        $landlord->save();

        return back()->with('success', 'Property Owner has been added to the system');
        }
        // catch (\Exception $e) {
        // DB::rollback();
        // return back()->with('error', 'System error adding owner, please contact the developer.');
//}
catch (\Exception $e) {
    DB::rollback();
    return back()->with('error', $e->getMessage());
}

    }

    public function show($id)
    {
        $landlord = Landlord::findOrFail($id);
        $apartments = Apartment::where('landlord_id', $id)->get();
        $houses = House::pluck('id','house_type');
        $owner_invoices = Owner_invoices::where('owner_id', $id)->get();
        $repair_invoices = Repair::where('owner_id', $id)->get();
        return view('landlords.show', compact('landlord', 'apartments', 'houses', 'owner_invoices', 'repair_invoices'));

    }

    public function edit($id)
    {
        $landlord = Landlord::findOrFail($id);
        return view('landlords.edt', compact('landlord'));

    }
    public function update(UpdateLandlordRequest $request, $id)
    {
        try{
        $landlord = Landlord::findOrFail($id);
        $apartments = Apartment::where('landlord_id', $landlord->id)->get();
        foreach($apartments as $apartment){
        $apartment->landlord_id = $request->id;
        $apartment->save();
        }

        $landlord->id = $request->id;
        $landlord->full_name = $request->full_name;
        //$landlord->other_names = $request->other_names;
        $landlord->email = $request->email;
        $landlord->landlordid_number = $request->landlordid_number;
        $landlord->country = $request->country;
        $landlord->address = $request->address;
        $landlord->bank_name = $request->bank_name;
        $landlord->bank_branch = $request->bank_branch;
        $landlord->bank_acc_name = $request->bank_acc_name;
        $landlord->bank_acc_no = $request->bank_acc_no;
        $landlord->emergency_person = $request->emergency_person;
        $landlord->emergency_id = $request->emergency_id;
        $landlord->emergency_number = $request->emergency_number;
        $landlord->relationship = $request->relationship;
        
        $files = $request->filenames;
        if ($files) {
            $response = $this->uploadFile($files, 'landlordContracts', $landlord->id);
        }
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Edited Owner ' . $landlord->full_name,
            'more_info' => 'Edited Owner with phone:  +' . $landlord->id,
            'tenant_id' =>  '0',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => $landlord->id,
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);
        $landlord->save();

        return redirect()->route('landlord.show', [$landlord])->with('success', 'Property Owner Details have been updated');
        }
        catch (\Exception $e) {
         DB::rollback();
         return back()->with('error', 'System error editing owner, please contact the developer.');
}


    }

    public function showPasswordForm($id)
    {
        return view('landlords.change_pass')->with('landlord_id', $id);
    }
    public function updatePassword(ChangePasswordRequest $request, $id)
    {
        $landlord = Landlord::find($id);
        $landlord->password = Hash::make($request->new_password);
        $landlord->save();

        return redirect()->route('landlord.show', [$landlord])
            ->with('success', 'Property Owner password has been reset.');

    }

    public function delete($id)
    {
        try {
            $landlord = Landlord::findOrFail($id);
            $apartments = Apartment::where('landlord_id', $id)->get();

            foreach ($apartments as $apartment) {
                $houses = House::where('apartment_id', $apartment->id)->get();
                foreach ($houses as $house) {
                    HouseTenant::where('house_id', $house->id)->forceDelete();
                    Rent::where('house_id', $house->id)->forceDelete();
                }
                House::where('apartment_id', $apartment->id)->forceDelete();
                Invoice::where('apartment_id', $apartment->id)->forceDelete();
                Deposit::where('apartment_id', $apartment->id)->forceDelete();
                ServiceRequests::where('apartment_id', $apartment->id)->forceDelete();
                PayOwners::where('apartment_id', $apartment->id)->forceDelete();
            }

            Apartment::where('landlord_id', $id)->forceDelete();
            $landlord->forceDelete();

            return back()->with('success', 'Property Owner has been permanently deleted from system with all information linked to it.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }
}
