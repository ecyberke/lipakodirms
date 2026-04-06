@extends('tenant.layouts.master')
@section('title', 'My Invoices')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tenant-invoices-table">
                        <thead>
                            <tr>
                                <th style="width:4%">#</th>
                                <th style="width:13%">INV #</th>
                                <th style="width:15%">Month</th>
                                <th style="width:10%">Rent</th>
                                <th style="width:10%">Bills</th>
                                <th style="width:12%">Total Payable</th>
                                <th style="width:10%">Paid In</th>
                                <th style="width:10%">Balance</th>
                                <th style="width:5%">Status</th>
                                <th style="width:8%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @forelse($invoices as $inv)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>INV #{{ $inv->id }}</td>
                            <td>{{ $inv->rent_month }}</td>
                            <td>{{ $org->currency ?? 'KES' }} {{ number_format($inv->rent ?? 0) }}</td>
                            <td>{{ $org->currency ?? 'KES' }} {{ number_format($inv->bills ?? 0) }}</td>
                            <td><strong>{{ $org->currency ?? 'KES' }} {{ number_format($inv->total_payable ?? 0) }}</strong></td>
                            <td class="text-success">{{ $org->currency ?? 'KES' }} {{ number_format($inv->paid_in ?? 0) }}</td>
                            <td class="{{ ($inv->balance ?? 0) > 0 ? 'text-danger font-weight-bold' : 'text-success' }}">
                                {{ $org->currency ?? 'KES' }} {{ number_format($inv->balance ?? 0) }}
                            </td>
                            <td>
                                @if(($inv->balance ?? 0) <= 0)
                                    <span class="badge badge-success">Paid</span>
                                @else
                                    <span class="badge badge-danger">Unpaid</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-item">
                                                <a class="btn btn-sm btn-info btn-block" href="{{ route('tenant.invoice.show', $inv->id) }}"> View</a>
                                            </div>
                                            @if(($inv->balance ?? 0) > 0)
                                            <div class="dropdown-item">
                                                <a class="btn btn-sm btn-success btn-block" href="#"
                                                    data-toggle="modal" data-target="#stkModal{{ $inv->id }}"> Pay Now</a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="10" class="text-center text-muted">No invoices found</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- STK Push Modals --}}
@foreach($invoices as $inv)
@if(($inv->balance ?? 0) > 0)
<div class="modal fade" id="stkModal{{ $inv->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-mobile text-primary"></i>
                    INV #{{ $inv->id }} — {{ $inv->rent_month }} Payment
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ route('mpesa.stk.push', $inv->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img src="https://www.safaricom.co.ke/images/Lipanampesa.png" alt="M-PESA" style="height:70px;width:auto;">
                    </div>
                    <div class="form-group">
                        <label>Amount to Pay <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon">{{ $org->currency ?? 'KES' }}</span>
                            <input type="number" class="form-control form-control-lg"
                                name="amount" value="{{ $inv->balance }}"
                                min="1" max="{{ $inv->balance }}" step="1" required>
                        </div>
                        <small class="text-muted">Balance: {{ $org->currency ?? 'KES' }} {{ number_format($inv->balance) }}</small>
                    </div>
                    <div class="form-group">
                        <label>M-PESA Phone Number <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fe fe-phone"></i></span>
                            <input type="text" class="form-control"
                                name="phone" value="{{ $tenant->phone }}"
                                placeholder="e.g. 0712345678" required>
                        </div>
                    </div>
                    <div class="bg-light p-3 rounded">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Month:</span><strong>{{ $inv->rent_month }}</strong>
                        </div>
                        <div class="d-flex justify-content-between pt-2" style="border-top:1px solid #dee2e6;">
                            <span class="font-weight-bold">Balance Due:</span>
                            <span class="font-weight-bold text-danger">{{ $org->currency ?? 'KES' }} {{ number_format($inv->balance) }}</span>
                        </div>
                    </div>
                    <div class="alert alert-info p-2 mt-3 mb-0">
                        <i class="fe fe-info"></i>
                        <small>You will receive an M-Pesa prompt. Enter your PIN to complete payment.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fe fe-smartphone"></i> Send M-Pesa Prompt
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection

@section('scripts')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script>
$(function() {
    $('#tenant-invoices-table').DataTable({
        responsive: true,
        "pageLength": 25,
        "order": [[2, "desc"]],
        "columnDefs": [{"orderable": false, "targets": [9]}]
    });
});
</script>
@endsection
