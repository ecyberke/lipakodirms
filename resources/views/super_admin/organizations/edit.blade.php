@extends('super_admin.layouts.master')
@section('title', 'Edit Organization')
@section('page-title', 'Edit Organization')

@section('css')
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <form method="POST" action="{{ route('super.organizations.update', $org->id) }}">
                @csrf @method('PUT')
                <div class="row">
                    {{-- Organization Details --}}
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><i class="fe fe-briefcase mr-1"></i> Organization Details</h4>
                            </div>
                            <div class="card-body">
                                @include('includes.messages')
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Organization Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name', $org->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Subdomain Slug <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" name="slug" class="form-control"
                                                    value="{{ old('slug', $org->slug) }}" required pattern="[a-z0-9\-]+">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.lipakodi.co.ke</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Type <span class="text-danger">*</span></label>
                                            <select name="type" class="form-control" required>
                                                <option value="agency" {{ $org->type === 'agency' ? 'selected' : '' }}>Agency</option>
                                                <option value="individual" {{ $org->type === 'individual' ? 'selected' : '' }}>Individual</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Currency</label>
                                            <select name="currency" class="form-control">
                                                <option value="KES" {{ $org->currency === 'KES' ? 'selected' : '' }}>KES</option>
                                                <option value="UGX" {{ $org->currency === 'UGX' ? 'selected' : '' }}>UGX</option>
                                                <option value="TZS" {{ $org->currency === 'TZS' ? 'selected' : '' }}>TZS</option>
                                                <option value="USD" {{ $org->currency === 'USD' ? 'selected' : '' }}>USD</option>
                                                <option value="GBP" {{ $org->currency === 'GBP' ? 'selected' : '' }}>GBP</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Contact Person</label>
                                            <input type="text" name="contact_person" class="form-control"
                                                value="{{ old('contact_person', $org->contact_person) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Phone <span class="text-danger">*</span></label>
                                            <input type="text" name="phone" class="form-control"
                                                value="{{ old('phone', $org->phone) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email', $org->email) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>KRA PIN</label>
                                            <input type="text" name="kra_pin" class="form-control"
                                                value="{{ old('kra_pin', $org->kra_pin) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Number of Units</label>
                                            <input type="number" name="total_units" class="form-control"
                                                value="{{ old('total_units', $org->total_units) }}" min="1">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>County</label>
                                            <input type="text" name="county" class="form-control"
                                                value="{{ old('county', $org->county) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Town</label>
                                            <input type="text" name="town" class="form-control"
                                                value="{{ old('town', $org->town) }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control">
                                                <option value="active" {{ $org->status === 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="suspended" {{ $org->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                                                <option value="pending" {{ $org->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="cancelled" {{ $org->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="col-md-6">
                        {{-- Admin Password --}}
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="card-title"><i class="fe fe-lock mr-1"></i> Change Admin Password</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>New Password <small class="text-muted">(leave blank to keep current)</small></label>
                                    <input type="password" name="admin_password" class="form-control"
                                        placeholder="Leave blank to keep current password">
                                </div>
                            </div>
                        </div>

                        {{-- Account Patterns --}}
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="card-title"><i class="fe fe-hash mr-1"></i> Account Number Patterns</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Tenant</label>
                                            <input type="text" name="tenant_account_prefix" class="form-control"
                                                value="{{ old('tenant_account_prefix', $org->tenant_account_prefix) }}" maxlength="5">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Landlord</label>
                                            <input type="text" name="landlord_account_prefix" class="form-control"
                                                value="{{ old('landlord_account_prefix', $org->landlord_account_prefix) }}" maxlength="5">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Property</label>
                                            <input type="text" name="property_account_prefix" class="form-control"
                                                value="{{ old('property_account_prefix', $org->property_account_prefix) }}" maxlength="5">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Subscription --}}
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"><i class="fe fe-credit-card mr-1"></i> Subscription</h4>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info mb-0">
                                    <strong>Pricing Tiers:</strong><br>
                                    @foreach($plans as $plan)
                                        <small>{{ $plan->name }}: {{ $plan->units_min }}{{ $plan->units_max ? '-'.$plan->units_max : '+' }} units @ KES {{ number_format($plan->price_per_unit) }}/unit/month</small><br>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3 mb-4">
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-success waves-effect waves-light">
                            <i class="fe fe-save"></i> Update Organization
                        </button>
                        <a href="{{ route('super.organizations.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
@endsection
