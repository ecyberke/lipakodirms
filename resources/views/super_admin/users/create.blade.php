@extends('super_admin.layouts.master')
@section('title', 'Add User')
@section('page-title', 'Add User')

@section('css')
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="content container-fluid">
    <form action="{{ route('super.users.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                @include('includes.messages')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label>Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') }}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ old('phone') }}"
                                            pattern=".{12,}" title="Phone number must begin with 254 and contain 12 characters">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label>Username <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="username"
                                            value="{{ old('username') }}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email') }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label>User Level <span class="text-danger">*</span></label>
                                        <select class="form-control" name="role">
                                            <option value="super" selected>Super Admin</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="password"
                                            required minlength="8">
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-success waves-effect waves-light">
                                            Create User
                                        </button>
                                        <a href="{{ route('super.users.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
@endsection
