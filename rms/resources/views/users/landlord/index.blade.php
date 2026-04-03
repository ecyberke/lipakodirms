@extends('users.landlord.layout')

@section('content')
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                        <li class="breadcrumb-item active">LandLord</li>
                    </ul>
                </div>
            </div>
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
                                            <div class="staff-id">Tenant ID : {{ $landlord->id}}</div>
                                            <div class="small doj text-muted mb-2">Date of Join :
                                                {{ $landlord->created_at->diffForHumans() }}</div>
                                            
                                            <div class=""><a class="btn btn-custom btn-sm"
                                                             href="{{ route('landlord.changepassword',$landlord->id)}}">Update Password</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Phone:</div>
                                                <div class="text"><a href="">{{ $landlord->phone_no}}</a></div>
                                            </li>
                                            <li>
                                                <div class="title">Email:</div>
                                                <div class="text"><a href=""><span class="__cf_email__"
                                                                                   data-cfemail="39535651575d565c795c41585449555c175a5654">{{ $landlord->email}}</span></a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="title">Birthday:</div>
                                                <div class="text">24th July</div>
                                            </li>
                                            <li>
                                                <div class="title">Address:</div>
                                                <div class="text">{{ $landlord->address }}</div>
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

        <nav aria-label="breadcrumb" class="mb-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">LandLord Apartments</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-12">
                <div class="row">

                    @forelse ($apartments as $apartment)
                        <div class="col-6 d-flex">
                            <div class="card flex-fill">
                                <div class="card-body">
                                    <h6 class="card-title m-b-15">{{ $apartment->name}}</h6>
                                    <table class="table table-striped table-border p-1">
                                        <tbody>
                                        <tr>
                                            <td>Type:</td>
                                            <td class="text-right">{{ $apartment->type}}</td>
                                        </tr>
                                        <tr>
                                            <td>Town:</td>
                                            <td class="text-right">{{ $apartment->town}}</td>
                                        </tr>
                                        <tr>
                                            <td>Location:</td>
                                            <td class="text-right">{{ $apartment->location}}</td>
                                        </tr>
                                        <tr>
                                            <td>Description:</td>
                                            <td class="text-right">{{ $apartment->description}}</td>
                                        </tr>

                                        <tr>
                                            <td>Management Fee:</td>
                                            <td class="text-right">{{ $apartment->management_fee_percentage}} %</td>
                                        </tr>
                                        <tr>
                                            <td>Total Houses:</td>
                                            <td class="text-right">{{ $apartment->houses->count() }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @empty

                    @endforelse







                </div>




            </div>
        </div>















    </div>

@endsection
