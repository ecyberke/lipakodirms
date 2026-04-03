<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\House;
use App\Http\Requests\ServiceRequestsRequest;
use App\Http\Requests\UpdateServiceRequestsRequest;
use App\ServiceRequests;
use App\Tenant;
use App\Traits\UtilTrait;
use Illuminate\Http\Request;
use PDF;

class ServiceRequestsController extends Controller
{
    use UtilTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('servicerequests.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        return view('servicerequests.create', compact('tenants', 'apartments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequestsRequest $request)
    {
        $service_requests = new ServiceRequests;
        $service_requests->id = $request->id;
        $service_requests->tenant_id = $request->tenant_id; 
        if ($request->tenant_id == null ){
          $service_requests->full_name = 'No Tenant Specified';  
        }
        else{
           $service_requests->full_name = $service_requests->tenant->full_name; 
        }
            

        $service_requests->apartment_id = $request->apartment_id;
        $service_requests->house_id = $request->house_id;
        $service_requests->service_request = $request->service_request;
        // $service_requests->requested_date = $request->requested_date;
        $service_requests->status = $request->status;
         $service_requests->approval = $request->approval;
        //$service_requests->pay_status = $request->pay_status;
        $service_requests->attachment = $request->attachment;

        $service_requests->save();

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Service Request Created',
            'more_info' => 'Request ' . $request->service_request . ' Tenant:' . $service_requests->full_name,
            
            'tenant_id' => $request->tenant_id,
            'servicerequest_id' => $service_requests->id,
            'house_id' => $service_requests->house_id,
            'apartment_id' => $service_requests->apartment_id,
            'landlord_id' => $service_requests->apartment->landlord_id,
            'bill_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
            
        ]);

        return back()->with('success', 'New Request has been added to the system');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ServiceRequests  $serviceRequests
     * @return \Illuminate\Http\Response
     */
    //public function show(ServiceRequests $serviceRequests)
    public function show($id)
    {
        $service_requests = ServiceRequests::findOrFail($id);
        //$apartments = Apartment::where('landlord_id', $id)->get();
        $apartments = Apartment::pluck('id', 'landlord_id', 'name', 'town', 'management_fee_percentage');
        $houses = House::pluck('id', 'house_no');
        $tenants = Tenant::pluck('id', 'full_name');

        return view('servicerequests.show', compact('service_requests', 'tenants', 'apartments', 'houses'));

    }

    public function report($id)
    {

        $service_requests = ServiceRequests::findOrFail($id);
        //$apartments = Apartment::where('landlord_id', $id)->get();
        $apartments = Apartment::pluck('id', 'landlord_id', 'name', 'town', 'management_fee_percentage');
        $houses = House::pluck('id', 'house_no');
        $tenants = Tenant::pluck('id', 'full_name');

        //return view('servicerequests.show', compact());
        // $service_requests = ServiceRequests::where('id', $id)->get();
        //$invoices = Invoice::where('tenant_id', $idd)->get();
        // $apartments = Apartment::pluck('id','landlord_id','name', 'town', 'management_fee_percentage');
        // $houses = House::pluck('id','house_no');
        // $tenants = Tenant::pluck('id','full_name');

        //return response()->json([$service_requests]);
        $pdf = PDF::loadView('servicerequests.reportpdf', compact('service_requests', 'tenants', 'apartments', 'houses'));
        return $pdf->stream('Service #' . $id . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ServiceRequests  $serviceRequests
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service_requests = ServiceRequests::findOrFail($id);
        return view('servicerequests.edit', compact('service_requests'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ServiceRequests  $serviceRequests
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequestsRequest $request, $id)
    {
        
        
       
        //$service_requests->attachment = $request->attachment;
       $service_requests = ServiceRequests::find($id);
   
        $service_requests->approval = $request->approval;
         if ($service_requests->approval == 0) {
       
        
        $service_requests->status_edit = $request->status_edit;
        $service_requests->service_request_edit = $request->service_request_edit;
        $service_requests->notification = 'Update is awaiting approval from the Administrator';
        $service_requests->manager = $request->manager;
         }
         elseif ( $service_requests->approval == 1 && $service_requests->service_request_edit != null) {
       
        
        $service_requests->status = $service_requests->status_edit;
        $service_requests->service_request = $service_requests->service_request_edit;
        $service_requests->notification = 'Update is approved ';
         }
         elseif ( $service_requests->approval == 1 && $service_requests->service_request_edit == null && $service_requests->status_edit == null) {
       
        
        $service_requests->status = $request->status;
        $service_requests->service_request = $request->service_request;
        $service_requests->notification = 'Update done by administrator ';
         }
          elseif ( $service_requests->approval == 1  && $service_requests->status_edit != null) {
       
        
        $service_requests->status = $service_requests->status_edit;
        $service_requests->service_request = $service_requests->service_request;
         
        // $service_request->manager = $service_requests->manager;
         }
         elseif ( $service_requests->approval == 3 ) {
       
        
        $service_requests->status = $service_requests->status;
        $service_requests->service_request =  $service_requests->service_request;
        $service_requests->notification = 'Administrator has requested amendments on the update.';
        // $service_request->manager = $service_requests->manager;
         }
        
         
         else{
       
        
        $service_requests->status = $service_requests->status;
        $service_requests->service_request = $service_requests->service_request;
        $service_requests->notification = 'Your Update is declined by the Administrator';
        // $service_request->manager = $service_requests->manager;
         }
        $service_requests->save();

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Service Request Status Updated',
            'more_info' => 'New Status ' . $request->status . ' Request Type' . $service_requests->service_request,
             'tenant_id' => $service_requests->tenant_id,
            'servicerequest_id' => $service_requests->id,
            'house_id' => $service_requests->house_id,
            'apartment_id' => $service_requests->apartment_id,
            'landlord_id' => $service_requests->apartment->landlord_id,
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
        ]);

        return redirect()->route('servicerequests.show', [$service_requests])
            ->with('success', 'Service Request has been updated successfully ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ServiceRequests  $serviceRequests
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
         $service_requests = ServiceRequests::findOrFail($id);
         $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Service Request Deleted',
            'more_info' => 'Request:' .  $service_requests->service_request,
            'servicerequest_id' => $service_requests->id,
            'tenant_id' => $service_requests->tenant_id,
            'house_id' => $service_requests->house_id,
            'apartment_id' => $service_requests->apartment_id,
            'landlord_id' => $service_requests->apartment->landlord_id,
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
            'user_id' => '0',
         
        ]);
        $service_requests->delete();

        return back()->with('success', 'Request has been deleted from system');
    }
}
