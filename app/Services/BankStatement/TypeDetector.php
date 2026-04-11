<?php

namespace App\Services\BankStatement;

class TypeDetector
{
    private const PATTERNS = [
        'mobile_money'   => ['mpesa', 'm-pesa', 'momo', 'airtel money', 'airtel', 't-kash', 'tkash', 'mobile money', 'paybill', 'buy goods', 'send money'],
        'pesalink'       => ['pesalink', 'ipsl', 'pesa link', 'pl transfer'],
        'eft'            => ['eft', 'rtgs', 'swift', 'tt ', ' tt ', 'wire transfer', 'bank transfer', 'electronic funds', 'neft', 'interbank'],
        'cheque_deposit' => ['cheque', 'chq', ' chq', 'cq ', 'check deposit', 'clearing'],
        'cash_deposit'   => ['cash deposit', 'cash dep', 'cdm', 'cash in', 'over counter', 'otc deposit', 'counter deposit', 'branch deposit', 'cash transfer'],
    ];

    public function detect(string $description, string $reference = ''): string
    {
        $text = strtolower($description . ' ' . $reference);
        foreach (self::PATTERNS as $type => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($text, $keyword)) return $type;
            }
        }
        return 'other';
    }

    public function label(string $type): string
    {
        return match ($type) {
            'mobile_money'   => 'Mobile Money',
            'pesalink'       => 'PesaLink',
            'eft'            => 'EFT / RTGS',
            'cheque_deposit' => 'Cheque Deposit',
            'cash_deposit'   => 'Cash Deposit',
            default          => 'Bank Transfer',
        };
    }
}
