<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\Receipt;
use App\ManualPayment;
use App\Tenant;
use App\Traits\NotifyClient;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class MpesaController extends Controller
{
    //use MpesaTrait;
    use NotifyClient;
    // public function registerUrls()
    // {
    //     $this->register_Urls();
    // }
    // public function confirmationUrl()
    // {
    //     $this->confirmation_Url();
    // }
    // public function validationUrl()
    // {
    //     $this->validation_Url();
    // }
    
    public function excelProcessor()
    {

        $filename = 'pyaments1635923462.json';
        $file = \Illuminate\Support\Facades\Storage::get($filename);
        $cleanData = json_decode($file, true);
        $pymnts_not = [];
        $pymts = [];
        foreach($cleanData as $data){
             $payment = ManualPayment::where('TransID',$data['code'])->first();
             if(!$payment){
                  $pymts[] = $pymnt;
                //  return response(['message'=>'Payment present'],404);
             }else{
            // $payment = ManualPayment::create([
            //     'TransactionType' => 'Pay Bill',
            //     'TransID' => $data['code'],
            //     'TransTime' => $data['time'],
            //     'TransAmount' => $data['amount'],
            //     'BusinessShortCode' => 743994,
            //     'InvoiceNumber' => $data['acc'],
            //     'OrgAccountBalance' => 0,
            //     // 'ThirdPartyTransID' => $cleanData->ThirdPartyTransID,
            //     'MSISDN' => $data['phone'],
            //     'FirstName' => $data['name1'],
            //     'MiddleName' => $data['name2'],
            //     'LastName' => $data['name3'],
            // ]);
            $tenant = Tenant::where('account_number', $payment->InvoiceNumber)->first();
            $failed_payment_sms = []; 
            if(!$tenant){
                //  array_push($failed_payment_sms, $this->paymentFailedSmsmFormat([
                // 'mpesa_code' => $payment->TransID,
                // 'acc'=>$cleanData->BillRefNumber,
                // 'phone' => $payment->MSISDN,
                // 'name' => $payment->FirstName.' '.$payment->MiddleName.' '.$payment->LastName,
                // ]));
                continue;
            // return response()->json($sms_to_send, $sms_to_send_admin);
                // $this->sendMessage($failed_payment_sms);   
                $this->finishTransaction();
            }
            $client_invoices = Invoice::where('tenant_id', $tenant->id)
                ->where('is_paid', 0)->get();
            $this->updateClientInvoices($client_invoices, (int) $payment->TransAmount);

            $current_month_rent = $client_invoices->filter(function ($item) {
                // $arrs[] = $item['rent_month'];
                $date2 = $item['rent_month'];
                $date1 = Carbon::now()->format('M-Y');
                return $date1 == $date2;
            })->sum('rent');

            $balance_reached = Invoice::where('tenant_id', $tenant->id)->get()->sum('balance');
            $prepayment = $balance_reached < 0 ? abs($balance_reached) : 0;
            $balance = $balance_reached > 0 ? $balance_reached : 0;

            $sms_to_send = [];
            $sms_to_send_admin = [];
            $tenant_full_name = $tenant->full_name;
            $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
            $tenant_first_name = $arr_names[0];
            $tenant_last_name_n_first = $tenant_first_name === end($arr_names) ? $tenant_first_name : $tenant_first_name . ' ' . end($arr_names);

$check_receipt = Receipt::where('transaction_code',$payment->TransID)->first();
if(!$check_receipt){
    $receipt = Receipt::create([
                'name'=>$payment->FirstName.' '.$payment->MiddleName.' '.$payment->LastName,
                'phone_number'=>$payment->MSISDN,
                'transaction_code'=>$payment->TransID,
                'payment_method'=>'M-PESA',
                'rent_amount'=>$current_month_rent,
                'tenant_id'=>$tenant->id,
                'amount'=>$payment->TransAmount,
                'balance'=>$balance,
            ]);
}
            
             $pymnts_not[] = $payment;
             }
        }
        return response([
        'all_records'=>count($cleanData),
        'created_number'=>count($pymts),
        'created'=>$pymts,
        'not_created_count'=>count($pymnts_not),
        'not_created'=>$pymnts_not,
        ],404);
      
        //  Storage::put('confimation' . time() . '.txt', $callbackData);
            
            //$payment = ManualPayment::where('MSISDN', '254728519621')->first();
            // $tenant = Tenant::where('account_number', $payment->InvoiceNumber)->orWhere('phone', $payment->MSISDN)->first();
            $tenant = Tenant::where('account_number', $payment->InvoiceNumber)->first();
            $failed_payment_sms = []; 
            if(!$tenant){
                 array_push($failed_payment_sms, $this->paymentFailedSmsmFormat([
                'mpesa_code' => $payment->TransID,
                'acc'=>$cleanData->BillRefNumber,
                'phone' => $payment->MSISDN,
                'name' => $payment->FirstName.' '.$payment->MiddleName.' '.$payment->LastName,
                ]));
            // return response()->json($sms_to_send, $sms_to_send_admin);
                $this->sendMessage($failed_payment_sms);   
                $this->finishTransaction();
            }
            $client_invoices = Invoice::where('tenant_id', $tenant->id)
                ->where('is_paid', 0)->get();
            $this->updateClientInvoices($client_invoices, (int) $payment->TransAmount);

            $current_month_rent = $client_invoices->filter(function ($item) {
                // $arrs[] = $item['rent_month'];
                $date2 = $item['rent_month'];
                $date1 = Carbon::now()->format('M-Y');
                return $date1 == $date2;
            })->sum('rent');

            $balance_reached = Invoice::where('tenant_id', $tenant->id)->get()->sum('balance');
            $prepayment = $balance_reached < 0 ? abs($balance_reached) : 0;
            $balance = $balance_reached > 0 ? $balance_reached : 0;

            $sms_to_send = [];
            $sms_to_send_admin = [];
            $tenant_full_name = $tenant->full_name;
            $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
            $tenant_first_name = $arr_names[0];
            $tenant_last_name_n_first = $tenant_first_name === end($arr_names) ? $tenant_first_name : $tenant_first_name . ' ' . end($arr_names);


            $receipt = Receipt::create([
                'name'=>$payment->FirstName.' '.$payment->MiddleName.' '.$payment->LastName,
                'phone_number'=>$payment->MSISDN,
                'transaction_code'=>$payment->TransID,
                'payment_method'=>'M-PESA',
                'rent_amount'=>$current_month_rent,
                'tenant_id'=>$tenant->id,
                'amount'=>$payment->TransAmount,
                'balance'=>$balance,
            ]);
            // array_push($sms_to_send, $this->paymentConfirmationSmsFormat([
            //     'name' => $tenant_first_name,
            //     'amt_paid' => $payment->TransAmount,
            //     'prepayment' => $prepayment,
            //     'balance' => $balance,
            //     'rent' => $current_month_rent,
            //     'phone' => (int) $tenant->phone,
            //     'receipt_id' => $receipt->id,
            // ]));
            // return response()->json($sms_to_send, $sms_to_send_admin);
           
            // $this->sendMessage($sms_to_send);
            // $this->sendMessage($sms_to_send_admin);
            
        return response([
            'message' => 'Processed',
            'data' => $cleanData,
        ], 404);
    }
    public function simulateC2BPayment(Request $request)
    {
        $input = $request->all();
        $ShortCode = $input['ShortCode'];
        $CommandID = 'CustomerPayBillOnline'; //This is used for Pay Bills shortcodes.
        $Amount = $input['Amount'];
        $Msisdn = $input['MSISDN'];
        $BillRefNumber = time() . 'invoice000';

        $c2bTransactionResponse = $this->mpesaSimulateC2BPayment($ShortCode, $CommandID, $Amount, $Msisdn, $BillRefNumber);
        if (empty($c2bTransactionResponse)) {
            return $this->sendError('C2B Payment Simulation request failed.', 'Something went wrong - try again.');
        }
        $c2bTransactionResponseArray = json_decode($c2bTransactionResponse, true);
        $c2bTransactionResponseJson = json_decode($c2bTransactionResponse);
        if (array_key_exists('errorCode', $c2bTransactionResponseArray)) {
            return $this->sendError('C2B Payment Simulation request failed.', $c2bTransactionResponseJson);
        }
        return $this->sendResponse($c2bTransactionResponseJson, 'C2B Payment Simulation request sent.');
    }
    public function mpesaSimulateC2BPayment($ShortCode, $CommandID, $Amount, $Msisdn, $BillRefNumber)
    {
        $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';

        $curlPostData = array(
            #Fill in the request parameters with valid values
            'ShortCode' => $ShortCode,
            'CommandID' => $CommandID,
            'Amount' => $Amount,
            'Msisdn' => $Msisdn,
            'BillRefNumber' => $BillRefNumber,
        );
        return $this->mpesaRequestBody($ShortCode, $url, $curlPostData);
    }
    public function access_token()
    {
        // $mpesaKeys = $this->getMpesaKeys($shortCode);

        $consumerKey = config('app.mpesa_consumer_key');
        $consumerSecret = config('app.mpesa_consumer_secret');
        if (!isset($consumerKey) || !isset($consumerSecret)) {
            die("Please declare the consumer key and consumer secret as defined in the documentation.");
        }
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        

        $headers = ['Content-Type:application/json; charset=utf8'];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result = json_decode($result);

        $access_token = $result->access_token;
        curl_close($curl);

        return $access_token;
    }
    public function registerUrl(Request $request)
    {

        $registerUrlsResponse = $this->mpesaRegisterUrls();
        if (empty($registerUrlsResponse)) {
            return $this->sendError('Register URLs request failed.', 'Something went wrong - try again.');
        }
        $registerUrlsResponseArray = json_decode($registerUrlsResponse, true);
        $registerUrlsResponseJson = json_decode($registerUrlsResponse);
        if (array_key_exists('errorCode', $registerUrlsResponseArray)) {
            return $this->sendError('Register URLs request failed.', $registerUrlsResponseJson);
        }
        return $this->sendResponse($registerUrlsResponseJson, 'Register URLs request sent.');
    }
    public function mpesaRegisterUrls()
    {
        $confirmationURL = config('app.mpesa_confirmation_url');
        $validationURL = config('app.mpesa_validation_url');
        $url = config('app.mpesa_register_url');
        $shortCode = config('app.mpesa_short_code');

        $curlPostData = array(
            #Fill in the request parameters with valid values
            'ShortCode' => $shortCode,
            'ResponseType' => 'Completed',
            'ConfirmationURL' => $confirmationURL,
            'ValidationURL' => $validationURL,
        );
        return $this->mpesaRequestBody($shortCode, $url, $curlPostData);
    }

    private function mpesaRequestBody($shortCode, $endPoint, $curlPostData)
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $endPoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $this->access_token()));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curlPostData));
        $curl_response = curl_exec($curl);
        curl_close($curl);

        return $curl_response;
    }

    public function confirmationUrl()
    {
        $callbackData = $this->getDataFromCallback();

        // Storage::put('manual_payment' . time() . '.json', $callbackData);
        $cleanData = json_decode($callbackData);
        // return response($clean_data->MSISDN);
        if ($callbackData) {
            Storage::put('confimation' . time() . '.txt', $callbackData);
            $payment = ManualPayment::create([
                'TransactionType' => "Pay Bill",
                'TransID' => $cleanData->TransID,
                'TransTime' => $cleanData->TransTime,
                'TransAmount' => $cleanData->TransAmount,
                'BusinessShortCode' => $cleanData->BusinessShortCode,
                'InvoiceNumber' => $cleanData->BillRefNumber,
                'OrgAccountBalance' => $cleanData->OrgAccountBalance,
                'ThirdPartyTransID' => $cleanData->ThirdPartyTransID,
                // 'MSISDN' => 254714264331,
                'MSISDN' => $cleanData->MSISDN,
                'FirstName' => $cleanData->FirstName,
                // 'MiddleName' => $cleanData->MiddleName,
                // 'LastName' => $cleanData->LastName,
     
            ]);
            //$payment = ManualPayment::where('MSISDN', '254728519621')->first();
            // $tenant = Tenant::where('account_number', $payment->InvoiceNumber)->orWhere('phone', $payment->MSISDN)->first();
            $tenant = Tenant::where('account_number', $payment->InvoiceNumber)->first();
            $failed_payment_sms = []; 
            if(!$tenant){
                 array_push($failed_payment_sms, $this->paymentFailedSmsmFormat([
                'mpesa_code' => $payment->TransID,
                'acc'=>$cleanData->BillRefNumber,
                 'phone' => $payment->MSISDN,
                // 'name' => $payment->FirstName.' '.$payment->MiddleName.' '.$payment->LastName,
                 'name' => $payment->FirstName,
                ]));
            // return response()->json($sms_to_send, $sms_to_send_admin);
                $this->sendMessage($failed_payment_sms);   
                $this->finishTransaction();
            }
            $client_invoices = Invoice::where('tenant_id', $tenant->id)
                ->where('is_paid', 0)->get();
            $this->updateClientInvoices($client_invoices, (int) $payment->TransAmount);

            $current_month_rent = $client_invoices->filter(function ($item) {
                // $arrs[] = $item['rent_month'];
                $date2 = $item['rent_month'];
                $date1 = Carbon::now()->format('M-Y');
                return $date1 == $date2;
            })->sum('rent');

            $balance_reached = Invoice::where('tenant_id', $tenant->id)->get()->sum('balance');
            $prepayment = $balance_reached < 0 ? abs($balance_reached) : 0;
            $balance = $balance_reached > 0 ? $balance_reached : 0;

            $sms_to_send = [];
            $sms_to_send_admin = [];
            $tenant_full_name = $tenant->full_name;
            $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
            $tenant_first_name = $arr_names[0];
            $tenant_last_name_n_first = $tenant_first_name === end($arr_names) ? $tenant_first_name : $tenant_first_name . ' ' . end($arr_names);


            $receipt = Receipt::create([
                'name'=>$payment->FirstName,
                'phone_number'=>$payment->MSISDN,
                'transaction_code'=>$payment->TransID,
                'payment_method'=>'M-PESA',
                'rent_amount'=>$current_month_rent,
                'tenant_id'=>$tenant->id,
                'amount'=>$payment->TransAmount,
                'balance'=>$balance,
            ]);
            array_push($sms_to_send, $this->paymentConfirmationSmsFormat([
                'name' => $tenant_first_name,
                'amt_paid' => $payment->TransAmount,
                'prepayment' => $prepayment,
                'balance' => $balance,
                'rent' => $current_month_rent,
                'phone' => (int) $tenant->phone,
                'receipt_id' => $receipt->id,
            ]));
            // return response()->json($sms_to_send, $sms_to_send_admin);
           
            $this->sendMessage($sms_to_send);
            $this->sendMessage($sms_to_send_admin);
        }

        $this->finishTransaction();
    }

    public function paymentTester()
    {
        $payment = ManualPayment::findOrFail(8);
        $invoice_id = $payment->BillRefNumber;
        $invoice_id = preg_replace('/[^0-9]/', '', $invoice_id);
        $invoice_id = (int) $invoice_id;

        $invoice_by_id = Invoice::where('id', $invoice_id)->first();
        $invoice_by_phone = Invoice::where('tenant_id', $payment->MSISDN)->first();

        $invoice_to_update = null;
        if ($invoice_by_id) {
            $invoice_to_update = $invoice_by_id;
        } else if ($invoice_by_phone) {
            $invoice_to_update = $invoice_by_phone;
        }
        if ($invoice_to_update) {
            Storage::put('invoice_updated_via_mpesa' . time() . '.json', json_encode($invoice_to_update));
            $invoice_to_update->update([
                'paid_in' => $invoice_to_update->paid_in + $payment->TransAmount,
                'balance' => $invoice_to_update->balance - $payment->TransAmount,
                'is_paid' => ($invoice_to_update->balance - $payment->TransAmount <= 0) ? true : false,
                'payment_method' => 'Mpesa',
            ]);
            $updated_invoice = Invoice::findOrFail($invoice_to_update->id);

            $notificationBody = [
                'inv' => $payment->InvoiceNumber,
                'ref' => $payment->TransID,
                'amt_total_paid' => $updated_invoice->paid_in,
                'amt_balance' => $updated_invoice->balance + $updated_invoice->penalty_fee,
                'phone' => $payment->MSISDN,
            ];
            $this->sendConfirmationMessage((object) $notificationBody);
        }
        return 'finished';
    }
    public function validationUrl()
    {
        $this->finishTransaction();
    }
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $result,
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function finishTransaction($status = true)
    {
        if ($status === true) {
            $resultArray = [
                "ResultDesc" => "Confirmation Service request accepted successfully",
                "ResultCode" => "0",
            ];
        } else {
            $resultArray = [
                "ResultDesc" => "Confirmation Service not accepted",
                "ResultCode" => "1",
            ];
        }

        header('Content-Type: application/json');

        echo json_encode($resultArray);
    }

    private function getDataFromCallback()
    {
        #$callbackJSONData = file_get_contents('php://input');

        $handler = fopen('php://input', 'r');
        $callbackJSONData = stream_get_contents($handler);
        fclose($handler);

        return $callbackJSONData;
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

    private function paymentConfirmationSmsFormat($notificationBody)
    {
        $userData = (object) $notificationBody;

        $tenant_first_name = $userData->name;
        $amt_paid = $userData->amt_paid;

        $format = "Dear %s,\nYour rent payment of Ksh %d has been received.";
        $message_text = sprintf($format, $tenant_first_name, $amt_paid);

        $rent_section = "\nRent: Ksh %d";
        $message_text .= sprintf($rent_section, $userData->rent);
        $prepayment = $userData->prepayment > 0 ? true : false;

        // if ($arrears) {
        //     $arrears_section = "\nArrears: Ksh %d";
        //     $message_text .= sprintf($arrears_section, $userData->arrears);
        // }
        if ($prepayment) {
            $prepayment_section = "\nPrepayment: Ksh %d";
            $message_text .= sprintf($prepayment_section, $userData->prepayment);
        }
        $to_pay_section = "\nBalance: Ksh %d";
        $message_text .= sprintf($to_pay_section, $userData->balance);
        
        // $receipt = "\nReceipt: https://rms.lesaagencies.co.ke/receipt/%d/index";
        // $message_text .= sprintf($receipt, $userData->receipt_id);

        $message_text .= "\nFor enquiries call 0797597530.";

        $data = [
            'from' => config('app.sms_client'),
            'to' => $userData->phone,
            'text' => $message_text,
        ];

        return $data;
    }
    private function paymentConfirmationSmsFormatAdmin($notificationBody)
    {
        $userData = (object) $notificationBody;

        $tenant_first_name = $userData->name;
        $amt_paid = $userData->amt_paid;

        $format = "Dear Admin,\n%s has paid Kshs %d";
        $message_text = sprintf($format, $tenant_first_name, $amt_paid);

        $data = [
            'from' => config('app.sms_client'),
            'to' => (int) config('app.sms_admin_phone'),
            'text' => $message_text,
        ];

        return $data;
    }
    private function paymentFailedSmsmFormat($notificationBody)
    {
        $userData = (object) $notificationBody;
        $mpesa_code = $userData->mpesa_code;
        $phone = $userData->phone;
        $acc = $userData->acc;
        $name = $userData->name;
        $nm = '';
        $nameArray = preg_split('/[\s,]+/', $name, 3);
        if(count($nameArray) > 1){
            $name = $nameArray[0].' '.$nameArray[1];
        }else{
           $name = $nameArray[0];
        }

        $format = "Auto-Apply failed:No matching invoice was found for,\nMPESA transaction # %s\nPaid By: %s\nAccount: %s\nPhone.: %d";
        $message_text = sprintf($format, $mpesa_code, $name, $acc, $phone);

        $data = [
            'from' => config('app.sms_client'),
            'to' => (int) config('app.sms_admin_phone'),
            'text' => $message_text,
        ];

        return $data;
    }
}
