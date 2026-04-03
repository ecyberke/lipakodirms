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

    <div class="row ">
        <div class="col-sm-6">
            {{-- <h4 class="page-title">All Active Deposits Made By Current Tenants</h4> --}}
        </div>
    </div>

    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    @include('includes.messages')
                    <h4 class="mt-0 header-title"></h4>
                    </p>

                    <table id="deposits-table" class="table table-striped custom-table mb-0"
                        >
                        <thead>
                              <tr>
                                    <th style="width: 8%; ">#</th>
                                    <!--<th>Tenant</th>-->
                                    <th>Amount</th>
                                    <th>Paid on</th>
                                    
                                    <th>House</th>
                                    <th>Apartment</th>                                   
                                    <th style="width:5%; ">Actions</th>   
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
       $('#deposits-table').DataTable({
           processing: true,
           serverSide: true,
           ajax: '{!! route('api.deposits.list') !!}',
           columns: [
               { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false},
                //{ data: 'tenant', name: 'tenant' },
               { data: 'amount', name: 'amount' },
               { data: 'start_month', name: 'start_month' },
              
               { data: 'house.house_no', name: 'house.house_no' },
               { data: 'apartment', name: 'apartment' },
               { data: 'actions', name: 'actions',orderable:false,searchable:false },
             
                      
]
       });

       $(document).on('submit','.delete-deposit',function(event){
            return confirm('Are you sure you want to delete this deposit ? The action cannot be reversed');            
        });
   });
</script>
<!-- Datatable init js -->
{{-- <script src="assets/pages/datatables.init.js"></script> --}}
@endpush