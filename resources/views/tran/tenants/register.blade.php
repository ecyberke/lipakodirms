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

                    {{-- <h4 class="mt-0 header-title">Register Tenant </h4>--}}
                    <p class="text-muted m-b-30 font-14">After successful registration of the tenant, proceed and click assign house button to add tenant to a house.
                    </p>
                    @include('includes.messages')
                    <div class="p-20 pt-2">
                        <form action="{{ route('tenant.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>Full Names <span class="text-danger">*</span></label>
                                        <div>
                                            <input type="text" class="form-control" name="full_name"
                                                value="{{old('full_name')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Phone Number (ID) <span class="text-danger">*</span></label>
                                        <div>
                                            <input type="text" class="form-control" name="id"
                                                value="{{old('id')}} ">
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
                                            <input type="text" class="form-control" name="id_number" value="" id="passport">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Email Address</label>
                                        <div>
                                            <input type="text" class="form-control" name="email"
                                                value="{{old('email')}} ">
                                        </div>
                                    </div>
                                </div>
                                

                                {{-- <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tenant's System Code <span class="text-danger">*</span></label>
                                        <div>
                                            <input type="text" class="form-control" name="password"
                                                value="{{old('password')}}" id="password">
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Physical Address</label>
                                        <div>
                                            <input type="text" class="form-control" name="physical_address"
                                                value="{{old('physical_address')}}">
                                        </div>
                                    </div>
                                </div> --}}
                                 <div class="col-sm-4">                                
                                    <div class="form-group">
                                        <label>Occupation Status:</label>
                                        <div>
                                            <select class="select" name="occupation">
                                                <option value="0">--choose--</option>
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
                            {{-- <div class="row">
                                <div class="col-sm-12">
                                    <hr>
                                </div>
                            </div> --}}
                            <div class="row">
                               
                                
                                {{-- <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>At:</label>
                                        <div>
                                            <input type="text" class="form-control" name="occupied_at" value="{{old('occupied_at')}}">
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Contact Phone:</label>
                                        <div>
                                            <input type="text" class="form-control" name="job_contact" value="{{old('job_contact')}}">
                                        </div>
                                    </div>
                                </div> --}}
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
                                        <input type="text" class="form-control" name="emergency_person" value="{{old('emergency_person')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <div>
                                        <input type="tel" class="form-control" name="emergency_number" value="{{old('emergency_number')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Relationship:</label>
                                    <div>
                                        <input type="text" class="form-control" name="relationship" value="">
                                    </div>
                                </div>
                            </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-success waves-effect waves-light">
                                                Submit
                                            </button>
                                            <button type="reset" class="btn btn-secondary waves-effect m-l-5">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="float-right" style="padding-right: 15px;" style="padding-top: 15px;" >
                            <div class="row sm-6">
                                <div class="">
                                    <div class="form-group">
                                        <div>
                                            
                                            <a href="{{route('tenant.assign_room')}}"><button  class="btn btn-info ">
                                                Assign House
                                            </button></a>    
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- /Content End -->

</div>

@endsection

@push('footer_scripts')
    <script>
    $('#passport').keyup(function(){
        $('#password').val($(this).val());
    });
    </script>    

@endpush