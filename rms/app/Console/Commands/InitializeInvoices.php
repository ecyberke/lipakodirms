<?php

namespace App\Console\Commands;

use App\House;
use App\Invoice;
use App\MonthlyBilling;
use App\Overpaid;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use App\Traits\NotifyClient;

class InitializeInvoices extends Command
{
    use NotifyClient;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:initialize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate invoices for all tenants in the current month.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $var = Carbon::now()->format('M-Y');

        //Empty all invoices for the current month that may have been generated
        // $initialized_invoices = Invoice::where('rent_month', $var)->delete();

        //Initialize array that will be populated by all billable houses
        $billables = [];
        //Query to get house with corresponding monthly rent
        $houses = House::with('rent', 'house_tenant')->occupied()->get();
        //Iterate the collection,extracting each individual house with data and appending to array
        $test = 0;
        $array_of_messages = [];
        $data = [];
        foreach ($houses as $house) {
            if($house ->apartment->active == 1  ){
            if($house->house_tenant && $house->house_tenant->tenant){
               
                 if($house->rent_period == 1){
            $current_month_invoice = Invoice::where('rent_month', $var)
                ->where('house_id', $house->id)
                ->where('apartment_id', $house->apartment_id)
                ->where('tenant_id', $house->house_tenant->tenant->id)->first();

            if (!$current_month_invoice) {
                $current_month_invoice =  Invoice::create([
                    'rent' => $house->rent->amount,
                    'electricity_bill' => $house->rent->electricity_bill,
                    'water_bill' => $house->rent->water_bill,
                    'litter_bill' => $house->rent->litter_bill,
                    'compound_bill' => $house->rent->compound_bill,
                    'security' => $house->rent->security,
                    'other_bill' => $house->rent->others,
                    'type' => 'Monthly Rent',
                    'rent_month' => $var,
                    'rent_period'=> $house->rent_const,
                    'house_id' => $house->id,
                    'apartment_id' => $house->apartment_id,
                    'tenant_id' => $house->house_tenant->tenant_id,
                    'house_name' => $house->house_no,
                    'apartment_name' => $house ->apartment->name,
                    'tenant_name' => $house->house_tenant->tenant->full_name]
                );
            }
            
            if($house->rent_period == 1 && $house->rent_const > 1 ){
                    House::where('id', $house->id)->update(['rent_period' => $house->rent_const]);
                      }
          
                 }
                      elseif($house->rent_period > 1 && $house->rent_const > 1 ){
                    House::where('id', $house->id)->update(['rent_period' => ($house->rent_period - 1)]);   
                      }

        
                 

            //$current_month_invoice = Invoice::findorfail($current_month_invoice->balance);
            // $notificationBody = [
            //     'tenant_info' => $current_month_invoice->tenant->full_name,
            //     'invoice_id' => $current_month_invoice->id,
            //     'phone' => $current_month_invoice->tenant->id,
            //     'amount' => $current_month_invoice->total_payable
            // ];
            //$this->sendMessage((object) $notificationBody);
           // $this->sendEmail((object) $notificationBody);
        //   $userData = (object) $notificationBody;
        //   $name = $userData->tenant_info;
        //     $invoice = $userData->invoice_id;
    
        //     $number = $invoice;
        //     $length = 4;
        //     $invoice = 'LA'.substr(str_repeat(0, $length).$number, - $length);
        //     $amount = $userData->amount;
            
            
        //     $myvalue = $name;
        //     $arr = explode(' ',trim(ucfirst(strtolower($myvalue))));
        //     $name = $arr[0]; 
            
            //$format = "Dear %s, There was a system error affecting your rent amount notification. We are working to resolve the issue. Please pay your expected rent amount using the details below. \nPaybill number: 743994 \nAccount number: %s \nThank you \nFor enquiries call 0796106612."; 
    
            // $format = "Dear %s,\nYour October rent is due on or before 5th Oct, 2020.Pay now via Lipa na Mpesa:\nPaybill: 743994\nAccount: %s\nAmount: %d\nFor enquiries call 0796106612.";
            
            // $message_text = sprintf($format,$name,$invoice,$amount);
    
            // $data = [
            //     'from' => 'LesaAgency',
            //     'to' => $userData->phone,
            //     'text' => $message_text,
            // ];
            
        }
        // if(count($data) > 0){
        //     array_push($array_of_messages, $data);
        // }
   
      

        // $format = "Dear %s,\nYour October rent is due on or before 5th Oct, 2020.Pay now via Lipa na Mpesa:\nPaybill: 743994\nAccount: %s\nFor enquiries call 0796106612.";
        

        //Bulk insert the billables to the invoice table
        // DB::table('invoices')->insert($billables);

        //Clear array memory
        // unset($billables);

        //Query to compute dynamic monthly bills for any unit,for a given month
        $monthly_bills = MonthlyBilling::selectRaw('SUM(billing_amount) as sum_bills,house_id')
            ->where('billing_month', $var)
            ->groupBy('house_id')
            ->get();

        foreach ($monthly_bills as $bill) {
            Invoice::where('house_id', $bill->house_id)
                ->where('rent_month', $var)
                ->update(['bills' => $bill->sum_bills]);
        }

        //Query to compute carry overs from previous month
        // $this->generateCarryForwards($var);

        //Query to compute overpayments from previous month
        $this->generateOverPayments($var);
        $this->updatePreviousBalance($var);
        // $this->generateOtherBill($var);
        
        
        
        // $this->generateElectricityBill($var);
        
        // $this->generateCompoundBill($var);
        
        // $this->generateLitterBill($var);
        
        //Autofill Total Payable
         $this->setTotalPayable($var);
         
        //Auto calculate the remaining balance to be paid
        $this->setBalance($var);
        
        //Bulk mark invoices as paid,update Overpayment
         $this->finalizePayment($var);

       
        
        $this->info('Invoices for month  ' . $var . ' has been generated');

    }
        }
    
