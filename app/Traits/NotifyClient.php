<?php
namespace App\Traits;

use App\Mail\OnClientPayment;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

trait NotifyClient
{
    use UtilTrait;

    /**
     * Core SMS sender using Talksasa/Ecyber gateway
     */
    private function sendSMS(string $recipient, string $message, string $senderId = null): array
    {
        $org = config('app.organization');

        // Use org-specific credentials if available, else fall back to app config
        $apiToken = $org?->sms_api_token ?? config('app.sms_api_token');
        $senderId = $senderId ?? $org?->sms_sender_id ?? config('app.sms_sender_id', 'LIPAKODI');

        try {
            $client = new Client(['timeout' => 30, 'verify' => false]);
            $response = $client->post('https://sasa.ecyber.co.ke/api/v3/sms/send', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                ],
                'json' => [
                    'recipient' => $recipient,
                    'sender_id' => $senderId,
                    'type'      => 'plain',
                    'message'   => $message,
                ],
            ]);

            $result = json_decode($response->getBody(), true);
            Storage::put('sms_log_' . time() . '.json', json_encode($result));
            return $result;
        } catch (\Exception $e) {
            Storage::put('sms_error_' . time() . '.json', json_encode([
                'error' => $e->getMessage(),
                'recipient' => $recipient,
                'message' => $message,
            ]));
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Send email notification
     */
    public function sendEmail($userData)
    {
        $format = '%s/api/viewpdf/%d';
        $userData->invoice_id = sprintf($format, config('app.url'), $userData->invoice_id);
        \Mail::to($userData->tenant_info->email)->send(new OnClientPayment($userData));
        return true;
    }

    /**
     * Send message to multiple recipients
     * Compatible with existing call signature: array of ['to' => phone, 'text' => message]
     */
    public function sendMessage($array_of_messages)
    {
        $this->smsData([
            'message_body'  => $array_of_messages[0]['text'] ?? '',
            'message_count' => count($array_of_messages),
        ]);

        $results = [];
        foreach ($array_of_messages as $msg) {
            $recipient = $msg['to'] ?? '';
            $message   = $msg['text'] ?? '';
            if ($recipient && $message) {
                $results[] = $this->sendSMS($recipient, $message, $msg['from'] ?? null);
            }
        }
        return $results;
    }

    /**
     * Send test message
     */
    public function sendTestMessage($array_of_messages)
    {
        return $this->sendMessage($array_of_messages);
    }

    /**
     * Send payment confirmation to tenant
     */
    public function sendConfirmationMessage($userData)
    {
        $org = config('app.organization');
        $currency = $org?->currency ?? 'KES';

        $message = sprintf(
            "Dear %s,\nYour rent payment of %s %s has been received.\nThank you.",
            $userData->inv,
            $currency,
            number_format($userData->amt_paid)
        );

        return $this->sendSMS($userData->phone, $message);
    }

    /**
     * Send payment notification to admin
     */
    public function sendConfirmationMessageAdmin($userData)
    {
        $org = config('app.organization');
        $adminPhone = $org?->phone ?? config('app.sms_admin_phone');
        $currency   = $org?->currency ?? 'KES';

        $message = sprintf(
            "%s has paid %s %s for House %s.",
            $userData->inv,
            $currency,
            number_format($userData->amount),
            $userData->house_number ?? ''
        );

        return $this->sendSMS($adminPhone, $message);
    }

    /**
     * Send a simple SMS to a single number - new helper for direct use
     */
    public function sendSimpleSMS(string $phone, string $message): array
    {
        return $this->sendSMS($phone, $message);
    }

    /**
     * Send SMS to multiple phones at once (comma-separated via Talksasa)
     */
    public function sendBulkSMS(array $phones, string $message): array
    {
        $recipient = implode(',', $phones);
        return $this->sendSMS($recipient, $message);
    }
}
