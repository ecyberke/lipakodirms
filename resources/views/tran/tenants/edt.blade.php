@extends('layouts.home')

@section('content')

<div class="content container-fluid">

    <!-- Page Title -->
    {{-- <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">New Tenant</h4>
        </div>
    </div> --}}
    <!-- /Page Title -->

    <!-- Content Starts -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    {{-- <h4 class="mt-0 header-title">Update Tenant Details </h4> --}}
                    <p class="text-muted m-b-10 font-14">
                    </p>
                    @include('includes.messages')
                    <div class="p-20 pt-2">
                        <form action="{{ route('tenant.update', $tenant->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Full Names <span class="text-danger">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" name="full_name"
                                        value="{{  $tenant->full_name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Phone Number (ID) <span class="text-danger">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" name="id"
                                        value="{{  $tenant->id }}">
                                    </div>
                                </div>
                            </div>
                            
                           
                        </div>
                        <!-- end row -->
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>National ID Number / Passport </label>
                                    <div>
                                        <input type="text" class="form-control" name="id_number" value="{{  $tenant->id_number}}" " id="passport">
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <div>
                                        <input type="text" class="form-control" name="email"
                                        value="{{  $tenant->email }}">
                                    </div>
                                </div>
                            </div>
                            

                            
                             <div class="col-sm-4">                                
                                <div class="form-group">
                                    <label>Occupation Status:</label>
                                    <div>
                                        <select class="select" name="occupation">
                                            <option>{{  $tenant->occupation }}</option>
                                            <option>Employed</option>
                                            <option>Self-Employed</option>
                                            <option>Student</option>
                                            <option>Unemployed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-sm-12">
                                     <div class="form-group">
                                            <label>Tenant Contract</label>
                                            <div>
                                                <input type="file" name="filenames" class="myfrm form-control">
                                            </div>
                                        </div>
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <hr>
                            </div>
                            <div class="col-sm-12">
                                <p class="text-muted m-b-30 font-14">CONTACT PERSON
                                </p>
                            </div>

                        </div>
                        <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Names</label>
                                <div>
                                    <input type="text" class="form-control" name="emergency_person" value="{{ $tenant->emergency_person }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Phone Number:</label>
                                <div>
                                    <input type="tel" class="form-control" name="emergency_number" value="{{ $tenant->emergency_number }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Relationship:</label>
                                <div>
                                    <input type="text" class="form-control" name="relationship" value="{{ $tenant->relationship }}">
                                </div>
                            </div>
                        </div>
                        </div>
                            

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                Update Tenant
                                            </button>                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- /Content End -->

</div>

@endsection

@push('footer_scripts')      

@endpush