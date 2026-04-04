@extends('tenant.layouts.master')
@section('title', 'Submit Notice')

@section('content')
<div class="row justify-content-center">
<div class="col-md-7">
<div class="content-card">
    <h6 class="mb-1"><i class="fas fa-door-open text-danger"></i> Submit Vacating Notice</h6>
    <p class="text-muted small mb-4">Please provide at least 30 days notice before vacating.</p>

    <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>
        <strong>Important:</strong> Submitting this notice will notify management and your landlord. This action cannot be undone. All outstanding balances will be reconciled before vacating.
    </div>

    <form method="POST" action="{{ route('tenant.notice.submit') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Intended Vacating Date</label>
            <input type="date" name="vacating_date" class="form-control"
                min="{{ now()->addDays(30)->format('Y-m-d') }}" required>
            <small class="text-muted">Minimum 30 days from today</small>
        </div>
        <div class="mb-4">
            <label class="form-label">Reason for Vacating</label>
            <textarea name="reason" class="form-control" rows="4" required
                placeholder="Please provide your reason for vacating..."></textarea>
        </div>
        <button type="submit" class="btn btn-danger w-100"
            onclick="return confirm('Are you sure you want to submit a vacating notice? This will notify management immediately.')">
            <i class="fas fa-paper-plane"></i> Submit Vacating Notice
        </button>
    </form>
</div>
</div>
</div>
@endsection
