<?php

namespace App\Http\Controllers;

use App\House;
use App\HouseTenant;
//mailable classes
use App\Http\Controllers\Controller;
// use App\Mail\OnClientPayment;
use App\Invoice;

//models
use App\ManualPayment;
use App\MonthlyBilling;
use App\Overpayment;
use App\Tenant;
use App\Traits\NotifyClient;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PDF;

class NotificationsController extends Controller
{
    use NotifyClient;
    public function confirmPaymentReceipt(Request $request)
    {
        // $super = User::where('type', 'Super')->first();

        //third party api calls
        $client = new Client(); //GuzzleHttp\Client
        $test_url = 'https://jsonplaceholder.typicode.com/users';
        $response = $client->request('GET', $test_url);
        $json = json_decode($response->getBody());

        //sending email
        // \Mail::to('eric.ndungu16@gmail.com')->send(
        //     new OnClientPayment($metadata)
        // );
        echo $response->getStatusCode(); // 200
        echo $response->getReasonPhrase(); // OK
        echo $response->getProtocolVersion();
        return response([
            'status' => 200,
            // 'metadata' => $array_holder,
            'json' => $json,
        ]);
    }
    public function sendRentAppeal(Request $request)
    {
        $var = Carbon::now()->format('M-Y');
        $invoices = Invoice::with('tenant')->get()->groupBy('tenant_id');

        $grouped_invoices = [];

        foreach ($invoices as $inv) {
            //if($inv)
            $rent_of_current_month = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', $var)->sum('rent');
            $total_payable_of_current_month = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', $var)->sum('total_payable');
            $arreas = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', '!=', $var)->sum('total_payable');
            $bills = $total_payable_of_current_month - $rent_of_current_month;
            
            $acc_num = $inv[0]->tenant && $inv[0]->tenant->account_number ? $inv[0]->tenant->account_number : 0;
            $tenant_phone = $inv[0]->tenant && $inv[0]->tenant->phone ? $inv[0]->tenant->phone : 0;
             $all_tenant_payments = ManualPayment::where('InvoiceNumber',  $acc_num)->orWhere('MSISDN', $tenant_phone)->get();
             
            $total_tenant_payments = $all_tenant_payments->sum('TransAmount');
            // $tenant['total_paid_in'] = $all_tenant_invoices->sum('paid_in');
            // $total_tenant_payable = $all_tenant_invoices->sum('total_payable');
            
// if (in_array((int) $inv[0]->tenant->phone, $numbers)) {
//     echo "Got Irix";
// }
$tenant_id = $inv[0]->tenant && $inv[0]->tenant->id ? $inv[0]->tenant->id : 0;
$tenant_has_house = HouseTenant::where('tenant_id',$tenant_id )->first();
$topay = $arreas + $total_payable_of_current_month -  $total_tenant_payments;
            if($inv[0]->tenant){
                $sms_object = $this->rentAppealSmsFormat([
                    // 'phone' => (int)'254714264331',
                    'tenant' => $inv[0]->tenant,
                    'to_pay' =>   $arreas + $total_payable_of_current_month -  $total_tenant_payments,
                    'month_bills' => $bills,
                    'rent_amount' => $rent_of_current_month,
                    'arreas' => $arreas,
                    'prepayment' => $inv->sum('overpayment'),
                    'phone' => (int) $inv[0]->tenant->phone,
                ]);
                if($tenant_has_house){
                array_push($grouped_invoices, $sms_object);
                }
            }


        }
// $grouped_invoices = array_slice($grouped_invoices,0,1);
return response()->json($grouped_invoices);
// return response()->json(count($grouped_invoices));
// return response()->json($this->sendMessage($grouped_invoices));
    }
    
    
     private function rentAppealSmsFormat($notificationBody)
    {
        $userData = (object) $notificationBody;
        $account_number = $userData->tenant->account_number;

        $amount = $userData->rent_amount;

        $tenant_full_name = $userData->tenant->full_name;
        $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
        $tenant_first_name = $arr_names[0]; // will print Test

        $format = "Dear %s,\nMake All your rent payments using:\nMpesa Paybill:743994\nAcc #: %s\nor\nBank Deposit\nBank:KCB\nName:Lesa Int'l Agencies\nAcc #: 1177934779\nRef:%s\n\nCASH PAYMENTS WILL NOT BE ACCEPTED";
        $message_text = sprintf($format, $tenant_first_name, $account_number,$account_number, $amount);

        
        $message_text .= "\nFor enquiries 0797597530.";

        $data = [
            'from' => 'LesaAgency',
            'to' => (int) $userData->phone,
            'text' => $message_text,
        ];

        return $data;

    }
    
    public function correctPayments()
    {
        $tenant_ids = Tenant::all()->pluck('id');
        $pymts = ManualPayment::whereIn('MSISDN', $tenant_ids)
                    ->get();
           
        foreach($pymts as $pym){
            $tenant_record = Tenant::where('id',$pym->MSISDN)->first();
            $pym->update([
                'MSISDN'=>$tenant_record->phone,
                'InvoiceNumber'=>$tenant_record->account_number
            ]);
        }
        return response([
            'status' => 200,
            'count'=>$pymts->count(),
            'records'=>$pymts
        ]);
    }
    public function testSms(Request $request)
    {
        $array_holder = [];
        $data = [
            'from' => 'Enet_Online',
            'to' => '254728519621',
            'text' => 'Tester',
        ];
        array_push($array_holder, $data);
        $main_object = ['messages' => $array_holder];
        $json = json_encode($main_object);

        //third party api calls
        $client = new Client();
        $credentials = base64_encode('LesaAgency:Sms.lesa1');
        $response = $client->request('POST', 'https://sms.enet.co.ke/sms/1/text/multi', [
            'headers' => [
                'Authorization' => 'Basic ' . $credentials,
            ],
            'body' => $json,
        ]);
        $result = json_decode($response->getBody());

        // $metadata = (object) $array;

        //sending text
        // \Mail::to('eric.ndungu16@gmail.com')->send(
        //     new OnClientPayment($metadata)
        // );

        return response([
            'status' => 200,
            'result' => $result,
            'json' => $json,
        ]);
    }

