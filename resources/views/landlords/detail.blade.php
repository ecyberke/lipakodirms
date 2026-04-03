@extends('layouts.home')

@section('content')

<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                {{-- <h3 class="page-title">Profile</h3> --}}
                {{-- <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                    <li class="breadcrumb-item active">LandLord</li>
                </ul> --}}
            </div>
        </div>
    </div>
    <div class="mb-2"><a class="btn btn-sm btn-danger"
        href="{{ route('landlord.index')}}">Back to the list</a>
</div>
    <!-- /Page Header -->

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
                                <div class="col-md-7">
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Phone:</div>
                                            <div class="text"><a href="">{{ $landlord->phone_no}}</a></div>
                                        </li>
                                        
                                        <li>
                                            <div class="title">Physical Address:</div>
                                            <div class="text">{{ $landlord->address }}</div>
                                        </li>
                                        <li>
                                            <div class="title">Email:</div>
                                            <div class="text"><a href=""><span class="__cf_email__"
                                                        data-cfemail="39535651575d565c795c41585449555c175a5654">{{ $landlord->email}}</span></a>
                                            </div>
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

    {{-- <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"></li>
        </ol>
    </nav> --}}
    <div class="card mb-3">
        <div class="card-body">
    <div class="">
        {{-- <div class="card profile-box flex-fill"> --}}
            <div class="card-body">
                <h3 class="card-title">Owner Properties </h3> 
                <div class="table-responsive"> 
                   
                    {{-- <table class="table table-bordered  table-nowrap datatable" id="" style="border-collapse: collapse; border-spacing: 0; width: 100%;"> --}}
                        <table id="invoices-table" class="table table-bordered"
                        >
                        <thead>
                            <tr>
                             
                                <th style="width:10%">#</th>
                                <th>Property Name</th>
                                <th>House Type</th>
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
                                <td>{{$apartment->houses->house_type}}</td>
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
                {{-- </div> --}}
            </div>
        </div>
    </div>
</div>


@push('footer_scripts')
<!-- Required datatable js -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>

<!-- Responsive examples -->
<script src="{{ asset('plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

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

@endpush
</div>


@endsection