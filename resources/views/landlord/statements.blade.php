@extends('landlord.layouts.master')
@section('title', 'Statements')

@section('content')
<div class="content-card">
    <h6 class="mb-3"><i class="fas fa-file-alt text-primary"></i> Payment Statements</h6>
    <table class="table table-hover">
        <thead class="table-light">
            <tr><th>Month</th><th>Property</th><th>Total Owned</th><th>Paid</th><th>Balance</th><th>Status</th></tr>
        </thead>
        <tbody>
        @forelse($payments as $payment)
        <tr>
            <td>{{ $payment->rent_month }}</td>
            <td>{{ $payment->apartment->name ?? 'N/A' }}</td>
            <td>{{ $org->currency ?? 'KES' }} {{ number_format($payment->total_payable ?? 0) }}</td>
            <td class="text-success">{{ $org->currency ?? 'KES' }} {{ number_format($payment->paid_in ?? 0) }}</td>
            <td class="{{ ($payment->balance ?? 0) > 0 ? 'text-danger' : 'text-success' }}">
                {{ $org->currency ?? 'KES' }} {{ number_format($payment->balance ?? 0) }}
            </td>
            <td>
                <span class="badge {{ $payment->pay_status === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ ucfirst($payment->pay_status ?? 'pending') }}
                </span>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center text-muted">No statements available</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $payments->links() }}
</div>
@endsection
