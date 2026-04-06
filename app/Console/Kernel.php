<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\CheckSubscriptions::class,
        Commands\GenerateSubscriptionInvoices::class,
        Commands\InitializeInvoices::class,
        Commands\PenalizeInvoices::class,
        Commands\PayingOwners::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Generate subscription invoices on 1st of every month
        $schedule->command('subscription:generate-invoices')->monthlyOn(1, '08:00');

        // Check subscriptions daily
        $schedule->command('subscriptions:check')->daily();
        $schedule->command('sms:test');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
