@extends('super_admin.layouts.master')
@section('title', 'Invoices')
@section('page-title', 'All Invoices')

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
                    <h3 class="card-title">All Invoices</h3>
                    <div class="card-options">
                        <a href="{{ route('super.invoices.create') }}" class="btn btn-sm btn-primary">
                            <i class="fe fe-plus"></i> Add Invoice
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @include('includes.messages')
                    <table id="inv-table" class="table table-striped custom-table mb-0 dt-responsive nowrap" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="width:2%">#</th>
                                <th>Invoice No.</th>
                                <th>Organization</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th style="width:5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @forelse($invoices as $inv)
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
                            <td>
                                @if($inv->status === 'paid')
                                    <span class="badge badge-success">PAID</span>
                                @elseif($inv->status === 'partial')
                                    <span class="badge badge-warning">PARTIAL</span>
                                @elseif($inv->status === 'overpayment')
                                    <span class="badge" style="background-color:#6f42c1;color:#fff;">OVERPAYMENT</span>
                                @elseif($inv->status === 'cancelled')
                                    <span class="badge badge-secondary">CANCELLED</span>
                                @else
                                    <span class="badge badge-danger">UNPAID</span>
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
                                                <a class="btn btn-sm btn-info btn-block"
                                                    href="{{ route('super.invoices.show', $inv->id) }}"> View</a>
                                            </div>
                                            <div class="dropdown-item">
                                                <a class="btn btn-sm btn-success btn-block"
                                                    href="{{ route('super.invoices.edit', $inv->id) }}"> Edit</a>
                                            </div>
                                            <div class="dropdown-item">
                                                <form class="delete-invoice" method="POST"
                                                    action="{{ route('super.invoices.destroy', $inv->id) }}">
                                                    @csrf @method('DELETE')
                                                    <input class="btn btn-sm btn-danger btn-block"
                                                        type="submit" value="Delete">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center text-muted">No invoices found</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $invoices->links() }}
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
$(function() {
    $('#inv-table').DataTable({ responsive: true, pageLength: 25, order: [[0, 'desc']], paging: false });
    $(document).on('submit', '.delete-invoice', function() {
        return confirm('Are you sure you want to delete this invoice? This cannot be reversed.');
    });
});
</script>
@endsection
