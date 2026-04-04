@extends('super_admin.layouts.master')
@section('title', 'Organizations')
@section('page-title', 'All Organizations')

@section('content')
<div class="d-flex justify-content-between mb-4">
    <div class="row g-3">
        <div class="col-auto"><div class="stat-card py-2 px-3"><small>Total</small><h5 class="mb-0">{{ $stats['total'] }}</h5></div></div>
        <div class="col-auto"><div class="stat-card green py-2 px-3"><small>Active</small><h5 class="mb-0">{{ $stats['active'] }}</h5></div></div>
        <div class="col-auto"><div class="stat-card red py-2 px-3"><small>Suspended</small><h5 class="mb-0">{{ $stats['suspended'] }}</h5></div></div>
        <div class="col-auto"><div class="stat-card orange py-2 px-3"><small>Monthly Rev.</small><h5 class="mb-0">KES {{ number_format($stats['monthly_revenue']) }}</h5></div></div>
    </div>
    <a href="{{ route('super.organizations.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Organization</a>
</div>

<div class="table-card">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>#</th><th>Organization</th><th>Subdomain</th><th>Type</th>
                <th>Units</th><th>Status</th><th>Subscription</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($organizations as $org)
            <tr>
                <td>{{ $org->id }}</td>
                <td>
                    <strong>{{ $org->name }}</strong><br>
                    <small class="text-muted">{{ $org->email }}</small>
                </td>
                <td><code>{{ $org->slug }}.lipakodi.co.ke</code></td>
                <td>{{ ucfirst($org->type) }}</td>
                <td>{{ $org->total_units }}</td>
                <td><span class="org-status status-{{ $org->status }}">{{ ucfirst($org->status) }}</span></td>
                <td>
                    @if($org->subscription)
                        <small>Ends: {{ $org->subscription->ends_at->format('d M Y') }}</small>
                    @else
                        <small class="text-muted">No subscription</small>
                    @endif
                </td>
                <td>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('super.organizations.show', $org->id) }}" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('super.organizations.edit', $org->id) }}" class="btn btn-outline-secondary"><i class="fas fa-edit"></i></a>
                        @if($org->status === 'active')
                            <form method="POST" action="{{ route('super.organizations.suspend', $org->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-outline-warning" onclick="return confirm('Suspend this organization?')"><i class="fas fa-pause"></i></button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('super.organizations.activate', $org->id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-outline-success"><i class="fas fa-play"></i></button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('super.impersonate', $org->id) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-dark" title="Login as this org"><i class="fas fa-user-secret"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center text-muted">No organizations found</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $organizations->links() }}
</div>
@endsection
