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
            <h4 class="page-title">All Individual Houses</h4>
        </div>
    </div> --}}

    @include('includes.messages')

    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="mt-0 header-title">All Houses</h4>
                    </p> --}}
                    {{-- <div class="row py-3">
                        <div class="col-1 align-end">
                            <a class="btn btn-danger btn-sm" href="{{ route('house.vacant')}}">Vacant</a>
                        </div>&nbsp;&nbsp;&nbsp;
                        <div class="">
                            <a class="btn btn-success btn-sm " href="{{ route('house.occupied')}}">Occupied</a>
                        </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <div class="">
                            <a class="btn btn-secondary btn-sm" href="{{ route('house.unpaid')}}">Unpaid</a>
                        </div>
                        
                    </div> --}}
                    


                    
                    <table id="servicerequest-table" class="table table-striped custom-table mb-0">
                        
                        <thead>
                           
                              <tr>
                                     <th style="width:10%">#</th>
                                     <th>Owner Name</th>
                                    <th>Property</th>
                                    <th style="width:10%">House No</th>
                                    
                                    <th>Amount Paid</th>                                           
                                   
                                     <th>Payment Status</th>                                  
                                    <th class="text-right">Action</th>                                    
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
        $('#servicerequest-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('api.bills.list') !!}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'owner', name: 'owner' },
                { data: 'name', name: 'name' },
                { data: 'house_no', name: 'house_no' },
                
                { data: 'amount', name: 'amount' },                              
           
                { data: 'pay_status', name: 'pay_status' },          
                { data: 'action', name: 'action',searchable:false,orderable:false },           
                    ]
        });
      

       
        $(document).on('submit','.delete-house',function(event){
            return confirm('Are you sure you want to delete this house ? The action cannot be reversed');            
        });
       
    });
</script>

<!-- Datatable init js -->
{{-- <script src="assets/pages/datatables.init.js"></script>  --}}
@endpush