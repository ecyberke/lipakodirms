@extends('super_admin.layouts.master')
@section('title', 'Dashboard')
@section('page-title', 'Super Admin Dashboard')

@section('content')
<!-- Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <p>Total Organizations</p>
            <h3>{{ $stats['total_orgs'] }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card green">
            <p>Active</p>
            <h3>{{ $stats['active_orgs'] }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card red">
            <p>Suspended / Pending</p>
            <h3>{{ $stats['suspended_orgs'] + $stats['pending_orgs'] }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card orange">
            <p>Est. Monthly Revenue</p>
            <h3>KES {{ number_format($stats['monthly_revenue']) }}</h3>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <p>Total Active Units</p>
            <h3>{{ number_format($stats['total_units']) }}</h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card orange">
            <p>Est. Annual Revenue</p>
            <h3>KES {{ number_format($stats['annual_revenue']) }}</h3>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Expiring Soon -->
    <div class="col-md-6">
        <div class="table-card">
            <h6 class="mb-3"><i class="fas fa-exclamation-triangle text-warning"></i> Subscriptions Expiring Soon</h6>
            @if($expiring_soon->isEmpty())
                <p class="text-muted">No subscriptions expiring in the next 14 days.</p>
            @else
                <table class="table table-sm">
                    <thead><tr><th>Organization</th><th>Expires</th><th>Amount</th></tr></thead>
                    <tbody>
                    @foreach($expiring_soon as $sub)
                        <tr>
                            <td>{{ $sub->organization->name }}</td>
                            <td><span class="badge bg-warning text-dark">{{ $sub->ends_at->format('d M Y') }}</span></td>
                            <td>KES {{ number_format($sub->amount) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Recent Organizations -->
    <div class="col-md-6">
        <div class="table-card">
            <div class="d-flex justify-content-between mb-3">
                <h6><i class="fas fa-building"></i> Recent Organizations</h6>
                <a href="{{ route('super.organizations.create') }}" class="btn btn-sm btn-primary">+ Add New</a>
            </div>
            <table class="table table-sm">
                <thead><tr><th>Name</th><th>Subdomain</th><th>Status</th></tr></thead>
                <tbody>
                @foreach($recent_orgs as $org)
                    <tr>
                        <td><a href="{{ route('super.organizations.show', $org->id) }}">{{ $org->name }}</a></td>
                        <td><code>{{ $org->slug }}.lipakodi.co.ke</code></td>
                        <td><span class="org-status status-{{ $org->status }}">{{ ucfirst($org->status) }}</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Subscription Plans Quick View -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="table-card">
            <div class="d-flex justify-content-between mb-3">
                <h6><i class="fas fa-tags"></i> Subscription Plans</h6>
                <a href="{{ route('super.plans.index') }}" class="btn btn-sm btn-outline-primary">Manage Plans</a>
            </div>
            <div class="row g-3">
                @foreach($plans as $plan)
                <div class="col-md-3">
                    <div class="card border-0 bg-light">
                        <div class="card-body text-center">
                            <h6>{{ $plan->name }}</h6>
                            <p class="text-muted small">
                                {{ $plan->units_min }}{{ $plan->units_max ? ' - '.$plan->units_max : '+' }} units
                            </p>
                            <h4 class="text-primary">KES {{ number_format($plan->price_per_unit) }}</h4>
                            <small class="text-muted">per unit/month</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
