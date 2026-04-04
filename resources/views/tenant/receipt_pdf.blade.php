<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1A4FA8; padding-bottom: 10px; }
        .header h2 { color: #1A4FA8; margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th { background: #1A4FA8; color: white; padding: 8px; text-align: left; }
        td { padding: 6px 8px; border-bottom: 1px solid #eee; }
        .amount { font-size: 1.5rem; font-weight: bold; color: #28a745; text-align: center; padding: 15px; }
        .footer { text-align: center; color: #999; font-size: 10px; margin-top: 30px; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $org->name ?? 'Property Management' }}</h2>
        <p>PAYMENT RECEIPT</p>
        <p>Generated: {{ date('d M Y H:i') }}</p>
    </div>

    <div class="amount">
        {{ $org->currency ?? 'KES' }} {{ number_format($payment->TransAmount ?? 0) }}
    </div>

    <table>
        <tr><th colspan="2">Payment Details</th></tr>
        <tr><td><strong>Transaction ID</strong></td><td>{{ $payment->TransID ?? 'N/A' }}</td></tr>
        <tr><td><strong>Payment Method</strong></td><td>{{ $payment->TransactionType ?? 'M-Pesa' }}</td></tr>
        <tr><td><strong>Phone</strong></td><td>{{ $payment->MSISDN ?? 'N/A' }}</td></tr>
        <tr><td><strong>Date</strong></td><td>{{ \Carbon\Carbon::parse($payment->payment_date ?? $payment->created_at)->format('d M Y H:i') }}</td></tr>
        <tr><td><strong>Status</strong></td><td>{{ $payment->status == 1 ? 'Approved' : 'Pending' }}</td></tr>
    </table>

    <table>
        <tr><th colspan="2">Tenant Details</th></tr>
        <tr><td><strong>Name</strong></td><td>{{ $tenant->full_name }}</td></tr>
        <tr><td><strong>Account No.</strong></td><td>{{ $tenant->account_number }}</td></tr>
        <tr><td><strong>Phone</strong></td><td>{{ $tenant->phone }}</td></tr>
    </table>

    <div class="footer">
        This is a computer-generated receipt. No signature required.<br>
        {{ $org->name ?? '' }} &mdash; {{ $org->email ?? '' }} &mdash; {{ $org->phone ?? '' }}
    </div>
</body>
</html>
