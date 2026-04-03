@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')

<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                {{-- <h3 class="page-title">Property Details</h3> --}}
                {{-- <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Property</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ul> --}}
            </div>
        </div>
        <div class="mb-2"><a class="btn btn-sm btn-danger"
            href="{{route('apartment.list')}}">Back to the list</a>
    </div>
    </div>
    <!-- /Page Header -->

    @include('includes.messages')

    <div class="row">
        <div class="col-md-8">
            <div class="job-info job-widget">
                <h3 class="job-title">{{ $apartment->name }}
                @if($apartment->active == 1)
                <a class="btn btn-sm btn-success" href="">Active</a>
                @else
                <a class="btn btn-sm btn-danger" href="">Inactive</a>
                @endif
                
                </h3>
                <ul class="job-post-det mb-2">
                    <!--<li><i class="fa fa-calendar"></i> Registered Date: <span-->
                    <!--        class="text-blue">{{ $apartment->created_at->diffForHumans() }}</span></li>-->
                              <li><i class="fa fa-calendar"></i> Registered Date: <span
                            class="text-blue">{{ $apartment->created_at->diffForHumans() }}</span></li>
                    <li><i class="fa fa-home"></i> Total Houses: <span
                            class="text-blue">{{ $apartment->houses->count() }}</span></li>
                </ul>
            </div>
            <div class="job-content job-widget">
                <div class="job-desc-title"><div class="row">
							<div class="col-12">
								
					

								
								<!--div-->
								<div class="card">
									
									<div class="card-body">
										<div class="">
											<div class="table-responsive">
												 <table id="houses-table" id="example"  class="table table-striped custom-table mb-0 text-nowrap key-buttons"
                        >
                        
                        <thead>
                           
                              <tr>
                                      <th>#</th>
                                <th>House</th>
                                <th>Type</th>
                                {{-- <th>Status</th> --}}
                                <th>Rent</th>
                                {{-- <th>..</th> --}}                                  
                                </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    
                    </table>
											</div>
										</div>
									</div>
								</div>
								<!--/div-->

								
										</div>
									</div>
                    
                </div>
               

            </div>
        </div>
        <div class="col-md-4 order-first">
            <div class=" card">
                <div class="card-body">
                    {{-- <div class="info-list">
                        <span><i class="fa fa-bar-chart"></i></span>
                        <h5>Type</h5>
                        <p> {{ $house->house_type}}</p>
                    </div> --}}
                    <div class="info-list">
                        <span><i class="fa fa-map"></i></span>
                        <h5>Town</h5>
                        <p>{{ $apartment->town}}</p>
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-suitcase"></i></span>
                        <h5>Reference Number</h5>
                        <p>
                            {{ $apartment->reference_no }}</p>
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-home"></i></span>
                        <h5>Houses Limit </h5>
                        <p>{{ $apartment->houses_qty}} </p>
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-ticket"></i></span>
                        <h5>Management Fee</h5>
                        <p>{{ $apartment->management_fee_percentage}} %</p>
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-user"></i></span>
                        <h5>Owner</h5>
                        <p>{{ $apartment->landlord->full_name}}</p>
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-map-signs"></i></span>
                        <h5>Description</h5>
                        <p> {{ $apartment->description }}</p>
                    </div>
                    <hr class="pt-4">

                    {{-- <div class="row py-3">
                        <div class="col-6 align-end">
                            <a class="btn btn-info btn-sm " href="{{ route('apartment.edit',$apartment->id)}}">Edit
                                Property</a>
                        </div>
                        <div class="col-6 ">

                            @if (Auth::user()->is_admin || Auth::user()->is_super)
                                <form action="{{ route('apartment.delete',$apartment->id) }}" method="post"
                                class="delete-form">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Delete" class="btn btn-sm  btn-block btn-danger">
                            </form>
                            @endif                            
                        </div>
                    </div> --}}

                </div>


            </div>
        </div>
        <input type="hidden" data-fetch-route="{{ route('api.apartment.houses', $apartment->id ) }}" id="invoicesFetch">
    </div>


</div>
@endsection
@section('js')
<script>
    $(function () {
        $(document).ready(function () {
            $('#invoices-table').DataTable(
                {
                    "pageLength": 4,
                    "bLengthChange": false
                }
            );
        });
    });

    $(function () {

        var $data_route = $("#invoicesFetch").attr('data-fetch-route');

        console.log($data_route);
        $('#houses-table').DataTable({
            "pageLength": 3,
            "bLengthChange": true,
            processing: true,
            serverSide: true,
            ajax: $data_route,
             columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'house_no', name: 'houses.house_no' },
                                         
                { data: 'house_type', name: 'house_type' },
                { data: 'rent', name: 'rent' ,searchable:false,orderable:false},
                
                
                  
                     
               
                    ]
        });
    });

    $(document).on('submit', '.delete-form', function (event) {
        return confirm('Deleting apartment will also delete all associated houses attached to it.Are you sure ?');
        event.preventDefault();
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



