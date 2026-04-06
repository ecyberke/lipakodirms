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
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-primary"
                                data-toggle="modal" data-target="#importModal"
                                title="Import Payments">
                                <i class="fe fe-upload"></i>
                                <span class="d-none d-md-inline ml-1">Import Payments</span>
                            </button>
                            <a href="{{ route('super.invoices.pay') }}" class="btn btn-success"
                                title="Record Payment">
                                <i class="fe fe-plus"></i>
                                <span class="d-none d-md-inline ml-1">Record Payment</span>
                            </a>
                        </div>
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
                                <th style="width:5%">Action</th>
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
                            <td>
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-item">
                                            <a class="btn btn-sm btn-info btn-block" href="#">View</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="9" class="text-center text-muted">No payments found</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Import Modal --}}
<div class="modal fade" id="importModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fe fe-upload mr-2"></i> Import M-Pesa Payments</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="importForm" action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fe fe-info mr-2"></i>
                        Import M-Pesa payments from CSV file.
                        <small class="d-block mt-1">
                            <strong>Required columns:</strong> Receipt No., Paid In, Completion Time, A/C No.
                        </small>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">M-Pesa Statement File *</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="import_file"
                                name="import_file" accept=".csv" required>
                            <label class="custom-file-label" for="import_file">Choose M-Pesa statement CSV file...</label>
                        </div>
                        <small class="text-muted">Maximum file size: 10MB. Format: CSV</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fe fe-upload mr-1"></i> Import Payments
                    </button>
                </div>
            </form>
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
    $('#pay-table').DataTable({ responsive: true, pageLength: 25, order: [[0, 'desc']], paging: false });
    $('#import_file').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').text(fileName);
    });
});
</script>
@endsection
