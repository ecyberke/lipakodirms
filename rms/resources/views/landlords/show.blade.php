@extends('layouts.master')


@push('header_scripts')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endpush

@section('content')

<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                {{-- <h3 class="page-title">Profile</h3> --}}
                {{-- <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">Property Owner</li>
                </ul> --}}
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="mb-2"><a class="btn btn-sm btn-danger"
        href="{{ route('landlord.index')}}">Back to the list</a>
</div>
    @include('includes.messages')

       <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="profile-img-wrap">
                            <div class="profile-img">
                                <a href="#"><img alt="" src="{{ asset('assets/img/landlord.jpg')}}"></a>
                            </div>
                        </div>
                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0">{{ $landlord->full_name}}</h3>
                                        <h6 class="text-muted"></h6>
                                        <small class="text-muted"></small>
                                        <div class="staff-id">Property Owner's ID Number : {{ $landlord->landlordid_number}}</div>
                                        <div class="small doj text-muted mb-2">Registered :
                                            {{ $landlord->created_at->diffForHumans() }}</div>
                                        <div class="mb-2"><a class="btn  btn-sm btn-secondary"
                                                href="{{ route('landlord.edit',$landlord->id) }}">Edit Owner
                                                Details</a>
                                        </div>
                                        <div class=""><a class="btn btn-info btn-sm"
                                        href="{{ route('apartment.create', $landlord->id)}}">Add Property</a>
                                        </div>
                                       <!--  <div class=""><a class="btn btn-custom btn-sm"
                                        href="{{ route('landlord.changepassword',$landlord->id)}}">Update Password</a>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="col-md-4">
                                   <ul class="personal-info">
                                       <li>
                                           @if($landlord->bank_name != null)
                                            <div ><b>Bank name:</b> {{ $landlord->bank_name}}</div>
                                            @else
                                            <div ><b>Bank name:</b>  <em style=color:red;>Not yet submitted</em></div>
                                            @endif
                                           
                                        </li>
                                        <li>
                                             @if($landlord->bank_branch != null)
                                            <div ><b>Bank branch:</b> {{ $landlord->bank_branch}}</div>
                                            @else
                                            <div ><b>Bank branch:</b> <em style=color:red;>Not yet submitted</em></div>
                                            @endif
                                           
                                        </li>
                                        <li>
                                            @if($landlord->bank_acc_name != null)
                                            <div ><b>Bank account name:</b> {{ $landlord->bank_acc_name}}</div>
                                            @else
                                            <div ><b>Bank account name:</b> <em style=color:red;>Not yet submitted</em></div>
                                            @endif
                                           
                                        </li>
                                        <li>
                                            @if($landlord->bank_acc_no != null)
                                            <div ><b>Bank account number:</b> {{ $landlord->bank_acc_no}}</div>
                                             @else
                                            <div ><b>Bank account number:</b> <em style=color:red;>Not yet submitted</em></div>
                                            @endif
                                           
                                        </li>
                                        <li>
                                            <div ><b>Phone:</b> {{ $landlord->id}}</div>
                                           
                                        </li>
                                        
                                        <li>
                                            <div ><b>Physical Address:</b> {{ $landlord->address }}</div>
                                            
                                        </li>
                                        <li>
                                            <div ><b>Email:</b> {{ $landlord->email}}</div>
                                            
                                        </li>
                                    </ul>
                                </div>
                                 <div class="col-md-3">
                                     <h3>Next of Kin</h3><hr>
                                   <ul class="personal-info">
                                       <li>
                                           @if($landlord->emergency_person != null)
                                            <div ><b>Full Name:</b> {{ $landlord->emergency_person}}</div>
                                            @else
                                            <div ><b>Full Name:</b>  <em style=color:red;>Not yet submitted</em></div>
                                            @endif
                                           
                                        </li>
                                         <li>
                                             @if($landlord->emergency_id != null)
                                            <div ><b>ID/Passport Number:</b> {{ $landlord->id}}</div>
                                            @else
                                            <div ><b>ID/Passport Number:</b> <em style=color:red;>Not yet submitted</em></div>
                                            @endif
                                           
                                        </li>
                                        <li>
                                             @if($landlord->emergency_number != null)
                                            <div ><b>Phone Number:</b> {{ $landlord->emergency_number}}</div>
                                            @else
                                            <div ><b>Phone Number:</b> <em style=color:red;>Not yet submitted</em></div>
                                            @endif
                                           
                                        </li>
                                        <li>
                                            @if($landlord->relationship != null)
                                            <div ><b>Relationship:</b> {{ $landlord->relationship}}</div>
                                            @else
                                            <div ><b>Relationship:</b> <em style=color:red;>Not yet submitted</em></div>
                                            @endif
                                           
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

   <div class="tab-content">

        <!-- Profile Info Tab -->
        <div id="emp_profile" class="pro-overview tab-pane fade show active">
     <div class="row">
                


                <!---Deposit list Section---->
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                           <h3 class="card-title">Owner Properties </h3> 
                            <div class="table-responsive">
                                 <table id="invoices-table" class="table table-bordered"
                        >
                        <thead>
                            <tr>
                             
                                <th style="width:10%">#</th>
                                <th>Property Name</th>
                                {{-- <th>House Type</th> --}}
                                <th>Town</th>
                                <th>Management Fee</th>
                                <th>Total Houses</th>
                            </tr>
                        </thead>
                        @php
                        $count=1;
                        @endphp
                        <tbody>
                            
                            @forelse ($apartments as $apartment)
                            <tr>
                                <td>{{$count}}</td>
                                <td>{{$apartment->name}}</td>
                                {{-- <td>{{$apartment->type}}</td> --}}
                                <td>{{$apartment->town}}</td>
                                <td>{{ $apartment->management_fee_percentage}} %</td>
                                <td>{{ $apartment->houses->count() }}</td>
                             
                                
                            </tr>
                            @php
                            $count+=1;
                            @endphp
                            @empty

                            @endforelse

                        </tbody>
                    </table>
                            </div>
                        </div>
                    </div>
                </div></div></div>
              
                 <div class="row">
                


                <!---Deposit list Section---->
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            
                            <h3 class="card-title">Owner Invoices </h3>
                            <div class="table-responsive">
                                <table id="owner_invoices-table" class="table table-bordered"
                        >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tenant Name</th>
                                            <th>Property</th>
                                            <th>House</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>

                                    @php
                                    $count=1;
                                    @endphp
                                    <tbody>
                                        @forelse ($owner_invoices as $depo)
                                        <tr>
                                           <td>{{$count}}</td>
                                            <td class="text-uppercase">{{$depo->tenant_name}}</td>
                                            <td class="text-uppercase">{{$depo->apartment_name}}</td>
                                            <td class="text-uppercase">{{$depo->house_name}}</td>
                                            <td class="text-uppercase">Ksh.{{number_format( $depo->deposit_amount)}}</td>
                                            <td>
                                                @if ($depo->status > 0)
                                                <span class="badge badge-success">PAID  
                                                @elseif ($depo->status == 2 )
                                                <span class="badge badge-warning">PARTIAL</span>
                                                @else <span
                                                    class="badge badge-danger">UNPAID</span> @endif
                                            </td>
                                            <td>{{ $depo->created_at}}</td>
                                        </tr>

                                        @php
                                        $count+=1;
                                        @endphp
                                        @empty

                                        @endforelse

                                    </tbody>
                    </table>
                            </div>
                        </div>
                    </div>
                </div>
