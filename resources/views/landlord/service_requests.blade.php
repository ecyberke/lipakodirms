@extends('landlord.layouts.master')
@section('title', 'Service Requests')

@section('content')
<div class="content-card">
    <h6 class="mb-3"><i class="fas fa-tools text-warning"></i> Service Requests on My Properties</h6>
    @forelse($requests as $req)
    <div class="border rounded p-3 mb-3">
        <div class="d-flex justify-content-between">
            <div>
                <strong>{{ $req->request_type }}</strong>
                <small class="text-muted ms-2">{{ $req->created_at->format('d M Y') }}</small>
            </div>
            <span class="badge {{ $req->approval ? 'bg-success' : 'bg-warning text-dark' }}">
                {{ $req->approval ? 'Resolved' : 'Pending' }}
            </span>
        </div>
        <p class="text-muted small mt-2 mb-0">{{ $req->description }}</p>
    </div>
    @empty
    <p class="text-muted">No service requests on your properties.</p>
    @endforelse
    {{ $requests->links() }}
</div>
@endsection