    // $latest_array = [];
    // foreach($array_of_messages as $msg){
    //     array_push($latest_array,$msg);
    // }
    //   $this->sendMessage($latest_array);
    }

    

    // public function generateElectricityBill($month)
    // {
    //     $previous_month = Carbon::now()->subMonth(1)->format('M-Y');

    //     $electricity = Invoice::where('rent_month', $previous_month)->where('electricity_bill', '>', 0)->get();

    //     foreach ($electricity as $carryover) {
    //         Invoice::where('house_id', $carryover->house_id)
    //             ->where('tenant_id', $carryover->tenant_id)
    //             ->where('rent_month', $month)
    //             ->update(['electricity_bill' => $carryover->electricity_bill]);

    //     }

    // }
    // public function generateCompoundBill($month)
    // {
    //     $previous_month = Carbon::now()->subMonth(1)->format('M-Y');

    //     $compounds = Invoice::where('rent_month', $previous_month)->where('compound_bill', '>', 0)->get();

    //     foreach ($compounds as $compound) {
    //         Invoice::where('house_id', $compound->house_id)
    //             ->where('tenant_id', $compound->tenant_id)
    //             ->where('rent_month', $month)
    //             ->update(['compound_bill' => $compound->compound_bill]);

    //     }

    // }
    
    // public function generateLitterBill($month)
    // {
    //     $previous_month = Carbon::now()->subMonth(1)->format('M-Y');

    //     $litters = Invoice::where('rent_month', $previous_month)->where('litter_bill', '>', 0)->get();

    //     foreach ($litters as $litter) {
    //         Invoice::where('house_id', $litter->house_id)
    //             ->where('tenant_id', $litter->tenant_id)
    //             ->where('rent_month', $month)
    //             ->update(['litter_bill' => $litter->litter_bill]);

    //     }

    // }
    // public function generateOtherBill($month)
    // {
    //     $previous_month = Carbon::now()->subMonth(1)->format('M-Y');

    //     $others = Invoice::where('rent_month', $previous_month)->where('other_bill', '>', 0)->get();

    //     foreach ($others as $other) {
    //         Invoice::where('house_id', $other->house_id)
    //             ->where('tenant_id', $other->tenant_id)
    //             ->where('rent_month', $month)
    //             ->update(['other_bill' => $other->other_bill]);

    //     }

    // }

    public function generateOverPayments($month)
    {
        $previous_month = Carbon::now()->subMonth(1)->format('M-Y');

        $overpayments = Invoice::where('rent_month', $previous_month)->where('balance', '<', 0)->get();

        foreach ($overpayments as $overpayment) {
            Invoice::where('house_id', $overpayment->house_id)
                ->where('tenant_id', $overpayment->tenant_id)
                ->where('rent_month', $month)
                ->update(['paid_in' => $overpayment->balance*-1]);

        }

    }
    public function updatePreviousBalance($month)
    {
        $previous_month = Carbon::now()->subMonth(1)->format('M-Y');

        $balance = Invoice::where('rent_month', $previous_month)->where('balance', '<', 0)->get();

        foreach ($balance as $overpayment) {
            Invoice::where('house_id', $overpayment->house_id)
                ->where('rent_month', $previous_month)
                ->where('tenant_id', $overpayment->tenant_id)
                ->update(['balance' => ($overpayment->balance - $overpayment->balance)]);

        }

    }
    

    public function setTotalPayable($month)
    {
        $invoices = Invoice::where('rent_month', $month)->where('house_id', '!=', null)->get();

        foreach ($invoices as $invoice) {
           
            Invoice::where('house_id', $invoice->house_id)
                ->where('tenant_id', $invoice->tenant_id)
                ->where('rent_month', $month)
                ->update(['total_payable' => (($invoice->rent  + $invoice->carryforward + $invoice->electricity_bill + $invoice->water_bill + $invoice->compound_bill + $invoice->litter_bill + $invoice->security + $invoice->other_bill + $invoice->deposit_paid)*$invoice->house->rent_const)]);

        }

    }

    public function setBalance($month)
    {
        $invoices = Invoice::where('rent_month', $month)->get();

        foreach ($invoices as $invoice) {
            Invoice::where('house_id', $invoice->house_id)
                ->where('tenant_id', $invoice->tenant_id)
                ->where('rent_month', $month)
                ->update(['balance' => ($invoice->total_payable - $invoice->paid_in)]);

        }

    }

    public function finalizePayment($month)
    {
        $invoices = Invoice::where('rent_month', $month)->where('balance', '<=', 0)->get();

        foreach ($invoices as $invoice) {
            Invoice::where('house_id', $invoice->house_id)
                ->where('tenant_id', $invoice->tenant_id)
                ->where('rent_month', $month)
                ->update(['is_paid' => 1,
                    'payment_method' => 'Reconciled']);

        }

    }

   
}
