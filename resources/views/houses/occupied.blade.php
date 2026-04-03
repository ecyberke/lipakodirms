@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
						<!--Page header-->
						<div class="page-header">
						
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{ route('home')}}" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
									<!--<li class="breadcrumb-item"><a href="#">Forms</a></li>-->
									<li class="breadcrumb-item active" aria-current="page">Tenant List</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
@endsection

@section('content')
<div class="content container-fluid">

    {{-- <div class="row ">
        <div class="col-sm-6">
            <h4 class="page-title">Occupied Houses</h4>
        </div>
    </div> --}}

    @include('includes.messages')

    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="mt-0 header-title">Occupied Houses</h4>  --}}
                   <!--<div class="btn-group" style="width:40%">-->
                   <!--<button  style="border-top-left-radius:10px; border-bottom-left-radius: 10px;"><a href="{{ route('house.list')}}">All</a></button>-->
                   <!-- <button class="w3-button w3-blue"><a href="{{ route('house.occupied')}}">Occupied</a></button>-->
                   <!-- <button style="border-top-right-radius:10px; border-bottom-right-radius: 10px;"><a href="{{ route('house.vacant')}}">Vacant</a></button>-->
                   <!-- </div>-->
                   <!-- <br><br><br>-->

                    <table id="occupied-houses" class="table table-striped custom-table mb-0"
                        >
                        <thead>
                                <tr>
                                     <th style="width:10%">Account No.</th>
                                     <th >Name</th>
                                     <th >Phone Number</th>
                                     <th>Property</th> 
                                     <th>House No.</th> 
                                     <th>Rent</th>
                                   
                                     <th>Action</th> 
                                    
                                  
                                                                                                          
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
@section('js')
<script>
    $(function () {
        $('#occupied-houses').DataTable({
         
            processing: true,
            serverSide: true,
             "pageLength": 25,
            ajax: '{!! route('api.house.occupied') !!}',
            columns: [
                // { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false},   
                { data: 'account_number', name: 'tenant.account_number' ,orderable: false},  
                 { data: 'tenant_names', name: 'tenant.full_name' ,orderable: false, searchable:true }, 
                 { data: 'phone_number', name: 'tenant.phone' ,orderable: false},
                 { data: 'building', name: 'building',orderable: false },
                { data: 'house.house_no', name: 'house.house_no',orderable: false  },
                { data: 'rent', name: 'rent'  },
               
                
                // { data: 'action', name: 'action',orderable: false , searchable:false},                             
                         
                { data: 'actions', name: 'actions',orderable: false , searchable:false}, 
                  
 ]
        });

        $(document).on('submit','.delete-tenant',function(event){
            return confirm('Are you sure you want to PERMANENTLY DELETE this tenant? The action will also delete all information linked with the tenant.');
            event.preventDefault();
        });
    });
</script>
<!-- Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables.js')}}"></script>
<!-- Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
@endsection