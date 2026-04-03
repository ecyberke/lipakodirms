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
                    <li class="breadcrumb-item active">Tenant</li>
                </ul> --}}
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="mb-2"><a class="btn btn-sm btn-danger"
        href="{{ route('house.occupied')}}">Back to the list</a>
</div>
    @include('includes.messages')

    <div class="card mb-0">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="profile-img-wrap">
                            <div class="profile-img">
                                <a href="#"><img alt="" src="{{ asset('assets/img/tenant.jpg')}}"></a>
                            </div>
                        </div>
                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0">{{ $tenant->full_name}}</h3>
                                        <h6 class="text-muted">{{ $tenant->occupation}}</h6>
                                        <small class="text-muted">{{ $tenant->occupation_at }}</small>
                                        <div class="staff-id">Tenant Phone Number : {{ $tenant->phone}}</div>
                                        <div class="small doj text-muted mb-2">Registered :
                                            {{ $tenant->created_at->diffForHumans() }}</div>
                                        <div class="mb-2"><a class="btn btn-sm btn-primary"
                                                href="{{ route('tenant.edit', $tenant->id )}}">Edit Tenant Details</a>
                                        </div>
                                        <div class="mb-2"><a class="btn btn-sm btn-success"
                                                href="{{ route('sms.welcome', $tenant->id )}}">Resend Welcoming Message</a>
                                        </div>
                                      
                                         
                                      
                                        
                                       <!--  <div class=""><a class="btn btn-sm btn-white"
                                                href="{{ route('tenant.changepassword',$tenant->id)}}">Update
                                                Password</a>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h3 class="card-title">Details </h3>
                                    <ul class="personal-info">
                                         <li>
                                           <b>Account Number:</b> &nbsp;{{ $tenant->account_number }} | 
                                            <b>Tenant ID Number:</b> &nbsp;{{ $tenant->id_number }} |
                                             <b>Email:</b>&nbsp;<span class="__cf_email__"
                                                        data-cfemail="39535651575d565c795c41585449555c175a5654">{{ $tenant->email}}</span>
                                        </li>
                                       
                                       
                                       
                                    </ul><hr>
                            <h3 class="card-title">Emergency Contact </h3>
                            <ul class="personal-info">
                                <li>
                                    <b>Name</b>
                                    {{$tenant->emergency_person }}| 
                                    <b>Contact</b>
                                    {{ $tenant->emergency_number }} | 
                                    <b>ID/Passport Number</b>
                                    {{ $tenant->kin_id }} | 
                                    <b>Relationship</b>
                                    {{ $tenant->relationship }}
                                </li>
                               

                            </ul><hr>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>


    <div class="tab-content">

        <!-- Profile Info Tab -->
        <div id="emp_profile" class="pro-overview tab-pane fade show active">
            <div class="row">
                <div class="col-md-6 d-flex">
                    <div class="card  flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Monthly Balances </h3>
                                        
                          <div class="table-responsive">
                                <table class="table table-bordered  table-nowrap datatable" id="balance-table">
                                       <thead> <tr>
                                            <th>Invoice No</th>
                                            <th>Month</th>
                                            <th>Amount to Pay</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @forelse ($tenant->invoices as $invoice)
                                        <tr>
                                            <td class="text-uppercase">INV0{{ ($invoice->id) }}</td>
                                            <td class="text-uppercase">{{ ($invoice->rent_month) }}</td>
                                            <td>Ksh. {{number_format($invoice->balance)}}</td>
                                         


                                           

                                        </tr>
                                        @empty
                                         No Invoice generated yet.

                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!---Assigned Houses---->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Occupant In </h3>
                            <div class="table-responsive">
                                <table class="table table-bordered  table-nowrap datatable" id="house-table">
                                       <thead> <tr>
                                            <th>Hse No</th>
                                            <th>Type</th>
                                            <th>Apartment</th>
                                            <th>Placement Date</th>
                                            <th class="text-right no-sort">Action</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($houzez as $houze)
                                        <tr>
                                            <td class="text-uppercase">{{$houze->house->house_no}}</td>
                                            <td class="text-uppercase">{{$houze->house->house_type}}</td>
                                            <td>{{$houze->house->apartment->name}}</td>
                                            <td>{{$houze->placement_date}}</td>

                                             <td>
                                                <div class="text-right">
                            <div class="dropdown dropdown-action">
						    	<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-danger btn-block" href="{{route ('tenant.vacate1', $houze->house->id)}}"> Vacate</a>
                                    </div>
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-primary btn-block" href="{{route('tenant.assignRoomedit', $houze->id )}}"> Reassign House</a>
                                    </div>
                                     <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-success btn-block" href="{{ route('lease.pdf', $houze->house->id )}}" > Download Lease Agreement</a>
                                    </div>
                                    <!-- <div class="dropdown-item ">-->
                                    <!--   <a class="btn btn-sm btn-success btn-block" href="{{route('tenant.missingInvoices', $houze->id )}}"> Generate Invoice</a>-->
                                    <!--</div>-->
                                    <!--<div class="dropdown-item ">-->
                                    <!--    <div class="dropdown dropdown-action">-->
                                    <!--        <a class="btn btn-sm btn-success btn-block" href="{{route('tenant.missingInvoices', $houze->id )}}"> Generate Invoice</a>-->
                                        <!--<div class="dropdown-item ">-->
                                        <!--<a href="{{route('tenant.missingInvoices', $houze->id )}}"> Past 1 Month</a>-->
                                        <!--</div>-->
                                        
                                    <!--</div>-->
                                    </div>
                                    <!--<div class="dropdown-item ">-->
                                    <!--    <a class="btn btn-sm btn-success btn-block" href="{{ route('tenant.change_room', $houze->id) }}" > Change House</a>-->
                                    <!--</div>-->
                                    

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
                
            </div>
            <div class="row">
                

                <!---Invoice Section---->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Tenant Invoices </h3>
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
                                        @forelse ($tenant->invoices as $invoice)
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
                <!---Payment Section---->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Tenant Payments </h3>
                            <div class="table-responsive">
                                <table class="table table-bordered  table-nowrap datatable" id="deposit-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Reference</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Receipt</th>
                                        </tr>
                                    </thead>

                                    @php
                                    $count=1;
                                    @endphp
                                    <tbody>
                                        @forelse ($tenant_payment as $deposit)
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td class="text-uppercase">{{$deposit->TransID}}</td>
                                            <td class="text-uppercase">Ksh.{{number_format( $deposit->TransAmount)}}</td>
                                            <td>{{ $deposit->created_at}}</td>
                                            <td>
                                                <div class="dropdown-item ">
                                                    @if($deposit->receipt)
                                        <a class="btn btn-sm btn-success btn-block" href="{{route('receipt.index', $deposit->receipt)}}" target="blank_">Download</a>
                                        @else
                                        <p>No receipt</p>
                                        @endif
                                    </div>
                                    </td>
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
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Tenant Deposits </h3>
                            <div class="table-responsive">
                                <table class="table table-bordered  table-nowrap datatable" id="deposit-list-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>House</th>
                                            <th>Deposit Amount</th>
                                            <th>Date Entered</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    @php
                                    $count=1;
                                    @endphp
                                    <tbody>
                                        @forelse ($invoiz as $deposits)
                                        <tr>
                                            <td>{{$count}}</td>
                                            <td class="text-uppercase">{{$deposits->house->house_no}}</td>
                                            <td class="text-uppercase">Ksh.{{number_format( $deposits->deposit_paid + $deposits->electricity_deposit_paid)}}</td>
                                            <td>{{ $deposits->created_at}}</td>
                                            <td>
                                                <div class="text-right">
                            <div class="dropdown dropdown-action">
						    	<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-info btn-block" href="{{route('invoice.show', $deposits->id)}}"> View</a>
                                    </div>
                                   
                                    @if($deposits->locking == null)
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-danger btn-block" href="{{route('tenant.deposit_refund', $deposits->id)}}"> Initiate Refund</a>
                                    </div>
                                    @elseif($deposits->locking == 1)
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-warning btn-block" href=""> Refund in Progress</a>
                                    </div>
                                    @else
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-success btn-block" href=""> Refund Completed</a>
                                    </div>
                                   @endif
                                    

						    	</div>
                            </div>
                        </div>
                                                
                                            </td>
                                           
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
                <!---Tenant Bill Section---->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Tenant Deposit Bills </h3>
                            <div class="table-responsive">
                                <table class="table table-bordered  table-nowrap datatable" id="tenant-bill-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>House</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    @php
                                    $count=1;
                                    @endphp
                                    <tbody>
                                        @forelse ($tenant_bill as $depo)
                                        <tr>
                                           <td>{{$count}}</td>
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
                                            <td>
                                                <div class="text-right">
                            <div class="dropdown dropdown-action">
						    	<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-info btn-block" href="{{route('tenant_bill.show', $depo->id)}}"> View</a>
                                    </div>
                                   
                                    @if($depo->status == 0)
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-danger btn-block" href="{{route('tenant.pay', $depo->id)}}"> Make Payment</a>
                                    </div>
                                    @else
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-success btn-block" href=""> Refund Completed</a>
                                    </div>
                                   @endif
                                    

						    	</div>
                            </div>
                        </div>
                                                
                                            </td>
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
        <!-- /Profile Info Tab -->



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
                    "pageLength": 12,
                    "order": [[ 0, "desc" ]],
                    "bLengthChange": false
                }
            );
        });
    });
</script>
<script>
    $(function () {
        $(document).ready(function () {
            $('#house-table').DataTable(
                {
                    "pageLength": 2,
                    "order": [[ 2, "asc" ]],
                    "bLengthChange": false
                }
            );
        });
    });
</script>
<script>
    $(function () {
        $(document).ready(function () {
            $('#balance-table').DataTable(
                {
                    "pageLength": 2,
                    "order": [[ 2, "desc" ]],
                    "bLengthChange": false
                     
                }
            );
        });
    });
</script>
<script>
    $(function () {
        $(document).ready(function () {
            $('#deposit-table').DataTable(
                {
                    "pageLength": 8,
                    "order": [[ 3, "desc" ]],
                    "bLengthChange": false
                }
            );
        });
    });
</script>
<script>
    $(function () {
        $(document).ready(function () {
            $('#deposit-list-table').DataTable(
                {
                    "pageLength": 12,
                    "bLengthChange": false
                }
            );
        });
    });
</script>
<script>
    $(function () {
        $(document).ready(function () {
            $('#tenant-bill-table').DataTable(
                {
                    "pageLength": 12,
                    "bLengthChange": false
                }
            );
        });
    });
</script>
@endsection