    public function carbonTest(Request $request)
    {
        //  $all_tenants = Tenant::all();
        // $length = 4;

        // foreach($all_tenants as $key=>$tenant){
        //     $number = $key+1;
        //      $invoice = '282'.substr(str_repeat(0, $length).$number, - $length);

        //      $tenant->update([
        //          'account_number'=> $invoice
        //          ]);
        // }
        //  $updated_tenants = Tenant::all();
        $payments_in_system = [];
        $all_payments = ManualPayment::all();

        $all_invoices = Invoice::with('tenant')->where('paid_in', '>', 0)->get();

        $array_object = [];
// foreach($all_payments as $payment){
        //     $phone_in_tenants = Tenant::where('id',$payment->MSISDN)->first();

//     $invoice_id = $payment->BillRefNumber;
        //     $invoice_id = preg_replace('/[^0-9]/', '', $invoice_id);
        //     $invoice_id = (int)$invoice_id;
        //     $acc_in_tenants = Invoice::where('id',$invoice_id)->first();

//     if($phone_in_tenants){
        //         array_push($array_object,$phone_in_tenants->account_number);
        //     }

// }foreach($all_payments as $payment){

//}

        $array_of_messages = [];

        $var = Carbon::now()->format('M-Y');
        $houses = House::with('rent', 'house_tenant')->occupied()->get();
        $manual_payments_invoice_number = ManualPayment::get()->pluck('InvoiceNumber');
        $manual_payments_phones = ManualPayment::get()->pluck('MSISDN');
        foreach ($houses as $house) {
            if ($house->house_tenant && $house->house_tenant->tenant) {

                $current_month_invoice = Invoice::with('tenant')->where('rent_month', $var)
                    ->where('house_id', $house->id)
                    ->where('apartment_id', $house->apartment_id)
                    ->where('tenant_id', $house->house_tenant->tenant->id)->first();

                // if (!$current_month_invoice) {
                //     $current_month_invoice = Invoice::create([
                //         'rent' => $house->rent->amount,
                //         'rent_month' => $var,
                //         'house_id' => $house->id,
                //         'apartment_id' => $house->apartment_id,
                //         'tenant_id' => $house->house_tenant->tenant_id]
                //     );
                // }

                //$current_month_invoice = Invoice::findorfail($current_month_invoice->balance);
                $notificationBody = [
                    'tenant_info' => $current_month_invoice->tenant,
                    'invoice_id' => $current_month_invoice->id,
                    'phone' => $current_month_invoice->tenant->id,
                    'amount' => $current_month_invoice->total_payable,
                ];
                //$this->sendMessage((object) $notificationBody);
                // $this->sendEmail((object) $notificationBody);
                $userData = (object) $notificationBody;
                $account_number = $userData->tenant_info->account_number;
                $name = $userData->tenant_info->full_name;
                // $invoice = $userData->invoice_id;

                // $number = $invoice;
                // $length = 4;
                $invoice = $account_number;
                $amount = $userData->amount;

                $myvalue = $name;
                $arr = explode(' ', trim(ucfirst(strtolower($myvalue))));
                $name = $arr[0]; // will print Test

                //$format = "Dear %s, There was a system error affecting your rent amount notification. We are working to resolve the issue. Please pay your expected rent amount using the details below. \nPaybill number: 743994 \nAccount number: %s \nThank you \nFor enquiries call 0796106612.";

                // $format = "Dear %s,\nYour rent is due on or before 5th Oct, 2020.Pay now via Lipa na Mpesa:\nPaybill: 743994\nAccount: %s\nRent Amount: %d\nFor enquiries call 0796106612.";

                $format = "Dear %s,\nYour rent payment is overdue.Pay now via Lipa na Mpesa:\nPaybill: 743994\nAccount: %s\nRent Amount: %d\nFor enquiries call 0797597530.";

                $message_text = sprintf($format, $name, $invoice, $amount);

                $data = [
                    'from' => 'LesaAgency',
                    'to' => $userData->phone,
                    'text' => $message_text,
                ];

            }

            // $array_exemptions = array('2820004', '2820085', '2820052', '2820094', '2820084');
            if (count($data) > 0 && !in_array($invoice, $manual_payments_invoice_number->toArray()) && !in_array($userData->phone, $manual_payments_phones->toArray())) {
                array_push($array_of_messages, $data);
            }

        }

        $latest_array = [];
        foreach ($array_of_messages as $msg) {
            array_push($latest_array, $msg);
        }
        return response()->json($latest_array);
        // $response = $this->sendMessage($latest_array);

        return response()->json($response);
    }
    public function pdfTest(Request $request, $id)
    {
        // return response()->json('rData');
        $invoice = Invoice::with('tenant', 'house')->findOrFail($id);

        $overpayment = 0;
        $overpayments = Overpayment::where('tenant_id', $invoice->tenant_id)->get();

        if (count($overpayments) > 0) {
            $overpayment = Overpayment::where('tenant_id', $invoice->tenant_id)->first()->value('amount');
        }

        $billings = MonthlyBilling::where('billing_month', $invoice->rent_month)
            ->where('house_id', $invoice->house_id)
            ->get();
        $pdf = PDF::loadView('invoices.invoicepdf', compact('invoice', 'billings', 'overpayment'));
        // \Storage::disk('public')->put('pdfs/invoice_eric.pdf', $pdf->download('invoice_eric.pdf'));
        // if (file_exists(public_path('pdfs/invoice_eric.pdf'))) {
        //     dd('File is Exists');
        // } else {
        //     dd('File is Not Exists');
        // }
        return $pdf->stream('Invoice #' . $invoice->id . '.pdf');
        //return response()->json($use'rData);
    }

