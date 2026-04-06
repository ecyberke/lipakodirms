@extends('super_admin.layouts.master')
@section('title', 'Add Organization')
@section('page-title', 'Add New Agency / Landlord')

@section('css')
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <form method="POST" action="{{ route('super.organizations.store') }}">
            @csrf
            <div class="row">
                {{-- Organization Details --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><i class="fe fe-briefcase mr-1"></i> Organization Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Organization Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Subdomain Slug <span class="text-danger">*</span> <small class="text-muted">(e.g. "demo" → demo.lipakodi.co.ke)</small></label>
                                        <div class="input-group">
                                            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required pattern="[a-z0-9\-]+">
                                            <div class="input-group-append">
                                                <span class="input-group-text">.lipakodi.co.ke</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Type <span class="text-danger">*</span></label>
                                        <select name="type" class="form-control select2-show-search" required>
                                            <option value="agency">Agency (Property Management)</option>
                                            <option value="individual">Individual (Property Owner)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Currency</label>
                                        <select name="currency" class="form-control select2-show-search">
                                            <option value="KES">KES - Kenyan Shilling</option>
                                            <option value="UGX">UGX - Ugandan Shilling</option>
                                            <option value="TZS">TZS - Tanzanian Shilling</option>
                                            <option value="USD">USD - US Dollar</option>
                                            <option value="GBP">GBP - British Pound</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Contact Person</label>
                                        <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Phone <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>KRA PIN</label>
                                        <input type="text" name="kra_pin" class="form-control" value="{{ old('kra_pin') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Number of Units <span class="text-danger">*</span></label>
                                        <input type="number" name="total_units" class="form-control" value="{{ old('total_units', 1) }}" min="1" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>County</label>
                                        <input type="text" name="county" class="form-control" value="{{ old('county') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Town</label>
                                        <input type="text" name="town" class="form-control" value="{{ old('town') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div class="col-md-6">
                    {{-- Admin User --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title"><i class="fe fe-user mr-1"></i> Admin User Credentials</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Admin Name <span class="text-danger">*</span></label>
                                        <input type="text" name="admin_name" class="form-control" value="{{ old('admin_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Admin Email <span class="text-danger">*</span></label>
                                        <input type="email" name="admin_email" class="form-control" value="{{ old('admin_email') }}" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Admin Password <span class="text-danger">*</span></label>
                                        <input type="password" name="admin_password" class="form-control" required minlength="8">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Subscription --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title"><i class="fe fe-credit-card mr-1"></i> Subscription</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Billing Cycle</label>
                                <select name="billing_cycle" class="form-control select2-show-search">
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly (5% discount)</option>
                                    <option value="half_yearly">Half Yearly (8% discount)</option>
                                    <option value="annual">Annual (12% discount)</option>
                                </select>
                            </div>
                            <div class="alert alert-info mb-0">
                                <strong>Pricing Tiers:</strong><br>
                                @foreach($plans as $plan)
                                    <small>{{ $plan->name }}: {{ $plan->units_min }}{{ $plan->units_max ? '-'.$plan->units_max : '+' }} units @ KES {{ number_format($plan->price_per_unit) }}/unit/month</small><br>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Account Patterns --}}
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><i class="fe fe-hash mr-1"></i> Account Number Patterns</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tenant</label>
                                        <input type="text" name="tenant_account_prefix" class="form-control" value="LKT" maxlength="5">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Landlord</label>
                                        <input type="text" name="landlord_account_prefix" class="form-control" value="LKL" maxlength="5">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Property</label>
                                        <input type="text" name="property_account_prefix" class="form-control" value="LKP" maxlength="5">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3 mb-4">
                <div class="col-sm-8">
                    <button type="submit" class="btn btn-success waves-effect waves-light">
                        <i class="fe fe-save"></i> Create Organization
                    </button>
                    <a href="{{ route('super.organizations.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
@endsection
