@extends('super_admin.layouts.master')
@section('title', 'Pay Invoice')
@section('page-title', 'Pay Invoice')

@section('css')
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="content container-fluid">
    <div class="row">
        {{-- Record Payment --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Record Payment</h4>
                </div>
                <div class="card-body">
                    @include('includes.messages')
                    <form action="{{ route('super.invoices.record-payment') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Select Invoice <span class="text-danger">*</span></label>
                            <select name="invoice_id" class="form-control select2-show-search" required>
                                <option value="">--- Select Unpaid Invoice ---</option>
                                @foreach($unpaidInvoices as $inv)
                                <option value="{{ $inv->id }}" {{ request('invoice_id') == $inv->id ? 'selected' : '' }}>
                                    {{ $inv->invoice_number }} - {{ $inv->org_name }} - KES {{ number_format($inv->amount) }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Payment Method <span class="text-danger">*</span></label>
                            <select name="payment_method" class="form-control" required>
                                <option value="">--- Select ---</option>
                                <option value="mpesa">M-Pesa</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="cash">Cash</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Transaction Reference <span class="text-danger">*</span></label>
                            <input type="text" name="payment_reference" class="form-control"
                                placeholder="e.g. QGH7K2L3M4" required>
                        </div>
                        <button type="submit" class="btn btn-success waves-effect waves-light">
                            Record Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Add SMS Credits --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Purchase SMS Credits</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('super.invoices.sms-credits') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Organization <span class="text-danger">*</span></label>
                            <select name="organization_id" class="form-control select2-show-search" required>
                                <option value="">--- Select Organization ---</option>
                                @foreach($unpaidInvoices->pluck('org_name', 'organization_id')->unique() as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Amount (KES) <span class="text-danger">*</span></label>
                            <input type="number" name="amount" class="form-control"
                                placeholder="e.g. 1000" min="1" required>
                        </div>
                        <div class="form-group">
                            <label>Payment Method <span class="text-danger">*</span></label>
                            <select name="payment_method" class="form-control" required>
                                <option value="">--- Select ---</option>
                                <option value="mpesa">M-Pesa</option>
                                <option value="bank">Bank Transfer</option>
                                <option value="cash">Cash</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Transaction Reference <span class="text-danger">*</span></label>
                            <input type="text" name="payment_reference" class="form-control"
                                placeholder="e.g. QGH7K2L3M4" required>
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                            Add SMS Credits
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Unpaid Invoices Table --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Unpaid Invoices</h3>
                </div>
                <div class="card-body">
                    <table id="unpaid-table" class="table table-striped custom-table mb-0" style="width:100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice No.</th>
                                <th>Organization</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @forelse($unpaidInvoices as $inv)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td><strong>{{ $inv->invoice_number }}</strong></td>
                            <td>{{ $inv->org_name }}</td>
                            <td>
                                @if($inv->type === 'sms_credits')
                                    <span class="badge badge-info">SMS Credits</span>
                                @else
                                    <span class="badge badge-primary">Subscription</span>
                                @endif
                            </td>
                            <td>KES {{ number_format($inv->amount) }}</td>
                            <td>{{ \Carbon\Carbon::parse($inv->due_date)->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">No unpaid invoices</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script>
$(function() { $('#unpaid-table').DataTable({ pageLength: 25 }); });
</script>
@endsection
