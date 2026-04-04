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
use App\Imports\ManualPaymentsImport; 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class MpesaController extends Controller
{
    use NotifyClient;

    /**
     * Get access token for M-Pesa API
     */
    public function access_token()
    {
        // $mpesaKeys = $this->getMpesaKeys($shortCode);

        $consumerKey = 'G8cTIYJlnn41NN2pqXjhGsV0xONA6ACk';
        $consumerSecret = 'LQSBVwZ0tQydKupl';
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

        // return $access_token;
        return $access_token;
    }

    /**
     * Register M-Pesa URLs
     */
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
    
    /**
     * M-Pesa confirmation URL callback
     */
    public function confirmationUrl()
    {
        $callbackData = $this->getDataFromCallback();
        Storage::put('confirmation_' . time() . '.json', $callbackData);
        
        $cleanData = json_decode($callbackData);
        
        if (!$cleanData) {
            Log::error('Failed to parse callback data', ['data' => $callbackData]);
            $this->finishTransaction(false);
            return;
        }
        $phone_number = Tenant::where('account_number', $cleanData->BillRefNumber )->first();
        // Save payment to ManualPayment table
        $payment = ManualPayment::create([
            'TransactionType' => $cleanData->TransactionType ?? 'Pay Bill',
            'TransID' => $cleanData->TransID,
            'TransTime' => $cleanData->TransTime,
            'TransAmount' => $cleanData->TransAmount,
            'BusinessShortCode' => $cleanData->BusinessShortCode,
            'InvoiceNumber' => $cleanData->BillRefNumber ?? ($cleanData->InvoiceNumber ?? ''),
            'OrgAccountBalance' => $cleanData->OrgAccountBalance,
            'ThirdPartyTransID' => $cleanData->ThirdPartyTransID ?? '',
            'MSISDN' => $phone_number->phone ?? 'No Valid Phone Number',
            'FirstName' => $cleanData->FirstName ?? '',
            'MiddleName' => $cleanData->MiddleName ?? '',
            'LastName' => $cleanData->LastName ?? '',
        ]);
        
        // Process the payment
        $this->processManualPayment($payment, $cleanData);
        
        $this->finishTransaction();
    }

    /**
     * M-Pesa validation URL callback
     */
    public function validationUrl()
    {
        $this->finishTransaction();
    }

    /**
     * ================================================================
     * STK PUSH FUNCTIONALITY (ADDED)
     * ================================================================
     */

    /**
     * Generate M-PESA password for STK Push
     */
    private function generateSTKPassword()
    {
        $shortCode = config('app.mpesa_short_code', '743994');
        $passkey = 'a100c71f733fd0f71077dc9f316fcfc64043040f6ccbe8940c4d876d42836807';
        $timestamp = Carbon::rawParse('now')->format('YmdHms');
        
        $dataToEncode = $shortCode . $passkey . $timestamp;
        return base64_encode($dataToEncode);
    }

    /**
     * Lipa na M-PESA STK Push method
     */
   /**
 * Lipa na M-PESA STK Push method
 */
/**
 * Lipa na M-PESA STK Push method with partial payment support
 */
/**
 * Lipa na M-PESA STK Push method with partial payment support
 */
public function stkPush(Request $request, $id)
{
    // Validate request
    $validator = Validator::make($request->all(), [
        'phone' => 'required|string|min:10|max:13',
        'amount' => 'required|numeric|min:1'
    ]);

    if ($validator->fails()) {
        return redirect()->route('invoice.show', $id)
            ->with('error', 'Please provide a valid phone number and amount')
            ->withErrors($validator);
    }

    try {
        // Find invoice
        $invoice = Invoice::findOrFail($id);
        
        // Format phone number
        $phone = $this->formatPhoneNumber($request->phone);
        
        // Get amount from request
        $amount = round($request->amount);
        
        // Check if amount is valid
        if ($amount <= 0) {
            return redirect()->route('invoice.show', $id)
                ->with('error', 'Invalid amount');
        }
        
        // Check if amount exceeds balance
        if ($amount > $invoice->balance) {
            return redirect()->route('invoice.show', $id)
                ->with('error', 'Amount cannot exceed invoice balance of Ksh ' . number_format($invoice->balance));
        }
        
        // Generate access token
        $accessToken = $this->access_token();
        
        if (!$accessToken) {
            return redirect()->route('invoice.show', $id)
                ->with('error', 'Failed to generate access token. Please try again.');
        }
        
        // STK Push URL
        $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        
        // Generate password
        $password = $this->generateSTKPassword();
        $timestamp = Carbon::rawParse('now')->format('YmdHms');
        
        // Prepare callback URL
        $callbackUrl = route('mpesa.stk.callback');
        
        // Prepare STK Push data
        $stkData = [
            'BusinessShortCode' => config('app.mpesa_short_code', '743994'),
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => config('app.mpesa_short_code', '743994'),
            'PhoneNumber' => $phone,
            'CallBackURL' => $callbackUrl,
            'AccountReference' => $invoice->invoice_number,
            'TransactionDesc' => 'Payment for Invoice ' . $invoice->invoice_number . ' - Partial'
        ];
        
        // Make API request
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($stkData));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $curl_response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        if (curl_error($curl)) {
            throw new \Exception('cURL Error: ' . curl_error($curl));
        }
        
        curl_close($curl);
        
        $response = json_decode($curl_response);
        
        // Log the response for debugging
        Log::info('STK Push Response', [
            'response' => $response, 
            'http_code' => $http_code,
            'invoice_id' => $id
        ]);
        
        // Check if request was successful
        if ($http_code === 200 && isset($response->ResponseCode) && $response->ResponseCode === '0') {
            
            // Store transaction details in session
            session()->flash('stk_checkout_id', $response->CheckoutRequestID ?? null);
            
            $message = 'STK Push sent successfully for Ksh ' . number_format($amount) . '. ';
            if ($amount < $invoice->balance) {
                $message .= 'This is a partial payment. Remaining balance: Ksh ' . number_format($invoice->balance - $amount);
            }
            
            return redirect()->route('invoice.show', $id)
                ->with('success', $message);
        } else {
            // Handle different error responses
            $errorMessage = 'Failed to initiate STK Push. ';
            
            if (isset($response->errorMessage)) {
                $errorMessage .= $response->errorMessage;
            } elseif (isset($response->error_message)) {
                $errorMessage .= $response->error_message;
            } elseif (isset($response->ResponseDescription)) {
                $errorMessage .= $response->ResponseDescription;
            } else {
                $errorMessage .= 'Please try again.';
            }
            
            throw new \Exception($errorMessage);
        }
        
    } catch (\Exception $e) {
        Log::error('STK Push Error', [
            'message' => $e->getMessage(),
            'invoice_id' => $id,
            'trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->route('invoice.show', $id)
            ->with('error', 'Payment failed: ' . $e->getMessage());
    }
}

    /**
     * STK Push Callback URL handler
     */
    public function stkCallback(Request $request)
    {
        // Log the callback data
        Log::info('STK Push Callback Received', $request->all());
        
        try {
            $callbackData = $request->getContent();
            $callbackData = json_decode($callbackData, true);
            
            // Log parsed callback data
            Log::info('STK Push Callback Parsed', $callbackData ?? []);
            
            // Process the callback data
            if (isset($callbackData['Body']['stkCallback'])) {
                $stkCallback = $callbackData['Body']['stkCallback'];
                
                $resultCode = $stkCallback['ResultCode'];
                $resultDesc = $stkCallback['ResultDesc'];
                $merchantRequestId = $stkCallback['MerchantRequestID'];
                $checkoutRequestId = $stkCallback['CheckoutRequestID'];
                
                if ($resultCode == 0) {
                    // Successful transaction
                    $callbackMetadata = $stkCallback['CallbackMetadata']['Item'];
                    
                    $transactionData = [];
                    foreach ($callbackMetadata as $item) {
                        $transactionData[$item['Name']] = $item['Value'] ?? null;
                    }
                    
                    Log::info('STK Push Payment Successful', $transactionData);
                    
                    // Create manual payment record
                    $payment = ManualPayment::create([
                        'TransactionType' => 'STK Push',
                        'TransID' => $transactionData['MpesaReceiptNumber'] ?? $checkoutRequestId,
                        'TransTime' => $transactionData['TransactionDate'] ?? now(),
                        'TransAmount' => $transactionData['Amount'] ?? 0,
                        'BusinessShortCode' => config('app.mpesa_short_code', '743994'),
                        'InvoiceNumber' => $transactionData['AccountReference'] ?? '',
                        'OrgAccountBalance' => 0,
                        'ThirdPartyTransID' => $checkoutRequestId,
                        'MSISDN' => $transactionData['PhoneNumber'] ?? '',
                        'FirstName' => 'STK',
                        'MiddleName' => 'Push',
                        'LastName' => 'Payment',
                    ]);
                    
                    // Process the payment using your existing method
                    $this->processManualPayment($payment);
                    
                    return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
                } else {
                    // Failed transaction
                    Log::error('STK Push Payment Failed', [
                        'resultCode' => $resultCode,
                        'resultDesc' => $resultDesc
                    ]);
                    
                    return response()->json(['ResultCode' => $resultCode, 'ResultDesc' => $resultDesc]);
                }
            }
            
            return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Invalid callback data']);
            
        } catch (\Exception $e) {
            Log::error('STK Push Callback Processing Error', ['error' => $e->getMessage()]);
            return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Error processing callback']);
        }
    }

    /**
     * Query STK Push status
     */
    public function stkQuery(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checkout_request_id' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Checkout Request ID is required'
            ], 422);
        }

        try {
            $accessToken = $this->access_token();
            
            if (!$accessToken) {
                throw new \Exception('Failed to generate access token');
            }
            
            $url = 'https://api.safaricom.co.ke/mpesa/stkpushquery/v1/query';
            
            $password = $this->generateSTKPassword();
            $timestamp = Carbon::rawParse('now')->format('YmdHms');
            
            $queryData = [
                'BusinessShortCode' => config('app.mpesa_short_code', '743994'),
                'Password' => $password,
                'Timestamp' => $timestamp,
                'CheckoutRequestID' => $request->checkout_request_id
            ];
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $accessToken
            ]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($queryData));
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
            $curl_response = curl_exec($curl);
            curl_close($curl);
            
            $response = json_decode($curl_response);
            
            return response()->json([
                'success' => true,
                'data' => $response
            ]);
            
        } catch (\Exception $e) {
            Log::error('STK Query Error', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * ================================================================
     * EXISTING METHODS (YOUR ORIGINAL CODE BELOW - PRESERVED)
     * ================================================================
     */

    public function processImport(Request $request)
    {
        try {
            Log::info('Import request received', [
                'has_import_data' => $request->has('import_data'),
                'all_input_keys' => array_keys($request->all()),
            ]);
            
            $jsonData = $request->input('import_data');
            
            if (!$jsonData || trim($jsonData) === '') {
                Log::error('No import_data received or empty');
                return response()->json([
                    'success' => false,
                    'message' => 'No data received from client'
                ], 400);
            }
            
            // Clean the JSON string
            $jsonData = trim($jsonData);
            $jsonData = preg_replace('/^\xEF\xBB\xBF/', '', $jsonData);
            $jsonData = str_replace("\0", '', $jsonData);
            
            Log::info('Cleaned JSON data (first 500 chars):', [
                'data_sample' => substr($jsonData, 0, 500)
            ]);
            
            $data = json_decode($jsonData, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON decode error:', [
                    'error' => json_last_error_msg(),
                    'json_data_sample' => substr($jsonData, 0, 200),
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid data format: ' . json_last_error_msg()
                ], 400);
            }
            
            if (!$data || !isset($data['rows'])) {
                Log::error('Invalid data structure after decode', ['data' => $data]);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid data structure: missing rows array'
                ], 400);
            }
            
            Log::info('Data parsed successfully', [
                'row_count' => count($data['rows']),
                'short_code' => $data['short_code'] ?? 'not set',
            ]);
            
            $rows = $data['rows'];
            $shortCode = $data['short_code'] ?? '743994';
            $paymentMethod = 'Mpesa';
            
            $importedRows = [];
            $failedRows = [];
            $successCount = 0;
            $failCount = 0;
            
            // Validate each row
            foreach ($rows as $index => $rowData) {
                try {
                    // Ensure rowData is an array
                    if (!is_array($rowData)) {
                        throw new \Exception('Invalid row data format');
                    }
                    
                    // Extract data from the row
                    $receiptNo = $rowData['TransID'] ?? '';
                    $paidAmount = $rowData['TransAmount'] ?? 0;
                    $completionTime = $rowData['TransTime'] ?? '';
                    $accountNo = $rowData['InvoiceNumber'] ?? '';
                    
                    // Clean the account number
                    $accountNo = str_replace('\\\\', '\\', $accountNo);
                    $accountNo = str_replace("\0", '', $accountNo);
                    $accountNo = trim($accountNo);
                    
                    // Debug logging for each row
                    Log::debug('Processing row', [
                        'row' => $index + 1,
                        'receiptNo' => $receiptNo,
                        'accountNo' => $accountNo,
                        'completionTime' => $completionTime,
                        'amount' => $paidAmount
                    ]);
                    
                    // Validate required fields
                    if (empty($receiptNo)) {
                        throw new \Exception('Missing Transaction ID');
                    }
                    
                    if (empty($accountNo)) {
                        throw new \Exception('Missing Account Number');
                    }
                    
                    if (empty($completionTime)) {
                        throw new \Exception('Missing Completion Time');
                    }
                    
                    // Skip zero amounts
                    $paidAmount = floatval($paidAmount);
                    if ($paidAmount <= 0) {
                        throw new \Exception('Invalid or zero transaction amount: ' . $paidAmount);
                    }
                    
                    // Skip non-numeric account numbers (like "Lesa", "LESA via WEB", etc.)
                    if (!preg_match('/^\d+$/', $accountNo)) {
                        throw new \Exception('Skipping non-numeric account number: ' . $accountNo);
                    }
                    
                    // Look up tenant
                    $tenant = Tenant::where('account_number', $accountNo)->first();
                    
                    if (!$tenant) {
                        throw new \Exception('Account number could not be found: ' . $accountNo);
                    }
                    
                    // Check if payment already exists
                    $existingPayment = ManualPayment::where('TransID', $receiptNo)->first();
                    if ($existingPayment) {
                        throw new \Exception('Payment already exists with Transaction ID: ' . $receiptNo);
                    }
                    
                    // Parse completion time with multiple format attempts
                    try {
                        $completionDateTime = null;
                        
                        // Try multiple date formats
                        $formats = [
                            'd-m-Y H:i:s',  // 14-01-2026 13:39:49
                            'd/m/Y H:i:s',   // 14/01/2026 13:39:49
                            'Y-m-d H:i:s',   // 2026-01-14 13:39:49
                            'd-m-Y H:i',     // 14-01-2026 13:39
                            'd/m/Y H:i',     // 14/01/2026 13:39
                        ];
                        
                        foreach ($formats as $format) {
                            $parsed = \DateTime::createFromFormat($format, $completionTime);
                            if ($parsed !== false) {
                                $completionDateTime = \Carbon\Carbon::instance($parsed);
                                break;
                            }
                        }
                        
                        // If none worked, try Carbon's parser as fallback
                        if (!$completionDateTime) {
                            $completionDateTime = \Carbon\Carbon::parse($completionTime);
                        }
                        
                    } catch (\Exception $e) {
                        Log::warning('Date parsing failed, using current time', [
                            'completionTime' => $completionTime,
                            'error' => $e->getMessage()
                        ]);
                        $completionDateTime = now();
                    }
                    
                    // Format date for database
                    $paymentDate = $completionDateTime->format('Y-m-d');
                    
                    // Create payment record
                    $payment = ManualPayment::create([
                        'TransactionType' => 'Pay Bill',
                        'TransID' => $receiptNo,
                        'TransTime' => $completionTime,
                        'payment_date' => $paymentDate,
                        'TransAmount' => $paidAmount,
                        'BusinessShortCode' => $shortCode,
                        'InvoiceNumber' => $accountNo,
                        'MSISDN' => $tenant->phone ?? $tenant->mobile ?? '',
                        'full_name' => $tenant->full_name ?? '',
                        'OrgAccountBalance' => $rowData['OrgAccountBalance'] ?? 0,
                        'ThirdPartyTransID' => $rowData['ThirdPartyTransID'] ?? '',
                        'created_at' => $completionDateTime,
                        'updated_at' => $completionDateTime,
                    ]);
                    
                    $importedRows[] = [
                        'TransID' => $receiptNo,
                        'InvoiceNumber' => $accountNo,
                        'TransAmount' => $paidAmount,
                        'FullName' => $tenant->full_name ?? '',
                        'MSISDN' => $tenant->phone ?? '',
                        'TransTime' => $completionTime,
                        'PaymentDate' => $paymentDate
                    ];
                    
                    $successCount++;
                    Log::info('Payment imported successfully', [
                        'TransID' => $receiptNo,
                        'AccountNo' => $accountNo,
                        'Amount' => $paidAmount
                    ]);
                     // Process the payment
                        $processResult = $this->processManualPayment($payment);
                        
                        if (!$processResult) {
                            $failedRows[] = [
                                'row' => $index + 1,
                                'data' => $row,
                                'error' => 'Failed to process payment (tenant not found)'
                            ];
                        }
                    
                } catch (\Exception $e) {
                    $failCount++;
                    $failedRows[] = [
                        'row' => $index + 1,
                        'account_no' => $accountNo ?? 'N/A',
                        'error' => $e->getMessage()
                    ];
                    Log::warning('Error processing row', [
                        'row' => $index + 1,
                        'error' => $e->getMessage(),
                        'account_no' => $accountNo ?? 'N/A',
                        'receipt_no' => $receiptNo ?? 'N/A'
                    ]);
                }
            }
            
            Log::info('Import completed', [
                'success_count' => $successCount,
                'fail_count' => $failCount,
                'total_rows' => count($rows)
            ]);
            
            return response()->json([
                'success' => true,
                'message' => $successCount > 0 ? 
                    'Import completed successfully. ' . $successCount . ' payments imported.' : 
                    'No payments were imported. Check failed rows for details.',
                'statistics' => [
                    'total' => count($rows),
                    'success' => $successCount,
                    'failed' => $failCount,
                    'success_percentage' => count($rows) > 0 ? round(($successCount / count($rows)) * 100, 2) : 0,
                    'short_code' => $shortCode,
                    'payment_method' => $paymentMethod
                ],
                'imported_rows' => $importedRows,
                'failed_rows' => $failedRows
            ]);
            
        } catch (\Exception $e) {
            Log::error('Import failed with exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process imported CSV payments (No Excel package needed)
     */
    public function processImportoutdated(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'import_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        try {
            $file = $request->file('import_file');
            $filename = $file->getClientOriginalName();
            
            // Read CSV file
            $rows = $this->readCSVFile($file);
            
            if (empty($rows)) {
                return response()->json([
                    'success' => false,
                    'message' => 'CSV file is empty or could not be read.'
                ], 400);
            }
            
            $importedCount = 0;
            $failedRows = [];
            
            // Process each row
            foreach ($rows as $index => $row) {
                try {
                    // Skip header row (row 0)
                    if ($index === 0) continue;
                    
                    // Skip empty rows
                    if (empty(array_filter($row))) {
                        continue;
                    }
                    
                    // Validate row has enough columns
                    if (count($row) < 4) {
                        $failedRows[] = [
                            'row' => $index + 1,
                            'data' => $row,
                            'error' => 'Row does not have enough columns (minimum 4 required)'
                        ];
                        continue;
                    }
                    
                    // Validate required fields
                    if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3])) {
                        $failedRows[] = [
                            'row' => $index + 1,
                            'data' => $row,
                            'error' => 'Missing required fields (TransID, TransTime, TransAmount, MSISDN)'
                        ];
                        continue;
                    }
                    
                    // Map CSV columns to database fields
                    $paymentData = [
                        'TransactionType' => isset($row[9]) ? $row[9] : 'Pay Bill',
                        'TransID' => trim($row[0]),
                        'TransTime' => trim($row[1]),
                        'TransAmount' => (float) $row[2],
                        'BusinessShortCode' => isset($row[8]) ? $row[8] : config('app.mpesa_short_code', '123456'),
                        'InvoiceNumber' => isset($row[4]) ? trim($row[4]) : '',
                        'OrgAccountBalance' => isset($row[10]) ? (float) $row[10] : 0,
                        'ThirdPartyTransID' => isset($row[11]) ? trim($row[11]) : '',
                        'MSISDN' => $this->formatPhoneNumber($row[3]),
                        'FirstName' => isset($row[5]) ? trim($row[5]) : '',
                        'MiddleName' => isset($row[6]) ? trim($row[6]) : '',
                        'LastName' => isset($row[7]) ? trim($row[7]) : '',
                    ];
                    
                    // Check if payment already exists
                    $existingPayment = ManualPayment::where('TransID', $paymentData['TransID'])->first();
                    if ($existingPayment) {
                        $failedRows[] = [
                            'row' => $index + 1,
                            'data' => $row,
                            'error' => 'Payment with this TransID already exists'
                        ];
                        continue;
                    }
                    
                    // Create payment
                    $payment = ManualPayment::create($paymentData);
                    $importedCount++;
                    
                    // Process the payment
                    $processResult = $this->processManualPayment($payment);
                    
                    if (!$processResult) {
                        $failedRows[] = [
                            'row' => $index + 1,
                            'data' => $row,
                            'error' => 'Failed to process payment (tenant not found)'
                        ];
                    }
                    
                } catch (\Exception $e) {
                    $failedRows[] = [
                        'row' => $index + 1,
                        'data' => $row,
                        'error' => $e->getMessage()
                    ];
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Import completed successfully',
                'imported' => $importedCount,
                'failed' => count($failedRows),
                'failed_details' => $failedRows,
            ]);
            
        } catch (\Exception $e) {
            Log::error('CSV import failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Import failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Download CSV template for manual payments import
     */
    public function downloadTemplate()
    {
        $filename = 'manual_payments_template.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Write UTF-8 BOM for Excel compatibility
            fwrite($file, "\xEF\xBB\xBF");
            
            // Write headers
            fputcsv($file, [
                'TransID',
                'TransTime',
                'TransAmount',
                'MSISDN',
                'InvoiceNumber',
                'FirstName',
                'MiddleName',
                'LastName',
                'BusinessShortCode',
                'TransactionType',
                'OrgAccountBalance',
                'ThirdPartyTransID'
            ]);
            
            // Write sample data
            fputcsv($file, [
                'TQ12345678',
                '20231224120000',
                '5000',
                '254712345678',
                'INV001',
                'John',
                'M',
                'Doe',
                '123456',
                'Pay Bill',
                '0',
                ''
            ]);
            
            fputcsv($file, [
                'TQ87654321',
                '20231224123000',
                '7500',
                '254798765432',
                'INV002',
                'Jane',
                'K',
                'Smith',
                '123456',
                'Pay Bill',
                '0',
                ''
            ]);
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    /**
     * Get import history (simple version)
     */
    public function getImportHistory(Request $request)
    {
        $query = ManualPayment::orderBy('created_at', 'desc');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('TransID', 'like', "%{$search}%")
                  ->orWhere('MSISDN', 'like', "%{$search}%")
                  ->orWhere('InvoiceNumber', 'like', "%{$search}%")
                  ->orWhere('FirstName', 'like', "%{$search}%")
                  ->orWhere('LastName', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('per_page')) {
            $imports = $query->paginate($request->per_page);
        } else {
            $imports = $query->paginate(20);
        }
        
        return response()->json([
            'success' => true,
            'data' => $imports,
        ]);
    }

    /**
     * Process manual payment from JSON file (legacy method)
     */
    public function excelProcessor()
    {
        $filename = 'payments1635923462.json';
        
        if (!Storage::exists($filename)) {
            return response(['error' => 'File not found'], 404);
        }
        
        $file = Storage::get($filename);
        $cleanData = json_decode($file, true);
        
        if (!$cleanData) {
            return response(['error' => 'Invalid JSON data'], 400);
        }
        
        $pymts = [];
        $pymnts_not = [];
        $failed_payments = [];
        
        foreach ($cleanData as $data) {
            try {
                // Check if payment already exists
                $existingPayment = ManualPayment::where('TransID', $data['code'])->first();
                
                if ($existingPayment) {
                    $pymnts_not[] = $existingPayment;
                    continue;
                }
                
                // Create new payment
                $payment = ManualPayment::create([
                    'TransactionType' => 'Pay Bill',
                    'TransID' => $data['code'],
                    'TransTime' => $data['time'],
                    'TransAmount' => $data['amount'],
                    'BusinessShortCode' => 743994,
                    'InvoiceNumber' => $data['acc'],
                    'OrgAccountBalance' => 0,
                    'ThirdPartyTransID' => '',
                    'MSISDN' => $data['phone'],
                    'FirstName' => $data['name1'] ?? '',
                    'MiddleName' => $data['name2'] ?? '',
                    'LastName' => $data['name3'] ?? '',
                ]);
                
                $pymts[] = $payment;
                
                // Process the payment
                if (!$this->processManualPayment($payment)) {
                    $failed_payments[] = $payment->TransID;
                }
                
            } catch (\Exception $e) {
                Log::error('Failed to process payment from JSON', [
                    'data' => $data,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        return response([
            'all_records' => count($cleanData),
            'created_number' => count($pymts),
            'created' => $pymts,
            'not_created_count' => count($pymnts_not),
            'not_created' => $pymnts_not,
            'failed_processing' => $failed_payments,
        ]);
    }

    /**
     * Simulate C2B payment (for testing)
     */
    public function simulateC2BPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ShortCode' => 'required',
            'Amount' => 'required|numeric|min:1',
            'MSISDN' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->sendError('Validation failed', $validator->errors(), 422);
        }
        
        $ShortCode = $request->ShortCode;
        $CommandID = 'CustomerPayBillOnline';
        $Amount = $request->Amount;
        $Msisdn = $request->MSISDN;
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

    /**
     * Payment tester (for testing)
     */
    public function paymentTester()
    {
        $payment = ManualPayment::find(8);
        
        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }
        
        $invoice_id = $payment->BillRefNumber;
        $invoice_id = preg_replace('/[^0-9]/', '', $invoice_id);
        $invoice_id = (int) $invoice_id;

        $invoice_by_id = Invoice::where('id', $invoice_id)->first();
        $invoice_by_phone = Invoice::where('tenant_id', $payment->MSISDN)->first();

        $invoice_to_update = $invoice_by_id ?? $invoice_by_phone;
        
        if ($invoice_to_update) {
            Storage::put('invoice_updated_via_mpesa_' . time() . '.json', json_encode($invoice_to_update));
            
            $invoice_to_update->update([
                'paid_in' => $invoice_to_update->paid_in + $payment->TransAmount,
                'balance' => $invoice_to_update->balance - $payment->TransAmount,
                'is_paid' => ($invoice_to_update->balance - $payment->TransAmount <= 0) ? true : false,
                'payment_method' => 'Mpesa',
            ]);
            
            $updated_invoice = Invoice::find($invoice_to_update->id);

            $notificationBody = [
                'inv' => $payment->InvoiceNumber,
                'ref' => $payment->TransID,
                'amt_total_paid' => $updated_invoice->paid_in,
                'amt_balance' => $updated_invoice->balance + $updated_invoice->penalty_fee,
                'phone' => $payment->MSISDN,
            ];
            
            $this->sendConfirmationMessage((object) $notificationBody);
        }
        
        return response()->json(['message' => 'finished']);
    }

    /**
     * ===================================================================
     * PRIVATE HELPER METHODS
     * ===================================================================
     */

    /**
     * Read CSV file
     */
    private function readCSVFile($file)
    {
        $rows = [];
        $filePath = $file->getRealPath();
        
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $rows[] = $data;
            }
            fclose($handle);
        }
        
        return $rows;
    }

    /**
     * Process manual payment
     */
    private function processManualPayment($payment, $cleanData = null)
    {
        try {
            $tenant = Tenant::where('account_number', $payment->InvoiceNumber)->first();
            
            if (!$tenant) {
                $failedSms = $this->paymentFailedSmsmFormat([
                    'mpesa_code' => $payment->TransID,
                    'acc' => $payment->InvoiceNumber,
                    'phone' => $payment->MSISDN,
                    'name' => trim(($payment->FirstName ?? '') . ' ' . ($payment->MiddleName ?? '') . ' ' . ($payment->LastName ?? '')),
                ]);
                
                // $this->sendMessage([$failedSms]);
                return false;
            }
            
            $client_invoices = Invoice::where('tenant_id', $tenant->id)
                ->where('is_paid', 0)
                ->get();
            
            $this->updateClientInvoices($client_invoices, (int) $payment->TransAmount);
            
            $current_month_rent = $client_invoices->filter(function ($item) {
                $date2 = $item['rent_month'];
                $date1 = Carbon::now()->format('M-Y');
                return $date1 == $date2;
            })->sum('rent');
            
            $balance_reached = Invoice::where('tenant_id', $tenant->id)->get()->sum('balance');
            $prepayment = $balance_reached < 0 ? abs($balance_reached) : 0;
            $balance = $balance_reached > 0 ? $balance_reached : 0;
            
            // Check if receipt already exists
            $check_receipt = Receipt::where('transaction_code', $payment->TransID)->first();
            
            if (!$check_receipt) {
                $receipt = Receipt::create([
                    'name' => trim(($payment->FirstName ?? '') . ' ' . ($payment->MiddleName ?? '') . ' ' . ($payment->LastName ?? '')),
                    'phone_number' => $payment->MSISDN,
                    'transaction_code' => $payment->TransID,
                    'payment_method' => 'M-PESA',
                    'rent_amount' => $current_month_rent,
                    'tenant_id' => $tenant->id,
                    'amount' => $payment->TransAmount,
                    'balance' => $balance,
                ]);
                
                // Send confirmation SMS
                $tenant_full_name = $tenant->full_name;
                $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
                $tenant_first_name = $arr_names[0] ?? '';
                
                $sms_to_send = $this->paymentConfirmationSmsFormat([
                    'name' => $tenant_first_name,
                    'amt_paid' => $payment->TransAmount,
                    'prepayment' => $prepayment,
                    'balance' => $balance,
                    'rent' => $current_month_rent,
                    'phone' => (int) $tenant->phone,
                    'receipt_id' => $receipt->id,
                ]);
                
                // $this->sendMessage([$sms_to_send]);
            }
            
            return true;
            
        } catch (\Exception $e) {
            Log::error('Failed to process excel import manual payment', [
                'payment_id' => $payment->id,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Register URLs with M-Pesa
     */
    private function mpesaRegisterUrls()
    {
        $confirmationURL = config('app.mpesa_confirmation_url');
        $validationURL = config('app.mpesa_validation_url');
        $url = config('app.mpesa_register_url');
        $shortCode = config('app.mpesa_short_code');

        $curlPostData = [
            'ShortCode' => $shortCode,
            'ResponseType' => 'Completed',
            'ConfirmationURL' => $confirmationURL,
            'ValidationURL' => $validationURL,
        ];
        
        return $this->mpesaRequestBody($shortCode, $url, $curlPostData);
    }

    /**
     * Simulate C2B payment
     */
    private function mpesaSimulateC2BPayment($ShortCode, $CommandID, $Amount, $Msisdn, $BillRefNumber)
    {
        $url = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate';

        $curlPostData = [
            'ShortCode' => $ShortCode,
            'CommandID' => $CommandID,
            'Amount' => $Amount,
            'Msisdn' => $Msisdn,
            'BillRefNumber' => $BillRefNumber,
        ];
        
        return $this->mpesaRequestBody($shortCode, $url, $curlPostData);
    }

    /**
     * Make M-Pesa API request
     */
    private function mpesaRequestBody($shortCode, $endPoint, $curlPostData)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $endPoint);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Authorization:Bearer ' . $this->access_token()
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curlPostData));
        
        $curl_response = curl_exec($curl);
        curl_close($curl);
        
        return $curl_response;
    }

    /**
     * Get callback data
     */
    private function getDataFromCallback()
    {
        $handler = fopen('php://input', 'r');
        $callbackJSONData = stream_get_contents($handler);
        fclose($handler);
        
        return $callbackJSONData;
    }

    /**
     * Update client invoices with payment
     */
    private function updateClientInvoices($client_invoices, $total_amt_for_month_paid)
    {
        $balance_wallet = $total_amt_for_month_paid;
        $length = count($client_invoices);
        $x = 1;

        foreach ($client_invoices as $client_invoice) {
            if ($balance_wallet > 0) {
                $paid_in = $balance_wallet >= $client_invoice->balance ? $client_invoice->balance : $balance_wallet;
                $balance = $balance_wallet >= $client_invoice->balance ? 0 : $client_invoice->balance - $balance_wallet;
                
                $client_invoice->update([
                    'paid_in' => $client_invoice->paid_in + $paid_in,
                    'balance' => $balance,
                    'is_paid' => ($balance <= 0) ? true : false,
                    'payment_method' => 'M-PESA',
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

    /**
     * Format phone number
     */
    private function formatPhoneNumber($phone)
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If starts with 0, replace with 254
        if (strlen($phone) == 10 && $phone[0] == '0') {
            $phone = '254' . substr($phone, 1);
        }
        
        // If starts with 7, add 254
        if (strlen($phone) == 9 && $phone[0] == '7') {
            $phone = '254' . $phone;
        }
        
        // If starts with 1, add 254
        if (strlen($phone) == 9 && $phone[0] == '1') {
            $phone = '254' . $phone;
        }
        
        return $phone;
    }

    /**
     * Send success response
     */
    private function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $result,
        ];

        return response()->json($response, 200);
    }

    /**
     * Send error response
     */
    private function sendError($error, $errorMessages = [], $code = 404)
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

    /**
     * Finish transaction (send response to M-Pesa)
     */
    private function finishTransaction($status = true)
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
        exit;
    }

    /**
     * Payment confirmation SMS format
     */
    private function paymentConfirmationSmsFormat($notificationBody)
    {
        $userData = (object) $notificationBody;

        $format = "Dear %s,\nYour rent payment of Ksh %d has been received.\nFor enquiries call 0797597530.";
        $message_text = sprintf($format, $userData->name, $userData->amt_paid);

        return [
            'from' => config('app.sms_client'),
            'to' => $userData->phone,
            'text' => $message_text,
        ];
    }

    /**
     * Payment failed SMS format
     */
    private function paymentFailedSmsmFormat($notificationBody)
    {
        $userData = (object) $notificationBody;
        
        $name = $userData->name ?? '';
        $nameArray = preg_split('/[\s,]+/', $name, 3);
        
        if (count($nameArray) > 1) {
            $name = $nameArray[0] . ' ' . $nameArray[1];
        } elseif (count($nameArray) === 1) {
            $name = $nameArray[0];
        } else {
            $name = 'Unknown';
        }

        $format = "Auto-Apply failed:No matching invoice was found for,\nMPESA transaction # %s\nPaid By: %s\nAccount: %s\nPhone.: %d";
        $message_text = sprintf($format, $userData->mpesa_code ?? '', $name, $userData->acc ?? '', $userData->phone ?? '');

        return [
            'from' => config('app.sms_client'),
            'to' => (int) config('app.sms_admin_phone'),
            'text' => $message_text,
        ];
    }
    
    /**
     * Send confirmation message (legacy method)
     */
    private function sendConfirmationMessage($notificationBody)
    {
        // This method can be implemented if needed
        return true;
    }
}