@extends('tenant.layouts.master')
@section('title', 'Change Password')

@section('content')
<div class="row justify-content-center">
<div class="col-md-5">
<div class="content-card">
    <h6 class="mb-4"><i class="fas fa-key text-primary"></i> Change Password</h6>
    <form method="POST" action="{{ route('tenant.password.update') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="password" class="form-control" required minlength="8">
        </div>
        <div class="mb-4">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Password</button>
    </form>
</div>
</div>
</div>
@endsection
