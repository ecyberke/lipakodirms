@extends('super_admin.layouts.master')
@section('title', 'Add Organization')
@section('page-title', 'Add New Organization')

@section('content')
<div class="row justify-content-center">
<div class="col-md-10">
<form method="POST" action="{{ route('super.organizations.store') }}">
@csrf
<div class="row g-4">
    <!-- Organization Details -->
    <div class="col-md-6">
        <div class="table-card">
            <h6 class="mb-3"><i class="fas fa-building"></i> Organization Details</h6>
            <div class="mb-3">
                <label class="form-label">Organization Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Subdomain Slug <small class="text-muted">(e.g. "demo" for demo.lipakodi.co.ke)</small></label>
                <div class="input-group">
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required pattern="[a-z0-9\-]+">
                    <span class="input-group-text">.lipakodi.co.ke</span>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-select" required>
                    <option value="agency">Agency (Property Management)</option>
                    <option value="individual">Individual (Property Owner)</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Contact Person</label>
                <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">KRA PIN</label>
                <input type="text" name="kra_pin" class="form-control" value="{{ old('kra_pin') }}">
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">County</label>
                    <input type="text" name="county" class="form-control" value="{{ old('county') }}">
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Town</label>
                    <input type="text" name="town" class="form-control" value="{{ old('town') }}">
                </div>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label class="form-label">Number of Units</label>
                    <input type="number" name="total_units" class="form-control" value="{{ old('total_units', 1) }}" min="1" required>
                </div>
                <div class="col-6 mb-3">
                    <label class="form-label">Currency</label>
                    <select name="currency" class="form-select">
                        <option value="KES">KES - Kenyan Shilling</option>
                        <option value="UGX">UGX - Ugandan Shilling</option>
                        <option value="TZS">TZS - Tanzanian Shilling</option>
                        <option value="USD">USD - US Dollar</option>
                        <option value="GBP">GBP - British Pound</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <!-- Admin User -->
        <div class="table-card mb-4">
            <h6 class="mb-3"><i class="fas fa-user-shield"></i> Admin User Credentials</h6>
            <div class="mb-3">
                <label class="form-label">Admin Name</label>
                <input type="text" name="admin_name" class="form-control" value="{{ old('admin_name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Admin Email</label>
                <input type="email" name="admin_email" class="form-control" value="{{ old('admin_email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Admin Password</label>
                <input type="password" name="admin_password" class="form-control" required minlength="8">
            </div>
        </div>

        <!-- Subscription -->
        <div class="table-card mb-4">
            <h6 class="mb-3"><i class="fas fa-credit-card"></i> Subscription</h6>
            <div class="mb-3">
                <label class="form-label">Billing Cycle</label>
                <select name="billing_cycle" class="form-select">
                    <option value="monthly">Monthly</option>
                    <option value="quarterly">Quarterly (5% discount)</option>
                    <option value="half_yearly">Half Yearly (8% discount)</option>
                    <option value="annual">Annual (12% discount)</option>
                </select>
            </div>
            <div class="alert alert-info">
                <small><strong>Pricing Tiers:</strong><br>
                @foreach($plans as $plan)
                    {{ $plan->name }}: {{ $plan->units_min }}{{ $plan->units_max ? '-'.$plan->units_max : '+' }} units @ KES {{ number_format($plan->price_per_unit) }}/unit/month<br>
                @endforeach
                </small>
            </div>
        </div>

        <!-- Account Patterns -->
        <div class="table-card">
            <h6 class="mb-3"><i class="fas fa-hashtag"></i> Account Number Patterns</h6>
            <div class="row">
                <div class="col-4 mb-3">
                    <label class="form-label">Tenant</label>
                    <input type="text" name="tenant_account_prefix" class="form-control" value="LKT" maxlength="5">
                </div>
                <div class="col-4 mb-3">
                    <label class="form-label">Landlord</label>
                    <input type="text" name="landlord_account_prefix" class="form-control" value="LKL" maxlength="5">
                </div>
                <div class="col-4 mb-3">
                    <label class="form-label">Property</label>
                    <input type="text" name="property_account_prefix" class="form-control" value="LKP" maxlength="5">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-3">
    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Create Organization</button>
    <a href="{{ route('super.organizations.index') }}" class="btn btn-secondary">Cancel</a>
</div>
</form>
</div>
</div>
@endsection
