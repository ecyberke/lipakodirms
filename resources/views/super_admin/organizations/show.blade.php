@extends('super_admin.layouts.master')
@section('title', $org->name)
@section('page-title', $org->name)

@section('content')
<div class="row g-4">
    <div class="col-md-8">
        <!-- Details -->
        <div class="table-card mb-4">
            <div class="d-flex justify-content-between mb-3">
                <h6><i class="fas fa-building"></i> Organization Details</h6>
                <div class="d-flex gap-2">
                    <a href="{{ route('super.organizations.edit', $org->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    @if($org->status === 'active')
                        <form method="POST" action="{{ route('super.organizations.suspend', $org->id) }}">
                            @csrf
                            <button class="btn btn-sm btn-warning" onclick="return confirm('Suspend?')">Suspend</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('super.organizations.activate', $org->id) }}">
                            @csrf
                            <button class="btn btn-sm btn-success">Activate</button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('super.impersonate', $org->id) }}">
                        @csrf
                        <button class="btn btn-sm btn-dark"><i class="fas fa-user-secret"></i> Login As</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><strong>Subdomain:</strong><br><code>{{ $org->slug }}.lipakodi.co.ke</code></div>
                <div class="col-6"><strong>Status:</strong><br><span class="org-status status-{{ $org->status }}">{{ ucfirst($org->status) }}</span></div>
                <div class="col-6 mt-3"><strong>Type:</strong><br>{{ ucfirst($org->type) }}</div>
                <div class="col-6 mt-3"><strong>Total Units:</strong><br>{{ $org->total_units }}</div>
                <div class="col-6 mt-3"><strong>Phone:</strong><br>{{ $org->phone }}</div>
                <div class="col-6 mt-3"><strong>Email:</strong><br>{{ $org->email }}</div>
                <div class="col-6 mt-3"><strong>KRA PIN:</strong><br>{{ $org->kra_pin ?? 'N/A' }}</div>
                <div class="col-6 mt-3"><strong>County/Town:</strong><br>{{ $org->county }}, {{ $org->town }}</div>
                <div class="col-6 mt-3"><strong>Currency:</strong><br>{{ $org->currency }}</div>
                <div class="col-6 mt-3"><strong>Current Plan:</strong><br>{{ $plan->name ?? 'N/A' }} @ KES {{ number_format($plan->price_per_unit ?? 0) }}/unit</div>
            </div>
        </div>

        <!-- Subscriptions -->
        <div class="table-card mb-4">
            <h6 class="mb-3"><i class="fas fa-file-invoice"></i> Subscription History</h6>
            <table class="table table-sm">
                <thead><tr><th>Cycle</th><th>Amount</th><th>Units</th><th>Start</th><th>End</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($subscriptions as $sub)
                    <tr>
                        <td>{{ ucfirst(str_replace('_', ' ', $sub->billing_cycle)) }}</td>
                        <td>KES {{ number_format($sub->amount) }}</td>
                        <td>{{ $sub->units }}</td>
                        <td>{{ $sub->starts_at->format('d M Y') }}</td>
                        <td>{{ $sub->ends_at->format('d M Y') }}</td>
                        <td><span class="org-status status-{{ $sub->status }}">{{ ucfirst($sub->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">No subscriptions</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Users -->
        <div class="table-card">
            <h6 class="mb-3"><i class="fas fa-users"></i> Admin Users</h6>
            <table class="table table-sm">
                <thead><tr><th>Name</th><th>Email</th><th>Role</th></tr></thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->is_admin ? 'Admin' : 'Staff' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- API Integrations sidebar -->
    <div class="col-md-4">
        <div class="table-card mb-4">
            <h6 class="mb-3"><i class="fas fa-cog"></i> Configuration</h6>
            <form method="POST" action="{{ route('super.organizations.update', $org->id) }}">
                @csrf @method('PUT')
                {{-- BULK SMS --}}
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-muted small mb-0">BULK SMS</h6>
                    @if($org->sms_api_token)
                        <span class="badge badge-success"><i class="fe fe-check"></i> Active</span>
                    @else
                        <span class="badge badge-secondary">Not Configured</span>
                    @endif
                </div>
                <div class="mb-2">
                    <label class="small text-muted">Sender ID</label>
                    <input type="text" name="sms_sender_id" class="form-control form-control-sm" 
                        placeholder="e.g. SaliSystems" value="{{ $org->sms_sender_id }}">
                </div>
                <div class="mb-2">
                    <label class="small text-muted">Admin Phone</label>
                    <input type="text" name="sms_admin_phone" class="form-control form-control-sm" 
                        placeholder="e.g. 254700000000" value="{{ $org->sms_admin_phone }}">
                </div>
                <div class="mb-3">
                    <label class="small text-muted">API Key</label>
                    <input type="text" name="sms_api_token" class="form-control form-control-sm" 
                        placeholder="Bearer Token" value="{{ $org->sms_api_token }}">
                </div>

                {{-- M-PESA --}}
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="text-muted small mb-0">M-PESA</h6>
                    @if($org->mpesa_consumer_key && $org->mpesa_consumer_secret && $org->mpesa_shortcode && $org->mpesa_passkey)
                        <span class="badge badge-success"><i class="fe fe-check"></i> Active</span>
                    @else
                        <span class="badge badge-secondary">Not Configured</span>
                    @endif
                </div>
                <div class="mb-2">
                    <label class="small text-muted">Shortcode</label>
                    <input type="text" name="mpesa_shortcode" class="form-control form-control-sm" 
                        placeholder="Shortcode/Till" value="{{ $org->mpesa_shortcode }}">
                </div>
                <div class="mb-2">
                    <label class="small text-muted">Consumer Key</label>
                    <input type="text" name="mpesa_consumer_key" class="form-control form-control-sm" 
                        placeholder="Consumer Key" value="{{ $org->mpesa_consumer_key }}">
                </div>
                <div class="mb-2">
                    <label class="small text-muted">Consumer Secret</label>
                    <input type="text" name="mpesa_consumer_secret" class="form-control form-control-sm" 
                        placeholder="Consumer Secret" value="{{ $org->mpesa_consumer_secret }}">
                </div>
                <div class="mb-2">
                    <label class="small text-muted">Pass Key</label>
                    <input type="text" name="mpesa_passkey" class="form-control form-control-sm" 
                        placeholder="Passkey" value="{{ $org->mpesa_passkey }}">
                </div>

                <h6 class="text-muted small">Bank</h6>
                <div class="mb-2"><input type="text" name="bank_name" class="form-control form-control-sm" placeholder="Bank Name" value="{{ $org->bank_name }}"></div>
                <div class="mb-2"><input type="text" name="bank_account" class="form-control form-control-sm" placeholder="Account Number" value="{{ $org->bank_account }}"></div>
                <div class="mb-3"><input type="text" name="bank_branch" class="form-control form-control-sm" placeholder="Branch" value="{{ $org->bank_branch }}"></div>
                <h6 class="text-muted small">WhatsApp</h6>
                <div class="mb-2"><input type="text" name="whatsapp_token" class="form-control form-control-sm" placeholder="API Token" value="{{ $org->whatsapp_token }}"></div>
                <div class="mb-3"><input type="text" name="whatsapp_phone_id" class="form-control form-control-sm" placeholder="Phone ID" value="{{ $org->whatsapp_phone_id }}"></div>
                <h6 class="text-muted small">Email SMTP</h6>
                <div class="mb-2"><input type="text" name="smtp_host" class="form-control form-control-sm" placeholder="SMTP Host" value="{{ $org->smtp_host }}"></div>
                <div class="mb-2"><input type="text" name="smtp_port" class="form-control form-control-sm" placeholder="Port" value="{{ $org->smtp_port }}"></div>
                <div class="mb-2"><input type="text" name="smtp_username" class="form-control form-control-sm" placeholder="Username" value="{{ $org->smtp_username }}"></div>
                <div class="mb-2"><input type="password" name="smtp_password" class="form-control form-control-sm" placeholder="Password" value="{{ $org->smtp_password }}"></div>
                <div class="mb-2"><input type="text" name="smtp_from_email" class="form-control form-control-sm" placeholder="From Email" value="{{ $org->smtp_from_email }}"></div>
                <div class="mb-3"><input type="text" name="smtp_from_name" class="form-control form-control-sm" placeholder="From Name" value="{{ $org->smtp_from_name }}"></div>
                <button type="submit" class="btn btn-primary btn-sm w-100">Save Integrations</button>
            </form>
        </div>
    </div>
</div>
@endsection
