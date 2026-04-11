<?php

namespace App\Services\BankStatement;

use App\Organization;
use App\Tenant;

class TenantMatcher
{
    public function match(array $row, Organization $org): ?Tenant
    {
        $prefix  = strtoupper(trim($org->tenant_account_prefix ?? 'LKT'));
        $pattern = '/' . preg_quote($prefix, '/') . '\d{5}/i';
        $searchText = ($row['description'] ?? '') . ' ' . ($row['reference'] ?? '');

        if (!preg_match($pattern, $searchText, $matches)) return null;

        return Tenant::where('org_id', $org->id)
            ->where('account_number', strtoupper($matches[0]))
            ->first();
    }
}