</div>
<div class="row">
                


                <!---Deposit list Section---->
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            
                            <h3 class="card-title">Repairs </h3>
                            <div class="table-responsive">
                                <table id="repair_invoices-table" class="table table-bordered"
                        >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Property</th>
                                            <th>House</th>
                                            <th>Tenant Name</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>

                                    @php
                                    $count=1;
                                    @endphp
                                    <tbody>
                                        @forelse ($repair_invoices as $depo)
                                        <tr>
                                           <td>{{$count}}</td>
                                           
                                            <td class="text-uppercase">{{$depo->apartment_name}}</td>
                                            <td class="text-uppercase">{{$depo->house_name}}</td>
                                             <td class="text-uppercase">{{$depo->tenant_name}}</td>
                                             <td>{{$depo->repaired_items}}</td>
                                            <td class="text-uppercase">Ksh.{{number_format( $depo->total_repair_amount)}}</td>
                                            <td>{{ $depo->created_at}}</td>
                                        </tr>

                                        @php
                                        $count+=1;
                                        @endphp
                                        @empty

                                        @endforelse

                                    </tbody>
                    </table>
                            </div>
                        </div>
                    </div>
                </div>
</div>
</div>
</div>

@endsection

@section('js')
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

<script>
    $(function () {
        $(document).ready(function () {
            $('#invoices-table').DataTable(
                {
                    "pageLength": 10 ,
                    "bLengthChange": true
                }
            );
        });
    });
</script>
<script>
    $(function () {
        $(document).ready(function () {
            $('#owner_invoices-table').DataTable(
                {
                    "pageLength": 10 ,
                    "bLengthChange": true
                }
            );
        });
    });
</script>
<script>
    $(function () {
        $(document).ready(function () {
            $('#repair_invoices-table').DataTable(
                {
                    "pageLength": 10 ,
                    "bLengthChange": true
                }
            );
        });
    });
</script>
@endsection

