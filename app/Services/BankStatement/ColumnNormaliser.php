<?php

namespace App\Services\BankStatement;

class ColumnNormaliser
{
    private const BANK_MAPS = [
        'equity' => [
            'date'        => ['date', 'trans date', 'transaction date', 'value date'],
            'description' => ['description', 'narration', 'details'],
            'reference'   => ['txn ref', 'transaction ref', 'reference', 'cheque no', 'ref'],
            'credit'      => ['credit', 'cr', 'money in', 'deposits', 'amount in'],
            'debit'       => ['debit', 'dr', 'money out', 'withdrawals', 'amount out'],
            'balance'     => ['balance', 'ledger balance', 'running balance', 'closing balance'],
        ],
        'kcb' => [
            'date'        => ['date', 'tnx date', 'txn date', 'transaction date', 'value date'],
            'description' => ['description', 'details', 'narration', 'particulars'],
            'reference'   => ['cheque no', 'cheque number', 'reference', 'ref no', 'txn ref'],
            'credit'      => ['money in', 'credit', 'cr amount', 'deposits', 'amount in'],
            'debit'       => ['money out', 'debit', 'dr amount', 'withdrawals', 'amount out'],
            'balance'     => ['ledger balance', 'balance', 'running balance', 'closing balance'],
        ],
        'ncba' => [
            'date'        => ['transaction date', 'trans date', 'date', 'value date'],
            'description' => ['narration', 'description', 'details', 'particulars'],
            'reference'   => ['reference', 'ref no', 'txn ref', 'cheque no'],
            'credit'      => ['credit amount', 'credit', 'cr', 'money in', 'deposits'],
            'debit'       => ['debit amount', 'debit', 'dr', 'money out', 'withdrawals'],
            'balance'     => ['running balance', 'balance', 'closing balance', 'ledger balance'],
        ],
        'coop' => [
            'date'        => ['trans. date', 'trans date', 'date', 'value date', 'transaction date'],
            'description' => ['description', 'narration', 'details', 'particulars'],
            'reference'   => ['trans. ref', 'trans ref', 'reference', 'ref no', 'cheque no'],
            'credit'      => ['cr amount', 'credit', 'cr', 'money in', 'deposits'],
            'debit'       => ['dr amount', 'debit', 'dr', 'money out', 'withdrawals'],
            'balance'     => ['balance', 'running balance', 'ledger balance', 'closing balance'],
        ],
        'nbk' => [
            'date'        => ['date', 'value date', 'transaction date', 'trans date'],
            'description' => ['details', 'description', 'narration', 'particulars'],
            'reference'   => ['ref no', 'reference', 'cheque no', 'txn ref'],
            'credit'      => ['credit', 'cr', 'money in', 'deposits', 'amount in'],
            'debit'       => ['debit', 'dr', 'money out', 'withdrawals', 'amount out'],
            'balance'     => ['closing balance', 'balance', 'running balance', 'ledger balance'],
        ],
        'dtb' => [
            'date'        => ['posting date', 'date', 'value date', 'transaction date', 'trans date'],
            'description' => ['transaction details', 'description', 'narration', 'details', 'particulars'],
            'reference'   => ['reference no', 'reference', 'ref no', 'cheque no', 'txn ref'],
            'credit'      => ['credit', 'cr', 'money in', 'deposits', 'amount in'],
            'debit'       => ['debit', 'dr', 'money out', 'withdrawals', 'amount out'],
            'balance'     => ['balance', 'running balance', 'ledger balance', 'closing balance'],
        ],
        'family' => [
            'date'        => ['date', 'value date', 'transaction date', 'trans date'],
            'description' => ['description', 'narration', 'details', 'particulars'],
            'reference'   => ['reference', 'ref no', 'txn ref', 'cheque no'],
            'credit'      => ['credit', 'cr', 'money in', 'deposits', 'amount in'],
            'debit'       => ['debit', 'dr', 'money out', 'withdrawals', 'amount out'],
            'balance'     => ['balance', 'running balance', 'closing balance', 'ledger balance'],
        ],
    ];

    public static function bankOptions(): array
    {
        return [
            'equity' => 'Equity Bank',
            'kcb'    => 'KCB Bank',
            'ncba'   => 'NCBA Bank',
            'coop'   => 'Co-operative Bank',
            'nbk'    => 'National Bank of Kenya',
            'dtb'    => 'DTB Bank',
            'family' => 'Family Bank',
        ];
    }

    public function normalise(array $rows, string $bankKey): array
    {
        $map = self::BANK_MAPS[$bankKey] ?? null;
        if (!$map) throw new \InvalidArgumentException("Unknown bank key: {$bankKey}");
        if (empty($rows)) return [];

        $actualHeaders = array_keys($rows[0]);
        $columnLookup  = $this->buildLookup($actualHeaders, $map);
        $normalised    = [];

        foreach ($rows as $row) {
            $credit = $this->parseAmount($this->get($row, $columnLookup['credit'] ?? null));
            if ($credit <= 0) continue;

            $description = $this->get($row, $columnLookup['description'] ?? null);
            $reference   = $this->get($row, $columnLookup['reference'] ?? null);

            if (empty($reference) && $bankKey === 'kcb') {
                $reference = $this->extractReferenceFromDescription($description);
            }

            $normalised[] = [
                'date'        => $this->parseDate($this->get($row, $columnLookup['date'] ?? null)),
                'description' => $description,
                'reference'   => $reference,
                'credit'      => $credit,
                'debit'       => $this->parseAmount($this->get($row, $columnLookup['debit'] ?? null)),
                'balance'     => $this->parseAmount($this->get($row, $columnLookup['balance'] ?? null)),
                'raw'         => json_encode($row),
            ];
        }

        return $normalised;
    }

    private function buildLookup(array $actualHeaders, array $map): array
    {
        $lookup = [];
        $lowerHeaders = array_map('strtolower', $actualHeaders);

        foreach ($map as $unifiedField => $candidates) {
            foreach ($candidates as $candidate) {
                $index = array_search(strtolower($candidate), $lowerHeaders);
                if ($index !== false) {
                    $lookup[$unifiedField] = $actualHeaders[$index];
                    break;
                }
            }
        }

        return $lookup;
    }

    private function get(array $row, ?string $key): string
    {
        if ($key === null || !isset($row[$key])) return '';
        return trim((string) $row[$key]);
    }

    private function parseAmount(string $value): float
    {
        if ($value === '' || $value === '-') return 0.0;
        $clean = preg_replace('/[^0-9.\-]/', '', str_replace(['(', ')'], ['-', ''], $value));
        return (float) $clean;
    }

    private function parseDate(string $value): ?string
    {
        if (empty($value)) return null;

        foreach (['d/m/Y', 'd-m-Y', 'Y-m-d', 'd M Y', 'd-M-Y', 'Y/m/d', 'm/d/Y'] as $format) {
            $date = \DateTime::createFromFormat($format, $value);
            if ($date) return $date->format('Y-m-d');
        }

        try {
            return (new \DateTime($value))->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function extractReferenceFromDescription(string $description): string
    {
        if (preg_match('/\b(TT|QG|PB|MP|EFT|RFT|OTC|ATM|CDM)[A-Z0-9]{6,}\b/i', $description, $m)) {
            return $m[0];
        }
        if (preg_match('/\b[A-Z]{1,2}[A-Z0-9]{8,10}\b/', $description, $m)) {
            return $m[0];
        }
        return '';
    }
}