    public function sendRentDueSms()
    {
        $var = Carbon::now()->format('M-Y');
        $invoices = Invoice::with('tenant')->get()->groupBy('tenant_id');

        $grouped_invoices = [];

        foreach ($invoices as $inv) {
            //if($inv)
            $rent_of_current_month = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', $var)->sum('rent');
            $total_payable_of_current_month = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', $var)->sum('total_payable');
            $arreas = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', '!=', $var)->sum('total_payable');
           $bills = $total_payable_of_current_month - $rent_of_current_month;
            
            $acc_num = $inv[0]->tenant && $inv[0]->tenant->account_number ? $inv[0]->tenant->account_number : 0;
            
            $ph = $inv[0]->tenant && $inv[0]->tenant->phone ? $inv[0]->tenant->phone : null;
            if(!$ph) continue;
            $tenant_phone = $inv[0]->tenant && $inv[0]->tenant->phone ? $inv[0]->tenant->phone : 0;
            if(!$tenant_phone) continue;
             $all_tenant_payments = ManualPayment::where('InvoiceNumber',  $acc_num)->get();
            
            $total_tenant_payments = $all_tenant_payments->sum('TransAmount');
            // $tenant['total_paid_in'] = $all_tenant_invoices->sum('paid_in');
            // $total_tenant_payable = $all_tenant_invoices->sum('total_payable');

$topay = $arreas + $total_payable_of_current_month -  $total_tenant_payments;
            if($inv[0]->tenant && $topay > 0){
                // $sms_object =[
                //     //'phone' => (int)'254728519621',
                //     'tenant' => $inv[0]->tenant,
                //     'total_payments' => $total_tenant_payments,
                //     'total_-payable' =>   $arreas + $rent_of_current_month,
                //     'rent_amount' => $rent_of_current_month,
                //     'arreas' => $arreas,
                //     'prepayment' => $inv->sum('overpayment'),
                //     'phone' => (int) $inv[0]->tenant->phone,
                // ];
                $sms_object = $this->rentDueSmsFormat([
                    // 'phone' => (int)'254728519621',
                    'tenant' => $inv[0]->tenant,
                    'to_pay' =>   $arreas + $total_payable_of_current_month -  $total_tenant_payments,
                    'month_bills' => $bills,
                    'rent_amount' => $rent_of_current_month,
                    'arreas' => $arreas,
                    'prepayment' => $inv->sum('overpayment'),
                    'phone' => (int) $inv[0]->tenant->phone,
                ]);
                
            //      $sms_object = $this->rentOverdueSmsFormat([
            //     // 'phone' => (int)'254728519621',
            //     'tenant' => $inv[0]->tenant,
            //     'to_pay' =>  $arreas + $total_payable_of_current_month -  $total_tenant_payments,
            //     'rent_amount' => $rent_of_current_month,
            //     'arreas' => $arreas,
            //     'prepayment' => $inv->sum('overpayment'),
            //     'phone' => (int) $inv[0]->tenant->phone,
            // ]);
//              $clients = [89,88,100,106];         
// if (in_array((int) $inv[0]->tenant->id,  $clients)) {
//      array_push($grouped_invoices, $sms_object);
// }
                array_push($grouped_invoices, $sms_object);
            }


        }
// $grouped_invoices = array_slice($grouped_invoices,0,1);
return response()->json($grouped_invoices);
// return response()->json(count($grouped_invoices));
// return response()->json($this->sendMessage($grouped_invoices));
    }

