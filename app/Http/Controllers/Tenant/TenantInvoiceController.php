<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\Tenant;
use App\Overpayment;
use App\MonthlyBilling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:tenant');
    }

    public function show($id)
    {
        $tenantUser = Auth::guard('tenant')->user();
        $org = config('app.organization');
        $orgId = config('app.org_id', 1);

        $tenant = Tenant::where('account_number', $tenantUser->account_number)
            ->where('org_id', $orgId)->first();

        // Only allow tenant to view their own invoices
        $invoice = Invoice::with('tenant', 'house')
            ->where('id', $id)
            ->where('tenant_id', $tenant->id ?? 0)
            ->firstOrFail();

        $overpayment = 0;
        $overpayments = Overpayment::where('tenant_id', $invoice->tenant_id)->get();
        if (count($overpayments) > 0) {
            $overpayment = Overpayment::where('tenant_id', $invoice->tenant_id)->first()->value('amount');
        }

        $billings = MonthlyBilling::where('billing_month', $invoice->rent_month)
            ->where('house_id', $invoice->house_id)
            ->get();

        return view('tenant.invoice_show', compact('invoice', 'tenant', 'org', 'overpayment', 'billings'));
    }
}
