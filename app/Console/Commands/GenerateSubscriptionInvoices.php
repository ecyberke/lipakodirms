<?php
namespace App\Console\Commands;

use App\Organization;
use App\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Carbon\Carbon;

class GenerateSubscriptionInvoices extends Command
{
    protected $signature = 'subscription:generate-invoices {--org= : Generate for specific org ID}';
    protected $description = 'Generate monthly subscription invoices for all active organizations';

    public function handle()
    {
        $now    = Carbon::now();
        $month  = $now->format('Y-m');
        $query  = Organization::where('status', 'active')->with('subscription');

        if ($this->option('org')) {
            $query->where('id', $this->option('org'));
        }

        $organizations = $query->get();
        $generated = 0;
        $skipped   = 0;

        foreach ($organizations as $org) {
            $sub = $org->subscription;
            if (!$sub || $sub->status !== 'active') {
                $this->warn("Skipping {$org->name} — no active subscription");
                $skipped++;
                continue;
            }

            // Check if invoice already generated this month
            $exists = DB::table('subscription_invoices')
                ->where('organization_id', $org->id)
                ->where('type', 'subscription')
                ->whereRaw("DATE_FORMAT(created_at, '%Y-%m') = ?", [$month])
                ->exists();

            if ($exists) {
                $this->warn("Invoice already exists for {$org->name} this month — skipping");
                $skipped++;
                continue;
            }

            // Generate invoice number
            $count  = DB::table('subscription_invoices')->count() + 1;
            $invNo  = 'LKI-' . str_pad($count, 5, '0', STR_PAD_LEFT);

            DB::table('subscription_invoices')->insert([
                'organization_id'  => $org->id,
                'subscription_id'  => $sub->id,
                'invoice_number'   => $invNo,
                'amount'           => $sub->amount,
                'type'             => 'subscription',
                'description'      => 'Monthly subscription — ' . $now->format('F Y'),
                'status'           => 'unpaid',
                'due_date'         => $now->copy()->addDays(7)->toDateString(),
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);

            // Send SMS notification
            $this->sendInvoiceSms($org, $invNo, $sub->amount);

            $this->info("Invoice {$invNo} generated for {$org->name} — KES " . number_format($sub->amount));
            $generated++;
        }

        $this->info("Done. Generated: {$generated}, Skipped: {$skipped}");
    }

    private function sendInvoiceSms($org, $invoiceNumber, $amount)
    {
        if (!$org->phone) return;

        $token    = $org->sms_api_token ?? config('app.sms_api_token');
        $senderId = $org->sms_sender_id ?? config('app.sms_sender_id', 'LIPAKODI');
        $message  = "Dear {$org->name}, your Lipakodi subscription invoice {$invoiceNumber} of KES " .
                    number_format($amount) . " has been generated. Due: " .
                    Carbon::now()->addDays(7)->format('d M Y') . ". Pay via Paybill to avoid suspension.";

        try {
            $client = new Client(['timeout' => 30, 'verify' => false]);
            $client->post('https://sasa.ecyber.co.ke/api/v3/sms/send', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                ],
                'json' => [
                    'recipient' => $org->phone,
                    'sender_id' => $senderId,
                    'type'      => 'plain',
                    'message'   => $message,
                ],
            ]);
        } catch (\Exception $e) {
            $this->error("SMS failed for {$org->name}: " . $e->getMessage());
        }
    }
}
