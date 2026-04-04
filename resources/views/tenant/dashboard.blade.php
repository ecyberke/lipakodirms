@extends('tenant.layouts.master')
@section('title', 'Dashboard')

@section('content')
@if(!isset($tenant) || !$tenant)
    <div class="alert alert-warning">Your tenant profile is not yet linked. Please contact management.</div>
@else
<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <small class="text-muted">Current Balance</small>
            <h4 class="{{ $totalBalance > 0 ? 'text-danger' : 'text-success' }}">
                {{ $org->currency ?? 'KES' }} {{ number_format($totalBalance) }}
            </h4>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card orange">
            <small class="text-muted">Unpaid Invoices</small>
            <h4>{{ $unpaidInvoices->count() }}</h4>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card green">
            <small class="text-muted">Service Requests</small>
            <h4>{{ $serviceRequests->count() }}</h4>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <small class="text-muted">Unit</small>
            <h4>{{ $assignment?->house?->house_no ?? 'N/A' }}</h4>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Current Invoice -->
    <div class="col-md-6">
        <div class="content-card">
            <h6 class="mb-3"><i class="fas fa-file-invoice text-primary"></i> Current Month Invoice</h6>
            @if($currentInvoice)
            <table class="table table-sm">
                <tr><td>Month</td><td><strong>{{ $currentInvoice->rent_month }}</strong></td></tr>
                <tr><td>Rent</td><td>{{ $org->currency ?? 'KES' }} {{ number_format($currentInvoice->rent_amount ?? 0) }}</td></tr>
                <tr><td>Total Payable</td><td>{{ $org->currency ?? 'KES' }} {{ number_format($currentInvoice->total_payable ?? 0) }}</td></tr>
                <tr><td>Paid</td><td class="text-success">{{ $org->currency ?? 'KES' }} {{ number_format($currentInvoice->paid_in ?? 0) }}</td></tr>
                <tr><td>Balance</td><td class="{{ $currentInvoice->balance > 0 ? 'text-danger' : 'text-success' }} fw-bold">
                    {{ $org->currency ?? 'KES' }} {{ number_format($currentInvoice->balance ?? 0) }}
                </td></tr>
            </table>
            <a href="{{ route('invoice.show', $currentInvoice->id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-eye"></i> View & Pay
            </a>
            @else
            <p class="text-muted">No invoice generated for this month yet.</p>
            @endif
        </div>
    </div>

    <!-- Tenant Info -->
    <div class="col-md-6">
        <div class="content-card">
            <h6 class="mb-3"><i class="fas fa-user text-primary"></i> My Information</h6>
            <table class="table table-sm">
                <tr><td>Name</td><td><strong>{{ $tenant->full_name }}</strong></td></tr>
                <tr><td>Account No.</td><td><code>{{ $tenant->account_number }}</code></td></tr>
                <tr><td>Phone</td><td>{{ $tenant->phone }}</td></tr>
                <tr><td>Property</td><td>{{ $assignment?->house?->apartment?->name ?? 'N/A' }}</td></tr>
                <tr><td>Unit</td><td>{{ $assignment?->house?->house_no ?? 'N/A' }}</td></tr>
            </table>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="col-md-6">
        <div class="content-card">
            <div class="d-flex justify-content-between mb-3">
                <h6><i class="fas fa-money-bill text-success"></i> Recent Payments</h6>
                <a href="{{ route('tenant.invoices') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            @forelse($recentPayments as $payment)
            <div class="d-flex justify-content-between border-bottom py-2">
                <div>
                    <small class="text-muted">{{ $payment->created_at->format('d M Y') }}</small><br>
                    <strong>{{ $org->currency ?? 'KES' }} {{ number_format($payment->TransAmount) }}</strong>
                </div>
                <span class="badge bg-success align-self-center">Paid</span>
            </div>
            @empty
            <p class="text-muted">No payments recorded yet.</p>
            @endforelse
        </div>
    </div>

    <!-- Service Requests -->
    <div class="col-md-6">
        <div class="content-card">
            <div class="d-flex justify-content-between mb-3">
                <h6><i class="fas fa-tools text-warning"></i> Recent Service Requests</h6>
                <a href="{{ route('tenant.service-requests') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            @forelse($serviceRequests as $req)
            <div class="d-flex justify-content-between border-bottom py-2">
                <div>
                    <strong>{{ $req->request_type }}</strong><br>
                    <small class="text-muted">{{ $req->created_at->format('d M Y') }}</small>
                </div>
                <span class="badge {{ $req->approval ? 'bg-success' : 'bg-warning text-dark' }} align-self-center">
                    {{ $req->approval ? 'Approved' : 'Pending' }}
                </span>
            </div>
            @empty
            <p class="text-muted">No service requests.</p>
            @endforelse
        </div>
    </div>
</div>
@endif
@endsection
