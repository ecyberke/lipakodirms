<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DocController;
use App\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenantStatementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:tenant');
    }

    public function index(Request $request)
    {
        $tenantUser = Auth::guard('tenant')->user();
        $org = config('app.organization');
        $orgId = config('app.org_id', 1);

        $tenant = Tenant::where('account_number', $tenantUser->account_number)
            ->where('org_id', $orgId)->first();

        if (!$tenant) {
            return back()->with('error', 'Tenant profile not found');
        }

        $from = $request->from ?? null;
        $to = $request->to ?? null;
        $download = $request->download ?? 'no';
        $hasReport = $request->has('generate') || ($from && $to);

        // Default empty data
        $entries = [];
        $deposit_sum = 0;
        $electricity_deposit_sum = 0;
        $others_sum = 0;
        $rent_sum = 0;
        $payments = 0;
        $total = 0;
        $balance = 0;
        $other_info = [];

        if ($hasReport) {
            // Use DocController's getTenantData via a temporary auth spoof
            // Login as web user temporarily for the DocTrait
            $docController = new DocController();

            // Use reflection to call protected getTenantData
            $dates = [];
            if ($from && $to) {
                $dates = ['from' => $from, 'to' => $to];
            }

            try {
                $info = $docController->getTenantDataPublic($tenant->id, $dates);
                $entries = $info['entries'];
                $deposit_sum = $info['deposit_sum'];
                $electricity_deposit_sum = $info['electricity_deposit_sum'];
                $others_sum = $info['others_sum'];
                $rent_sum = $info['rent_sum'];
                $payments = $info['payments'];
                $total = $info['total'];
                $balance = $info['balance'];
                $other_info = $info['other_info'];

                // PDF download
                if ($download == 'yes') {
                    $data = compact(
                        'entries', 'deposit_sum', 'electricity_deposit_sum',
                        'others_sum', 'rent_sum', 'payments', 'total',
                        'balance', 'other_info', 'org'
                    );
                    $pdf = \PDF::loadView('docs.tenantStatement', $data);
                    return $pdf->download('statement_' . $tenant->account_number . '_' . date('Ymd') . '.pdf');
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Could not generate statement: ' . $e->getMessage());
            }
        }

        return view('tenant.statement', compact(
            'tenant', 'org', 'hasReport', 'from', 'to',
            'entries', 'deposit_sum', 'electricity_deposit_sum',
            'others_sum', 'rent_sum', 'payments', 'total', 'balance', 'other_info'
        ));
    }
}
