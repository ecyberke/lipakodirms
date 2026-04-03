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
                    <li class="breadcrumb-item"><a href="">House</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ul> --}}
            </div>
        </div>
        <div class="mb-2"><a class="btn btn-sm btn-danger"
            href="{{route('house.list')}}">Back to the list</a>
    </div>
    </div>
    <!-- /Page Header -->

    @include('includes.messages')

    <div class="row">
        <div class="col-md-8">
            <div class="job-info job-widget">
                <h3 class="job-title">{{ $house->house_no }} @if($house->apartment->active == 0)<a class="btn btn-sm btn-danger"
            href="{{route('apartment.edit', $house->apartment->id)}}">Activate Property</a>
            @endif</h3>
                
                <ul class="job-post-det mb-2">
                    <!--<li><i class="fa fa-calendar"></i> Registered Date: <span-->
                    <!--        class="text-blue">{{ $house->apartment->created_at->diffForHumans() }}</span></li>-->
                              <li><i class="fa fa-calendar"></i> Registered Date: <span
                            class="text-blue">5 Months ago</span></li>
                    <li><i class="fa fa-home"></i> Property: <span
                            class="text-blue">{{ $house->apartment->name }} @if($house->apartment->active == 0) <span
                            style="color:red;">Inactive</span> @endif</span> </li>
                </ul>
            </div>
            <div class="job-content job-widget">
                <div class="job-desc-title"><div class="row">
							<div class="col-12">
								
					

								
								<!--div-->
							<!---Invoice Section---->
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">House Invoices </h3>
                            <div class="table-responsive">
                                <table class="table table-bordered  table-nowrap datatable" id="invoices-table">
                                    <thead>
                                        <tr>
                                            <th style="width:20%">#INV</th>
                                            <th style="width:20%">Month</th>
                                            <th style="width:30%">Status</th>
                                            <th style="width:30%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($invoices as $invoice)
                                        <tr>
                                            <td>{{ $invoice->id }}</td>
                                            <td>{{ $invoice->rent_month }}</td>
                                            <td>
                                                @if ($invoice->is_paid > 0)
                                                <span class="badge badge-success">PAID  
                                                @elseif ($invoice->is_paid == 0 && $invoice->paid_in > 0 )
                                                <span class="badge badge-warning">PARTIAL</span>
                                                @else <span
                                                    class="badge badge-danger">UNPAID</span> @endif
                                            </td>
                                            

                                            <!--<td><a href="{{ route('invoice.show',$invoice->id)}}" class="btn btn-sm btn-primary">View</a> </td>-->
                                            <td>
                                                <div class="text-right">
                            <div class="dropdown dropdown-action">
						    	<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-info btn-block" href="{{route('invoice.show', $invoice->id)}}"> View</a>
                                    </div>
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-success btn-block" href="{{route('invoice.edit', $invoice->id)}}"> Edit</a>
                                    </div>
                                    

						    	</div>
                            </div>
                        </div>
                                                
                                            </td>
                                        </tr>

                                        @empty

                                        @endforelse

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
                        <span><i class="fa fa-user"></i></span>
                        <h5>Tenant</h5>
                        
                        @forelse ($houzes as $tenants)
                        <p>{{ $tenants->tenant->full_name}}</p>
                        @empty

                        @endforelse
                      
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-user"></i></span>
                        <h5>Owner</h5>
                        <p>{{ $house->apartment->landlord->full_name}}</p>
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-money"></i></span>
                        <h5>Rent</h5>
                        <p>Ksh. {{ number_format($house->rent->amount)}}</p>
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-suitcase"></i></span>
                        <h5>Location</h5>
                        <p>
                            {{ $house->apartment->location }}</p>
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-ticket"></i></span>
                        <h5>Management Fee</h5>
                        <p>{{ $house->apartment->management_fee_percentage}} %</p>
                    </div>
                    
                    
                    <div class="info-list">
                        <span><i class="fa fa-map-signs"></i></span>
                        <h5>Description</h5>
                        <p> {{ $house->description }}</p>
                    </div>
                    <hr class="pt-4">
                     <div class="info-list">
                        
                        <h4>Bills</h4>
                        @if($house->rent->compound_bill == 0 && $house->rent->water_bill == 0 && $house->rent->compound_bill == 0 && $house->rent->litter_bill == 0 )
                        <p>No Bills</p>
                        @else
                        @if($house->rent->electricity_bill != 0)
                        <p>Electricity: Ksh. {{ number_format($house->rent->electricity_bill)}}</p>
                        @else
                        
                        @endif
                        @if($house->rent->water_bill != 0)
                        <p>Water: Ksh. {{ number_format($house->rent->water_bill)}}</p>
                        @else
                        
                        @endif
                        @if($house->rent->compound_bill != 0)
                        <p>Compound: Ksh. {{ number_format($house->rent->compound_bill)}}</p>
                        @else
                        
                        @endif
                        @if($house->rent->litter_bill != 0)
                        <p>Litter: Ksh. {{ number_format($house->rent->litter_bill)}}</p>
                        @else
                        
                        @endif
                        @endif
                        
                    </div>
                    <hr class="pt-4">
                    

                 
                </div>


            </div>
        </div>
       
    </div>


</div>
@endsection
@section('js')

<script>
    $(function () {
        $(document).ready(function () {
            $('#invoices-table').DataTable(
                {   
                    "order": [[ 0, "desc" ]],
                    "pageLength": 8,
                    "bLengthChange": false
                }
            );
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



