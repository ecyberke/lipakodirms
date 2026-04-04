@extends('tenant.layouts.master')
@section('title', 'Dashboard')

@section('content')
@if(!isset($tenant) || !$tenant)
    <div class="alert alert-warning">Your tenant profile is not yet linked. Please contact management.</div>
@else

{{-- Top bar: Balance + STK Push button --}}
<div class="row mb-3" style="margin-top:10px;">
    <div class="col-9">
        <div class="card mb-0" style="border-left: 4px solid {{ $totalBalance > 0 ? '#dc3545' : '#28a745' }};">
            <div class="card-body py-2 px-3">
                <small class="text-muted d-block">Current Rent Balance</small>
                <span class="font-weight-bold {{ $totalBalance > 0 ? 'text-danger' : 'text-success' }}" style="font-size:1.1rem;">
                    {{ $org->currency ?? 'KES' }} {{ number_format($totalBalance) }}
                    @if($totalBalance <= 0)
                        <i class="fe fe-check-circle text-success ml-1"></i>
                    @endif
                </span>
            </div>
        </div>
    </div>
    <div class="col-3 d-flex align-items-center justify-content-end">
        @if($totalBalance > 0 && $currentInvoice)
        <button type="button" class="btn btn-sm btn-success w-100" data-toggle="modal" data-target="#stkPushModal">
            <i class="fe fe-smartphone"></i> Pay Now
        </button>
        @else
        <span class="btn btn-sm btn-outline-success w-100">
            <i class="fe fe-check"></i> All Paid
        </span>
        @endif
    </div>
</div>

