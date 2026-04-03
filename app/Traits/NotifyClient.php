<?php
namespace App\Traits;

use App\Mail\OnClientPayment;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
trait NotifyClient
{
    use UtilTrait;
    public function sendEmail($userData)
    {
        //sending email
        $format = '%s/api/viewpdf/%d';
        $userData->invoice_id = sprintf($format, config('app.url'), $userData->invoice_id);

        \Mail::to($userData->tenant_info->email)->send(
            new OnClientPayment($userData)
        );

        return true;
    }

    public function sendMessage($array_of_messages)
    {
        $sms_job_object = ['messages' => $array_of_messages];

        $this->smsData([
            // 'type' => auth()->user()->username,
            'message_body' => $array_of_messages[0]['text'],
            'message_count' => count($array_of_messages),
        ]);

        $json_sms_job_object = json_encode($sms_job_object);

        //return  $array_of_messages;
        $client = new Client();
        $credentials = base64_encode(config('app.sms_username') . ':' . config('app.sms_password'));
        $response = $client->request('POST', 'https://sms.enet.co.ke/sms/1/text/multi', [
            'headers' => [
                'Authorization' => 'Basic ' . $credentials,
            ],
            'body' => $json_sms_job_object,
        ]);
        Storage::put('smsresponse' . time() . '.json', $response->getBody());
        return json_decode($response->getBody());
    }
    public function sendTestMessage($array_of_messages)
    {
        $sms_job_object = ['messages' => $array_of_messages];

        $this->smsData([
            // 'type' => auth()->user()->username,
            'message_body' => $array_of_messages[0]['text'],
            'message_count' => count($array_of_messages),
        ]);

        $json_sms_job_object = json_encode($sms_job_object);

        //return  $array_of_messages;
        $client = new Client();
        $credentials = base64_encode(config('app.sms_test_username') . ':' . config('app.sms_test_password'));
        $response = $client->request('POST', 'https://sms.enet.co.ke/sms/1/text/multi', [
            'headers' => [
                'Authorization' => 'Basic ' . $credentials,
            ],
            'body' => $json_sms_job_object,
        ]);
        Storage::put('smsresponse_test' . time() . '.json', $response->getBody());
        return json_decode($response->getBody());
    }
    public function sendConfirmationMessage($userData)
    {

        $format = "Dear %s,\nYour rent payment of Ksh %d has been received.\nFor enquiries call 0796106612.";

        $message_text = sprintf($format,
            $userData->inv,
            $userData->amt_paid);

        $array_of_messages = [];
        $data = [
            'from' => config('app.sms_client'),
            'to' => $userData->phone,
            'text' => $message_text,
        ];
        array_push($array_of_messages, $data);
        $sms_job_object = ['messages' => $array_of_messages];
        $json_sms_job_object = json_encode($sms_job_object);

        $client = new Client();
        $credentials = base64_encode(config('app.sms_username') . ':' . config('app.sms_password'));
        $response = $client->request('POST', 'https://sms.enet.co.ke/sms/1/text/multi', [
            'headers' => [
                'Authorization' => 'Basic ' . $credentials,
            ],
            'body' => $json_sms_job_object,
        ]);
        Storage::put('smsresponseconfirmation' . time() . '.json', $response->getBody());
        return json_decode($response->getBody());
    }
    public function sendConfirmationMessageAdmin($userData)
    {

        $format = "%s of %d, %d has paid Ksh %d.";

        $message_text = sprintf($format,
            $userData->inv,
            $userData->house_name,
            $userData->house_number,
            $userData->amount);

        $array_of_messages = [];
        $data = [
            'from' => config('app.sms_client'),
            'to' => config('app.sms_admin_phone'),
            'text' => $message_text,
        ];
        array_push($array_of_messages, $data);
        $sms_job_object = ['messages' => $array_of_messages];
        $json_sms_job_object = json_encode($sms_job_object);

        $client = new Client();
        $credentials = base64_encode(config('app.sms_username') . ':' . config('app.sms_password'));
        $response = $client->request('POST', 'https://sms.enet.co.ke/sms/1/text/multi', [
            'headers' => [
                'Authorization' => 'Basic ' . $credentials,
            ],
            'body' => $json_sms_job_object,
        ]);
        Storage::put('smsresponseconfirmation' . time() . '.json', $response->getBody());
        return json_decode($response->getBody());
    }
}
