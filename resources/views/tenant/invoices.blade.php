@extends('tenant.layouts.master')
@section('title', 'My Invoices')

@section('content')
<div class="content-card">
    <h6 class="mb-3"><i class="fas fa-file-invoice text-primary"></i> My Invoices</h6>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr><th>Month</th><th>Rent</th><th>Total Payable</th><th>Paid</th><th>Balance</th><th>Status</th><th>Action</th></tr>
            </thead>
            <tbody>
            @forelse($invoices as $inv)
            <tr>
                <td>{{ $inv->rent_month }}</td>
                <td>{{ $org->currency ?? 'KES' }} {{ number_format($inv->rent_amount ?? 0) }}</td>
                <td>{{ $org->currency ?? 'KES' }} {{ number_format($inv->total_payable ?? 0) }}</td>
                <td class="text-success">{{ $org->currency ?? 'KES' }} {{ number_format($inv->paid_in ?? 0) }}</td>
                <td class="{{ ($inv->balance ?? 0) > 0 ? 'text-danger fw-bold' : 'text-success' }}">
                    {{ $org->currency ?? 'KES' }} {{ number_format($inv->balance ?? 0) }}
                </td>
                <td>
                    @if(($inv->balance ?? 0) <= 0)
                        <span class="badge bg-success">Paid</span>
                    @else
                        <span class="badge bg-danger">Unpaid</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('invoice.show', $inv->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-eye"></i> View
                    </a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted">No invoices found</td></tr>
            @endforelse
            </tbody>
        </table>
        {{ $invoices->links() }}
    </div>
</div>
@endsection