 public function text()
    {

$grouped_invoices = [];
        $data = [
            'from' => 'LesaAgency',
             'to' => 254714264331,
            'text' => 'Hello there, test sms at 9:11am',
        ];
          array_push($grouped_invoices, $data);
       return response()->json($this->sendMessage($grouped_invoices));
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

 
        $format = "Dear %s,\nYour rent is due on or before 5th %s, %d.Pay now via Lipa na Mpesa:\nPaybill: 743994\nAccount: %s\nRent Amount: %d";
        $message_text = sprintf($format, $tenant_first_name, $mnth, $yr, $account_number, $amount);

        $arrears = $userData->arreas > 0 ? true : false;
        $prepayment = $userData->prepayment > 0 ? true : false;

       $to_pay_amount = $userData->to_pay < 0 ? 0 : $userData->to_pay;
        if ($userData->to_pay < 0) {
            $prepayment_section = "\nPrepayment: Ksh %d";
            $message_text .= sprintf($prepayment_section, abs($userData->to_pay));
        }else{
            $arrears = $to_pay_amount - $amount > 0 ?  $to_pay_amount - $amount : 0;
            $arrears_section = "\nArrears: Ksh %d";
            $message_text .= sprintf($arrears_section, $arrears);
           
        }
        


        $to_pay_section = "\nTo Pay: Ksh %d";
        $message_text .= sprintf($to_pay_section, abs($to_pay_amount));

        $message_text .= "\nFor enquiries call 0797597530.";


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

    public function updateUnpaidInvoices()
    {
        // $original_date_start = '2020-11-1';
        // $startdate = date('Y-m-d H:i:s', strtotime($original_date_start . " 00:00:00"));
        // $this_month_payments = ManualPayment::where('created_at', '>=', $startdate)->where('TransactionType', 'Pay Bill')->get()->sum('TransAmount');
        // // $month_income = ManualPayment::whereMonth('created_at', Carbon::now()->month)->get()->sum('TransAmount');
        // return response()->json([$this_month_payments]);

        //resets the invoice payments
        $invoices = Invoice::all();
        foreach ($invoices as $inv) {
            $inv->update([
                'is_paid' => 0,
                'balance' => $inv->total_payable,
                'paid_in' => 0,
            ]);
        }
        $invoices = Invoice::get(['is_paid', 'balance', 'paid_in']);
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            $tenant_payments_sum = ManualPayment::where('InvoiceNumber', $tenant->account_number)->orWhere('MSISDN', $tenant->id)->get()->sum('TransAmount');
            $invoices = Invoice::where('tenant_id', $tenant->id)->get();
            // $invoices = Invoice::where('tenant_id', $tenant->id)->get()->sum('balance');
            // $paid_in = Invoice::where('tenant_id', $tenant->id)->get()->sum('paid_in');
            // if ($tenant->id === '254717224346') {
            //     $tenant_inv_n_payments[] = (object) [
            //         'invoices_count' => $invoices,
            //         'paid_in' => $paid_in,
            //         'payments' => $tenant_payments_sum,
            //         'tenant' => $tenant->id,
            //         'name' => $tenant->full_name,
            //     ];
            // }
            $this->updateClientInvoices($invoices, $tenant_payments_sum);

        }
        return response()->json('reached');

        $var = Carbon::now()->format('M-Y');
        $invoices = Invoice::with('tenant')->get()->groupBy('tenant_id');

        $grouped_invoices = [];
        foreach ($invoices as $inv) {
            //if($inv)
            $rent_of_current_month = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', $var)->sum('rent');
            if (!$tenant = Tenant::where('id', $inv[0]->tenant_id)->first()) {
                $tenant = $inv[0]->tenant_name;
            } else {
                $tenant = $tenant->full_name;
            }
            $original_date_start = '2020-11-1';
            $startdate = date('Y-m-d H:i:s', strtotime($original_date_start . " 00:00:00"));
            $this_month_payments = ManualPayment::where('MSISDN', $inv[0]->tenant_id)->where('TransactionType', 'Pay Bill')->where('created_at', '>=', $startdate)->get()->sum('TransAmount');
            $arreas = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', '!=', $var)->sum('balance');

            $sms_object = [
                'phone' => (int) '254728519621',
                'tenant' => $tenant,
                'to_pay' => $inv->sum('balance'),
                'total_payable' => $inv->sum('total_payable'),
                'rent_amount' => $rent_of_current_month,
                'total_payments' => $this_month_payments,
                // 'arreas' => $arreas,
                // 'prepayment' => $inv->sum('overpayment'),
                // 'phone' => (int)$inv[0]->tenant->id,
            ];
            if ($this_month_payments > 0 && $inv->sum('balance') > 0) {
                $this->updateClientInvoices($inv, $this_month_payments);
                array_push($grouped_invoices, $sms_object);
            }

        }
//$grouped_invoices = array_slice($grouped_invoices,0,1);
        //return response()->json($grouped_invoices);
        return response()->json($this->sendMessage($grouped_invoices));
    }
    public function sendRentOverdueSms()
    {
        $var = Carbon::now()->format('M-Y');
        $invoices = Invoice::with('tenant')->where('rent_month', $var)->get()->groupBy('tenant_id');
        $all_tenants = Tenant::all();
        $grouped_invoices = [];

        foreach ($invoices as $inv) {

            $rent_of_current_month = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', $var)->sum('rent');
            if (!$tenant = Tenant::where('id', $inv[0]->tenant_id)->first()) {
                $tenant = $inv[0]->tenant_name;
            } else {
                $tenant = $tenant->full_name;
            }

            $sum_balance = Invoice::where('tenant_id', $inv[0]->tenant_id)->get()->sum('balance');
            $original_date_start = '2020-11-1';
            $startdate = date('Y-m-d H:i:s', strtotime($original_date_start . " 00:00:00"));
            $this_month_payments = ManualPayment::where('MSISDN', $inv[0]->tenant_id)->where('created_at', '>=', $startdate)->get()->sum('TransAmount');
            $arreas = Invoice::where('tenant_id', $inv[0]->tenant_id)->where('rent_month', '!=', $var)->sum('balance');
            
if($inv[0]->tenant && $inv[0]->tenant->phone && $sum_balance > 0){
                $sms_object = $this->rentOverdueSmsFormat([
                // 'phone' => $inv[0]->tenant->phone,
                'tenant' => $inv[0]->tenant,
                'to_pay' => $sum_balance,
                'rent_amount' => $inv->sum('rent'),
                'arreas' => $inv->sum('carryforward'),
                'prepayment' => $inv->sum('overpayment'),
                'phone' => $inv[0]->tenant->phone,
            ]);
            if ($inv->sum('balance') > 0) {
                // $this->updateClientInvoices($inv, $this_month_payments);
                array_push($grouped_invoices, $sms_object);
            }
}

        }
//$grouped_invoices = array_slice($grouped_invoices,0,1);
        // return response()->json(count($all_tenants));
        return response()->json($grouped_invoices);
        //return response()->json($this->sendMessage($grouped_invoices));
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
        // $format = "Dear %s,\nMake All your rent payments using:\nMpesa Paybill:743994\nAcc #: %s\nor\nBank Deposit\nBank:KCB\nName:Lesa Int'l Agencies\nAcc #: 1177934779\nRef:%s\n\nCASH PAYMENTS WILL NOT BE ACCEPTED";
        $format = "Kindly ignore the message sent earlier, it was meant for our tenants.\nApologies for any inconvenience caused.";
        $message_text = sprintf($format, $tenant_first_name, $account_number,$account_number, $amount);

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


        $arrears = $userData->arreas > 0 ? true : false;
        $prepayment = $userData->prepayment > 0 ? true : false;

    //   $to_pay_amount = $userData->to_pay < 0 ? 0 : $userData->to_pay;
    //     if ($userData->to_pay < 0) {
    //         $prepayment_section = "\nPrepayment: Ksh %d";
    //         $message_text .= sprintf($prepayment_section, abs($userData->to_pay));
    //     }else{
    //         $arrears = $to_pay_amount - $amount > 0 ?  $to_pay_amount - $amount : 0;
    //         $arrears_section = "\nArrears: Ksh %d";
    //         $message_text .= sprintf($arrears_section, $arrears);
           
    //     }
        
        // $to_pay_section = "\nBalance: Ksh %d";
        // $message_text .= sprintf($to_pay_section, abs($to_pay_amount));
        
        // $message_text .= "\nFor enquiries 0797597530.";

        $data = [
            'from' => 'LesaAgency',
            'to' => (int) $userData->phone,
            'text' => $message_text,
        ];

        return $data;

    }

    private function updateClientInvoices($client_invoices, $total_amt_for_month_paid)
    {
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
                    'payment_method' => 'Cash',
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
    }
}
