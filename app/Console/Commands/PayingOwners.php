<?php

namespace App\Console\Commands;

use App\House;
use App\Bills;
use App\Invoice;
use App\PayOwners;
use App\ServiceRequests;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use App\Traits\NotifyClient;

class PayingOwners extends Command
{
    use NotifyClient;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'owner:pay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate payments for all owners in the current month.';

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
        $bill_month = Carbon::now()->format('M-Y');
        //Empty all invoices for the current month that may have been generated
        // $initialized_invoices = Invoice::where('rent_month', $var)->delete();

        //Initialize array that will be populated by all billable houses
        $billables = [];
        //Query to get house with corresponding monthly rent
        $invoices = Invoice::where('paid_in','>',0)->where('rent_month', $var)->where('rent','>',0)->get();
        //Iterate the collection,extracting each individual house with data and appending to array
        $test = 0;
        $array_of_messages = [];
        $data = [];
        foreach ($invoices as $invoice) {
            if($invoice->house_id && $invoice->apartment->landlord){
    
             
            $current_month_pay = PayOwners::where('rent_month', $var)
                ->where ('mgt', $invoice->house->apartment->management_fee_percentage)
                ->where ('total_owned', '>', 0)
                ->where ('balance', '>', 0)
                ->where('house_id', $invoice->house->id)
                ->where('type', 'Rent Collection' )
                ->where('apartment_id', $invoice->house->apartment_id)
                ->where('landlord_id', $invoice->house->apartment->landlord->id)->first();

            if (!$current_month_pay) {
                $current_month_pay =  PayOwners::create([
                    'rent' => $invoice->rent,
                    'compound' => $invoice->compound_bill,
                    'security' => $invoice->security,
                    'water' => $invoice->water_bill,
                    'electricity' => $invoice->electricity_bill,
                    'litter' => $invoice->litter_bill,
                    'type' => 'Rent Collection',
                    'mgt' => $invoice->house->apartment->management_fee_percentage,
                    'rent_month' => $var,
                    'house_id' => $invoice->house->id,
                    'apartment_id' => $invoice->house->apartment_id,
                    'landlord_id' => $invoice->house->apartment->landlord_id,
                    'house_name' => $invoice->house->house_no,
                    'apartment_name' => $invoice->house->apartment->name,
                    'landlord_name' => $invoice->house->apartment->landlord->full_name]
                );
            }

          
          
            
           
            
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
        $bills = PayOwners::with('apartment')->where('mgt', null)->where('rent_month', $bill_month)
            ->get()->groupBy('apartment_id');

        $apartment_summed = [];
        foreach($bills as $bll){
                    array_push($apartment_summed,[
                        'id'=> $bll[0]->apartment_id,
                        'total'=>$bll->sum('total_owned')
                    ]);
        }
        foreach ($apartment_summed as $apartment) {
            $owner = PayOwners::where('apartment_id', $apartment['id'])
                ->where('rent_month', $var)->where('mgt', '>', 0)->first();
            if($owner){
                $owner->update([
                    'bills'=>$apartment['total']
                ]);
            }
           
        }

        //Query to compute carry overs from previous month
        // $this->generateCarryForwards($var);

        //Query to compute overpayments from previous month
        $this->generateOverPayments($var);
        
        //Autofill Total Payable
         $this->setTotalPayable($var);

         //Autofill Commission
         $this->setCommission($var);
         
        //Auto calculate the remaining balance to be paid
        $this->setBalance($var);
        
        //Bulk mark invoices as paid,update Overpayment
         $this->finalizePayment($var);

       
        
        $this->info('Rent Collection for month  ' . $var . ' has been generated');

    }
    
    // $latest_array = [];
    // foreach($array_of_messages as $msg){
    //     array_push($latest_array,$msg);
    // }
    //   $this->sendMessage($latest_array);
    }

    

    public function generateCarryForwards($month)
    {
        $previous_month = Carbon::now()->subMonth(1)->format('M-Y');

        $carryovers = PayOwners::where('rent_month', $previous_month)->where('mgt', '>', 0)->where('type','==', 'Rent Collection' )->where('balance', '>', 0)->get();

        foreach ($carryovers as $carryover) {
            PayOwners::where('house_id', $carryover->house_id)
                ->where('landlord_id', $carryover->landlord_id)
                ->where('rent_month', $month)
                ->update(['carryforward' => $carryover->balance]);

        }

    }
    public function generateOverPayments($month)
    {
        $previous_month = Carbon::now()->subMonth(1)->format('M-Y');

        $overpayments = PayOwners::where('rent_month', $previous_month)->where('mgt', '>', 0)->where('balance', '<', 0)->get();

        foreach ($overpayments as $overpayment) {
            PayOwners::where('house_id', $overpayment->house_id)
                ->where('landlord_id', $overpayment->landlord_id)
                ->where('rent_month', $month)
                ->update(['overpayment' => $overpayment->balance]);

        }

    }

    public function setTotalPayable($month)
    {
        $payowners = PayOwners::where('rent_month', $month)->where('mgt', '>', 0)->get();

        foreach ($payowners as $payowner) {
            PayOwners::where('house_id', $payowner->house_id)
                ->where('landlord_id', $payowner->landlord_id)               
                ->where('rent_month', $month)               
                ->update(['total_owned' => ($payowner->rent  + $payowner->carryforward + $payowner->overpayment)]);

        }

    }
    public function setCommission($month)
    {
        $payowners = PayOwners::where('rent_month', $month)->where('mgt', '>', 0)->get();

        foreach ($payowners as $payowner) {
            PayOwners::where('house_id', $payowner->house_id)
                ->where('landlord_id', $payowner->landlord_id)               
                ->where('rent_month', $month)
                ->update(['commission' => ($payowner->rent * ($payowner->mgt)/100)]);
               

        }

    }

    public function setBalance($month)
    {
        $payowners = PayOwners::where('rent_month', $month)->where('mgt', '>', 0)->get();

        foreach ($payowners as $payowner) {
            PayOwners::where('house_id', $payowner->house_id)
                ->where('landlord_id', $payowner->landlord_id)
                ->where('rent_month', $month)
                ->update(['balance' => $payowner->total_owned - $payowner->paid_in - ($payowner->rent * ($payowner->mgt)/100) - $payowner->bills]);

        }

    }

    public function finalizePayment($month)
    {
        $payowners = PayOwners::where('rent_month', $month)->where('mgt', '>', 0)->where('balance', '<=', 0)->get();

        foreach ($payowners as $payowner) {
            PayOwners::where('house_id', $payowner->house_id)
                ->where('landlord_id', $payowner->landlord_id)
                ->where('rent_month', $month)
                ->update(['pay_status' => 1,
                    'transaction_type' => 'Previous Month OverPayment']);

        }

    }

   
}
