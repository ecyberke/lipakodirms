<?php

namespace App\Http\Controllers;

use App\Apartment;
use App\Receipt;
use App\House;
use App\Http\Requests\CreateMonthlyBillingRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Requests\InvoiceRequest;
use App\Invoice;
use App\ManualPayment;
use App\ManagerPayment;
use App\MonthlyBilling;
use App\Overpayment;
use App\Tenant;
use App\Traits\NotifyClient;
use App\Traits\UtilTrait;
use Carbon\Carbon;
use DB;
use NumberFormatter;

use Illuminate\Http\Request;
use PDF;

class InvoicesController extends Controller
{
    use NotifyClient;
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
    public function prepare()
    {
        $apartments = Apartment::pluck('id', 'name');
        return view('invoices.prepare', compact('apartments'));
    }

    public function storeMonthlyBilling(CreateMonthlyBillingRequest $request)
    {

        if ($request->filled('bill_name')) {
            for ($i = 0; $i < count($request->bill_name); $i++) {
                $monthly_bill = new MonthlyBilling;
                $monthly_bill->billing_name = $request->bill_name[$i];
                $monthly_bill->billing_amount = $request->bill_amount[$i];
                $monthly_bill->billing_month = $request->bill_month . '-' . $request->bill_year;
                $monthly_bill->house_id = $request->house_id;

                $monthly_bill->save();
            }
            return back()->with('success', 'Monthly bills have been scheduled for invoice generation');

        } else {
            return back()->with('success', 'No Bills Were Added');

        }

    }

