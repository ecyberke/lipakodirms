<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Account Statement</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1A4FA8; padding-bottom: 10px; }
        .header h2 { color: #1A4FA8; margin: 0; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .info-block p { margin: 3px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #1A4FA8; color: white; padding: 8px; text-align: left; font-size: 11px; }
        td { padding: 6px 8px; border-bottom: 1px solid #eee; font-size: 11px; }
        tr:nth-child(even) { background: #f9f9f9; }
        .summary { background: #f0f4ff; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
        .summary table { margin: 0; }
        .summary td { border: none; padding: 4px 8px; }
        .text-success { color: #28a745; }
        .text-danger { color: #dc3545; }
        .text-primary { color: #1A4FA8; }
        .badge-success { background: #d4edda; color: #155724; padding: 2px 6px; border-radius: 3px; }
        .badge-danger { background: #f8d7da; color: #721c24; padding: 2px 6px; border-radius: 3px; }
        h4 { color: #1A4FA8; border-bottom: 1px solid #dee2e6; padding-bottom: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $org->name ?? 'Property Management' }}</h2>
        <p>ACCOUNT STATEMENT</p>
        @if($from && $to)
        <p>Period: {{ date('d M Y', strtotime($from)) }} to {{ date('d M Y', strtotime($to)) }}</p>
        @endif
        <p>Generated: {{ date('d M Y H:i') }}</p>
    </div>

    <table style="width:100%;margin-bottom:15px;">
        <tr>
            <td style="width:50%;vertical-align:top;">
                <strong>Tenant Details</strong><br>
                Name: {{ $tenant->full_name }}<br>
                Account No: {{ $tenant->account_number }}<br>
                Phone: {{ $tenant->phone }}<br>
            </td>
            <td style="width:50%;vertical-align:top;text-align:right;">
                <strong>{{ $org->name ?? '' }}</strong><br>
                {{ $org->county ?? '' }}, {{ $org->town ?? '' }}<br>
                {{ $org->email ?? '' }}<br>
                {{ $org->phone ?? '' }}
            </td>
        </tr>
    </table>

    <!-- Summary -->
    <div class="summary">
        <table>
            <tr>
                <td><strong>Total Charged:</strong></td>
                <td class="text-primary"><strong>{{ $org->currency ?? 'KES' }} {{ number_format($totalCharged) }}</strong></td>
                <td><strong>Total Paid:</strong></td>
                <td class="text-success"><strong>{{ $org->currency ?? 'KES' }} {{ number_format($totalPaid) }}</strong></td>
                <td><strong>Balance:</strong></td>
                <td class="{{ $totalBalance > 0 ? 'text-danger' : 'text-success' }}"><strong>{{ $org->currency ?? 'KES' }} {{ number_format($totalBalance) }}</strong></td>
            </tr>
        </table>
    </div>

    <!-- Invoices -->
    <h4>Invoice History</h4>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>INV #</th>
                <th>Month</th>
                <th>Rent</th>
                <th>Bills</th>
                <th>Total Payable</th>
                <th>Paid</th>
                <th>Balance</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @php $i = 1; @endphp
        @forelse($invoices as $inv)
        <tr>
            <td>{{ $i++ }}</td>
            <td>INV #{{ $inv->id }}</td>
            <td>{{ $inv->rent_month }}</td>
            <td>{{ $org->currency ?? 'KES' }} {{ number_format($inv->rent ?? 0) }}</td>
            <td>{{ $org->currency ?? 'KES' }} {{ number_format($inv->bills ?? 0) }}</td>
            <td><strong>{{ $org->currency ?? 'KES' }} {{ number_format($inv->total_payable ?? 0) }}</strong></td>
            <td class="text-success">{{ $org->currency ?? 'KES' }} {{ number_format($inv->paid_in ?? 0) }}</td>
            <td class="{{ ($inv->balance ?? 0) > 0 ? 'text-danger' : 'text-success' }}">{{ $org->currency ?? 'KES' }} {{ number_format($inv->balance ?? 0) }}</td>
            <td>
                @if(($inv->balance ?? 0) <= 0)
                <span class="badge-success">Paid</span>
                @else
                <span class="badge-danger">Unpaid</span>
                @endif
            </td>
        </tr>
        @empty
        <tr><td colspan="9" style="text-align:center;color:#999;">No invoices in this period</td></tr>
        @endforelse
        </tbody>
    </table>

    <!-- Payments -->
    <h4>Payment History</h4>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Transaction Code</th>
                <th>Method</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @php $i = 1; @endphp
        @forelse($payments as $pay)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ \Carbon\Carbon::parse($pay->payment_date ?? $pay->created_at)->format('d M Y') }}</td>
            <td>{{ $pay->TransID ?? 'N/A' }}</td>
            <td>{{ $pay->TransactionType ?? 'M-Pesa' }}</td>
            <td class="text-success"><strong>{{ $org->currency ?? 'KES' }} {{ number_format($pay->TransAmount ?? 0) }}</strong></td>
            <td><span class="badge-success">Confirmed</span></td>
        </tr>
        @empty
        <tr><td colspan="6" style="text-align:center;color:#999;">No payments in this period</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:30px;text-align:center;color:#999;font-size:10px;border-top:1px solid #eee;padding-top:10px;">
        This statement was generated on {{ date('d M Y H:i') }} by {{ $org->name ?? 'Lipakodi RMS' }}
    </div>
</body>
</html>
