<?php

namespace App\Console\Commands;

use App\Traits\NotifyClient;
use Illuminate\Console\Command;

use App\House;
use App\Invoice;
use App\ManualPayment;
use App\MonthlyBilling;
use App\Overpayment;
use App\Tenant;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PDF;

class RentOverdueMessage extends Command
{
    use NotifyClient;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:rentoverdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rent Over due Sms sent(Sent after 5th of every month on 6th and 11th)';

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
                //   if($inv[0]->house->apartment->active === 1 ){
                $sms_object = $this->rentDueSmsFormat([
                    // 'phone' => (int)'254714264331',
                    'tenant' => $inv[0]->tenant,
                    'to_pay' =>   $topay,
                    'month_bills' => $bills,
                    'rent_amount' => $rent_of_current_month,
                    'arreas' => $arreas,
                    'prepayment' => $prepayment,
                    'phone' => (int) $inv[0]->tenant->phone,
                ]);
                array_push($grouped_invoices, $sms_object);
                //   }
            }


        }
// $grouped_invoices = array_slice($grouped_invoices,0,1);
// return response()->json($grouped_invoices);
//return response()->json(count($grouped_invoices));
return response()->json($this->sendMessage($grouped_invoices));
    }
    
    

//  $message_text = "Dear %s, due to a slight technical issue, our system sent out several wrong rent balances. We are working to correct this and send out the correct balances. Our sincere apologies for any inconvenience caused.
// \nFor enquiries, contact 0796106612.";
private function rentDueSmsFormat($notificationBody)
    {
        $userData = (object) $notificationBody;
        $account_number = $userData->tenant->account_number;

        $amount = $userData->rent_amount;
        $topay = $userData->to_pay;

        $tenant_full_name = $userData->tenant->full_name;
        $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
        if($userData->tenant->person != null){
        $tenant_first_name = $userData->tenant->full_name;
        }
        else{
        $tenant_first_name = $arr_names[0]; // will print Test
        }

        $format = "Dear %s\nYour rent payment is overdue. Pay via Mpesa\nPaybill: 743994\nAccount: %s";
        $message_text = sprintf($format, $tenant_first_name, $account_number);

        $to_pay_section = "\nPay: %d";
        $message_text .= sprintf($to_pay_section, abs($topay));
        
        $message_text .= "\nFor enquiries 0797597530";
        // $data = [
 //$message_text = sprintf($message_text);
        $data = [
            'from' => 'LesaAgency',
            'to' => (int) $userData->phone,
            'text' => $message_text,
        ];

        return $data;

    }
}