    public function deleteMonthlyBill(Request $request)
    {
        if ($request->ajax()) {
            MonthlyBilling::destroy($request->id);
        }

    }
    
    
public function leasepdfInvoice($id)
{
    try {
        $invoice = Invoice::where('house_id', $id)->where('type', 'rent and deposit')->latest()->first();
        
        if (!$invoice) {
            $invoice = Invoice::where('house_id', $id)->latest()->first();
        }
        
        if (!$invoice) {
            throw new \Exception('Invoice not found for house ID: ' . $id);
        }
        
        $house = $invoice->house;
        $tenant = $invoice->tenant;
        $apartment = $house->apartment ?? null;
        $landlord = $apartment->landlord ?? null;
        $rent = $house->rent ?? null;
        
        // DEBUG: Log all raw values to identify the problematic one
        \Log::info('=== LEASE PDF DEBUG START ===');
        \Log::info('Invoice ID: ' . $invoice->id);
        \Log::info('Raw monthly rent: ' . json_encode($rent->amount ?? ($house->rent->amount ?? 0)));
        \Log::info('Raw deposit paid: ' . json_encode($invoice->deposit_paid ?? 0));
        \Log::info('Raw rent paid: ' . json_encode($invoice->rent_paid ?? 0));
        \Log::info('Raw water deposit: ' . json_encode($invoice->water_deposit_paid ?? 0));
        \Log::info('Raw electricity deposit: ' . json_encode($invoice->electricity_deposit_paid ?? 0));
        \Log::info('Raw service charge: ' . json_encode($house->service_charge ?? 0));
        \Log::info('Raw other charges: ' . json_encode($invoice->other_charges_amount ?? 0));
        \Log::info('Raw total payable: ' . json_encode($invoice->total_payable ?? 0));
        
        // Get raw values
        $rawMonthlyRent = $rent->amount ?? ($house->rent->amount ?? 0);
        $rawDepositPaid = $invoice->deposit_paid ?? 0;
        $rawRentPaid = $invoice->rent_paid ?? $rawMonthlyRent;
        $rawWaterDeposit = $invoice->water_deposit_paid ?? 0;
        $rawElectricityDeposit = $invoice->electricity_deposit_paid ?? 0;
        $rawServiceCharge = $house->service_charge ?? 0;
        $rawOtherCharges = $invoice->other_charges_amount ?? 0;
        $rawTotalPayable = $invoice->total_payable ?? 0;
        
        // Convert to string to see exact characters
        \Log::info('Raw monthly rent as string: ' . $this->getRawString($rawMonthlyRent));
        \Log::info('Raw deposit paid as string: ' . $this->getRawString($rawDepositPaid));
        
        // Try to clean values with different methods to see what works
        $monthlyRentAmount = $this->debugCleanValue($rawMonthlyRent, 'monthly_rent');
        $depositPaid = $this->debugCleanValue($rawDepositPaid, 'deposit_paid');
        $rentPaid = $this->debugCleanValue($rawRentPaid, 'rent_paid');
        $waterDeposit = $this->debugCleanValue($rawWaterDeposit, 'water_deposit');
        $electricityDeposit = $this->debugCleanValue($rawElectricityDeposit, 'electricity_deposit');
        $serviceChargeValue = $this->debugCleanValue($rawServiceCharge, 'service_charge');
        $otherCharges = $this->debugCleanValue($rawOtherCharges, 'other_charges');
        $totalPayable = $this->debugCleanValue($rawTotalPayable, 'total_payable');
        
        $startDate = Carbon::parse($invoice->created_at ?? now());
        $endDate = $startDate->copy()->addMonths(24);
        
        // Use simple number to words without NumberFormatter to test
        $rentWords = $this->simpleNumberToWords($monthlyRentAmount) . ' only';
        
        $depositMonths = ($depositPaid > 0 && $monthlyRentAmount > 0) 
            ? round($depositPaid / $monthlyRentAmount, 1) 
            : 1;
        
        $data = [
            // Agreement date
            'agreementDay' => $startDate->format('d'),
            'agreementMonth' => $startDate->format('F'),
            'agreementYear' => $startDate->format('Y'),
            
            // Landlord
            'landlordName' => $this->cleanString($landlord->full_name ?? ''),
            'landlordId' => $this->cleanString($landlord->id_number ?? ''),
            'landlordPhone' => $this->cleanString($landlord->phone ?? ''),
            'landlordAddress' => $this->cleanString($landlord->email ?? ''),
            
            // Tenant
            'tenantName' => $this->cleanString($tenant->full_name ?? ''),
            'tenantId' => $this->cleanString($tenant->id_number ?? ''),
            'tenantPhone' => $this->cleanString($tenant->phone ?? ''),
            'tenantEmail' => $this->cleanString($tenant->email ?? ''),
            'additionalTenantName' => $this->cleanString($tenant->additional_tenant_name ?? ''),
            'additionalTenantId' => $this->cleanString($tenant->additional_tenant_id ?? ''),
            'additionalTenantPhone' => $this->cleanString($tenant->additional_tenant_phone ?? ''),
            
            // Property
            'unitNumber' => $this->cleanString($house->unit_number ?? ($house->name ?? '')),
            'propertyAddressFull' => $this->cleanString($apartment->address ?? ($apartment->name ?? '')),
            'propertyTypeOther' => $this->cleanString($house->property_type ?? 'Apartment'),
            
            // Tenancy dates
            'tenancyStartDay' => $startDate->format('d'),
            'tenancyStartMonth' => $startDate->format('F'),
            'tenancyStartYear' => $startDate->format('Y'),
            'tenancyEndDay' => $endDate->format('d'),
            'tenancyEndMonth' => $endDate->format('F'),
            'tenancyEndYear' => $endDate->format('Y'),
            
            // Tenant particulars
            'maritalStatus' => $this->cleanString($tenant->marital_status ?? ''),
            'childrenCount' => $this->cleanString($tenant->children_count ?? ''),
            'nationality' => $this->cleanString($tenant->nationality ?? ''),
            'occupation' => $this->cleanString($tenant->occupation ?? ''),
            'employer' => $this->cleanString($tenant->employer ?? ''),
            
            // Emergency
            'emergencyName' => $this->cleanString($tenant->emergency_name ?? ''),
            'emergencyRelation' => $this->cleanString($tenant->emergency_relation ?? ''),
            'emergencyId' => $this->cleanString($tenant->emergency_id ?? ''),
            'emergencyPhone' => $this->cleanString($tenant->emergency_phone ?? ''),
            'emergencyEmail' => $this->cleanString($tenant->emergency_email ?? ''),
            'emergencyWork' => $this->cleanString($tenant->emergency_work ?? ''),
            
            // Guarantor
            'guarantorName' => $this->cleanString($tenant->guarantor_name ?? ''),
            'guarantorId' => $this->cleanString($tenant->guarantor_id ?? ''),
            'guarantorPhone' => $this->cleanString($tenant->guarantor_phone ?? ''),
            'guarantorEmail' => $this->cleanString($tenant->guarantor_email ?? ''),
            
            // Rent and payment (simple formatting without number_format)
            'monthlyRent' => $this->simpleFormatNumber($monthlyRentAmount),
            'rentWords' => $rentWords,
            'mpesaAccount' => $this->cleanString($tenant->account_number ?? ($invoice->account_number ?? '')),
            'serviceCharge' => $this->simpleFormatNumber($serviceChargeValue),
            
            // Initial payments
            'securityDeposit' => $this->simpleFormatNumber($depositPaid),
            'advanceRent' => $this->simpleFormatNumber($rentPaid),
            'waterDeposit' => $this->simpleFormatNumber($waterDeposit),
            'electricityDeposit' => $this->simpleFormatNumber($electricityDeposit),
            'agencyFee' => $this->simpleFormatNumber($monthlyRentAmount * 0.1),
            'otherChargesDesc' => $this->cleanString($invoice->other_charges_description ?? ''),
            'otherChargesAmount' => $this->simpleFormatNumber($otherCharges),
            'totalInitialPayment' => $this->simpleFormatNumber($totalPayable),
            'depositMonths' => $depositMonths,
            
            // Signatures
            'agentSignatory' => 'Managing Director',
            'agentSignDate' => $startDate->format('d-M-Y'),
            'tenantSignName' => $this->cleanString($tenant->full_name ?? ''),
            'tenantSignDate' => $startDate->format('d-M-Y'),
            'additionalTenantSign' => $this->cleanString($tenant->additional_tenant_name ?? ''),
        ];
        
        \Log::info('=== LEASE PDF DATA PREPARED SUCCESSFULLY ===');
        \Log::info('Monthly rent cleaned: ' . $monthlyRentAmount);
        \Log::info('Monthly rent formatted: ' . $data['monthlyRent']);
        
  $html = view('tenants.lease', $data)->render();
        
        // Remove all non-ASCII characters (keep only characters 32-126)
        $html = preg_replace('/[^\x20-\x7E]/', '', $html);
        
        // Also remove HTML entities
        $html = preg_replace('/&[#a-zA-Z0-9]+;/', '', $html);
        
        // Load the cleaned HTML
        $pdf = PDF::loadHTML($html);
        $pdf->setPaper('A4', 'portrait');

return $pdf->stream('Lease_Agreement_' . $id . '.pdf');
        
        return $pdf->stream('Lease_Agreement_' . $id . '.pdf');
        
    } catch (\Exception $e) {
        \Log::error('Lease PDF Generation Error: ' . $e->getMessage());
        \Log::error($e->getTraceAsString());
        return redirect()->back()->with('error', 'Unable to generate lease agreement: ' . $e->getMessage());
    }
}

/**
 * Get raw string representation of a value for debugging
 */
private function getRawString($value)
{
    if ($value === null) {
        return 'NULL';
    }
    if (is_numeric($value)) {
        return (string) $value;
    }
    return bin2hex((string) $value) . ' (' . (string) $value . ')';
}

/**
 * Debug and clean a value, logging what was cleaned
 */
private function debugCleanValue($value, $fieldName)
{
    $original = $value;
    $originalType = gettype($value);
    
    // Remove everything except digits and decimal point
    $string = (string) $value;
    $cleaned = preg_replace('/[^0-9.]/', '', $string);
    
    $result = floatval($cleaned);
    
    \Log::info("Cleaning {$fieldName}: type={$originalType}, original={$this->getRawString($original)}, cleaned={$cleaned}, result={$result}");
    
    return $result;
}

/**
 * Clean string by removing any invalid UTF-8 characters
 */
private function cleanString($string)
{
    if (empty($string)) {
        return '';
    }
    
    // Remove any non-UTF-8 characters
    $string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
    
    // Remove control characters except newlines and tabs
    $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $string);
    
