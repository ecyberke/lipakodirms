<?php

namespace App\Console\Commands;

use App\Traits\NotifyClient;
use Illuminate\Console\Command;

use App\House;
use App\HouseTenant;
use App\Invoice;
use App\ManualPayment;
use App\MonthlyBilling;
use App\Overpayment;
use App\Tenant;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use PDF;

class RentPaymentAppeal extends Command
{
    use NotifyClient;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:rentappeal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rent Appeal Sms sent(Sent on 28th)';

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
            //if($inv)
           
            $acc_num = $inv[0]->tenant && $inv[0]->tenant->account_number ? $inv[0]->tenant->account_number : 0;
            $tenant_phone = $inv[0]->tenant && $inv[0]->tenant->phone ? $inv[0]->tenant->phone : 0;
           
            
// if (in_array((int) $inv[0]->tenant->phone, $numbers)) {
//     echo "Got Irix";
// }
$tenant_id = $inv[0]->tenant && $inv[0]->tenant->id ? $inv[0]->tenant->id : 0;
$tenant_has_house = HouseTenant::where('tenant_id',$tenant_id )->first();
            if($inv[0]->tenant){
                $sms_object = $this->rentAppealSmsFormat([
                    
                    'tenant' => $inv[0]->tenant,
                  
                    'phone' => (int) $inv[0]->tenant->phone,
                    // 'phone' => 254714264331,
                ]);
                if($tenant_has_house){
                array_push($grouped_invoices, $sms_object);
                }
            }


        }
    //   $grouped_invoices = array_slice($grouped_invoices,0,1);
// return response()->json($grouped_invoices);
//return response()->json(count($grouped_invoices));
return response()->json($this->sendMessage($grouped_invoices));
    }
    
     private function rentAppealSmsFormat($notificationBody)
    {
        $userData = (object) $notificationBody;
        $account_number = $userData->tenant->account_number;
        $tenant_full_name = $userData->tenant->full_name;
        $arr_names = explode(' ', trim(ucfirst(strtolower($tenant_full_name))));
        $tenant_first_name = $arr_names[0]; // will print Test

        $format = "Dear %s,\nMake All your rent payments using,\nMpesa Paybill:743994\nAcc #: %s\nCASH PAYMENTS WILL NOT BE ACCEPTED";
        $message_text = sprintf($format, $tenant_first_name, $account_number);

        
        $message_text .= "\nFor enquiries 0797597530.";

        $data = [
            'from' => 'LesaAgency',
            'to' => (int) $userData->phone,
            'text' => $message_text,
        ];

        return $data;

    }
}
