<?php

namespace App\Http\Controllers;

use App\BankStatementImport;
use App\ManagerPayment;
use App\Organization;
use App\Tenant;
use App\Services\BankStatement\ColumnNormaliser;
use App\Services\BankStatement\CsvParser;
use App\Services\BankStatement\TenantMatcher;
use App\Services\BankStatement\TypeDetector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BankStatementController extends Controller
{
    public function __construct(
        private CsvParser        $parser,
        private ColumnNormaliser $normaliser,
        private TenantMatcher    $matcher,
        private TypeDetector     $detector,
    ) {}

    public function upload(Request $request)
    {
        $request->validate([
            'bank_name'   => 'required|in:equity,kcb,ncba,coop,nbk,dtb,family',
            'import_file' => 'required|file|mimes:csv,xlsx,xls|max:10240',
        ]);

        $org = $this->currentOrg();

        $rawRows = $this->parser->parse($request->file('import_file'));

        if (empty($rawRows)) {
            return back()->with('error', 'The uploaded file appears to be empty or could not be read.');
        }

        $normalisedRows = $this->normaliser->normalise($rawRows, $request->bank_name);

        if (empty($normalisedRows)) {
            return back()->with('error', 'No credit/deposit transactions found in this statement. Only deposits are imported.');
        }

        $previewRows = [];

        foreach ($normalisedRows as $row) {
            $tenant = $this->matcher->match($row, $org);
            $type   = $this->detector->detect($row['description'], $row['reference'] ?? '');

            $previewRows[] = [
                'date'           => $row['date'],
                'description'    => $row['description'],
                'reference'      => $row['reference'],
                'credit'         => $row['credit'],
                'balance'        => $row['balance'],
                'type'           => $type,
                'type_label'     => $this->detector->label($type),
                'raw'            => $row['raw'],
                'tenant_id'      => $tenant?->id,
                'tenant_account' => $tenant?->account_number,
                'tenant_name'    => $tenant ? trim($tenant->firstname . ' ' . $tenant->lastname) : null,
                'matched'        => $tenant !== null,
            ];
        }

        $sessionKey = 'bank_import_' . time();
        Session::put($sessionKey, [
            'bank_name' => $request->bank_name,
            'filename'  => $request->file('import_file')->getClientOriginalName(),
            'rows'      => $previewRows,
            'org_id'    => $org->id,
        ]);

        return redirect()->route('bank-statement.preview', ['key' => $sessionKey]);
    }

    public function preview(Request $request)
    {
        $sessionKey = $request->query('key');
        $importData = Session::get($sessionKey);

        if (!$importData) {
            return redirect()->route('manualinvoice.paymentlist')
                ->with('error', 'Import session expired. Please upload the file again.');
        }

        $org     = $this->currentOrg();
        $tenants = Tenant::where('org_id', $org->id)
            ->orderBy('firstname')
            ->get(['id', 'firstname', 'lastname', 'account_number']);

        $bankOptions = ColumnNormaliser::bankOptions();
        $bankLabel   = $bankOptions[$importData['bank_name']] ?? $importData['bank_name'];
        $matched     = collect($importData['rows'])->where('matched', true)->count();
        $unmatched   = collect($importData['rows'])->where('matched', false)->count();

        return view('manualinvoices.bank_statement_preview', compact(
            'importData', 'sessionKey', 'tenants', 'bankLabel', 'matched', 'unmatched'
        ));
    }

    public function confirm(Request $request)
    {
        $sessionKey    = $request->input('session_key');
        $importData    = Session::get($sessionKey);

        if (!$importData) {
            return redirect()->route('manualinvoice.paymentlist')
                ->with('error', 'Import session expired. Please upload the file again.');
        }

        $org           = $this->currentOrg();
        $rows          = $importData['rows'];
        $manualTenants = $request->input('tenant_id', []);
        $skipped       = $request->input('skip', []);

        foreach ($rows as $i => &$row) {
            if (isset($skipped[$i]) && $skipped[$i]) {
                $row['skip'] = true;
                continue;
            }
            if (!$row['matched'] && !empty($manualTenants[$i])) {
                $tenant = Tenant::find($manualTenants[$i]);
                if ($tenant) {
                    $row['tenant_id']      = $tenant->id;
                    $row['tenant_account'] = $tenant->account_number;
                    $row['tenant_name']    = trim($tenant->firstname . ' ' . $tenant->lastname);
                    $row['matched']        = true;
                }
            }
        }
        unset($row);

        $toImport  = collect($rows)->where('skip', '!=', true)->where('matched', true);
        $unmatched = collect($rows)->where('skip', '!=', true)->where('matched', false);

        if ($toImport->isEmpty()) {
            return back()->with('error', 'No matched rows to import. Please assign at least one tenant or skip all rows.');
        }

        $import = BankStatementImport::create([
            'org_id'          => $org->id,
            'bank_name'       => $importData['bank_name'],
            'filename'        => $importData['filename'],
            'total_credits'   => $toImport->sum('credit'),
            'row_count'       => count($rows),
            'matched_count'   => $toImport->count(),
            'unmatched_count' => $unmatched->count(),
            'imported_by'     => Auth::user()->name ?? 'admin',
        ]);

        $created = 0;
        foreach ($toImport as $row) {
            $transId = !empty($row['reference'])
                ? $row['reference']
                : 'BANK-' . strtoupper(uniqid());

            ManagerPayment::create([
                'org_id'          => $org->id,
                'import_id'       => $import->id,
                'TransactionType' => 'Bank',
                'MSISDN'          => null,
                'TransID'         => $transId,
                'TransAmount'     => $row['credit'],
                'InvoiceNumber'   => $row['tenant_account'],
                'full_name'       => $row['tenant_name'],
                'payment_date'    => $row['date'],
                'Manager'         => Auth::user()->name ?? 'admin',
                'tenant_id'       => $row['tenant_id'],
                'invoice_type'    => 'property',
                'status'          => 1,
            ]);

            $created++;
        }

        Session::forget($sessionKey);

        return redirect()->route('manualinvoice.paymentlist')
            ->with('success', "Bank statement imported. {$created} payment(s) recorded. {$unmatched->count()} unmatched row(s) — use Reroute to assign them.");
    }

    private function currentOrg(): Organization
    {
        return app('currentOrganization');
    }
}
