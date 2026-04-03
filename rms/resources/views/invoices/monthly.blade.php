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
    <div class="page-header mb-3">
        <div class="row align-items-center">
            <div class="col">
            <h3 class="page-title">Individual Invoices for month : <u>{{ $month}}</u> </h3>
            </div>

            <input type="hidden" data-fetch-route="" id="invoicesFetch">

        </div>
    </div>
    <!-- /Page Header -->

    

    


    <div class="row">
        <div class="col-12">
            <div class="card">

                @include('includes.messages')
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0" id="invoices-table">
                            <thead>
                                <tr>
                                    <th style="width:5%">#</th>
                                    <th>House</th>
                                    <th>Tenant</th>
                                    <th>Rent</th>
                                    <th>Monthly Bills</th>
                                    {{-- <th>Carry Forward</th> --}}
                                    <th style="width:5%">Penalty</th>
                                    <th>Total Payable</th>                                    
                                    <th>Paid In</th>                                    
                                    <th>Balance</th>                                    
                                    <th style="width:5%">Status</th>  
                                    <th style="width:2%">--</th>                                 
                                    {{-- <th style="width:2%"> -- </th>                                  --}}
                                    
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

<a href="#" class="btn btn-sm btn-primary">PAY NOW</a>

<script>
    $(function() {           
            
      var $data_route= $("#invoicesFetch").attr('data-fetch-route');  

       
             $('#invoices-table').DataTable({
                 processing: true,
                 serverSide: true,
                 ajax: $data_route,
                 columns: [            
                     { data: 'id', name: 'id' },
                     { data: 'house.house_no', name: 'house.house_no', orderable: false },
                     { data: 'tenant.full_name', name: 'tenant.full_name',orderable: false },
                     { data: 'rent', name: 'rent' },
                     { data: 'bills', name: 'bills' },
                    //  { data: 'carryforward', name: 'carryforward', orderable: false, searchable: false },                     
                     { data: 'penalty_fee', name: 'penalty_fee', orderable: false, searchable: false },
                     { data: 'total_payable', name: 'total_payable', orderable: false, searchable: false },
                     { data: 'paid_in', name: 'paid_in', orderable: false, searchable: false },
                     { data: 'balance', name: 'balance', orderable: false, searchable: false },
                     { data: 'is_paid', name: 'is_paid', searchable: false  },                  
                     { data: 'download', name: 'download', searchable: false , orderable: false },                  
                   // { data: 'delete', name: 'delete', searchable: false , orderable: false },                  
                             ]
             });

             $(document).on('submit','.delete-overpayment',function(event){
            return confirm('Are you sure you want to delete this Invoice ? The action cannot be reversed');            
        });
         });


</script>
@endpush