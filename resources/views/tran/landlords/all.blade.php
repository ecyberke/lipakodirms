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
            <h4 class="page-title">List Of Property Owners</h4>
        </div>
    </div> --}}

    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    {{-- <h4 class="mt-0 header-title">Property Owners</h4> --}}
                    </p>

                    <table id="landlords-table" class="table table-striped custom-table mb-0"
                        >
                        <thead>
                            <tr>
                                
                               <th style="width:37%">Landlord Names</th>
                               <th>Phone</th>
                               <th>Email</th>
                              
                               <th>Owns</th>
                               
                               <th></th>
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
        $('#landlords-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('api.landlord.list') !!}',
            columns: [
                { data: 'full_name', name: 'full_name' },
                { data: 'id', name: 'id' },
                
                { data: 'email', name: 'email' },
                //{ data: 'phone_no', name: 'phone_no', orderable: false },
                { data: 'count', name: 'count', orderable: false },
                //{ data: 'view', name: 'view', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },

            ]
        });

         $(document).on('submit','.delete-landlord',function(event){
            return confirm('Are you sure you want to delete this landlord ? The action cannot be reversed ');            
        });
    });
</script>
<!-- Datatable init js -->
{{-- <script src="assets/pages/datatables.init.js"></script> --}}
@endpush