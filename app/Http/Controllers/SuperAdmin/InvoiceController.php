<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Organization;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceController extends SuperAdminController
{
    public function list()
    {
        $invoices = DB::table('subscription_invoices')
            ->join('organizations', 'subscription_invoices.organization_id', '=', 'organizations.id')
            ->select('subscription_invoices.*', 'organizations.name as org_name', 'organizations.slug as org_slug')
            ->latest('subscription_invoices.created_at')
            ->paginate(25);
        $organizations = Organization::where('status', 'active')->get();
        return view('super_admin.invoices.list', compact('invoices', 'organizations'));
    }

    public function create()
    {
        $organizations = Organization::where('status', 'active')->get();
        return view('super_admin.invoices.create', compact('organizations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'type'            => 'required|in:subscription,sms_credits',
            'amount'          => 'required|numeric|min:1',
            'due_date'        => 'required|date',
            'description'     => 'nullable|string|max:255',
        ]);

        // Generate invoice number
        $count = DB::table('subscription_invoices')->count() + 1;
        $invoiceNumber = 'LKI-' . str_pad($count, 5, '0', STR_PAD_LEFT);

        DB::table('subscription_invoices')->insert([
            'organization_id'  => $request->organization_id,
            'subscription_id'  => $request->subscription_id ?? null,
            'invoice_number'   => $invoiceNumber,
            'amount'           => $request->amount,
            'type'             => $request->type,
            'description'      => $request->description,
            'due_date'         => $request->due_date,
            'status'           => 'unpaid',
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        return redirect()->route('super.invoices.list')
            ->with('success', "Invoice {$invoiceNumber} created successfully.");
    }

    public function pay(Request $request)
    {
        $unpaidInvoices = DB::table('subscription_invoices')
            ->join('organizations', 'subscription_invoices.organization_id', '=', 'organizations.id')
            ->select('subscription_invoices.*', 'organizations.name as org_name')
            ->where('subscription_invoices.status', 'unpaid')
            ->latest('subscription_invoices.created_at')
            ->get();
        $organizations = Organization::where('status', 'active')->get();
        return view('super_admin.invoices.pay', compact('unpaidInvoices', 'organizations'));
    }

    public function recordPayment(Request $request)
    {
        $request->validate([
            'invoice_id'        => 'required|exists:subscription_invoices,id',
            'payment_method'    => 'required',
            'payment_reference' => 'required',
        ]);

        DB::table('subscription_invoices')
            ->where('id', $request->invoice_id)
            ->update([
                'status'            => 'paid',
                'payment_method'    => $request->payment_method,
                'payment_reference' => $request->payment_reference,
                'paid_at'           => now(),
                'updated_at'        => now(),
            ]);

        return redirect()->route('super.invoices.pay')
            ->with('success', 'Payment recorded successfully.');
    }

    public function payments()
    {
        $payments = DB::table('subscription_invoices')
            ->join('organizations', 'subscription_invoices.organization_id', '=', 'organizations.id')
            ->select('subscription_invoices.*', 'organizations.name as org_name', 'organizations.slug as org_slug')
            ->where('subscription_invoices.status', 'paid')
            ->latest('subscription_invoices.paid_at')
            ->paginate(25);
        return view('super_admin.invoices.payments', compact('payments'));
    }

    public function addSmsCredits(Request $request)
    {
        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'amount'          => 'required|numeric|min:1',
            'payment_method'  => 'required',
            'payment_reference' => 'required',
        ]);

        $count = DB::table('subscription_invoices')->count() + 1;
        $invoiceNumber = 'SMS-' . str_pad($count, 5, '0', STR_PAD_LEFT);

        DB::table('subscription_invoices')->insert([
            'organization_id'   => $request->organization_id,
            'invoice_number'    => $invoiceNumber,
            'amount'            => $request->amount,
            'type'              => 'sms_credits',
            'description'       => 'SMS Credits Purchase',
            'status'            => 'paid',
            'payment_method'    => $request->payment_method,
            'payment_reference' => $request->payment_reference,
            'paid_at'           => now(),
            'due_date'          => now(),
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return redirect()->route('super.invoices.payments')
            ->with('success', 'SMS credits recorded successfully.');
    }

    public function stkPush(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'phone'  => 'required|string|min:10|max:13',
            'amount' => 'required|numeric|min:1',
        ]);

        $invoice = DB::table('subscription_invoices')->where('id', $id)->first();
        if (!$invoice) abort(404);

        // Use MpesaController logic
        $mpesa = new \App\Http\Controllers\MpesaController();

        // Format phone
        $phone  = $request->phone;
        $phone  = preg_replace('/^0/', '254', $phone);
        $phone  = preg_replace('/^\+/', '', $phone);
        $amount = round($request->amount);

        // Generate access token
        $accessToken = $mpesa->access_token();
        if (!$accessToken) {
            return redirect()->route('super.invoices.show', $id)
                ->with('error', 'Failed to generate M-Pesa access token. Check M-Pesa configuration.');
        }

        $timestamp = \Carbon\Carbon::now()->format('YmdHms');
        $shortcode = config('services.mpesa.shortcode', '174379');
        $passkey   = config('services.mpesa.passkey', '');
        $password  = base64_encode($shortcode . $passkey . $timestamp);

        $stkData = [
            'BusinessShortCode' => $shortcode,
            'Password'          => $password,
            'Timestamp'         => $timestamp,
            'TransactionType'   => 'CustomerPayBillOnline',
            'Amount'            => $amount,
            'PartyA'            => $phone,
            'PartyB'            => $shortcode,
            'PhoneNumber'       => $phone,
            'CallBackURL'       => route('stk.callback'),
            'AccountReference'  => $invoice->invoice_number,
            'TransactionDesc'   => 'Payment for ' . $invoice->invoice_number,
        ];

        $curl = curl_init('https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken,
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($stkData));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response     = json_decode(curl_exec($curl));
        $http_code    = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if (isset($response->ResponseCode) && $response->ResponseCode == '0') {
            return redirect()->route('super.invoices.show', $id)
                ->with('success', 'STK Push sent successfully. Ask the client to enter their M-Pesa PIN.');
        }

        $error = $response->errorMessage ?? $response->ResultDesc ?? 'STK Push failed. Try again.';
        return redirect()->route('super.invoices.show', $id)->with('error', $error);
    }

    public function show($id)
    {
        $invoice = DB::table('subscription_invoices')
            ->join('organizations', 'subscription_invoices.organization_id', '=', 'organizations.id')
            ->select('subscription_invoices.*', 'organizations.name as org_name',
                     'organizations.slug as org_slug', 'organizations.phone as org_phone',
                     'organizations.email as org_email')
            ->where('subscription_invoices.id', $id)
            ->first();
        if (!$invoice) abort(404);
        return view('super_admin.invoices.show', compact('invoice'));
    }

    public function edit($id)
    {
        $invoice = DB::table('subscription_invoices')->where('id', $id)->first();
        if (!$invoice) abort(404);
        $organizations = Organization::where('status', 'active')->get();
        return view('super_admin.invoices.edit', compact('invoice', 'organizations'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'amount'   => 'required|numeric|min:1',
            'due_date' => 'required|date',
            'status'   => 'required|in:unpaid,paid,partial,cancelled',
        ]);
        DB::table('subscription_invoices')->where('id', $id)->update([
            'amount'      => $request->amount,
            'due_date'    => $request->due_date,
            'status'      => $request->status,
            'description' => $request->description,
            'updated_at'  => now(),
        ]);
        return redirect()->route('super.invoices.list')
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('subscription_invoices')->where('id', $id)->delete();
        return redirect()->route('super.invoices.list')
            ->with('success', 'Invoice deleted successfully.');
    }


    public function downloadPdf($id)
    {
        $invoice = DB::table('subscription_invoices')
            ->join('organizations', 'subscription_invoices.organization_id', '=', 'organizations.id')
            ->select('subscription_invoices.*', 'organizations.name as org_name',
                     'organizations.slug as org_slug', 'organizations.phone as org_phone',
                     'organizations.email as org_email')
            ->where('subscription_invoices.id', $id)
            ->first();
        if (!$invoice) abort(404);
        $pdf = Pdf::loadView('super_admin.invoices.pdf', compact('invoice'));
        return $pdf->stream('Invoice-' . $invoice->invoice_number . '.pdf');
    }

    public function printInvoice($id)
    {
        $invoice = DB::table('subscription_invoices')
            ->join('organizations', 'subscription_invoices.organization_id', '=', 'organizations.id')
            ->select('subscription_invoices.*', 'organizations.name as org_name',
                     'organizations.slug as org_slug', 'organizations.phone as org_phone',
                     'organizations.email as org_email')
            ->where('subscription_invoices.id', $id)
            ->first();
        if (!$invoice) abort(404);
        return view('super_admin.invoices.print', compact('invoice'));
    }

    public function sendMessage($id)
    {
        $invoice = DB::table('subscription_invoices')
            ->join('organizations', 'subscription_invoices.organization_id', '=', 'organizations.id')
            ->select('subscription_invoices.*', 'organizations.name as org_name',
                     'organizations.phone as org_phone')
            ->where('subscription_invoices.id', $id)
            ->first();
        if (!$invoice) abort(404);

        if (!$invoice->org_phone) {
            return redirect()->route('super.invoices.show', $id)
                ->with('error', 'No phone number found for this organization.');
        }

        $type    = $invoice->type === 'sms_credits' ? 'SMS Credits' : 'Subscription';
        $message = "Dear {$invoice->org_name}, your Lipakodi {$type} invoice {$invoice->invoice_number} " .
                   "of KES " . number_format($invoice->amount) . " is due on " .
                   \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') .
                   ". Pay via M-Pesa Paybill " . config('services.mpesa.shortcode', '') .
                   " Acc: {$invoice->invoice_number}. Contact support for assistance.";

        $token    = config('app.sms_api_token');
        $senderId = config('app.sms_sender_id', 'LIPAKODI');

        try {
            $client = new \GuzzleHttp\Client(['timeout' => 30, 'verify' => false]);
            $client->post('https://sasa.ecyber.co.ke/api/v3/sms/send', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                ],
                'json' => [
                    'recipient' => $invoice->org_phone,
                    'sender_id' => $senderId,
                    'type'      => 'plain',
                    'message'   => $message,
                ],
            ]);
            return redirect()->route('super.invoices.show', $id)
                ->with('success', 'Message sent successfully to ' . $invoice->org_phone);
        } catch (\Exception $e) {
            return redirect()->route('super.invoices.show', $id)
                ->with('error', 'Failed to send message: ' . $e->getMessage());
        }
    }

}