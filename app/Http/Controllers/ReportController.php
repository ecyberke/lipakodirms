<?php

namespace App\Http\Controllers;

use App\Report;
use App\Apartment;
use App\Tenant;
use App\House;
use App\Invoice;
use App\PayOwners;
use App\HouseTenant;
use App\Landlord;
use App\Traits\DocTrait;
use App\Traits\UtilTrait;
use PDF;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use DocTrait;
    use UtilTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index()

 
    {    $apartments = Apartment::pluck('id', 'name');
        return view('report.tenant', compact('apartments'));
    }

    public function tenantform()
    {
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $hasReport = false;
        return view('report.tenantform', compact('tenants', 'apartments','hasReport'));
    }
     public function property_status()
    {
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $hasReport = false;
        $message = '';
        return view('report.property_status', compact('tenants', 'apartments','hasReport', 'message'));
    }
     public function property_income_expense()
    {
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $hasReport = false;
        $message = '';
        return view('report.property_income_expense', compact('tenants', 'apartments','hasReport', 'message'));
    }
      public function property_occupancy_expense()
    {
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $hasReport = false;
        $message = '';
        return view('report.occupancy', compact('tenants', 'apartments','hasReport', 'message'));
    }
      public function rent()
    {
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $hasReport = false;
        $message = '';
        return view('report.rent', compact('tenants', 'apartments','hasReport', 'message'));
    }
     public function preprintedform()
    {
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        
        return view('report.preprintedform', compact('tenants', 'apartments'));
    }
     public function agency_status()
    {
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $hasReport = false;
        return view('report.agency_status', compact('tenants', 'apartments','hasReport'));
    }
     public function agency_income_expense()
    {
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $hasReport = false;
        return view('report.income_expense', compact('tenants', 'apartments','hasReport'));
    }
    
     public function prop_income()
    {
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $hasReport = false;
        return view('report.prop_income', compact('tenants', 'apartments','hasReport'));
    }
    
     public function tenant_income()
    {
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $hasReport = false;
        return view('report.tenant_income', compact('tenants', 'apartments','hasReport'));
    }
    
     public function month_income()
    {
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $hasReport = false;
        return view('report.month_income', compact('tenants', 'apartments','hasReport'));
    }
    
     public function tenant_month_income()
    {
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $hasReport = false;
        return view('report.tenant_month_income', compact('tenants', 'apartments','hasReport'));
    }
    
    public function landlordform()
    {
        $apartments = Apartment::pluck('id', 'name');
        $landlords = Landlord::pluck('id', 'full_name');
        $hasReport = false;
        return view('report.landlordform', compact('landlords', 'apartments','hasReport'));
    }
    public function vacantreport()
    {
        $apartments = Apartment::pluck('id', 'name');
        $landlords = Landlord::pluck('id', 'full_name');
        $hasReport = false;
        return view('report.vacant_report', compact('landlords', 'apartments','hasReport'));
    }
     public function viewing_fee()
    {
        $apartments = Apartment::pluck('id', 'name');
        $landlords = Landlord::pluck('id', 'full_name');
        $hasReport = false;
        return view('report.viewing_fee', compact('landlords', 'apartments','hasReport'));
    }
       public function external_owner()
    {
        $apartments = Apartment::pluck('id', 'name');
        $landlords = Landlord::pluck('id', 'full_name');
        $hasReport = false;
        return view('report.external_owner', compact('landlords', 'apartments','hasReport'));
    }
    public function apartmentReportGenerate(Request $request)
    {    
        $request->validate([
            'type'=>'required|string',
            'apartment'=>'required|integer'
        ]);
        // dd($request->all());
        switch ( $request->type) {
          case 'vacant':
            if( $request->apartment == 0){
             $info = House::with('apartment')->where('is_occupied',false)->get();   
            }else{
        $info = House::with('apartment')->where('is_occupied',false)->where('apartment_id',$request->apartment)->get();
            }
        
        foreach($info as $dt){
            $dt['apartment_name'] = $dt['apartment']['name'];
            $dt['rent_amount'] = 'Kshs.'.number_format($dt['rent']['amount']);
        }
        $columns = [
            [
                'id'=>'apartment_name',
                'label'=>'Apartment'
            ], 
            [
                'id'=>'house_no',
                'label'=>'House Number'
            ], 
            [
                'id'=>'house_type',
                'label'=>'House Type'
               
            ],
            [
                'id'=>'rent_amount',
                'label'=>'House Rent'
               
            ],
             
            [
                'id'=>'description',
                'label'=>'Description'
            ], 
        ];
       
        $data['columns']=$columns;
        $data['data']=$info;
        $data['typ']='Vacant';
        $data['report_title']='Vacant Houses Report';
        $data['hasReport'] = true;
            $data['filename'] =  $data['report_title'];
            break;
        case 'occupied':
            
             if( $request->apartment == 0){
             $info = House::with('apartment')->where('is_occupied',true)->get();   
            }else{
            $info = House::with('apartment','tenant')->where('is_occupied',true)->where('apartment_id',$request->apartment)->get();
            }
        foreach($info as $dt){
            $house = HouseTenant::where('house_id',$dt->id)->first();
            $tenant_data = Tenant::where('id',$house->tenant_id)->first();
            $dt['apartment_name'] = $dt['apartment']['name'];
            $dt['tenant_name'] = $tenant_data->full_name;
            $dt['tenant_phone'] = $tenant_data->phone ;
        }
        $columns = [
            [
                'id'=>'apartment_name',
                'label'=>'Apartment'
            ], 
            [
                'id'=>'tenant_name',
                'label'=>'Tenant Name'
            ], 
            [
                'id'=>'tenant_phone',
                'label'=>'Tenant Phone'
            ], 
            [
                'id'=>'house_no',
                'label'=>'House Number'
            ], 
            [
                'id'=>'house_type',
                'label'=>'House Type'
            ], 
            [
                'id'=>'description',
                'label'=>'Description'
            ], 
        ];
        $data['columns']=$columns;
        $data['data']=$info;
             $data['typ']='Occupied';
        $data['report_title']='Occupied Houses Report';
        $data['hasReport'] = true;
           $data['filename'] = 'Occupied Houses Report';
        break;
         case 'notice':
            $info = House::with('apartment')->where('notice',true)->where('apartment_id',$request->apartment)->get();
        
        foreach($info as $dt){
            $dt['apartment_name'] = $dt['apartment']['name'];
        }
        $columns = [
            [
                'id'=>'apartment_name',
                'label'=>'Apartment'
            ], 
            [
                'id'=>'house_no',
                'label'=>'House Number'
            ], 
            [
                'id'=>'house_type',
                'label'=>'House Type'
            ], 
            [
                'id'=>'description',
                'label'=>'Description'
            ], 
        ];
        $data['columns']=$columns;
        $data['data']=$info;
         $data['typ']='Notice';
        $data['report_title']='Houses on Notice';
        $data['hasReport'] = true;
            $data['filename'] = 'Houses on Notice Report';
        break;
         case 'tenant_balances':
            $info = Invoice::with('apartment','house','tenant')->where('apartment_id',$request->apartment)->where('balance','>',0)->where('apartment_id','!=', null)->get()->groupBy('tenant_id');
        
        foreach($info as $dt){
            $dt['balance'] = $dt->sum('balance');
            $dt['tenant_name'] = $dt[0]['tenant']['full_name'];   
            $dt['tenant_phone'] = $dt[0]['tenant']['phone'];   
            $dt['house_name'] = $dt[0]['house']['house_no'].' - '.$dt[0]['house']['description'];  
            $dt['apartment_name'] = $dt[0]['apartment_name']; 
        }
        $columns = [
            [
                'id'=>'apartment_name',
                'label'=>'Apartment'
            ], 
            [
                'id'=>'house_name',
                'label'=>'House'
            ], 
            [
                'id'=>'tenant_name',
                'label'=>'Tenant Name'
            ], 
            [
                'id'=>'tenant_phone',
                'label'=>'Tenant Phone'
            ], 
            [
                'id'=>'balance',
                'label'=>'Balance'
            ], 
            // [
            //     'id'=>'total_payable',
            //     'label'=>'Total Payable'
            // ], 
            // [
            //     'id'=>'paid_in',
            //     'label'=>'Total Paid'
            // ],
            // [
            //     'id'=>'rent_month',
            //     'label'=>'Invoice Month'
            // ],
        ];
        $data['columns']=$columns;
        $data['data']=$info;
        $data['report_title']='Tenant Balances';
        $data['hasReport'] = true;
         $data['typ']='tenantBalances';
        $data['filename'] = 'Tenant Balances Report';
        break;
         case 'all_tenants':
            $info = Tenant::all();
        
        foreach($info as $dt){
            $dt['status'] = $dt['is_active'] ? 'Active':'Deactivated';
        }
        $columns = [
            [
                'id'=>'account_number',
                'label'=>'Account Number'
            ], 
            [
                'id'=>'full_name',
                'label'=>'Full Name'
            ], 
            [
                'id'=>'phone',
                'label'=>'Phone Number'
            ], 
            [
                'id'=>'physical_address',
                'label'=>'Physical Address'
            ]
        ];
        $data['columns']=$columns;
        $data['data']=$info;
        $data['report_title']='All Tenants';
        $data['has_report'] = true;
               $data['filename'] = 'All Tenants Report';
        break;
         case 'all_property_owners':
            $info = Landlord::all();
  
        $columns = [
            [
                'id'=>'full_name',
                'label'=>'Property Owner Name'
            ], 
            [
                'id'=>'address',
                'label'=>'Address'
            ], 
            [
                'id'=>'bank_name',
                'label'=>'Bank'
            ],
            [
                'id'=>'bank_branch',
                'label'=>'Branch'
            ],
            [
                'id'=>'bank_acc_name',
                'label'=>'Account Holder Name'
            ],
            [
                'id'=>'bank_acc_no',
                'label'=>'Account Number'
            ],
            [
                'id'=>'town',
                'label'=>'Town'
            ],
        ];
        $data['columns']=$columns;
        $data['data']=$info;
        $data['report_title']='All Property Owners';
        $data['has_report'] = true;
         $data['filename'] = 'All Property Owners Report';
        break;
         case 'all_properties':
             dd($request->prop);
             if($request->prop == 'active'){
            $info = Apartment::with('landlord')->where('active', 1)->get();
             }else{
               $info = Apartment::with('landlord')->where('active', 0)->get();  
             }
            
        foreach($info as $dt){
            $dt['landlord_name'] = $dt['landlord']['full_name'];
            $dt['management_fee_percentage'] =$dt['houses_qty'] ? $dt['houses_qty'].'%':'-';
        }
  
        $columns = [
            [
                'id'=>'name',
                'label'=>'Property Name'
            ], 
            [
                'id'=>'landlord_name',
                'label'=>'Landlord'
            ], 
            [
                'id'=>'houses_qty',
                'label'=>'Number of Houses'
            ], 
            [
                'id'=>'location',
                'label'=>'Location'
            ],
            [
                'id'=>'management_fee_percentage',
                'label'=>'Management Fee'
            ]
        ];
        $data['columns']=$columns;
        $data['data']=$info;
        $data['typ']='Pop';
        if($request->prop == 'active'){
        $data['report_title']='All Active Properties';
        }else{
        $data['report_title']='All Inactive Properties';    
        }
        $data['has_report'] = true;
         if($request->prop == 'active'){
          $data['filename'] = 'All Active Properties Report';
         }else{
        $data['filename'] = 'All Inactive Properties Report'; 
        }
        break;
         case 'all_houses':
            $info = House::with('apartment')->get();
            
        foreach($info as $dt){
            $dt['apartment_name'] = $dt['apartment']['name'];
            $dt['is_occupied'] = $dt['is_occupied'] ? 'Occupied':'Not Occupied';
        }
  
        $columns = [
            [
                'id'=>'house_no',
                'label'=>'House Number'
            ], 
            [
                'id'=>'house_type',
                'label'=>'House Type'
            ], 
            [
                'id'=>'description',
                'label'=>'Description'
            ], 
            [
                'id'=>'is_occupied',
                'label'=>'Occupance'
            ],
            [
                'id'=>'apartment_name',
                'label'=>'Apartment'
            ]
        ];
        $data['columns']=$columns;
        $data['data']=$info;
        $data['report_title']='All Houses';
        $data['hasReport'] = true;
        $data['filename'] = 'All Houses Report';
        break;
          default:
                 $data['hasReport'] = false;
        }
        $data['apartments'] = Apartment::pluck('id', 'name');
        $data['landlords'] = Landlord::pluck('id', 'full_name');
        $dt = date('Y-m-d H:i:s');
        if($request->download === 'yes'){
        $pdf = \PDF::loadView('docs.house_report_pdf', $data);
        return $pdf->stream($data['filename'].' '.$dt.'.pdf');
        }else{
            if($data['typ'] === 'Vacant'){
           return view('report.vacant_report',$data); 
            }else if($data['typ'] === 'Occupied'){
        return view('report.occupied_report',$data);   
            }
           else if($data['typ'] === 'Pop'){
        return view('report.all_properties',$data);   
            } else if($data['typ'] === 'Notice'){
             return view('report.notice_report',$data);    
            }else if($data['typ'] === 'tenantBalances'){
            return view('report.tenant_balance',$data);  
            }else{
           return view('report.houses_reports',$data); 
                
            }
        }

        
    }
    public function occupiedreport()
    {
        $apartments = Apartment::pluck('id', 'name');
        $landlords = Landlord::pluck('id', 'full_name');
        $hasReport = false;
        return view('report.occupied_report', compact('landlords', 'apartments','hasReport'));
    }
    public function noticereport()
    {
        $apartments = Apartment::pluck('id', 'name');
        $landlords = Landlord::pluck('id', 'full_name');
        $hasReport = false;
        return view('report.notice_report', compact('landlords', 'apartments','hasReport'));
    }
    public function tenantbalance()
    {
        $apartments = Apartment::pluck('id', 'name');
        $landlords = Landlord::pluck('id', 'full_name');
        $hasReport = false;
        return view('report.tenant_balance', compact('landlords', 'apartments','hasReport'));
    }
    public function alltenants()
    {
        
        $hasReport = false;
        return view('report.all_tenants', compact('hasReport'));
    }
    public function allowners()
    {
        
        $has_report = false;
        return view('report.all_owners', compact('has_report'));
    }
    public function allproperties()
    {
        
        $has_report = false;
        return view('report.all_properties', compact('has_report'));
    }
    public function allhouses()
    {
        
        $has_report = false;
        return view('report.all_houses', compact('has_report'));
    }

    public function agencyform()
    {
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $landlords = Landlord::pluck('id', 'full_name');
        $hasReport = false;
        
        return view('report.agencyform', compact('tenants', 'apartments', 'landlords','hasReport'));
    }


    public function landlord()

 
    {    
        return view('report.landlord');
    }

    public function report($id)
    {
        $landlord_report = PayOwners::with('landlord')->where('landlord_id', $id)->get();
       // $landlord_report = PayOwners::findOrFail($id);
        //$apartments = Apartment::where('landlord_id', $id)->get();
        $apartments = Apartment::pluck('id','landlord_id','name', 'town', 'management_fee_percentage');
        $houses = House::pluck('id','house_no');
        $tenants = Tenant::pluck('id','full_name');
        //$landlord= $landlord_report->landlord->full_name;
        //$invoices = Invoice::where('tenant_id', $idd)->get();
  
        //return response()->json([$landlord_report, $id]);
        $pdf = PDF::loadView('report.landlord_reportpdf', compact('landlord_report','tenants', 'apartments', 'houses'));
        return $pdf->stream('Property Owner #' . $id . '.pdf');
    }

    public function unpaid()
    {
        $invoices = Invoice::with('house', 'tenant')->where('is_paid',0)->get();

        $data['invoices'] = $invoices;

        $pdf = PDF::loadView('report.agencyunpaidreport', $data);
                return $pdf->stream('Unpaid-Houses'  . '.pdf');

    }
    public function paid()
    {
        $invoices = Invoice::with('house', 'tenant')->where('is_paid',1)->get();

        $data['invoices'] = $invoices;

        $pdf = PDF::loadView('report.agencypaidreport', $data);
                return $pdf->stream('Paid-Houses'  . '.pdf');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = Report::findOrFail($id);
        //$apartments = Apartment::where('landlord_id', $id)->get();
        $apartments = Apartment::pluck('id','landlord_id','name', 'town', 'management_fee_percentage');
        $houses = House::pluck('id','house_no');
        $tenants = Tenant::pluck('id','full_name');
        
        return view('report.tenant_show', compact('report','tenants', 'apartments', 'houses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
    public function houses_reports()

 
    {    
                $data['has_report'] = false;
        return view('report.houses_reports',$data);
    }
    public function houses_reports_generate(Request $request)

 
    {    
        $request->validate([
            'selected_report'=>'required|string',
            'from'=>'nullable',
            'to'=>'nullable',
            ]);
            
        if($request->to || $request->from){
              $request->validate([
            'from'=>'required',
            'to'=>'required',
            ]);
        }    
        
        $from = null;
        $to = null;
        if($request->to){
            $from = $request['from'] . " 00:00:00";
            $to = $request['to'] . " 23:59:00";
            $from = $this->dateFormater('d/m/Y H:i:s',  $from, 'Y-m-d');
            $to = $this->dateFormater('d/m/Y H:i:s',  $to, 'Y-m-d');
        }
        
         //return [$from,$to];
                
        switch ( $request->selected_report) {
          case 'vacant':
        $info = House::with('apartment')->where('is_occupied',false)->get();   
        foreach($info as $dt){
            $dt['apartment_name'] = $dt['apartment']['name'];
            $dt['rent_amount'] = 'Kshs.'.number_format($dt['rent']['amount']);
        }
        $columns = [
            [
                'id'=>'apartment_name',
                'label'=>'Apartment'
            ], 
            [
                'id'=>'house_no',
                'label'=>'House Number'
            ], 
            [
                'id'=>'house_type',
                'label'=>'House Type'
               
            ],
            [
                'id'=>'rent_amount',
                'label'=>'House Rent'
               
            ],
             
            [
                'id'=>'description',
                'label'=>'Description'
            ], 
        ];
       
        $data['columns']=$columns;
        $data['data']=$info;
        
        $data['report_title']='Vacant Houses Report';
        $data['has_report'] = true;
            $data['filename'] =  $data['report_title'];
            break;
        case 'occupied':
            $info = House::with('apartment','tenant')->where('is_occupied',true)->get();
        
        foreach($info as $dt){
            $house = HouseTenant::where('house_id',$dt->id)->first();
            $tenant_data = Tenant::where('id',$house->tenant_id)->first();
            $dt['apartment_name'] = $dt['apartment']['name'];
            $dt['tenant_name'] = $tenant_data->full_name;
            $dt['tenant_phone'] = $tenant_data->phone ;
        }
        $columns = [
            [
                'id'=>'apartment_name',
                'label'=>'Apartment'
            ], 
            [
                'id'=>'tenant_name',
                'label'=>'Tenant Name'
            ], 
            [
                'id'=>'tenant_phone',
                'label'=>'Tenant Phone'
            ], 
            [
                'id'=>'house_no',
                'label'=>'House Number'
            ], 
            [
                'id'=>'house_type',
                'label'=>'House Type'
            ], 
            [
                'id'=>'description',
                'label'=>'Description'
            ], 
        ];
        $data['columns']=$columns;
        $data['data']=$info;
        $data['report_title']='Occupied Houses Report';
        $data['has_report'] = true;
           $data['filename'] = 'Occupied Houses Report';
        break;
         case 'notice':
            $info = House::with('apartment')->where('notice',true)->get();
        
        foreach($info as $dt){
            $dt['apartment_name'] = $dt['apartment']['name'];
        }
        $columns = [
            [
                'id'=>'apartment_name',
                'label'=>'Apartment'
            ], 
            [
                'id'=>'house_no',
                'label'=>'House Number'
            ], 
            [
                'id'=>'house_type',
                'label'=>'House Type'
            ], 
            [
                'id'=>'description',
                'label'=>'Description'
            ], 
        ];
        $data['columns']=$columns;
        $data['data']=$info;
        $data['report_title']='Houses on Notice';
        $data['has_report'] = true;
            $data['filename'] = 'Houses on Notice Report';
        break;
         case 'tenant_balances':
            $info = Invoice::with('apartment','house','tenant')->where('balance','>',0)->get()->groupBy('tenant_id');
        
        foreach($info as $dt){
            $dt['balance'] = $dt->sum('balance');
            $dt['tenant_name'] = $dt[0]['tenant']['full_name'];   
            $dt['tenant_phone'] = $dt[0]['tenant']['phone'];   
            $dt['house_name'] = $dt[0]['house']['house_no'].' - '.$dt[0]['house']['description'];  
            $dt['apartment_name'] = $dt[0]['apartment_name']; 
        }
        $columns = [
            [
                'id'=>'apartment_name',
                'label'=>'Apartment'
            ], 
            [
                'id'=>'house_name',
                'label'=>'House'
            ], 
            [
                'id'=>'tenant_name',
                'label'=>'Tenant Name'
            ], 
            [
                'id'=>'tenant_phone',
                'label'=>'Tenant Phone'
            ], 
            [
                'id'=>'balance',
                'label'=>'Balance'
            ], 
            // [
            //     'id'=>'total_payable',
            //     'label'=>'Total Payable'
            // ], 
            // [
            //     'id'=>'paid_in',
            //     'label'=>'Total Paid'
            // ],
            // [
            //     'id'=>'rent_month',
            //     'label'=>'Invoice Month'
            // ],
        ];
        $data['columns']=$columns;
        $data['data']=$info;
        $data['report_title']='Tenant Balances';
        $data['has_report'] = true;
        $data['filename'] = 'Tenant Balances Report';
        break;
         case 'all_tenants':
            $info = Tenant::all();
        
        foreach($info as $dt){
            $dt['status'] = $dt['is_active'] ? 'Active':'Deactivated';
        }
        $columns = [
            [
                'id'=>'account_number',
                'label'=>'Account Number'
            ], 
            [
                'id'=>'full_name',
                'label'=>'Full Name'
            ], 
            [
                'id'=>'phone',
                'label'=>'Phone Number'
            ], 
            [
                'id'=>'physical_address',
                'label'=>'Physical Address'
            ]
        ];
        $data['columns']=$columns;
        $data['data']=$info;
        $data['report_title']='All Tenants';
        $data['has_report'] = true;
               $data['filename'] = 'All Tenants Report';
        break;
         case 'all_property_owners':
            $info = Landlord::all();
  
          if($from){
        $info = Landlord::
        where('created_at', '>=', $from)
        ->where('created_at', '<=', $to. " 23:59:00")
        ->get();
        }else{
        $info = Landlord::all(); 
        } 
        
        $columns = [
            [
                'id'=>'full_name',
                'label'=>'Property Owner Name'
            ], 
            [
                'id'=>'address',
                'label'=>'Address'
            ], 
            [
                'id'=>'bank_name',
                'label'=>'Bank'
            ],
            [
                'id'=>'bank_branch',
                'label'=>'Branch'
            ],
            [
                'id'=>'bank_acc_name',
                'label'=>'Account Holder Name'
            ],
            [
                'id'=>'bank_acc_no',
                'label'=>'Account Number'
            ],
            [
                'id'=>'town',
                'label'=>'Town'
            ],
        ];
        $data['columns']=$columns;
        $data['data']=$info;
        $data['report_title']='All Property Owners';
        $data['has_report'] = true;
         $data['filename'] = 'All Property Owners Report';
         
                 $dt = date('Y-m-d H:i:s');
        if($request->download === 'yes'){
        $pdf = \PDF::loadView('docs.house_report_pdf', $data);
        return $pdf->stream($data['filename'].' '.$dt.'.pdf');
        }else{
           return view('report.all_owners',$data); 
        }
        
        break;
         case 'all_properties':
        if($request->prop == 'active'){
        if($from){
        $info = Apartment::with('landlord')
        ->where('active', 1)->where('created_at', '>=', $from)
        ->where('created_at', '<=', $to. " 23:59:00")
        ->get();
        }else{
        $info = Apartment::with('landlord')->where('active', 1)->get();  
        } 
        }else{
         if($from){
        $info = Apartment::with('landlord')
        ->where('active', 0)->where('created_at', '>=', $from)
        ->where('created_at', '<=', $to. " 23:59:00")
        ->get();
        }else{
        $info = Apartment::with('landlord')->where('active', 0)->get();  
        }    
        }
        // $request->validate([
        //     'from'=>'required|date',
        //     'to'=>'required|date'
        // ]);
        foreach($info as $dt){
            $dt['landlord_name'] = $dt['landlord']['full_name'];
            $dt['management_fee_percentage'] =$dt['management_fee_percentage'] ? $dt['management_fee_percentage'].'%':'-';
        }
  
        $columns = [
            [
                'id'=>'name',
                'label'=>'Property Name'
            ], 
            [
                'id'=>'landlord_name',
                'label'=>'Landlord'
            ], 
            [
                'id'=>'houses_qty',
                'label'=>'Number of Houses'
            ], 
            [
                'id'=>'location',
                'label'=>'Location'
            ],
            [
                'id'=>'management_fee_percentage',
                'label'=>'Management Fee'
            ]
        ];
        $data['columns']=$columns;
        $data['data']=$info;
        if($request->prop == 'active'){
        $data['report_title']='All Active Properties';
        $data['filename'] = 'All Active Properties Report';
        }else{
         $data['report_title']='All Inactive Properties';
        $data['filename'] = 'All Inactive Properties Report';   
        }
        $data['has_report'] = true;  
        $dt = date('Y-m-d H:i:s');
        if($request->download === 'yes'){
        $pdf = \PDF::loadView('docs.house_report_pdf', $data);
        return $pdf->stream($data['filename'].' '.$dt.'.pdf');
        }else{
           return view('report.all_properties',$data); 
        }
        
        break;
         case 'all_houses':
            
                if($from){
        $info = House::with('apartment')
        ->where('created_at', '>=', $from)
        ->where('created_at', '<=', $to. " 23:59:00")
        ->get();
        }else{
        $info = House::with('apartment')->get();  
        } 
        
        foreach($info as $dt){
            $dt['apartment_name'] = $dt['apartment']['name'];
            $dt['is_occupied'] = $dt['is_occupied'] ? 'Occupied':'Not Occupied';
        }
  
        $columns = [
            [
                'id'=>'house_no',
                'label'=>'House Number'
            ], 
            [
                'id'=>'house_type',
                'label'=>'House Type'
            ], 
            [
                'id'=>'description',
                'label'=>'Description'
            ], 
            [
                'id'=>'is_occupied',
                'label'=>'Occupance'
            ],
            [
                'id'=>'apartment_name',
                'label'=>'Apartment'
            ]
        ];
        $data['columns']=$columns;
        $data['data']=$info;
        $data['report_title']='All Houses';
        $data['has_report'] = true;
        $data['filename'] = 'All Houses Report';
        
                         $dt = date('Y-m-d H:i:s');
        if($request->download === 'yes'){
        $pdf = \PDF::loadView('docs.house_report_pdf', $data);
        return $pdf->stream($data['filename'].' '.$dt.'.pdf');
        }else{
           return view('report.all_houses',$data); 
        }
        
        break;
          default:
                 $data['has_report'] = false;
        }
        $dt = date('Y-m-d H:i:s');
        if($request->download === 'yes'){
        $pdf = \PDF::loadView('docs.house_report_pdf', $data);
        return $pdf->stream($data['filename'].' '.$dt.'.pdf');
        }else{
           return view('report.houses_reports',$data); 
        }

        
    }
    
        private function dateFormater($date_format, $date, $converted_format)
    {
        return date($converted_format, strtotime($date));
    }
}
