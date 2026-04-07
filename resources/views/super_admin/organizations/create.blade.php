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
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Type <span class="text-danger">*</span></label>
                                        <select name="type" class="form-control" required>
                                            <option value="agency">Agency (Property Management)</option>
                                            <option value="individual">Individual (Property Owner)</option>
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
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>KRA PIN</label>
                                        <input type="text" name="kra_pin" class="form-control" value="{{ old('kra_pin') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Town/City</label>
                                        <input type="text" name="town" class="form-control" value="{{ old('town') }}">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" name="country" class="form-control" value="{{ old('country', 'Kenya') }}">
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
                                <select name="billing_cycle" class="form-control">
                                    <option value="monthly">Monthly</option>
                                    <option value="quarterly">Quarterly (5% discount)</option>
                                    <option value="half_yearly">Half Yearly (8% discount)</option>
                                    <option value="annual">Annual (12% discount)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Subscription Plan <span class="text-danger">*</span></label>
                                <select name="subscription_plan_id" class="form-control" required>
                                    <option value="">--- Select Plan ---</option>
                                    @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" {{ old('subscription_plan_id') == $plan->id ? 'selected' : '' }}>
                                        {{ $plan->name }} — {{ $plan->units_min }}{{ $plan->units_max ? '-'.$plan->units_max : '+' }} units @ KES {{ number_format($plan->price_per_unit) }}/unit/month
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="alert alert-info mb-0">
                                <strong>Note:</strong> Plan is determined by number of units. The selected plan above will be used for billing.
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