@if($totalBalance > 0 && $currentInvoice)
<!-- STK PUSH MODAL -->
<div class="modal fade" id="stkPushModal" tabindex="-1" role="dialog" aria-labelledby="stkPushModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stkPushModalLabel">
                    <i class="fa fa-mobile text-primary"></i>
                    {{ $tenant->account_number }} - M-Pesa Payment
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('mpesa.stk.push', $currentInvoice->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img src="https://www.safaricom.co.ke/images/Lipanampesa.png" alt="M-PESA" style="height:80px;width:auto;">
                    </div>
                    <!-- Amount -->
                    <div class="form-group mb-3">
                        <label>Amount to Pay <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon">{{ $org->currency ?? 'KES' }}</span>
                            <input type="number" class="form-control form-control-lg"
                                id="amount" name="amount"
                                value="{{ $currentInvoice->balance }}"
                                min="1" max="{{ $currentInvoice->balance }}"
                                step="1" required>
                        </div>
                        <small class="text-muted">Balance: {{ $org->currency ?? 'KES' }} {{ number_format($currentInvoice->balance) }}</small>
                    </div>
                    <!-- Phone -->
                    <div class="form-group mb-3">
                        <label>M-PESA Phone Number <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fe fe-phone"></i></span>
                            <input type="text" class="form-control"
                                id="phone" name="phone"
                                value="{{ $tenant->phone }}"
                                placeholder="e.g. 0712345678" required>
                        </div>
                    </div>
                    <!-- Summary -->
                    <div class="bg-light p-3 rounded mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Account:</span>
                            <strong>{{ $tenant->account_number }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Month:</span>
                            <strong>{{ $currentInvoice->rent_month }}</strong>
                        </div>
                        <div class="d-flex justify-content-between pt-2" style="border-top:1px solid #dee2e6;">
                            <span class="font-weight-bold">Amount to Pay:</span>
                            <span class="font-weight-bold text-primary" id="displayAmount">{{ $org->currency ?? 'KES' }} {{ number_format($currentInvoice->balance) }}</span>
                        </div>
                    </div>
                    <div class="alert alert-info p-2 mb-0">
                        <i class="fe fe-info"></i>
                        <small>You will receive an M-Pesa prompt on your phone. Enter your PIN to complete payment.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="submitBtn">
                        <i class="fe fe-smartphone"></i> Send Prompt
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

{{-- Stat Cards --}}
<div class="row">
    <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <svg class="card-custom-icon text-danger icon-dropshadow-danger" viewBox="0 0 24 24" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                            <path d="M17.431,2.156h-3.715c-0.228,0-0.413,0.186-0.413,0.413v6.973h-2.89V6.687c0-0.229-0.186-0.413-0.413-0.413H6.285c-0.228,0-0.413,0.184-0.413,0.413v6.388H2.569c-0.227,0-0.413,0.187-0.413,0.413v3.942c0,0.228,0.186,0.413,0.413,0.413h14.862c0.228,0,0.413-0.186,0.413-0.413V2.569C17.844,2.342,17.658,2.156,17.431,2.156z"/>
                        </svg>
                        <p class="mb-1">Outstanding Balance</p>
                        <h2 class="mb-1 font-weight-bold {{ $totalBalance > 0 ? 'text-danger' : 'text-success' }}">
                            {{ $org->currency ?? 'KES' }} {{ number_format($totalBalance) }}
                        </h2>
                        <div class="progress progress-sm mt-3 bg-danger-transparent">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width: {{ $totalBalance > 0 ? '80%' : '0%' }}"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <svg class="card-custom-icon text-warning icon-dropshadow-warning" viewBox="0 0 24 24" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                            <path d="M17.431,2.156h-3.715c-0.228,0-0.413,0.186-0.413,0.413v6.973h-2.89V6.687c0-0.229-0.186-0.413-0.413-0.413H6.285c-0.228,0-0.413,0.184-0.413,0.413v6.388H2.569c-0.227,0-0.413,0.187-0.413,0.413v3.942c0,0.228,0.186,0.413,0.413,0.413h14.862c0.228,0,0.413-0.186,0.413-0.413V2.569C17.844,2.342,17.658,2.156,17.431,2.156z"/>
                        </svg>
                        <p class="mb-1">Unpaid Invoices</p>
                        <h2 class="mb-1 font-weight-bold">{{ $unpaidInvoices->count() }}</h2>
                        <div class="progress progress-sm mt-3 bg-orange-transparent">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-orange" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <svg class="card-custom-icon text-success icon-dropshadow-success" viewBox="0 0 24 24" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                            <path d="M18.121,9.88l-7.832-7.836c-0.155-0.158-0.428-0.155-0.584,0L1.842,9.913c-0.262,0.263-0.073,0.705,0.292,0.705h2.069v7.042c0,0.227,0.187,0.414,0.414,0.414h3.725c0.228,0,0.414-0.188,0.414-0.414v-3.313h2.483v3.313c0,0.227,0.187,0.414,0.413,0.414h3.726c0.229,0,0.414-0.188,0.414-0.414v-7.042h2.068h0.004C18.331,10.617,18.389,10.146,18.121,9.88z"/>
                        </svg>
                        <p class="mb-1">My Unit</p>
                        <h2 class="mb-1 font-weight-bold">{{ $assignment?->house?->house_no ?? 'N/A' }}</h2>
                        <div class="progress progress-sm mt-3 bg-success-transparent">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <svg class="card-custom-icon text-primary icon-dropshadow-primary" viewBox="0 0 24 24" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle>
                        </svg>
                        <p class="mb-1">Service Requests</p>
                        <h2 class="mb-1 font-weight-bold">{{ $serviceRequests->count() }}</h2>
                        <div class="progress progress-sm mt-3 bg-primary-transparent">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 80%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Current Invoice --}}
    <div class="col-xl-6 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Current Month Invoice</h4>
                <div class="card-options">
                    @if($currentInvoice)
                    <a href="{{ route('tenant.invoices') }}" class="btn btn-sm btn-outline-primary">View Invoice</a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if($currentInvoice)
                <table class="table table-bordered table-hover">
                    <tr><td>Month</td><td><strong>{{ $currentInvoice->rent_month }}</strong></td></tr>
                    <tr><td>Rent</td><td>{{ $org->currency ?? 'KES' }} {{ number_format($currentInvoice->rent ?? 0) }}</td></tr>
                    <tr><td>Bills</td><td>{{ $org->currency ?? 'KES' }} {{ number_format($currentInvoice->bills ?? 0) }}</td></tr>
                    <tr><td>Total Payable</td><td><strong>{{ $org->currency ?? 'KES' }} {{ number_format($currentInvoice->total_payable ?? 0) }}</strong></td></tr>
                    <tr><td>Paid</td><td class="text-success"><strong>{{ $org->currency ?? 'KES' }} {{ number_format($currentInvoice->paid_in ?? 0) }}</strong></td></tr>
                    <tr><td>Balance</td><td class="{{ ($currentInvoice->balance ?? 0) > 0 ? 'text-danger' : 'text-success' }}"><strong>{{ $org->currency ?? 'KES' }} {{ number_format($currentInvoice->balance ?? 0) }}</strong></td></tr>
                </table>
                @else
                <p class="text-muted">No invoice generated for this month yet.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- My Information --}}
    <div class="col-xl-6 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">My Information</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <tr><td>Name</td><td><strong>{{ $tenant->full_name }}</strong></td></tr>
                    <tr><td>Account No.</td><td><strong>{{ $tenant->account_number }}</strong></td></tr>
                    <tr><td>Phone</td><td>{{ $tenant->phone }}</td></tr>
                    <tr><td>Property</td><td>{{ $assignment?->house?->apartment?->name ?? $currentInvoice?->apartment_name ?? 'N/A' }}</td></tr>
                    <tr><td>Unit</td><td>{{ $assignment?->house?->house_no ?? $currentInvoice?->house_name ?? 'N/A' }}</td></tr>
                    <tr><td>Move In</td><td>{{ $assignment?->start_date ?? 'N/A' }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent Payments --}}
    <div class="col-xl-6 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Recent Payments</h4>
                <div class="card-options">
                    <a href="{{ route('tenant.payments') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead><tr><th>Date</th><th>Amount</th><th>Method</th><th>Status</th></tr></thead>
                        <tbody>
                        @forelse($recentPayments as $payment)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($payment->payment_date ?? $payment->created_at)->format('d M Y') }}</td>
                            <td><strong>{{ $org->currency ?? 'KES' }} {{ number_format($payment->TransAmount) }}</strong></td>
                            <td>{{ $payment->TransactionType ?? 'Payment' }}</td>
                            <td><span class="badge badge-success">Paid</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted">No payments recorded yet</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Service Requests --}}
    <div class="col-xl-6 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Recent Service Requests</h4>
                <div class="card-options">
                    <a href="{{ route('tenant.service-requests') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead><tr><th>Type</th><th>Date</th><th>Status</th></tr></thead>
                        <tbody>
                        @forelse($serviceRequests as $req)
                        <tr>
                            <td>{{ $req->request_type }}</td>
                            <td>{{ $req->created_at->format('d M Y') }}</td>
                            <td><span class="badge {{ $req->approval ? 'badge-success' : 'badge-warning' }}">{{ $req->approval ? 'Approved' : 'Pending' }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center text-muted">No service requests</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    // Update displayed amount as user types
    document.getElementById('amount') && document.getElementById('amount').addEventListener('input', function() {
        var val = parseFloat(this.value) || 0;
        document.getElementById('displayAmount').textContent = 'KES ' + val.toLocaleString();
        document.getElementById('submitBtn').innerHTML = '<i class="fe fe-smartphone"></i> Send Prompt KES ' + val.toLocaleString();
    });
</script>
@endsection
