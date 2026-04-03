@extends('layouts.master')


@push('header_scripts')
<!-- DataTables -->
<link href="{{ asset('plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')<br><br>

<div class="content container-fluid">
    <!-- Page Header -->
    
    <!-- /Page Header -->

    @include('includes.messages')

    <div class="row">
        <div class="col-md-8">
            
            <div class="job-content job-widget">
            <h3 class="job-title">{{$service_requests->apartment->name}}</h3>
                <ul class="job-post-det mb-2">
                <li><i class="fa fa-calculator"></i> Request Number: <span
                            class="text-blue"></span>{{$service_requests->id}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    <li><i class="fa fa-calendar"></i> Requested Date:&nbsp; <span
                            class="text-blue"></span>{{$service_requests->created_at}}</li>
                            <!--<li><i class="fa fa-money"></i> Total Spent Amount:&nbsp; <span-->
                            <!--class="text-blue"></span>{{$service_requests->amount}}</li>-->
                        <!--    <li><i class="fa fa-money"></i> Payment Status:&nbsp; <span-->
                        <!--    class="text-blue"></span>@if($service_requests->pay_status == 0)-->
                        <!--<span style="color: #FF0000;">Unpaid</span>-->
                        <!--@elseif($service_requests->pay_status == 1)-->
                        <!--<span style="color: #66CD00;">Paid</span>-->
                        <!--@elseif($service_requests->pay_status == 2)-->
                        <!--<span style="color: #00bfff;">Partial</span>-->
                        <!--@endif</li>-->
                    
                </ul>
                <hr>
                <div class="job-desc-title">
                    <h4>Requested Service</h4>
                </div>
                <div class="table-responsive">
                    @if($service_requests->service_request_edit == null  )
                    <p>{{$service_requests->service_request}} </p>
                    @elseif($service_requests->service_request_edit == $service_requests->service_request )
                    <p>{{$service_requests->service_request}} </p>
                    @elseif($service_requests->approval == 2  )
                    <p>{{$service_requests->service_request}} </p>
                    @else
                    <p>{{$service_requests->service_request_edit}} </p>
                    @endif
                </div>

            </div>
          @if (Auth::user()->is_super)
            @if($service_requests->status != 1)
            <div class="mb-2"><a class="btn btn-sm btn-info"
            href="{{route('servicerequests.edit', $service_requests->id)}}">Authorize Update</a>
            
    </div>
    @endif
    @endif
    @if (Auth::user()->is_super == 0 )
            @if($service_requests->approval == 3)
            <div class="mb-2"><a class="btn btn-sm btn-info"
            href="{{route('servicerequests.edit', $service_requests->id)}}">Amend</a>
            
    </div>
    @endif
    @endif
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
                        <h5>Tenant Name</h5>
                        @if($service_requests->tenant_id == null)
                        <p> {{$service_requests->full_name}}
                            </p>
                            @else
                            <p> {{$service_requests->tenant->full_name}}
                            </p>
                            @endif
                    </div>
                    {{-- <div class="info-list">
                        <span><i class="fa fa-building"></i></span>
                        <h5>Apartment</h5>
                        <p>{{$service_requests->property}}</p>
                    </div> --}}
                    
                    <div class="info-list">
                        <span><i class="fa fa-home"></i></span>
                        <h5>House</h5>
                        @if($service_requests->house_id == null)
                        <p> No House Specified</p>
                        @else
                        <p> {{$service_requests->house->house_no}}</p>
                        @endif
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-edit"></i></span>
                        <h5>Status</h5>
                        @if($service_requests->status_edit == 0  )
                        <h6>@if($service_requests->status == 1)
                        <p style="color: #FF0000;">CLOSED</p>
                        @elseif($service_requests->status == 2)
                        <p style="color: #00bfff;">IN PROGRESS</p>
                        @elseif($service_requests->status == 0)
                        <p style="color: #66CD00;">OPEN</p>
                        @endif</h6>
                        @elseif($service_requests->status_edit == $service_requests->status )
                        <h6>@if($service_requests->status == 1)
                        <p style="color: #FF0000;">CLOSED</p>
                        @elseif($service_requests->status == 2)
                        <p style="color: #00bfff;">IN PROGRESS</p>
                        @elseif($service_requests->status == 0)
                        <p style="color: #66CD00;">OPEN</p>
                        @endif</h6>
                        @elseif($service_requests->approval == 2  )
                        <h6>@if($service_requests->status == 1)
                        <p style="color: #FF0000;">CLOSED</p>
                        @elseif($service_requests->status == 2)
                        <p style="color: #00bfff;">IN PROGRESS</p>
                        @elseif($service_requests->status == 0)
                        <p style="color: #66CD00;">OPEN</p>
                        @endif</h6>
                        @else
                         <h6>@if($service_requests->status_edit == 1)
                        <p style="color: #FF0000;">CLOSED</p>
                        @elseif($service_requests->status_edit == 2)
                        <p style="color: #00bfff;">IN PROGRESS</p>
                        @elseif($service_requests->status_edit == 0)
                        <p style="color: #66CD00;">OPEN</p>
                        @endif</h6>
                        @endif
                    
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-list"></i></span>
                        <h5>Phone Number</h5>
                           @if($service_requests->tenant_id == null)
                        <p> No Phone Number Specified
                            </p>
                            @else
                            <p> {{$service_requests->tenant->phone}}
                            </p>
                            @endif
                       
                    </div>
                    {{-- <hr class="pt-4"> --}}

                    <div class="row py-3">
                        {{-- <div class="col-6 align-end">
                            <a class="btn btn-info btn-sm " href="{{route('servicerequests.edit', $service_requests->id)}}">Add Expenses</a>
                        </div> --}}
                        {{-- <div class="col-6 ">

                            @if (Auth::user()->is_admin || Auth::user()->is_super)
                                <form action="{{ route('apartment.delete',$apartment->id) }}" method="post"
                                class="delete-form">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Delete" class="btn btn-sm  btn-block btn-danger">
                            </form>
                            @endif                            
                        </div> --}}
                    </div> 

                </div>


            </div>
        </div>
        {{-- <input type="hidden" data-fetch-route="{{ route('api.apartment.houses' ) }}" id="invoicesFetch"> --}}
    </div>


</div>

@endsection

@push('footer_scripts')
<!-- Required datatable js -->


@endpush