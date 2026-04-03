@extends('layouts.master')

@section('content')
<div class="content container-fluid">

    <form action="{{ route('admin.store') }}" method="post">

        @csrf
        <div class="row">
            <div class="col-md-12">

                <!-- Page Header -->
                {{-- <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Create User</h3>
                        </div>
                    </div>
                </div> --}}
                <!-- /Page Header -->

                @include('includes.messages')
                <form >
              
                               
                    <div class="row">
            
            
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    {{-- <h4 class="mt-0 header-title mb-4">User Details</h4> --}}
            
                                    <hr class="mt-2 mb-4">
                                   
            
                                    {{-- <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Predefined Monthly
                                            Rent</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" id="house-rent" readonly>
                                        </div>
                                    </div> --}}
            
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Full Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                           
                                                <input type="text" class="form-control" name="name">
                                        </div>
                                    </div>
            
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">ID Number<span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <input class="form-control" type="text" id="tenant-names" name="user_id" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Email Address<span class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <input class="form-control" type="email" id="agent_name" name="email"
                                                value="">
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Service Request Date <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <div class="cal-icon">
                                                    <input class="form-control datetimepicker" type="text" name="request_date"
                                                        value="">
                                                </div>
                                            </div>
            
                                        </div>
                                    </div> --}}
                                    <div class="row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">User Level <span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <select class="select" name="is_admin">
                                                    <option >---choose---</option>
                                                    <option value="0">Agent</option>
                                                    <option value="1">Manager</option>
                                                </select>
                                            </div>
            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Password<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div>
                                                    <input type="password" class="form-control" name="password">
                                                   
                                                </div>
                                            </div>
            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">Confirm Password<span
                                                class="text-danger">*</span></label>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div>
                                                    <input type="password" class="form-control" name="repeat-password">
                                                   
                                                </div>
                                            </div>
            
                                        </div>
                                    </div>
                                    
            
                                    <div class="row mb-4">
                                        <div class="col-sm-6 offset-sm-4">
                                            <button type="submit" class="btn btn-success waves-effect waves-light">Create User</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>            
                    </div>
                </form>
                
            </div>
        </div>
    </form>

</div>
<!-- /Page Content -->
@endsection