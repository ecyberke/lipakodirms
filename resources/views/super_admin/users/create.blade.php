@extends('super_admin.layouts.master')
@section('title', 'Add Super Admin User')
@section('page-title', 'Add Super Admin User')

@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fe fe-user mr-1"></i> New Super Admin User</h4>
                </div>
                <div class="card-body">
                    @include('includes.messages')
                    <form method="POST" action="{{ route('super.users.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" required minlength="8">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="row mt-3">
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    <i class="fe fe-save"></i> Create User
                                </button>
                                <a href="{{ route('super.users.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
