<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\House;
use App\PayOwners;
use App\Landlord;
use App\Tenant;
use App\Incomes;
use App\Invoice;
use App\ServiceRequests;
use App\ManualPayment;
use App\AgencyExpense;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $varry = Carbon::now()->format('M-Y');
        $start_of_day = date('Y-m-d H:i:s', strtotime(date('Y-m-d')  . " 00:00:00"));
        $end_of_day = date('Y-m-d H:i:s', strtotime(date('Y-m-d') . " 23:59:00"));
          $tenantTable = Tenant::get(['account_number']);
        $income_today = ManualPayment::wherein('InvoiceNumber',$tenantTable)->where('created_at','>=',$start_of_day )
        ->where('created_at', '<=',$end_of_day)->get()->sum('TransAmount');

        $bill_today = PayOwners::where('created_at','>=',$start_of_day )
        ->where('created_at', '<=',$end_of_day)->get()->sum('paid_in');

        $month_bill = PayOwners::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->get()->sum('paid_in');
        $tenants_details = Tenant::select('account_number');
      
        $month_income = ManualPayment::wherein('InvoiceNumber',$tenantTable)->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->get()->sum('TransAmount');
        // $month_income = ManualPayment::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->get()->sum('TransAmount');

        $tenants = Tenant::count();
        $landlords = Landlord::count();
        $apartments = Apartment::count();
        $houses = House::count();
        $incomes = Incomes::count();
        $servicerequest = ServiceRequests::latest()->limit(10)->where('approval', 0)->get();
        $expenses = AgencyExpense::count();
        $occupied_house = House::where('is_occupied', 1)->count(); 
        $vacant_house = House::where('is_occupied', 0)->count(); 
        
        $today_expenses = AgencyExpense::select('amount')->latest()->limit(1)->get();
        $arrears = Invoice::where('balance', '>', 0)->sum('balance');
        $no_arrears = Invoice::where('rent_month',$varry)->sum('total_payable');

        // $invoices = Invoice::unpaid()->latest()->limit(5)->get();
        $tenats = Tenant::select('full_name', 'phone')->latest()->limit(12)->get();
        $consumerKey = config('app.sms_username');
        $consumerSecret = config('app.sms_password');
        if (!isset($consumerKey) || !isset($consumerSecret)) {
            die("Please declare the consumer key and consumer secret as defined in the documentation.");
        }
        $url = 'https://sms.enet.co.ke/account/1/balance';
        

        $headers = ['Content-Type:application/json; charset=utf8'];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result = json_decode($result);

        $currency = $result->currency;
        $balance = number_format($result->balance);
        curl_close($curl);
        
        $sms_low = false;
return view('admins.index', compact('currency', 'balance', 'sms_low', 'arrears','no_arrears','tenants', 'landlords', 'apartments', 'houses', 'tenats', 'incomes','servicerequest', 'expenses', 'today_expenses', 'occupied_house','vacant_house', 'income_today', 'month_income', 'bill_today', 'month_bill'));
// return view('coming', compact('tenants', 'landlords', 'apartments', 'houses', 'tenats', 'incomes','servicerequest', 'expenses', 'today_expenses', 'occupied_house','vacant_house', 'income_today', 'month_income', 'bill_today', 'month_bill'));
  
        
    }

    //  public function side()
    // {
    //     $emails = Message::where('receiver_id', Auth::user()->id)->where('status','!=',null)->get();
    //  return view('layouts.side-menu', compact('emails'));
  
        
    // }
}
