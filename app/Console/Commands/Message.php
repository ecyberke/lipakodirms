<?php

namespace App\Console\Commands;

use App\Traits\NotifyClient;
use Illuminate\Console\Command;

class Message extends Command
{
    use NotifyClient;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test sms sent';

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
        $grouped_invoices = [];
        $data = [
            'from' => 'LesaAgency',
             'to' => 254714264331,
            'text' => 'Testing cron, it works very well :-)',
        ];
        array_push($grouped_invoices, $data);
        return $this->sendMessage($grouped_invoices);
    }
}
