@extends('landlord.layouts.master')
@section('title', 'Dashboard')

@section('content')
@if(!isset($landlord) || !$landlord)
    <div class="alert alert-warning">Your owner profile is not yet linked. Please contact management.</div>
@else
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card"><small class="text-muted">Total Units</small><h4>{{ $totalHouses }}</h4></div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card green"><small class="text-muted">Occupied</small><h4>{{ $occupiedHouses }}</h4></div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card orange"><small class="text-muted">Vacant</small><h4>{{ $vacantHouses }}</h4></div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card red"><small class="text-muted">On Notice</small><h4>{{ $onNoticeHouses }}</h4></div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card green">
            <small class="text-muted">Monthly Income</small>
            <h4>{{ $org->currency ?? 'KES' }} {{ number_format($monthlyIncome) }}</h4>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card red">
            <small class="text-muted">Total Arrears</small>
            <h4>{{ $org->currency ?? 'KES' }} {{ number_format($totalArrears) }}</h4>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="content-card">
            <h6 class="mb-3"><i class="fas fa-building text-primary"></i> My Properties</h6>
            @foreach($apartments as $apt)
            <div class="d-flex justify-content-between border-bottom py-2">
                <div><strong>{{ $apt->name }}</strong><br><small class="text-muted">{{ $apt->location }}</small></div>
                <div class="text-end">
                    <span class="badge bg-primary">{{ $apt->houses->count() }} units</span>
                </div>
            </div>
            @endforeach
            <a href="{{ route('landlord.properties') }}" class="btn btn-sm btn-outline-primary mt-3">View Details</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="content-card">
            <h6 class="mb-3"><i class="fas fa-tools text-warning"></i> Recent Service Requests</h6>
            @forelse($serviceRequests as $req)
            <div class="d-flex justify-content-between border-bottom py-2">
                <div><strong>{{ $req->request_type }}</strong><br><small class="text-muted">{{ $req->created_at->format('d M Y') }}</small></div>
                <span class="badge {{ $req->approval ? 'bg-success' : 'bg-warning text-dark' }}">{{ $req->approval ? 'Done' : 'Pending' }}</span>
            </div>
            @empty
            <p class="text-muted">No service requests.</p>
            @endforelse
        </div>
    </div>
</div>
@endif
@endsection
