@extends('tenant.layouts.master')
@section('title', 'My Payments')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        @include('includes.messages')
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0" id="payments-table">
                        <thead>
                            <tr>
                                <th style="width:3%">#</th>
                                <th style="width:20%">Name</th>
                                <th style="width:15%">Account No.</th>
                                <th style="width:12%">Payment Method</th>
                                <th style="width:18%">Transaction Code</th>
                                <th style="width:12%">Amount</th>
                                <th style="width:15%">Date</th>
                                <th class="text-right" style="width:5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @forelse($payments as $pay)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $pay->full_name }}</td>
                            <td>{{ $pay->InvoiceNumber }}</td>
                            <td>{{ $pay->TransactionType }}</td>
                            <td>{{ $pay->TransID }}</td>
                            <td class="text-success font-weight-bold">
                                {{ $org->currency ?? 'KES' }} {{ number_format($pay->TransAmount) }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($pay->payment_date ?? $pay->created_at)->format('d M Y') }}</td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-item">
                                            <a class="btn btn-sm btn-success btn-block"
                                                href="{{ route('tenant.receipt', $pay->id) }}">
                                                Download Receipt
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center text-muted">No payments recorded yet</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script>
$(function() {
    $('#payments-table').DataTable({
        responsive: true,
        "pageLength": 25,
        "order": [[6, "desc"]],
        "columnDefs": [{"orderable": false, "targets": [7]}]
    });
});
</script>
@endsection
