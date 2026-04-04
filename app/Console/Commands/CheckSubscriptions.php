<?php
namespace App\Console\Commands;

use App\Organization;
use App\Subscription;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckSubscriptions extends Command
{
    protected $signature = 'subscriptions:check';
    protected $description = 'Check subscription statuses and send renewal reminders';

    public function handle()
    {
        $now = Carbon::now();

        // Send reminders for subscriptions expiring in 14, 7, 3, 1 days
        $reminderDays = [14, 7, 3, 1];
        foreach ($reminderDays as $days) {
            $expiring = Subscription::where('status', 'active')
                ->whereDate('ends_at', $now->copy()->addDays($days)->toDateString())
                ->with('organization')
                ->get();

            foreach ($expiring as $sub) {
                $this->sendRenewalReminder($sub, $days);
                $this->info("Reminder sent to {$sub->organization->name} - expires in {$days} days");
            }
        }

        // Move expired subscriptions to grace period
        $expired = Subscription::where('status', 'active')
            ->where('ends_at', '<', $now)
            ->with('organization')
            ->get();

        foreach ($expired as $sub) {
            $graceDays = $sub->getGraceDays();
            $graceEnd = $now->copy()->addDays($graceDays);
            
            $sub->update([
                'status' => 'grace',
                'grace_ends_at' => $graceEnd,
            ]);
            $sub->organization->update(['status' => 'suspended']);
            
            $this->sendGraceNotice($sub, $graceDays);
            $this->info("Grace period started for {$sub->organization->name} - {$graceDays} days");
        }

        // Hard suspend orgs past grace period
        $pastGrace = Subscription::where('status', 'grace')
            ->where('grace_ends_at', '<', $now)
            ->with('organization')
            ->get();

        foreach ($pastGrace as $sub) {
            $sub->update(['status' => 'suspended']);
            $sub->organization->update(['status' => 'suspended']);
            $this->info("Hard suspended: {$sub->organization->name}");
        }

        $this->info('Subscription check complete');
    }

    private function sendRenewalReminder($sub, $days)
    {
        $org = $sub->organization;
        $message = "Dear {$org->name}, your Lipakodi subscription expires in {$days} day(s) on " .
                   $sub->ends_at->format('d M Y') . ". Amount due: KES " .
                   number_format($sub->amount) . ". Pay via Paybill {$org->mpesa_paybill} or contact support.";
        
        // Send via SMS if configured
        if ($org->sms_username && $org->sms_password && $org->phone) {
            $this->sendSms($org->phone, $message, $org->sms_username, $org->sms_password);
        }

        // Send via email if configured
        if ($org->email) {
            // Email would be sent here
        }
    }

    private function sendGraceNotice($sub, $graceDays)
    {
        $org = $sub->organization;
        $message = "NOTICE: Your Lipakodi subscription has expired. You have a {$graceDays}-day grace period until " .
                   $sub->grace_ends_at->format('d M Y') . ". Pay KES " . number_format($sub->amount) .
                   " to restore access. Contact support immediately.";

        if ($org->sms_username && $org->sms_password && $org->phone) {
            $this->sendSms($org->phone, $message, $org->sms_username, $org->sms_password);
        }
    }

    private function sendSms($phone, $message, $username, $password)
    {
        try {
            $url = 'https://sms.enet.co.ke/api/send';
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
                'mobile' => $phone,
                'message' => $message,
                'sender_id' => 'LIPAKODI',
            ]));
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERPWD, "{$username}:{$password}");
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_exec($curl);
            curl_close($curl);
        } catch (\Exception $e) {
            $this->error("SMS failed: " . $e->getMessage());
        }
    }
}