    return $string;
}

/**
 * Simple number formatting without using number_format
 */
private function simpleFormatNumber($value)
{
    $numeric = floatval($value);
    
    if ($numeric == 0) {
        return '';
    }
    
    // Convert to string and remove decimals if .00
    $number = (string) $numeric;
    if (strpos($number, '.') !== false) {
        $number = rtrim(rtrim($number, '0'), '.');
    }
    
    // Add commas manually
    $length = strlen($number);
    if ($length <= 3) {
        return $number;
    }
    
    $result = '';
    for ($i = $length - 1, $count = 0; $i >= 0; $i--, $count++) {
        if ($count > 0 && $count % 3 == 0) {
            $result = ',' . $result;
        }
        $result = $number[$i] . $result;
    }
    
    return $result;
}

/**
 * Simple number to words (fallback)
 */
private function simpleNumberToWords($number)
{
    $number = (int) $this->cleanNumericValue($number);
    
    if ($number == 0) {
        return 'zero';
    }
    
    $words = [
        1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five',
        6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten',
        11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen',
        15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'forty',
        50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
    ];
    
    if ($number < 21) {
        return $words[$number];
    }
    
    if ($number < 100) {
        $tens = floor($number / 10) * 10;
        $units = $number % 10;
        if ($units == 0) {
            return $words[$tens];
        }
        return $words[$tens] . '-' . $words[$units];
    }
    
    if ($number < 1000) {
        $hundreds = floor($number / 100);
        $remainder = $number % 100;
        if ($remainder == 0) {
            return $words[$hundreds] . ' hundred';
        }
        return $words[$hundreds] . ' hundred and ' . $this->simpleNumberToWords($remainder);
    }
    
    if ($number < 1000000) {
        $thousands = floor($number / 1000);
        $remainder = $number % 1000;
        if ($remainder == 0) {
            return $this->simpleNumberToWords($thousands) . ' thousand';
        }
        return $this->simpleNumberToWords($thousands) . ' thousand ' . $this->simpleNumberToWords($remainder);
    }
    
    return number_format($number);
}

