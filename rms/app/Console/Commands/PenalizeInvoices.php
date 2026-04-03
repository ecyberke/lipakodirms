<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Invoice;
use Carbon\Carbon;

class PenalizeInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:penalize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Penalize all unpaid invoices with 10% of the total rent due';

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
        // $var=Carbon::now()->subMonth(1)->format('M-Y');
        $var = Carbon::now()->format('M-Y');
;
        $defaulters = Invoice::unpaid()->where('rent_month', $var)->get();

        foreach ($defaulters as $defaulter) {
            $defaulter->update(['penalty_fee' => (($defaulter->balance) * 0.10)]);
        }

        $this->info('Unpaid invoices penalized');

    }
}
