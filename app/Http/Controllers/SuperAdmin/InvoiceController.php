<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Organization;
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
        return view('super_admin.invoices.pay', compact('unpaidInvoices'));
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
}
