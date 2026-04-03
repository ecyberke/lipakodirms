<?php
namespace App\Traits;

use App\ManualPayment;
use GuzzleHttp\Client;
trait MpesaTrait
{

    public function access_token()
    {
        // $mpesaKeys = $this->getMpesaKeys($shortCode);

        $consumerKey = config('app.mpesa_consumer_key');
        $consumerSecret = config('app.mpesa_consumer_secret');
        if (!isset($consumerKey) || !isset($consumerSecret)) {
            die("Please declare the consumer key and consumer secret as defined in the documentation.");
        }
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $headers = ['Content-Type:application/json; charset=utf8'];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result = json_decode($result);
        curl_close($curl);

        // return $access_token;
        return $result->access_token;;
    }
    public function register_Urls()
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

    public function confirmation_Url()
    {
        $callbackData = $this->getDataFromCallback();

        Storage::put('manual_payment' . time() . '.json', $callbackData);
        $cleanData = json_decode($callbackData);
        // return response($clean_data->MSISDN);
        if ($callbackData) {
            // Storage::put('confimation' . time() . '.txt', $callbackData);
            $payment = ManualPayment::create([
                'TransactionType' => $cleanData->TransactionType,
                'TransID' => $cleanData->TransID,
                'TransTime' => $cleanData->TransTime,
                'TransAmount' => $cleanData->TransAmount,
                'BusinessShortCode' => $cleanData->BusinessShortCode,
                'InvoiceNumber' => $cleanData->BillRefNumber,
                'OrgAccountBalance' => $cleanData->OrgAccountBalance,
                'ThirdPartyTransID' => $cleanData->ThirdPartyTransID,
                'MSISDN' => $cleanData->MSISDN,
                'FirstName' => $cleanData->FirstName,
                'MiddleName' => $cleanData->MiddleName,
                'LastName' => $cleanData->LastName,
            ]);
            if ($invoice = DB::connection('core')->table('invoices')->where('invoice_number', (int) $cleanData->BillRefNumber)->first()) {
                $data = $this->updateManualPayment($payment, $invoice);
            }

        }

        $this->finishTransaction();
    }

    public function validation_Url()
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
}
