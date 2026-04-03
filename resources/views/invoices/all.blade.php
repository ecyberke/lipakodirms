@extends('layouts.home')

@push('header_scripts')
<!-- DataTables -->
<link href="{{ asset('plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="">Invoices</h4>

            </div>

        </div>
    </div>
    <!-- /Page Header -->


    <div class="row">
        
        <div class="col-md-11">
            @include('includes.messages')
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0" id="invoices-table">
                            <thead>
                                <tr>
                                    <th>Listing Number</th>
                                    <th>Billings For</th>                                   
                                    <th>View Invoices</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- /Page Content -->

</div>
@endsection

@push('footer_scripts')

<!-- Required datatable js -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Responsive examples -->
<script src="{{ asset('plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

<script>
    $(function () {
        $('#invoices-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('api.invoice.list') !!}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'rent_month', name: 'rent_month' },               
                { data: 'view', name: 'view', orderable: false, searchable: false },
                // { data: 'delete', name: 'delete', orderable: false, searchable: false },
            ]
        });
    });


</script>
@endpush