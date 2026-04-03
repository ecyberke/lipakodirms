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
            {{-- <div class="col">
                <h4 class="">Invoices</h4>

            </div> --}}

        </div>
    </div>
    <!-- /Page Header -->


    <div class="row">
        
        <div class="col-md-12">
            @include('includes.messages')
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0" id="invoices-table">
                            <thead>
                                <tr>
                                     <th style="width:5%">#</th> 
                                     <th style="width:25%">Owners</th> 
                                    <th>Property</th>
                                    
                                    {{-- <th>House</th> --}}
                                    {{-- <th style="width:15%">Bill Month</th> --}}
                                    {{-- <th>Monthly Bills</th> --}}
                                    {{-- <th>Carry Forward</th> --}}
                                    {{-- <th style="width:5%">Penalty</th> --}}
                                    <th>Total Bill</th> 
                                    <th>Total Expenses</th>     
                                    {{-- <th>Commission</th>                                 --}}
                                    <th>Total Paid</th>                                     
                                    <th>Total Balance</th>                                     
                                    {{-- <th style="width:5%">Status</th>   --}}
                                    {{-- <th style="width:5%">Action</th>   --}}
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
             "pageLength": 25,
            ajax: '{!! route('api.payowners.totals') !!}',
            columns: [ 
               { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false},     
                    //  { data: 'id', name: 'id' },
                    { data: 'full_name', name: 'full_name',orderable: false },
                    { data: 'apartment', name: 'apartment', orderable: false },
                     
                    //{ data: 'rent_month', name: 'rent_month' },
                    //  { data: 'bills', name: 'bills' },
                    //  { data: 'carryforward', name: 'carryforward', orderable: false, searchable: false },                     
                     //{ data: 'penalty_fee', name: 'penalty_fee', orderable: false, searchable: false },
                    // { data: 'type', name: 'type', orderable: false, searchable: false },
                     { data: 'sum_bills', name: 'sum_bills', orderable: false, searchable: false },
                     { data: 'bill', name: 'bill', orderable: false, searchable: false },
                    { data: 'pay', name: 'pay', orderable: false, searchable: false },
                    { data: 'bal', name: 'bal', orderable: false, searchable: false },
                    // { data: 'pay_status', name: 'pay_status' },     
                    //  { data: 'action', name: 'action',searchable:false,orderable:false },             
                     //{ data: 'download', name: 'download', searchable: false , orderable: false },                  
                    //{ data: 'delete', name: 'delete', searchable: false , orderable: false },                  
                             ]
        });
         $(document).on('submit','.delete-overpayment',function(event){
            return confirm('Are you sure you want to delete this Invoice ? The action cannot be reversed');            
        });
        
    });


</script>
@endpush