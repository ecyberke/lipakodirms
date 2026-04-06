@extends('super_admin.layouts.master')
@section('title', 'Payments')
@section('page-title', 'List Payments')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payment History</h3>
                    <div class="card-options">
                        <a href="{{ route('super.invoices.pay') }}" class="btn btn-sm btn-primary">
                            <i class="fe fe-plus"></i> Record Payment
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @include('includes.messages')
                    <table id="pay-table" class="table table-striped custom-table mb-0 dt-responsive nowrap" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="width:2%">#</th>
                                <th>Invoice No.</th>
                                <th>Organization</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Reference</th>
                                <th>Paid On</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @forelse($payments as $pay)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td><strong>{{ $pay->invoice_number }}</strong></td>
                            <td>{{ $pay->org_name }}</td>
                            <td>
                                @if($pay->type === 'sms_credits')
                                    <span class="badge badge-info">SMS Credits</span>
                                @else
                                    <span class="badge badge-primary">Subscription</span>
                                @endif
                            </td>
                            <td>KES {{ number_format($pay->amount) }}</td>
                            <td>{{ ucfirst($pay->payment_method) }}</td>
                            <td>{{ $pay->payment_reference }}</td>
                            <td>{{ \Carbon\Carbon::parse($pay->paid_at)->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center text-muted">No payments found</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $payments->links() }}
                </div>
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
$(function() { $('#pay-table').DataTable({ responsive: true, pageLength: 25, paging: false }); });
</script>
@endsection
