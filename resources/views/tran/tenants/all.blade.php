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

    {{-- <div class="row ">
        <div class="col-sm-6">
            <h4 class="page-title">List Of Tenants</h4>
        </div>
    </div> --}}

    @include('includes.messages')

    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    {{-- <h4 class="mt-0 header-title">Tenants List</h4>
                    </p> --}}

                    <table id="tenants-table" class="table table-striped custom-table mb-0">
                        <thead>
                            <tr>
                                {{--<th style="width:10%">#</th>--}}
                                <th style="width:30%">Account No.</th>
                                <th style="width:30%">Tenant Name</th>
                                <th style="width:20%">Phone Number</th>
                                <!--<th style="width:30%">Status</th>-->
                                <th style="width:5%">Action</th>
                                
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

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
        $('#tenants-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('tenants.list') !!}',
            columns: [
                { data: 'account_number', name: 'account_number' },      
                { data: 'full_name', name: 'full_name' },
                { data: 'id', name: 'id', },
                // { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },

            ]
        });

        $(document).on('submit','.delete-tenant',function(event){
            return confirm('Are you sure you want to delete this tenant ? The tenant might be occupying a house and may break the system. This action is irreversable!!! ');            
        });
    });
</script>
<!-- Datatable init js -->
{{-- <script src="assets/pages/datatables.init.js"></script> --}}
@endpush