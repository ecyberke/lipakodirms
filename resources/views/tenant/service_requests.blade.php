@extends('tenant.layouts.master')
@section('title', 'Service Requests')

@section('content')
<div class="row g-4">
    <div class="col-md-5">
        <div class="content-card">
            <h6 class="mb-3"><i class="fas fa-plus-circle text-primary"></i> Submit New Request</h6>
            <form method="POST" action="{{ route('tenant.service-requests.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Request Type</label>
                    <select name="request_type" class="form-select" required>
                        <option value="">-- Select Type --</option>
                        <option value="Plumbing">Plumbing</option>
                        <option value="Electrical">Electrical</option>
                        <option value="Painting">Painting</option>
                        <option value="Carpentry">Carpentry</option>
                        <option value="Cleaning">Cleaning</option>
                        <option value="Security">Security</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required placeholder="Describe the issue in detail..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit Request</button>
            </form>
        </div>
    </div>
    <div class="col-md-7">
        <div class="content-card">
            <h6 class="mb-3"><i class="fas fa-list text-primary"></i> My Service Requests</h6>
            @forelse($requests as $req)
            <div class="border rounded p-3 mb-3">
                <div class="d-flex justify-content-between">
                    <strong>{{ $req->request_type }}</strong>
                    <span class="badge {{ $req->approval ? 'bg-success' : 'bg-warning text-dark' }}">
                        {{ $req->approval ? 'Approved' : 'Pending' }}
                    </span>
                </div>
                <p class="text-muted small mt-1 mb-1">{{ $req->description }}</p>
                <small class="text-muted">{{ $req->created_at->format('d M Y H:i') }}</small>
            </div>
            @empty
            <p class="text-muted">No service requests submitted yet.</p>
            @endforelse
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection
