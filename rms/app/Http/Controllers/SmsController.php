<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Landlord;
use Carbon\Carbon;
use App\ManualPayment;
use App\Sms;
use App\Apartment;
use App\HouseTenant;
use App\Tenant;
use App\Traits\UtilTrait;
use App\Traits\NotifyClient;
use Illuminate\Http\Request;

class SmsController extends Controller
{

    use UtilTrait;
     use NotifyClient;
     
     public function automatedSms(Request $request){
         
        //  dd($request->all());
         $request->validate([
             'group_sms'=>'required'
             ]);
         
         if($request->group_sms === 'overdue'){
              
              $this->rentOverdueSms();
         }
         if($request->group_sms === 'due'){
            
            $this->rentDueSms();
         }
        return back()->with('success', 'Messages sent successfully');
        // return back()->with('success', 'Under development, messages not sent');
     }
    public function sendSms(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'group_sms' => 'required|string',
            'owners_id' => 'nullable|array',
            'sms_tenant' => 'nullable|array',
            'group_type' => 'nullable|string',
        ]);
        
        $name_tags =  ["[Tenant FirstName]","[Tenant Fullname]","[Tenant Account Number]", "[Tenant Balance]", "[Tenant Phone]", "[Property Owner Name]", "[Property Owner Phone]", "[Name of Apartment]", "[Property Name]"];
        
        $message_array = [];
        if ($request->group_sms === 'group') {
            $request->validate([
                'group_type' => 'required|string',
            ]);
            if ($request->group_type === 'all_tenants') {
                
                foreach (HouseTenant::all() as $tenant) {
                    if($tenant->house->apartment->active == 1 ){
            
                $formatted_message = $this->formatSms($request->message, $name_tags,$tenant, 'tenant');
                    $data = [
                        'from' => 'LesaAgency',
                        'to' => '+' . $tenant->tenant->phone,
                        'text' => $formatted_message,
                    ];
                    array_push($message_array, $data);
                    }
          
                }
            } else if ($request->group_type === 'unpaid_tenants') {
                foreach (Invoice::with('tenant')->where('is_paid', 0)->get()->groupBy('tenant_id') as $inv) {
                    if($inv[0] ->apartment->active == 1 ){
                    if($inv[0]->tenant){
                         $formatted_message = $this->formatSms($request->message, $name_tags,$inv[0]->tenant, 'tenant');
                        $data = [
                        'from' => 'LesaAgency',
                        'to' => '+' . $inv[0]->tenant->phone,
                        'text' => $formatted_message,
                            ];
                         array_push($message_array, $data); 
                    }
                   
                }
                }
            } else if ($request->group_type === 'paid_tenants') {
                foreach (Invoice::with('tenant')->where('is_paid', 1)->get()->groupBy('tenant_id') as $inv) {
                     if($inv[0] ->apartment->active == 1 ){
                       if($inv[0]->tenant){
                            $formatted_message = $this->formatSms($request->message, $name_tags,$inv[0]->tenant, 'tenant');
                            $data = [
                        'from' => 'LesaAgency',
                        'to' => '+' . $inv[0]->tenant->phone,
                        'text' => $formatted_message,
                    ];
                    array_push($message_array, $data);
                       }
                   
                }
                }
            } else if ($request->group_type === 'all_property_owners') {
                foreach (Landlord::all() as $prop_owner) {
                    $formatted_message = $this->formatSms($request->message, $name_tags,$prop_owner, 'owner');
                    $data = [
                        'from' => 'LesaAgency',
                        'to' => '+' . $prop_owner->id,
                        'text' => $formatted_message,
                    ];
                    if($formatted_message){
                    array_push($message_array, $data);
                    }
                }
            } else {
                return response()->json('invalid group type');
            }

        } else if ($request->group_sms === 'tenant') {
            $request->validate([
                'sms_tenant' => 'required|array',
            ]);
            $tenants = Tenant::findMany($request->sms_tenant);
            foreach ($tenants as $tenant) {
                 $formatted_message = $this->formatSms($request->message, $name_tags,$tenant, 'tenant');
                $data = [
                    'from' => 'LesaAgency',
                    'to' => '+' . $tenant->phone,
                    'text' => $formatted_message,
                ];
                array_push($message_array, $data);
            }

        } else if ($request->group_sms === 'owners') {
            $request->validate([
                'owners_id' => 'required|array',
            ]);
            
            $landlords = Landlord::findMany($request->owners_id);
            foreach ($landlords as $landlord) {
                 $formatted_message = $this->formatSms($request->message, $name_tags,$landlord, 'owner');
                $data = [
                    'from' => 'LesaAgency',
                    'to' => '+' . $landlord->id,
                    'text' => $formatted_message,
                ];
                array_push($message_array, $data);
            }
        }

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Custom Sms Sent',
            'more_info' => 'Message: ' . $request->message,
            'tenant_id' =>  '0',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '1',
            'user_id' => '0',
            
        ]);
        // dd($message_array);
        // dd($request->all());
        $smses = array_slice($message_array,0,5);
        $sms_count = count($message_array);
      
        // return back()->with('success', 'Messages successfully sent');
        //  dd($smses);
        if($request->toSend === 'no'){
              $landlords = Landlord::pluck('id', 'full_name');
        $tenants = Tenant::pluck('id', 'full_name');
        // $smses = null;
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
        return view('sms.custom', compact('tenants', 'landlords','smses','sms_count', 'balance'));
        }else{
            $response = $this->sendMessage($message_array);
           return back()->with('success', 'Messages successfully sent');
        }
      
        
        return back()->with(compact('sms_count','smses'));
        return response()->json($response);
    }
    
    private function formatSms($message, $tags, $usr, $typ){
        if($typ === 'tenant'){
          if( $usr->tenant->person == null){
        $tenant_full_name = $usr->tenant->full_name;
        $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
         if( $usr->tenant->person == null){
             $tenant_first_name = $arr_names[0]; 
          
         }
         }else{
        $tenant_first_name =   $usr->tenant->full_name;
         }
        
        $invoice_balances = Invoice::where('tenant_id')->get()->sum('balance');
        $main = $message;
         $tenant_full_name = $usr->tenant->full_name;
        $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
        $tenant_first_name = $arr_names[0]; 
        
        $srt = str_replace("[Tenant FirstName]",$tenant_first_name,$main);
        $srt = str_replace("[Tenant Fullname]",$usr->tenant->full_name,$srt);
        $srt = str_replace("[Tenant Account Number]",$usr->tenant->account_number,$srt);
        $srt = str_replace("[Tenant Balance]",$invoice_balances, $srt);
        $srt = str_replace("[Tenant Phone]",$usr->tenant->phone, $srt);
            return $srt;
        }else if($typ === 'owner'){
            $apartment = Apartment::where('landlord_id',$usr->id)->first();
            $owner_full_name = $usr->full_name;
        $arr_names = explode(' ', trim(ucfirst(strtolower($owner_full_name))));
        $owner_first_name = $arr_names[0]; 
        
        if(!$apartment){
            return null;
        }
        $main = $message;
        $srt = str_replace("[Property Owner Name]",$owner_first_name,$main);
        $srt = str_replace("[Property Name]",$apartment->name,$srt);
        $srt = str_replace("[Property Owner Phone]",$usr->id,$srt);
        // $srt = str_replace("[Name of Apartment]",$apartment->name,$srt);
            return $srt;
        } else{
            return $message;
        }
        
    }
    public function sendRentDueSms()
    {
        // $invoices = Invoice::all();
        // $user_info = DB::table( 'invoices' )
        // ->select( 'tenant_id', DB::raw( 'count(*) as total' ) )
        // ->groupBy( 'browser' )
        // ->pluck( 'total', 'browser' )->all();
        $summed_invoices = [];
        $tenant_ids = Invoice::distinct('tenant_id')->pluck('tenant_id');
        foreach ($tenant_ids as $tenant_id) {
            $total_payable = Invoice::where('tenant_id', $tenant_id)->sum('total_payable');
            $rent = Invoice::where('tenant_id', $tenant_id)->sum('rent');
            $carryforward = Invoice::where('tenant_id', $tenant_id)->sum('carryforward');
            $paid_in = Invoice::where('tenant_id', $tenant_id)->sum('paid_in');
            $client_invoices = Invoice::where('tenant_id', $tenant_id)->get();
            $manual_payments = ManualPayment::where('MSISDN', $tenant_id)->sum('TransAmount');
            if (!$manual_payments) {

                // $array  = $client_invoices;
                $x = 1;
                $length = count($client_invoices);
                $total_paid_by_client = $manual_payments;
                $tenant_array = [];
                // foreach($client_invoices as $client_invoice){
                //     $paid_in = $total_paid_by_client >= $client_invoice->balance ? $client_invoice->balance : $total_paid_by_client;
                //     $balance = $total_paid_by_client >= $client_invoice->balance ? 0 : $client_invoice->balance - $total_paid_by_client;
                //     if($x === $length){
                //         // array_push($tenant_array,'one_inv');
                //         $client_invoice->update([
                //             'paid_in' => $paid_in,
                //             'balance' => $balance,
                //             'is_paid' => ($balance <= 0) ? true : false,
                //             'payment_method' => 'Mpesa',
                //         ]);
                //     }else{
                //         $client_invoice->update([
                //             'paid_in' => $paid_in,
                //             'balance' => $balance,
                //             'is_paid' => ($balance <= 0) ? true : false,
                //             'payment_method' => 'Mpesa',
                //         ]);
                //     }
                //     $total_paid_by_client = $total_paid_by_client - $paid_in;
                //     if($total_paid_by_client <= 0){
                //     break;
                //     }
                //     $x++;
                // }
                if ($length > 1) {
                    array_push($summed_invoices, [
                        'tenant_id' => $tenant_id,
                        'to pay' => $total_payable,
                        'rent' => $rent,
                        'client_invoices' => $length,
                        // 'paid_in' => $paid_in,
                        // 'client_invoices' => $client_invoices->pluck('total_payable'),
                        'amount paid' => $manual_payments,
                        // 'manual_payments'=>$tenant_array,
                    ]);
                }
            }

        }

        return response()->json($summed_invoices);
    }
    public function paymentConfirmation()
    {
        $payment = ManualPayment::where('id', 42)->first();

        $by_account_number = Tenant::where('account_number', $payment->InvoiceNumber)->first();
        $by_phone = Tenant::where('id', $payment->MSISDN)->first();

        $tenant_to_update = '';
        $response = '';
        $to_update_invoice = false;
        if ($by_account_number) {
            $to_update_invoice = true;
            $tenant_to_update = $by_account_number;
        } else if ($by_phone) {
            $to_update_invoice = true;
            $tenant_to_update = $by_phone;
        }

        if (!$to_update_invoice) {
            return response()->json('payment confirmation message without breakdown');
        }

        $total_amt_for_month_paid = ManualPayment::where('InvoiceNumber', $tenant_to_update->account_number)
            ->orWhere('MSISDN', $tenant_to_update->id)->sum('TransAmount');
        $tenant_id = $tenant_to_update->id;
        $client_invoices = Invoice::where('tenant_id', $tenant_id)->get();
        $x = 1;
        $balance_wallet = $total_amt_for_month_paid;
        $length = count($client_invoices);
        foreach ($client_invoices as $client_invoice) {

            if ($balance_wallet > 0) {
                $paid_in = $balance_wallet >= $client_invoice->balance ? $client_invoice->balance : $balance_wallet;
                $balance = $balance_wallet >= $client_invoice->balance ? 0 : $client_invoice->balance - $balance_wallet;
                $client_invoice->update([
                    'paid_in' => $client_invoice->paid_in + $paid_in,
                    'balance' => $balance,
                    'is_paid' => ($balance <= 0) ? true : false,
                    'payment_method' => 'Mpesa',
                ]);
                $balance_wallet = $balance_wallet - $paid_in;

                if ($x === $length && $balance_wallet > $client_invoice->balance) {
                    $client_invoice->update([
                        'balance' => $client_invoice->balance - $balance_wallet,
                    ]);
                }
                $x++;
            }

        }
        // $payment = ManualPayment::where('id',20)->first();
        $total_paid = ManualPayment::where('MSISDN', $tenant_id)->sum('TransAmount');
        $rent = Invoice::where('tenant_id', $tenant_id)->sum('rent');
        $carryforward = Invoice::where('tenant_id', $tenant_id)->sum('carryforward');
        $overpayments = Invoice::where('tenant_id', $tenant_id)
            ->where('balance', '<', 0)->sum('balance');
        $message = [
            'received' => $payment->TransAmount,
            'rent' => $rent,
            'arrears' => $carryforward,
            'advance payment' => abs($overpayments),
        ];
        return response()->json([
            'message' => $message,
            'total_paid' => $total_paid,
            'client_invoices' => $client_invoices,
        ]);
    }
    public function addPayment(Request $request)
    {
        $payment = ManualPayment::create([
            'TransactionType' => $request->TransactionType,
            'TransID' => $request->TransID,
            'TransTime' => $request->TransTime,
            'TransAmount' => $request->TransAmount,
            'BusinessShortCode' => $request->BusinessShortCode,
            'InvoiceNumber' => $request->BillRefNumber,
            'OrgAccountBalance' => $request->OrgAccountBalance,
            'ThirdPartyTransID' => $request->ThirdPartyTransID,
            'MSISDN' => $request->MSISDN,
            'FirstName' => $request->FirstName,
            'MiddleName' => $request->MiddleName,
            'LastName' => $request->LastName,
        ]);

        return response()->json([
            'message' => $payment,
        ]);
    }

    public function sendRentOverDueSms()
    {

    }

    public function sendRentConfirmationSms()
    {

    }

    public function custom()
    {
        // $apartments = Apartment::pluck('id', 'name');
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
        $landlords = Landlord::pluck('id', 'full_name');
        $tenants = Tenant::pluck('id', 'full_name');
        $smses = null;
        return view('sms.custom', compact('tenants','currency', 'balance', 'landlords','smses'));
    }
    public function individual()
    {
        // $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        return view('sms.individual', compact('tenants'));
    }
    public function owners()
    {
        // $apartments = Apartment::pluck('id', 'name');
        $landlords = Landlord::pluck('id', 'full_name');
        return view('sms.owners', compact('landlords'));
    }
    function list() {
        // $apartments = Apartment::pluck('id', 'name');
        $data['smses'] = Sms::all();
        return view('sms.list', $data);
    }
    public function failed()
    {
        // $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        $landlords = Landlord::pluck('id', 'full_name');
        return view('sms.failed', compact('tenants', 'landlords'));
    }

    private function paymentConfirmationSmsFormat($notificationBody)
    {
        $userData = (object) $notificationBody;

        $tenant_first_name = $userData->inv;
        $amt_paid = $userData->amt_paid;

        $format = "Dear %s,\nYour rent payment of Ksh %d has been received.";
        $message_text = sprintf($format, $tenant_first_name, $amt_paid);

        $rent_section = "\nRent: Ksh %d";
        $message_text .= sprintf($rent_section, $userData->rent);

        if ($arrears) {
            $arrears_section = "\nArrears: Ksh %d";
            $message_text .= sprintf($arrears_section, $userData->arrears);
        } else if ($prepayment) {
            $prepayment_section = "\nPrepayment: Ksh %d";
            $message_text .= sprintf($arrears_section, $userData->prepayment);
        }

        $message_text .= "\nFor enquiries call 0797597530.";

        $data = [
            'from' => config('app.sms_client'),
            'to' => $userData->phone,
            'text' => $message_text,
        ];

        return $data;
    }

    private function adminSmsFormat($notificationBody)
    {
        $userData = (object) $notificationBody;
        $format = "%s of %d, %d has paid Ksh %d.";

        $message_text = sprintf($format,
            $userData->inv,
            $userData->house_name,
            $userData->house_number,
            $userData->amount);

        $data = [
            'from' => config('app.sms_client'),
            'to' => config('app.sms_admin_phone'),
            'text' => $message_text,
        ];

        return $data;
    }

    public function resetInvoicePayments()
    {
        $invoices = Invoice::where('is_paid', 1)->get();

        // foreach($invoices as $inv){
        //     $inv->update([
        //         'paid_in' => 0,
        //         'is_paid' => 0,
        //         'balance' => $inv->total_payable
        //     ]);
        // }

        // $updated_invoices = Invoice::all();
        return response()->json($invoices);
    }
    public function updateInvoicePayments()
    {
        $all_manual_payments = ManualPayment::all();

        $output = [];
        foreach ($all_manual_payments as $payment) {

            $by_account_number = Tenant::where('account_number', $payment->InvoiceNumber)->first();
            $by_phone = Tenant::where('id', $payment->MSISDN)->first();

            $tenant_to_update = '';
            $response = '';
            $to_update_invoice = false;
            if ($by_account_number) {
                $to_update_invoice = true;
                $tenant_to_update = $by_account_number;
            } else if ($by_phone) {
                $to_update_invoice = true;
                $tenant_to_update = $by_phone;
            }

            if (!$to_update_invoice) {
                continue;
            }

            $total_amt_for_month_paid = ManualPayment::where('InvoiceNumber', $tenant_to_update->account_number)
                ->orWhere('MSISDN', $tenant_to_update->id)->sum('TransAmount');

            $tenant_id = $tenant_to_update->id;
            $client_invoices = Invoice::where('tenant_id', $tenant_id)->get();
            $x = 1;
            $balance_wallet = $total_amt_for_month_paid;
            $length = count($client_invoices);

            foreach ($client_invoices as $client_invoice) {

                if ($balance_wallet > 0) {
                    $paid_in = $balance_wallet >= $client_invoice->balance ? $client_invoice->balance : $balance_wallet;
                    $balance = $balance_wallet >= $client_invoice->balance ? 0 : $client_invoice->balance - $balance_wallet;
                    $client_invoice->update([
                        'paid_in' => $client_invoice->paid_in + $paid_in,
                        'balance' => $balance,
                        'is_paid' => ($balance <= 0) ? true : false,
                        'payment_method' => 'Mpesa',
                    ]);
                    $balance_wallet = $balance_wallet - $paid_in;

                    if ($x === $length && $balance_wallet > $client_invoice->balance) {
                        $client_invoice->update([
                            'balance' => $client_invoice->balance - $balance_wallet,
                        ]);
                    }
                    $x++;
                }

            }

            $updated_client_invoices = Invoice::where('tenant_id', $tenant_id)->get();
            array_push($output, [
                'in' => $payment->MSISDN,
                'total_amt_for_month_paid' => $total_amt_for_month_paid,
                'client_invoices' => $updated_client_invoices,
            ]);

        }

        return response()->json($output);

    }

    public function updateJsonFiles(Request $request)
    {

        $json_files = [];
        $json_files2 = [];
        $json_files3 = [];
        foreach (\Illuminate\Support\Facades\Storage::files('manuals') as $filename) {
            $file = \Illuminate\Support\Facades\Storage::get($filename);
            // array_push($json_files, json_decode($file));
            $cleanData = json_decode($file, true);
            $payment_record = ManualPayment::where('TransID', $cleanData['TransID'])->first();
            // array_push($json_files3, $decoded_data);
            if (!$payment_record && $cleanData['TransID']) {
                array_push($json_files, $cleanData['TransID']);
                $payment = ManualPayment::create([
                    'TransactionType' => $cleanData['TransactionType'],
                    'TransID' => $cleanData['TransID'],
                    'TransTime' => $cleanData['TransTime'],
                    'TransAmount' => $cleanData['TransAmount'],
                    'BusinessShortCode' => $cleanData['BusinessShortCode'],
                    'InvoiceNumber' => $cleanData['BillRefNumber'],
                    'OrgAccountBalance' => $cleanData['OrgAccountBalance'],
                    'ThirdPartyTransID' => $cleanData['ThirdPartyTransID'],
                    'MSISDN' => $cleanData['MSISDN'],
                    'FirstName' => $cleanData['FirstName'],
                    'MiddleName' => $cleanData['MiddleName'],
                    'LastName' => $cleanData['LastName'],
                ]);
            }
            // $payment_record = ManualPayment::where('TransID',)
        }
        // return response()->json([$json_files,$json_files2]);
        return response()->json($json_files);
    }
    
    private function rentDueSms(){
                $var = Carbon::now()->format('M-Y');
        $invoices = Invoice::with('tenant')->get()->groupBy('tenant_id');

        $grouped_invoices = [];

        foreach ($invoices as $inv) {
             $rent_of_current_month = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', $var)->sum('rent');
            $total_payable_of_current_month = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', $var)->sum('total_payable');
            $previous = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', '!=', $var)->sum('total_payable');
            $arreas = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', '!=', $var)->sum('balance');
            $prepayment = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', '!=', $var)->where('balance','<', 0)->sum('balance');
            $bills = $total_payable_of_current_month - $rent_of_current_month;
            
           $acc_num = $inv[0]->tenant && $inv[0]->tenant->account_number ? $inv[0]->tenant->account_number : 0;
            
            $ph = $inv[0]->tenant && $inv[0]->tenant->phone ? $inv[0]->tenant->phone : null;
            if(!$ph) continue;
            $tenant_phone = $inv[0]->tenant && $inv[0]->tenant->phone ? $inv[0]->tenant->phone : 0;
            if(!$tenant_phone) continue;
             $total_tenant_payments = ManualPayment::where('InvoiceNumber',  $acc_num)->sum('TransAmount');
            // $tenant['total_paid_in'] = $all_tenant_invoices->sum('paid_in');
            // $total_tenant_payable = $all_tenant_invoices->sum('total_payable');
            
// if (in_array((int) $inv[0]->tenant->phone, $numbers)) {
//     echo "Got Irix";
// }
$topay = $previous + $total_payable_of_current_month -  $total_tenant_payments;
            if($inv[0]->tenant && $topay > 0){
                $sms_object = $this->rentDueSmsFormat([
                //  'phone' => (int)'254714264331',
                    'tenant' => $inv[0]->tenant,
                    'to_pay' =>   $topay,
                    'month_bills' => $bills,
                    'rent_amount' => $rent_of_current_month,
                    'arreas' => $arreas,
                    'prepayment' => $prepayment,
                    'phone' => (int) $inv[0]->tenant->phone,
                ]);
                array_push($grouped_invoices, $sms_object);
            }


        }
// $grouped_invoices = array_slice($grouped_invoices,0,1);
// return response()->json($grouped_invoices);
// return response()->json(count($grouped_invoices));
return response()->json($this->sendMessage($grouped_invoices));
    }
    private function rentOverdueSms(){
         $var = Carbon::now()->format('M-Y');
        $invoices = Invoice::with('tenant')->get()->groupBy('tenant_id');

        $grouped_invoices = [];

        foreach ($invoices as $inv) {
            $rent_of_current_month = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', $var)->sum('rent');
            $total_payable_of_current_month = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', $var)->sum('total_payable');
            $previous = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', '!=', $var)->sum('total_payable');
            $arreas = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', '!=', $var)->sum('balance');
            $prepayment = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', '!=', $var)->where('balance','<', 0)->sum('balance');
            $bills = $total_payable_of_current_month - $rent_of_current_month;
            
           $acc_num = $inv[0]->tenant && $inv[0]->tenant->account_number ? $inv[0]->tenant->account_number : 0;
            
            $ph = $inv[0]->tenant && $inv[0]->tenant->phone ? $inv[0]->tenant->phone : null;
            if(!$ph) continue;
            $tenant_phone = $inv[0]->tenant && $inv[0]->tenant->phone ? $inv[0]->tenant->phone : 0;
            if(!$tenant_phone) continue;
             $total_tenant_payments = ManualPayment::where('InvoiceNumber',  $acc_num)->sum('TransAmount');
            // $tenant['total_paid_in'] = $all_tenant_invoices->sum('paid_in');
            // $total_tenant_payable = $all_tenant_invoices->sum('total_payable');
            
// if (in_array((int) $inv[0]->tenant->phone, $numbers)) {
//     echo "Got Irix";
// }
$topay = $previous + $total_payable_of_current_month -  $total_tenant_payments;
            if($inv[0]->tenant && $topay > 0){
                 $sms_object = $this->rentOverdueSmsFormat([
                // 'phone' => (int)'254714264331',
                'tenant' => $inv[0]->tenant,
                'to_pay' =>  $topay,
                'rent_amount' => $rent_of_current_month,
                'arreas' => $arreas,
                'prepayment' => $prepayment,
                'phone' => (int) $inv[0]->tenant->phone,
            ]);
                array_push($grouped_invoices, $sms_object);
            }


        }

// $grouped_invoices = array_slice($grouped_invoices,0,1);
// return response()->json($grouped_invoices);
//return response()->json(count($grouped_invoices));
return response()->json($this->sendMessage($grouped_invoices));
    }
        private function rentOverdueSmsFormat($notificationBody)
    {
        $userData = (object) $notificationBody;
        $account_number = $userData->tenant->account_number;

        $amount = $userData->rent_amount;

        $tenant_full_name = $userData->tenant->full_name;
        $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
        $tenant_first_name = $arr_names[0]; // will print Test

        // $format = "Dear %s,\nYour rent payment is overdue.Pay now via Lipa na Mpesa:\nPaybill: 743994\nAccount: %s\nRent Amount: %d";
        // $message_text = sprintf($format, $tenant_first_name, $account_number, $amount);
        
        $format = "Dear %s,\nYour rent payment is overdue.Pay now via Mpesa:\nPaybill: 743994\nAccount: %s";
        $message_text = sprintf($format, $tenant_first_name, $account_number);

        // $arrears = $userData->arreas > 0 ? true : false;
        // $prepayment = $userData->prepayment > 0 ? true : false;

        // if ($arrears) {
        //     $arrears_section = "\nArrears: Ksh %d";
        //     $message_text .= sprintf($arrears_section, $userData->arreas);
        // } else if ($prepayment) {
        //     $prepayment_section = "\nPrepayment: Ksh %d";
        //     $message_text .= sprintf($arrears_section, $userData->prepayment);
        // }

        // $to_pay_section = "\nBalance: Ksh %d";
        // $message_text .= sprintf($to_pay_section, $userData->to_pay);


    //     $arrears = $userData->arreas > 0 ? true : false;
    //     $prepayment = $userData->prepayment > 0 ? true : false;

      $to_pay_amount = $userData->to_pay < 0 ? 0 : $userData->to_pay;
    //     if ($userData->to_pay < 0) {
    //         $prepayment_section = "\nPrepayment: Ksh %d";
    //         $message_text .= sprintf($prepayment_section, abs($userData->to_pay));
    //     }else{
    //         $arrears = $to_pay_amount - $amount > 0 ?  $to_pay_amount - $amount : 0;
    //         $arrears_section = "\nArrears: Ksh %d";
    //         $message_text .= sprintf($arrears_section, $arrears);
           
    //     }
        
        $to_pay_section = "\nPay: Ksh %d";
        $message_text .= sprintf($to_pay_section, abs($to_pay_amount));
        
        // $message_text .= "\nFor enquiries call 0796106612.";
        $message_text .= "\nFor enquiries 0797597530.";

        $data = [
            'from' => 'LesaAgency',
            'to' => (int) $userData->phone,
            'text' => $message_text,
        ];

        return $data;

    }
    
        
     private function rentDueSmsFormat($notificationBody)
    {
        $userData = (object) $notificationBody;
        $account_number = $userData->tenant->account_number;
        $mnth = Carbon::now()->format('M');
        $yr = Carbon::now()->format('Y');

        $amount = $userData->rent_amount + $userData->month_bills;

        $tenant_full_name = $userData->tenant->full_name;
        $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
        $tenant_first_name = $arr_names[0]; // will print Test

 
        $format = "Dear %s,\nYour rent is due on 5th %s, %d.Pay now via Mpesa:\nPaybill: 743994\nAccount: %s";
        $message_text = sprintf($format, $tenant_first_name, $mnth, $yr, $account_number);

        $arrears = $userData->arreas > 0 ? true : false;
        $prepayment = $userData->prepayment > 0 ? true : false;

       $to_pay_amount = $userData->to_pay < 0 ? 0 : $userData->to_pay;
        // if ($userData->to_pay < 0) {
        //     $prepayment_section = "\nPrepayment: Ksh %d";
        //     $message_text .= sprintf($prepayment_section, abs($userData->to_pay));
        // }else{
        //     $arrears = $to_pay_amount - $amount > 0 ?  $to_pay_amount - $amount : 0;
        //     $arrears_section = "\nArrears: Ksh %d";
        //     $message_text .= sprintf($arrears_section, $arrears);
           
        // }
        


        $to_pay_section = "\nPay: Ksh %d";
        $message_text .= sprintf($to_pay_section, abs($to_pay_amount));

        $message_text .= "\nFor enquiries 0797597530.";


//  $message_text = "Dear %s, due to a slight technical issue, our system sent out several wrong rent balances. We are working to correct this and send out the correct balances. Our sincere apologies for any inconvenience caused.
// \nFor enquiries, contact 0796106612.";

 $message_text = sprintf($message_text, $tenant_first_name);
        $data = [
            'from' => 'LesaAgency',
            'to' => (int) $userData->phone,
            'text' => $message_text,
        ];

        return $data;

    }
}
