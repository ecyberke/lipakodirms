<?php

namespace App\Http\Controllers;

use App\House;
use App\Http\Controllers\Controller;
use App\Tenant;
use App\Log;
use App\Traits\UtilTrait;
use Illuminate\Http\Request;

class UtilController extends Controller
{
    use UtilTrait;
    public function testGenerateUserAccountNumber()
    {

        $generated_account_number = $this->generateUserAccountNumber();

        $all_tenants = Tenant::all();

        foreach ($all_tenants as $key => $tenant) {
            if (!$tenant->account_number) {
                $tenant->update([
                    'account_number' => $this->generateUserAccountNumber(),
                ]);
            }
        }
        return response()->json($generated_account_number);
    }
    public function softdeletes()
    {

        $data['houses'] = \App\House::onlyTrashed()
            ->get();
        $data['invoices'] = \App\Invoice::onlyTrashed()
            ->orderBy('created_at', 'DESC')->get();
        $data['landlords'] = \App\Landlord::onlyTrashed()
            ->get();
        $data['apartments'] = \App\Apartment::onlyTrashed()
            ->get();
        $data['tenants'] = \App\Tenant::onlyTrashed()
            ->get();
        $data['bills'] = \App\PayOwners::onlyTrashed()
            ->get();
        $data['users'] = \App\User::onlyTrashed()
            ->get();

        return view('softdeletes.index', $data);
    }
    public function restore_soft(Request $request)
    {

        $nameSpace = '\\App\\'; // assuming you're using the default Laravel 5.8 folder structure

        $model = $nameSpace . $request->table;
        $record = $model::withTrashed()->where('id', $request->id)->first();
        
        $this->createLog([
             'username' => auth()->user()->username,
            'operation' => $request->table . ' restored',
            'more_info' => 'File Successfully Restored',
            'tenant_id' =>  '0',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);

        $record->restore();
        return back()->with('success', 'Restored successfully');

    }
    public function delete_soft(Request $request)
    {
        $nameSpace = '\\App\\'; // assuming you're using the default Laravel 5.8 folder structure

        $model = $nameSpace . $request->table;

        $record = $model::withTrashed()->where('id', $request->id)->first();
        $record->forceDelete();

       
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => $request->table . ' permanently deleted',
            'more_info' => 'File Successfully Deleted',
            'tenant_id' =>  '0',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);

        return back()->with('success', 'Deleted Successfully');

    }
    public function logs()
    {
       $logs= Log::orderBy('created_at','desc')->get();
        // $data['logs'] = \App\Log::all();
        return view('logs.index', compact('logs'));
    }
}
