@extends('super_admin.layouts.master')
@section('title', 'Pay Invoice')
@section('page-title', 'Pay Invoice')

@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Record Payment</h4>
                </div>
                <div class="card-body">
                    @include('includes.messages')
                    <form action="{{ route('super.invoices.record-payment') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label>Organization <span class="text-danger">*</span></label>
                                <select name="org_filter" id="org_filter" class="form-control" required>
                                    <option value="">--- Select Organization ---</option>
                                    @foreach($organizations as $org)
                                    <option value="{{ $org->id }}">{{ $org->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label>Select Invoice <span class="text-danger">*</span></label>
                                <select name="invoice_id" id="invoice_select" class="form-control" required>
                                    <option value="">--- Select Organization First ---</option>
                                    @foreach($unpaidInvoices as $inv)
                                    <option value="{{ $inv->id }}"
                                        data-org="{{ $inv->organization_id }}"
                                        data-amount="{{ $inv->amount }}"
                                        data-type="{{ $inv->type }}">
                                        {{ $inv->invoice_number }} —
                                        {{ $inv->type === 'sms_credits' ? 'SMS Credits' : 'Subscription' }} —
                                        KES {{ number_format($inv->amount) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label>Amount (KES)</label>
                                <input type="text" id="inv_amount" class="form-control" readonly
                                    placeholder="Auto-filled from invoice">
                            </div>
                            <div class="col-sm-4">
                                <label>Payment Method <span class="text-danger">*</span></label>
                                <select name="payment_method" class="form-control" required>
                                    <option value="">--- Select ---</option>
                                    <option value="mpesa">M-Pesa</option>
                                    <option value="bank">Bank Transfer</option>
                                    <option value="cash">Cash</option>
                                    <option value="cheque">Cheque</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>Transaction Reference <span class="text-danger">*</span></label>
                                <input type="text" name="payment_reference" class="form-control"
                                    placeholder="e.g. QGH7K2L3M4" required>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    Record Payment
                                </button>
                                <a href="{{ route('super.invoices.list') }}" class="btn btn-secondary ml-2">Cancel</a>
                            </div>
                        </div>
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
                                <th style="width:2%">#</th>
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
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script>
$(function() {
    $('#unpaid-table').DataTable({ pageLength: 25 });

    // Filter invoices by selected organization
    $('#org_filter').on('change', function() {
        var orgId = $(this).val();
        $('#invoice_select').find('option').each(function() {
            if ($(this).val() === '') return; // keep placeholder
            if (!orgId || $(this).data('org') == orgId) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        $('#invoice_select').val('');
        $('#inv_amount').val('');
    });

    // Auto-fill amount when invoice selected
    $('#invoice_select').on('change', function() {
        var amount = $(this).find(':selected').data('amount');
        $('#inv_amount').val(amount ? 'KES ' + parseFloat(amount).toLocaleString() : '');
    });
});
</script>
@endsection
