<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\ServiceRequests;
use App\Tenant;
use App\HouseTenant;
use App\House;
use App\Apartment;
use App\ManagerPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TenantDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:tenant');
    }

    private function getTenant()
    {
        $tenantUser = Auth::guard('tenant')->user();
        return Tenant::where('account_number', $tenantUser->account_number)
            ->where('org_id', config('app.org_id', 1))->first();
    }

    public function index()
    {
        $tenantUser = Auth::guard('tenant')->user();
        $org = config('app.organization');
        $tenant = $this->getTenant();

        if (!$tenant) {
            return view('tenant.dashboard', compact('tenantUser', 'org'));
        }

        $tenantKey = $tenant->id;
        $currentMonth = Carbon::now()->format('M-Y');
        $currentInvoice = Invoice::where('tenant_id', $tenantKey)->where('rent_month', $currentMonth)->first();
        $unpaidInvoices = Invoice::where('tenant_id', $tenantKey)->where('balance', '>', 0)->latest()->get();
        $recentPayments = ManagerPayment::where('InvoiceNumber', $tenant->account_number)
            ->orWhere('tenant_id', $tenantKey)->latest()->take(5)->get();
        $totalBalance = Invoice::where('tenant_id', $tenantKey)->sum('balance');
        $assignment = HouseTenant::where('tenant_id', $tenantKey)->with('house.apartment')->latest()->first();
        $serviceRequests = ServiceRequests::where('tenant_id', $tenant->account_number)->latest()->take(5)->get();

        return view('tenant.dashboard', compact(
            'tenantUser', 'org', 'tenant', 'currentInvoice',
            'unpaidInvoices', 'recentPayments', 'totalBalance',
            'assignment', 'serviceRequests'
        ));
    }

    public function invoices()
    {
        $org = config('app.organization');
        $tenant = $this->getTenant();
        $invoices = Invoice::where('tenant_id', $tenant->id ?? 0)->latest()->paginate(20);
        return view('tenant.invoices', compact('invoices', 'tenant', 'org'));
    }

    public function payments()
    {
        $org = config('app.organization');
        $tenant = $this->getTenant();
        $payments = ManagerPayment::where('InvoiceNumber', $tenant->account_number ?? '')
            ->orWhere('tenant_id', $tenant->id ?? 0)->latest()->paginate(20);
        return view('tenant.payments', compact('payments', 'tenant', 'org'));
    }

    public function downloadReceipt($id)
    {
        $org = config('app.organization');
        $tenant = $this->getTenant();
        $payment = ManagerPayment::where('id', $id)
            ->where(function ($q) use ($tenant) {
                $q->where('InvoiceNumber', $tenant->account_number ?? '')
                  ->orWhere('tenant_id', $tenant->id ?? 0);
            })->firstOrFail();
        $data = compact('payment', 'tenant', 'org');
        $pdf = \PDF::loadView('tenant.receipt_pdf', $data);
        return $pdf->download('receipt_' . $payment->TransID . '.pdf');
    }

    public function createServiceRequest()
    {
        $org = config('app.organization');
        $tenant = $this->getTenant();
        $assignments = HouseTenant::where('tenant_id', $tenant->id ?? 0)
            ->with('house.apartment')->get();
        return view('tenant.service_request_create', compact('org', 'tenant', 'assignments'));
    }

    public function serviceRequests()
    {
        $org = config('app.organization');
        $tenant = $this->getTenant();
        $requests = ServiceRequests::where('tenant_id', $tenant->id ?? 0)
            ->with('house', 'apartment')->latest()->paginate(20);
        return view('tenant.service_requests_list', compact('requests', 'tenant', 'org'));
    }

    public function submitServiceRequest(Request $request)
    {
        $request->validate([
            'request_type' => 'required|string',
            'description'  => 'required|string|min:5',
        ]);

        $tenant = $this->getTenant();
        $orgId = config('app.org_id', 1);
        $houseId = $request->house_id;
        $apartmentId = $request->apartment_id;

        if (!$houseId) {
            $assignment = HouseTenant::where('tenant_id', $tenant->id)->latest()->first();
            $houseId = $assignment?->house_id;
            $apartmentId = $assignment?->apartment_id;
        }

        ServiceRequests::create([
            'org_id'        => $orgId,
            'tenant_id'     => $tenant->id,
            'tenant_name'   => $tenant->full_name,
            'house_id'      => $houseId,
            'apartment_id'  => $apartmentId,
            'request_type'  => $request->service_type,
            'area_affected' => $request->affected_area,
            'description'   => $request->service_request,
            'priority'      => $request->priority ?? 2,
            'approval'      => 0,
            'status'        => 0,
            'request_date'  => now(),
        ]);

        return redirect()->route('tenant.service-requests.list')
            ->with('success', 'Service request submitted successfully.');
    }

    public function markResolved(Request $request, $id)
    {
        $tenant = $this->getTenant();
        $sr = ServiceRequests::where('id', $id)
            ->where('tenant_id', $tenant->id)->firstOrFail();
        $sr->update(['status' => 'resolved by tenant']);
        return back()->with('success', 'Request marked as resolved.');
    }

    public function submitNotice(Request $request)
    {
        $request->validate([
            'notice_date'   => 'required|date|after_or_equal:today',
            'vacating_date' => 'required|date|after:today',
            'reason'        => 'required|string|min:5',
        ]);

        $tenant = $this->getTenant();
        $orgId = config('app.org_id', 1);
        $assignment = HouseTenant::where('tenant_id', $tenant->id)->latest()->first();

        ServiceRequests::create([
            'org_id'       => $orgId,
            'tenant_id'    => $tenant->account_number,
            'tenant_name'  => $tenant->full_name,
            'house_id'     => $assignment?->house_id,
            'apartment_id' => $assignment?->apartment_id,
            'request_type' => 'Vacating Notice',
            'description'  => "Notice Date: {$request->notice_date}\nVacating Date: {$request->vacating_date}\nReasons: {$request->reason}",
            'priority'     => 1,
            'approval'     => 0,
            'status'       => 'notice',
            'request_date' => now(),
        ]);

        return back()->with('success', 'Notice submitted successfully. Management will be in touch.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $tenantUser = Auth::guard('tenant')->user();
        if (!Hash::check($request->current_password, $tenantUser->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
        $tenantUser->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password changed successfully');
    }
}
