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

                    <table id="tenants-table" class="table table-striped custom-table mb-0 ">
                        <thead>
                            <tr>
                                {{--<th style="width:10%">#</th>--}}
                                <th>Tenant Name</th>
                                <th>Phone Number</th>
                                <th>Message</th>
                                <th>Date</th>
                                
                                {{-- <th style="width:5%">Statement</th>  --}}
                                
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
{{-- <script>
    $(function () {
        $('#tenants-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('tenants.report') !!}',
            columns: [
                        
                { data: 'full_name', name: 'full_name' },
                { data: 'id', name: 'id', },
                { data: 'name', name: 'name' },
                { data: 'house_no', name: 'house_no' },
               { data: 'actions', name: 'actions', orderable: false, searchable: false },

            ]
        });

        $(document).on('submit','.delete-tenant',function(event){
            return confirm('Are you sure you want to delete this tenant ? The action cannot be reversed ');            
        });
    });
</script> --}}
<!-- Datatable init js -->
{{-- <script src="assets/pages/datatables.init.js"></script> --}}
@endpush