private function cleanNumericValue($value)
{
    if ($value === null || $value === '') {
        return 0;
    }
    
    if (is_numeric($value)) {
        return (float) $value;
    }
    
    $string = (string) $value;
    $cleaned = preg_replace('/[^0-9.-]/', '', $string);
    
    if ($cleaned === '' || $cleaned === null) {
        return 0;
    }
    
    return (float) $cleaned;
}


    public function initializeInvoice($var)
    {
        //Initialize array that will be populated by all billable houses
        $billables = [];
        //Query to get house with corresponding monthly rent
        $houses = House::with('rent', 'house_tenant')->occupied()->get();
        // $test_array = [];
        //Iterate the collection,extracting each individual house with data and appending to array
        foreach ($houses as $house) {
            $current_month_invoice = Invoice::where('rent_month', $var)
                ->where('house_id', $house->id)
                ->where('apartment_id', $house->apartment_id)
                ->where('tenant_id', $house->house_tenant->tenant_id)->first();

            $is_paid_variable = $current_month_invoice && $current_month_invoice->is_paid == 1 ? 1 : 0;

            Invoice::create([
                'rent' => $house->rent->amount,
                'rent_month' => $var,
                'house_id' => $house->id,
                'apartment_id' => $house->apartment_id,
                'tenant_id' => $house->house_tenant->tenant_id,
                'is_paid' => $is_paid_variable]
            );
        }
        $monthly_bills = MonthlyBilling::selectRaw('SUM(billing_amount) as sum_bills,house_id')->where('billing_month', $var)
            ->groupBy('house_id')
            ->get();

        foreach ($monthly_bills as $bill) {
            Invoice::where('house_id', $bill->house_id)
                ->where('rent_month', $var)
                ->update(['bills' => $bill->sum_bills]);
        }

        

        return "Invoice Created.";

    }

    public function listAll()
    {
        return view('invoices.list');
    }
    
    

    public function showForSpecificMonth($month)
    {
        return view('invoices.monthly')->with('month', $month);
    }

    public function incurPenaltyCharges($var)
    {
        $defaulters = Invoice::unpaid()->where('rent_month', $var)->get();

        foreach ($defaulters as $defaulter) {
            $defaulter->update(['penalty_fee' => (($defaulter->rent + $defaulter->bills) * 0.15)]);
        }

        return " Penalty charged";
    }

    public function listUnpaid()
    {
        return view('invoices.unpaid');
    }
    public function listpaid()
    {
        return view('invoices.paid');
    }
     public function edit($id)
    {
        
        $invoice = Invoice::findOrFail($id);
       $houses = House::pluck('id', 'house_no');
        $apartments = Apartment::pluck('id', 'name');
        $tenants = Tenant::pluck('id', 'full_name');
        
        return view('invoices.edit', compact('invoice','apartments', 'tenants', 'houses'));
    }
    public function update(UpdateInvoiceRequest $request, $id)
    {
        $tenant = Invoice::find($id);
        $tenant->rent = $request->rent;
        $tenant->deposit_paid = $request->deposit_paid;
        $tenant->electricity_deposit_paid = $request->electricity_deposit_paid;
        $tenant->carryforward = $request->carryforward;
        $tenant->overpayment = $request->overpayment;
        $tenant->electricity_bill = $request->electricity_bill;
        $tenant->compound_bill = $request->compound_bill;
        $tenant->litter_bill = $request->litter_bill;
        $tenant->other_bill = $request->other_bill;
        $totalpayable = $tenant->rent + $tenant->deposit_paid + $tenant->electricity_deposit_paid + $tenant->carryforward - $tenant->overpayment + $tenant->electricity_bill + $tenant->compound_bill + $tenant->litter_bill + $tenant->other_bill;
        
        $tenant->total_payable = $totalpayable*$tenant->house->rent_const;
        $tenant->balance = ($totalpayable*$tenant->house->rent_const)-$tenant->paid_in;
        if($tenant->balance > 0){
            $tenant->is_paid = '0';
        }else{
            $tenant->is_paid = '1';
        }
        $tenant->description = $request->description;
        $tenant->save();


       

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Edited Invoice ' . $tenant->tenant->full_name,
            'more_info' => 'Tenant Account Number ' . $tenant->tenant->account_number,
            'servicerequest_id' => '0',
            'tenant_id' => $tenant->tenant_id,
            'house_id' => $tenant->house_id,
            'apartment_id' => $tenant->apartment_id,
            'landlord_id' => $tenant->apartment->landlord_id,
            'bill_id' => '0',
            'invoice_id' => $tenant->id,
            'sms_id' => '0',
            'user_id' => '0',
        ]);

     return back()->with('success', 'Invoice has been edited');

    }

    public function payInvoice(Request $request)
    {
        $invoice = Invoice::find($id);

        $bills = MonthlyBilling::where('billing_month', $invoice->rent_month)->where('house_id', $invoice->house_id)->get();

        $overpayment = 0;

        $temp_overpayment = Overpayment::where('tenant_id', $invoice->tenant_id)->value('amount');

        if ($temp_overpayment) {
            $overpayment = $temp_overpayment;
        }

        return view('invoices.pay', compact(['invoice', 'bills', 'overpayment']));
    }
    public function payInvoiceNow(Request $request)
    {   
        $attributes = $request->validate([
            'invoice_type' => 'required',
            'tenant_id' => 'required',
            'payment_type' => 'required',
            'reference' => 'required',
            'amount' => 'required',
            'payment_date' => 'required',
        ]);
        $tenant = Tenant::where('id', $attributes['tenant_id'])->first();
        $pymt = ManagerPayment::where('TransID', $attributes['reference'])->first();

        if ($pymt) {
            return back()->with('error', 'Payment with transaction code ' . $attributes['reference'] . ' has already been added');
        }
        if ($attributes['invoice_type'] === 'agency') {
            $inv = Invoice::where('id', $attributes['tenant_id'])->first();
            $tenant = Tenant::where('id', $attributes['tenant_id'])->first();
            if (!$tenant) {
                return back()->with('error', 'User not found');
            }
            if ($inv) {
                $payment = ManagerPayment::create([
                    'TransactionType' => $attributes['payment_type'],
                    'MSISDN' => $tenant->phone,
                    'TransID' => $attributes['reference'],
                    'TransAmount' => $attributes['amount'],
                    'InvoiceNumber' => $tenant->account_number,
                    'full_name' => $tenant->full_name,
                    'payment_date' => $attributes['payment_date'],
                    'Manager' => auth()->user()->username,
                    'tenant_id' => $tenant->id,
                    'invoice_type' => 'agency',
                ]);
               
                $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Agency Invoice Manual Payment made by office Manager',
                    'more_info' => 'Invoice Type: Agency Invoice ',
                    'servicerequest_id' => '0',
                    'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    
                ]);
            }

            return back()->with('success', 'Payment added successfully awaiting approval');
        }
        $tenant = Tenant::where('id', $attributes['tenant_id'])->first();

        if (!$tenant) {
            return back()->with('error', 'User not found');
        }
     
        $payment = ManagerPayment::create([
            'TransactionType' => $attributes['payment_type'],
            'MSISDN' => $tenant->phone,
            'TransID' => $attributes['reference'],
            'TransAmount' => $attributes['amount'],
            'InvoiceNumber' => $tenant->account_number,
            'full_name' => $tenant->full_name,
            'Manager' => auth()->user()->username,
            'payment_date' => $attributes['payment_date'],
            'tenant_id' => $tenant->id,
            'invoice_type' => 'property',
        ]);
        $payment_month = date('M-Y', strtotime($attributes['payment_date']));
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Property Invoice Manual Payment',
            'more_info' => 'Payment made by Manager'. auth()->user()->username . 'for' . $tenant->full_name,
            'servicerequest_id' => '0',
                    'tenant_id' => $tenant->id,
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
        ]);
        $balance_reached = Invoice::where('tenant_id', $tenant->id)->get()->sum('balance');
            $prepayment = $balance_reached < 0 ? abs($balance_reached) : 0;
            $balance = $balance_reached > 0 ? $balance_reached : 0;
        $receipt = Receipt::create([
            'name'=>$tenant->full_name,
            'phone_number'=>$tenant->phone,
            'transaction_code'=>$attributes['reference'],
            'payment_method'=>$attributes['payment_type'],
            'rent_amount'=>$payment_month,
            'tenant_id'=>$tenant->id,
            'amount'=>$attributes['amount'],
            'balance'=>$balance_reached,
        ]);
        $tenant_full_name = $tenant->full_name;
            $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
            $tenant_first_name = $arr_names[0];
        $sms_to_send = [];
        array_push($sms_to_send, $this->paymentConfirmationSmsFormat([
                'name' => $tenant_first_name,
                'amt_paid' => $attributes['amount'],
                'prepayment' => $prepayment,
                'balance' => $balance,
                'rent' => $payment_month,
                'phone' => (int) $tenant->phone,
                // 'receipt_id' => $receipt->id,
            ]));
            // return response()->json($sms_to_send, $sms_to_send_admin);
           
        $this->sendMessage($sms_to_send);
            
        // return response()->json([$client_invoices, (int)$payment->TransAmount]);
        
        // $sms_to_send = [];
        // $sms_to_send_admin = [];
        // $tenant_full_name = $tenant->full_name;
        // $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
        // $tenant_first_name = $arr_names[0];
        // $tenant_last_name_n_first = $tenant_first_name === end($arr_names) ? $tenant_first_name : $tenant_first_name . ' ' . end($arr_names);

        // array_push($sms_to_send, $this->paymentConfirmationSmsFormat([
        //     'name' => $tenant_first_name,
        //     'amt_paid' => $payment->TransAmount,
        //     'prepayment' => $prepayment,
        //     'balance' => $balance,
        //     'rent' => $current_month_rent,
        //     'phone' => (int) $tenant->id,
        //     // 'phone' => (int) '254728519621',
        // ]));
        // array_push($sms_to_send_admin, $this->paymentConfirmationSmsFormatAdmin([
        //     'name' => $tenant_last_name_n_first,
        //     'amt_paid' => $payment->TransAmount,
        //     'prepayment' => $prepayment,
        //     'balance' => $balance,
        //     'transaction_code' => $payment->TransID,
        //     'account_number' => $tenant->account_number,
        //     'rent' => $current_month_rent,
        //     'phone' => (int) $tenant->phone,
        // ]));
        // $this->createLog([
        //     'username' => auth()->user()->username,
        //     'operation' => 'Sms on invoice payment sent',
        //     'more_info' => 'Tenant Account Number ' . $tenant->account_number . ' Tenant Phone' . $tenant->phone,
        // ]);

        // return response()->json([$sms_to_send, $sms_to_send_admin]);
        //$this->sendMessage($sms_to_send);
        //$this->sendMessage($sms_to_send_admin);
        return back()->with('success', 'Payment added successfully awaiting approval');
     
    }
    public function payInvoiceNowupdate(UpdateInvoiceRequest $request, $id)
   {
       $approve_pymt = ManagerPayment::find($id);
      
        $tenant = Tenant::where('id', $approve_pymt->tenant_id)->first();
        $pymt = ManualPayment::where('TransID', $approve_pymt->TransID)->first();
        

        if ($pymt) {
            return back()->with('error', 'Payment with transaction code ' . $approve_pymt->TransID . ' has already been added');
        }
        if ($approve_pymt->invoice_type === 'agency') {
            $inv = Invoice::where('id', $approve_pymt->tenant_id)->first();
            $tenant = Tenant::where('id', $approve_pymt->tenant_id)->first();
            
            if (!$tenant) {
                return back()->with('error', 'Agency Invoice payment not found');
            }
            if ($inv) {
                $payment = ManualPayment::create([
                    'TransactionType' => $approve_pymt->TransactionType,
                    'MSISDN' => $approve_pymt->MSISDN,
                    'TransID' => $approve_pymt->TransID,
                    'TransAmount' => $approve_pymt->TransAmount,
                    'InvoiceNumber' => $approve_pymt->InvoiceNumber,
                    'payment_date' => $approve_pymt->payment_date,
                    'full_name' => $approve_pymt->full_name,
                ]);
                if($request->approval == 1){
                $is_paid = $inv->balance - $approve_pymt->TransAmount > 0 ? 0 : 1;
                $balance = $inv->balance - $approve_pymt->TransAmount;
                $inv->update([
                    'is_paid' => $is_paid,
                    'balance' => $balance,
                    'paid_in' => $approve_pymt->TransAmount,
                ]);
                $approve_pymt->update([
                    'status' => $request->approval,
                   
                ]);
                $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Agency Invoice Manual Payment Approval',
                    'more_info' => 'Invoice Type: Agency Invoice ',
                    'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]);   }
                elseif($request->approval == 2){
                   $this->createLog([
                    'username' => auth()->user()->username,
                    'operation' => 'Agency Invoice Manual Payment Rejected ',
                    'more_info' => 'Invoice Type: Agency Invoice ',
                    'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
                ]); 
                }
               
            }

            return back()->with('success', 'Payment updated successfully');
        }
        $tenant = Tenant::where('id', $approve_pymt->tenant_id)->first();
        
        if (!$tenant) {
            return back()->with('error', 'Tenant Invoice Payment not found');
        }
        // return response()->json($request->all());
        $client_invoices = Invoice::where('tenant_id', $approve_pymt->tenant_id)->get();
        $current_month_rent = $client_invoices->filter(function ($item) {
            // $arrs[] = $item['rent_month'];
            $date2 = $item['rent_month'];
            $date1 = Carbon::now()->format('M-Y');
            return $date1 == $date2;
        })->sum('rent');
        $approve_pymt->update([
                    'status' => $request->approval,
                   
                ]);
          $status = $request->approval;
          if ($status == 1){
        $payment = ManualPayment::create([
                    'TransactionType' => $approve_pymt->TransactionType,
                    'MSISDN' => $approve_pymt->MSISDN,
                    'TransID' => $approve_pymt->TransID,
                    'TransAmount' => $approve_pymt->TransAmount,
                    'InvoiceNumber' => $approve_pymt->InvoiceNumber,
                    'payment_date' => $approve_pymt->payment_date,
                    'full_name' => $approve_pymt->full_name,
                    
                ]);
         
       
         $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Tenant Invoice Manual Payment Authorization',
            'more_info' => 'Tenant Account Number ' . $tenant->account_number . ' Tenant Phone' . $tenant->phone,
            'tenant_id' => $tenant->id,
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
        ]);
        // return response()->json([$client_invoices, (int)$payment->TransAmount]);
        $balance_reached = $this->updateClientInvoices($client_invoices, (int) $payment->TransAmount);

        $balance_reached = Invoice::where('tenant_id', $approve_pymt->tenant_id)->get()->sum('balance');
        $prepayment = $balance_reached < 0 ? abs($balance_reached) : 0;
        $balance = $balance_reached > 0 ? $balance_reached : 0;

        $sms_to_send = [];
        $sms_to_send_admin = [];
        $tenant_full_name = $tenant->full_name;
        $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
        $tenant_first_name = $arr_names[0];
        $tenant_last_name_n_first = $tenant_first_name === end($arr_names) ? $tenant_first_name : $tenant_first_name . ' ' . end($arr_names);

        array_push($sms_to_send, $this->paymentConfirmationSmsFormat([
            'name' => $tenant_first_name,
            'amt_paid' => $payment->TransAmount,
            'prepayment' => $prepayment,
            'balance' => $balance,
            'rent' => $current_month_rent,
            'phone' => (int) $tenant->phone,
            // 'phone' => (int) '254728519621',
        ]));
        array_push($sms_to_send_admin, $this->paymentConfirmationSmsFormatAdmin([
            'name' => $tenant_last_name_n_first,
            'amt_paid' => $payment->TransAmount,
            'prepayment' => $prepayment,
            'balance' => $balance,
            'transaction_code' => $payment->TransID,
            'account_number' => $tenant->account_number,
            'rent' => $current_month_rent,
            'phone' => (int) $tenant->phone,
        ]));
          }
       

        // return response()->json([$sms_to_send, $sms_to_send_admin]);
        // $this->sendMessage($sms_to_send);
        // $this->sendMessage($sms_to_send_admin);
        
                    
         return redirect()->route('manualinvoice.payments')
            ->with('success', 'Payment authorization has been recorded');     
      
    }
        

     public function payInvoiceNowadmin(Request $request)
    {   
        $attributes = $request->validate([
            'invoice_type' => 'required',
            'tenant_id' => 'required',
            'payment_type' => 'required',
            'reference' => 'required',
            'amount' => 'required',
            'payment_date' => 'required',
        ]);
        $tenant = Tenant::where('id', $attributes['tenant_id'])->first();
        $pymt = ManualPayment::where('TransID', $attributes['reference'])->first();
       

        if ($pymt) {
            return back()->with('error', 'Payment with transaction code ' . $attributes['reference'] . ' has already been added');
        }
        if ($attributes['invoice_type'] === 'agency') {
            $inv = Invoice::where('id', $attributes['tenant_id'])->first();
            $tenant = Tenant::where('id', $attributes['tenant_id'])->first();
            
            if (!$tenant) {
                return back()->with('error', 'User not found');
            }
            if ($inv) {
                $payment = ManualPayment::create([
                    'TransactionType' => $attributes['payment_type'],
                    'MSISDN' => $tenant->phone,
                    'TransID' => $attributes['reference'],
                    'TransAmount' => $attributes['amount'],
                    'InvoiceNumber' => $tenant->account_number,
                    'full_name' => $tenant->full_name,
                    'payment_date' => $attributes['payment_date'],
                ]);
                $is_paid = $inv->balance - $attributes['amount'] > 0 ? 0 : 1;
                $balance = $inv->balance - $attributes['amount'];
                $inv->update([
                    'is_paid' => $is_paid,
                    'balance' => $balance,
                    'paid_in' => $attributes['amount'],
                ]);
               
                
                $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Invoice Manual Payment by Administrator:' . auth()->user()->username,
            'more_info' => 'Invoice Type: Agency Invoice ',
            'tenant_id' => '0',
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
        ]);
            }

            return back()->with('success', 'Payment added successfully');
        }
        $tenant = Tenant::where('id', $attributes['tenant_id'])->first();
       
        if (!$tenant) {
            return back()->with('error', 'User not found');
        }
        // return response()->json($request->all());
        $client_invoices = Invoice::where('tenant_id', $attributes['tenant_id'])->get();
        $current_month_rent = $client_invoices->filter(function ($item) {
            // $arrs[] = $item['rent_month'];
            $date2 = $item['rent_month'];
            $date1 = Carbon::now()->format('M-Y');
            return $date1 == $date2;
        })->sum('rent');
        $payment = ManualPayment::create([
            'TransactionType' => $attributes['payment_type'],
            'MSISDN' => $tenant->phone,
            'TransID' => $attributes['reference'],
            'TransAmount' => $attributes['amount'],
            'InvoiceNumber' => $tenant->account_number,
            'full_name' => $tenant->full_name,
            'payment_date' => $attributes['payment_date'],
        ]);
       
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Invoice Manual Payment by Administrator:' . auth()->user()->username,
            'more_info' => 'Tenant Account Number ' . $tenant->account_number . ' Tenant Name' . $tenant->full_name . ' Tenant Phone' . $tenant->phone,
            'tenant_id' => $tenant->id,
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => '0',
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
        ]);
        // return response()->json([$client_invoices, (int)$payment->TransAmount]);
        $balance_reached = $this->updateClientInvoices($client_invoices, (int) $payment->TransAmount);

        $balance_reached = Invoice::where('tenant_id', $attributes['tenant_id'])->get()->sum('balance');
        $prepayment = $balance_reached < 0 ? abs($balance_reached) : 0;
        $balance = $balance_reached > 0 ? $balance_reached : 0;

        $sms_to_send = [];
        $sms_to_send_admin = [];
        $tenant_full_name = $tenant->full_name;
        $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
        $tenant_first_name = $arr_names[0];
        $tenant_last_name_n_first = $tenant_first_name === end($arr_names) ? $tenant_first_name : $tenant_first_name . ' ' . end($arr_names);
        $payment_month = date('M-Y', strtotime($attributes['payment_date']));
        
        $receipt = Receipt::create([
            'name'=>$tenant->full_name,
            'phone_number'=>$tenant->phone,
            'transaction_code'=>$attributes['reference'],
            'payment_method'=>$attributes['payment_type'],
            'rent_amount'=>$payment_month,
            'tenant_id'=>$tenant->id,
            'amount'=>$attributes['amount'],
            'balance'=>$balance_reached,
        ]);
        
        array_push($sms_to_send, $this->paymentConfirmationSmsFormat([
            'name' => $tenant_first_name,
            'amt_paid' => $payment->TransAmount,
            'prepayment' => $prepayment,
            'balance' => $balance,
            'receipt_id'=>$receipt->id,
            'rent' => $current_month_rent,
            'phone' => (int) $tenant->phone,
            // 'phone' => (int) '254728519621',
        ]));
        array_push($sms_to_send_admin, $this->paymentConfirmationSmsFormatAdmin([
            'name' => $tenant_last_name_n_first,
            'amt_paid' => $payment->TransAmount,
            'prepayment' => $prepayment,
            'balance' => $balance,
            'transaction_code' => $payment->TransID,
            'account_number' => $tenant->account_number,
            'rent' => $current_month_rent,
            'phone' => (int) $tenant->phone,
        ]));
       

        // return response()->json([$sms_to_send, $sms_to_send_admin]);
        // $this->sendMessage($sms_to_send);
        // $this->sendMessage($sms_to_send_admin);
        return back()->with('success', 'Payment added successfully to the tenant invoices');

 
        
    }

    public function reconcileInvoicePayment(InvoiceRequest $request)
    {

        // DB::beginTransaction();
        // try {
        $invoice = Invoice::findOrFail($request->invoice_id);
        //grab current invoice balance
        $balance = $invoice->balance;

        $invoice->update([
            'paid_in' => $request->paid_in + $invoice->paid_in + $invoice->deposit_paid,
            'balance' => $balance - $request->paid_in,
            'is_paid' => ($balance - $request->paid_in <= 0) ? true : false,
            'payment_method' => $request->payment_method,
        ]);
        // $invoice->save();

        // if ($request->current_overpayment > 0) {
        //     $overpayment = Overpayment::where('tenant_id', $request->tenant_id)->update([
        //         'amount' => 0,
        //     ]);
        // }

        // if ($request->filled('new_overpayment')) {
        //     $overpayment_2 = Overpayment::updateOrCreate(
        //         ['tenant_id' => $request->tenant_id],
        //         ['amount' => $request->new_overpayment]
        //     );

        // }
        $updated_invoice = Invoice::findOrFail($request->invoice_id);
        $notificationBody = [
            'amt_paid_in' => $request->paid_in,
            'amt_balance' => $updated_invoice->balance + $invoice->penalty_fee,
            'amt_total_paid' => $updated_invoice->paid_in,
            'tenant_info' => $updated_invoice->tenant,
            'date_paid' => $updated_invoice->updated_at,
        ];

        DB::commit();
        $this->sendMessage((object) $notificationBody);
        // $this->sendEmail((object) $notificationBody);
        return redirect()->route('invoice.all')
            ->with('success', 'Invoice for ' . $invoice->tenant->full_name . ' has been successfully paid');

        // } catch (\Exception $th) {
        //     DB::rollback();
        //     return back()->with('error', 'Error with database');

        //  }

    }

    // public function showOverpayments()
    // {
    //     return view('invoices.overpayments');
    // }

    public function showInvoice($id, $action = null)
    {
        $invoice = Invoice::with('tenant', 'house')->findOrFail($id);

        // $invoice_payments = ManualPayment::where('MSISDN', $invoice->tenant->phone)->get();

        $overpayment = 0;
        $overpayments = Overpayment::where('tenant_id', $invoice->tenant_id)->get();

        if (count($overpayments) > 0) {
            $overpayment = Overpayment::where('tenant_id', $invoice->tenant_id)->first()->value('amount');
        }

        $billings = MonthlyBilling::where('billing_month', $invoice->rent_month)
            ->where('house_id', $invoice->house_id)
            ->get();

        // if (!$action) {
        //     return view('invoices.invoiceprint', compact('invoice', 'billings', 'overpayment'));
        // }

        switch ($action) {
            case 'print':
                return view('invoices.invoiceprint', compact('invoice', 'billings', 'overpayment'));
            case 'message':
                $current_invoice = Invoice::with('tenant')->where('id',$id)->first();
                
            $smses = [];
            $sms_object = $this->invoiceMessageFormat([
                // 'phone' => $inv[0]->tenant->phone,
                'tenant' => $current_invoice->tenant,
                'to_pay' =>  $current_invoice->balance,
                'phone' => (int) $current_invoice->tenant->phone,
            ]);
        array_push($smses, $sms_object);
        $this->sendMessage($smses);
                return back()->with('success', 'Message sent successfully'); 
            case 'pdf':
                // return view('invoices.invoicepf', compact('invoice', 'billings', 'overpayment'));

                $pdf = PDF::loadView('invoices.invoicepf', compact('invoice', 'billings', 'overpayment'));
                // if ($pdf == 'false'){
                return $pdf->stream('Invoice #' . $id . '.pdf');
        // }
                // else {
                // return back()->with('error', 'Total number of Invoices have exceeded pdf loadview limit of 7000 rows, please use print option');
                // }
            default:
                return view('invoices.invoice', compact('invoice', 'billings', 'overpayment'));
                break;
        }

    }

    public function pdfInvoice($id)
    {
        $invoice = Invoice::with('tenant', 'house')->findOrFail($id);

        $overpayment = 0;
        $overpayments = Overpayment::where('tenant_id', $invoice->tenant_id)->get();

        if (count($overpayments) > 0) {
            $overpayment = Overpayment::where('tenant_id', $invoice->tenant_id)->first()->value('amount');
        }

        $billings = MonthlyBilling::where('billing_month', $invoice->rent_month)
            ->where('house_id', $invoice->house_id)
            ->get();

        // $pdf = PDF::loadView('invoices.invoicepdf', compact('invoice', 'billings', 'overpayment'));

        // return $pdf->stream('Invoice #' . $id . '.pdf');

        return view('invoices.invoicepdf', compact('invoice', 'billings', 'overpayment'));

    }

    public function delete($id)
    {
        $invoice = Invoice::findOrFail($id);
         $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Deleted Invoice number' . $invoice->id,
            'more_info' => 'Invoice deleted by' . auth()->user()->username ,
            'tenant_id' => $invoice->tenant_id,
                    'house_id' => '0',
                    'apartment_id' => '0',
                    'landlord_id' => '0',
                    'bill_id' => '0',
                    'invoice_id' => $invoice->id,
                    'sms_id' => '0',
                    'user_id' => '0',
                    'servicerequest_id' => '0',
        ]);
        $invoice->delete();

        return back()->with('success', 'Invoice has been deleted');
    }

     private function paymentConfirmationSmsFormat($notificationBody)
    {
        $userData = (object) $notificationBody;

        $tenant_first_name = $userData->name;
        $amt_paid = $userData->amt_paid;

        $format = "Dear %s,\nYour rent payment of Ksh %d has been received.";
        $message_text = sprintf($format, $tenant_first_name, $amt_paid);

        // $rent_section = "\nRent: Ksh %d";
        // $message_text .= sprintf($rent_section, $userData->rent);
        // $prepayment = $userData->prepayment > 0 ? true : false;

        // if ($arrears) {
        //     $arrears_section = "\nArrears: Ksh %d";
        //     $message_text .= sprintf($arrears_section, $userData->arrears);
        // }
        // if ($prepayment) {
        //     $prepayment_section = "\nPrepayment: Ksh %d";
        //     $message_text .= sprintf($prepayment_section, $userData->prepayment);
        // }
        // $to_pay_section = "\nBalance: Ksh %d";
        // $message_text .= sprintf($to_pay_section, $userData->balance);
        
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

        $tenant_name = $userData->name;
        $amt_paid = $userData->amt_paid;
        $arr_prep_string = $userData->prepayment > 0 ? $userData->prepayment : '';
        $acc_num = $userData->account_number;
        $transaction_code = $userData->transaction_code;

        $format = "%s has made a payment.\nTenant# %s\nPaid: %d\nTxn# %s\n%s";
        $message_text = sprintf($format, $tenant_name, $acc_num, $amt_paid, $transaction_code, $arr_prep_string);

        $data = [
            'from' => config('app.sms_client'),
            'to' => (int) config('app.sms_admin_phone'),
            //'to' => (int) config('app.sms_test_phone'),
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

    private function dateFormater($date_format, $date, $converted_format)
    {
        return \DateTime::createFromFormat($date_format, $date)->format($converted_format);
    }

    private function invoiceMessageFormat($notificationBody)
    {
        $userData = (object) $notificationBody;
        $account_number = $userData->tenant->account_number;

        $amount = $userData->to_pay;

        $tenant_full_name = $userData->tenant->full_name;
        $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
        $tenant_first_name = $arr_names[0]; // will print Test

        $format = "Dear %s,\nYour rent has been updated.\nPlease pay Ksh %d to:\nPaybill: 743994\nAccount: %s";
        $message_text = sprintf($format, $tenant_first_name, $amount, $account_number);

        $message_text .= "\nFor enquiries call 0796106612.";

        $data = [
            'from' => 'LesaAgency',
            'to' => (int) $userData->phone,
            'text' => $message_text,
        ];

        return $data;
        return back()->with('success', 'Message sent successfully'); 

    }
}
