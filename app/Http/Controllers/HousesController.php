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
use DB;

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
        if (!$request->apartment_id) {
            return back()->with('error', 'Please select a property.');
        }

        $houses_qty = Apartment::where('id', $request->apartment_id)->first();
        $total_houses = House::where('apartment_id', $request->apartment_id)->count();

        if ($houses_qty && $houses_qty->houses_qty > 0 && $total_houses >= $houses_qty->houses_qty) {
            return back()->with('error', 'Property number of houses limit has been reached.');
        }

        DB::beginTransaction();
        try {
            $house = House::create([
                'house_no' => $request->house_no,
                'house_type' => $request->house_type,
                'description' => $request->house_description,
                'apartment_id' => $request->apartment_id,
                'rent_const' => $request->rent_period,
                'rent_period' => $request->rent_period,
            ]);

            Rent::create([
                'house_id' => $house->id,
                'amount' => $request->rent_amount ?? 0,
                'electricity_bill' => $request->electricity_bill ?? 0,
                'water_bill' => $request->water_bill ?? 0,
                'litter_bill' => $request->litter_bill ?? 0,
                'compound_bill' => $request->compound_bill ?? 0,
                'security' => $request->security ?? 0,
                'others' => $request->others ?? 0,
            ]);

            $files = $request->filenames;
            if ($files && count($files) > 0) {
                $response = $this->uploadFiles($files, 'houseImages', $house->id);
            }

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

            DB::commit();
            return redirect()->route('apartment.add_unit', $house->apartment_id)
                ->with('success', 'A new House has been added');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    function index() {
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
        Rent::updateOrCreate(
            ["house_id" => $house->id],
            [
                "amount" => $request->rent_amount,
                "electricity_bill" => $request->electricity,
                "water_bill" => $request->water,
                "litter_bill" => $request->litter,
                "compound_bill" => $request->compound,
            ]
        );

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
            ->with('success', 'House details for House - ' . $house->house_no . ' has been updated');
    }

    public function destroy($id)
    {
        try {
            $house = House::find($id);
            Invoice::where('house_id', $id)->forceDelete();
            HouseTenant::where('house_id', $id)->forceDelete();
            Rent::where('house_id', $id)->forceDelete();
            Deposit::where('house_id', $id)->forceDelete();
            ServiceRequests::where('house_id', $id)->forceDelete();
            PayOwners::where('house_id', $id)->forceDelete();

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

            return back()->with('success', 'House has been permanently deleted along with all associated information.');

        } catch (\Exception $e) {
            return back()->with('error', 'System error deleting house, please contact the System Administrator.');
        }
    }
}
