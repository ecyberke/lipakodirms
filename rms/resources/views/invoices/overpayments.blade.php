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
                <h3 class="page-title">Tenants With Overpayments</h3>

            </div>

        </div>
    </div>
    <!-- /Page Header -->


    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0" id="invoices-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tenant Names</th>                                   
                                    <th>Amount</th>
                                    <th>Created On</th>
                                    <th>Last Updated</th> 
                                    <th></th>                                   
                                    <th></th>                                   
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
            ajax: '{!! route('api.invoice.overpayment') !!}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'tenant.full_name', name: 'tenant.full_name' },               
                { data: 'amount', name: 'amount', orderable: false, searchable: false },
                { data: 'created_at', name: 'created_at', orderable: false, searchable: false },
                { data: 'updated_at', name: 'updated_at', orderable: false, searchable: false },
                { data: 'edit', name: 'edit', orderable: false, searchable: false },
                { data: 'delete', name: 'delete', orderable: false, searchable: false },
            
            ]
        });

         $(document).on('submit','.delete-overpayment',function(event){
            return confirm('Are you sure you want to delete this Overpayment ? The action cannot be reversed');            
        });
    });


</script>
@endpush