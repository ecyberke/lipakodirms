@extends('layouts.master2')
@section('content')
<div class="page">
    <div class="page-single">
        <div class="p-5">
            <div class="row">
                <div class="col mx-auto">
                    <div class="row justify-content-center">
                        <div class="col-lg-9 col-xl-8">
                            <div class="card-group mb-0">
                                <div class="card p-4 page-content">
                                    <div class="card-body page-single-content">
                                        <div class="w-100">
                                            <div class="mb-4">
                                                <img src="{{URL::asset('assets/images/lipakodi_main_logo.png')}}" alt="Lipakodi" style="height:50px;">
                                                <h1 class="mb-2 mt-3">Super Admin</h1>
                                                <p class="text-muted">Sign in to the Lipakodi Super Admin Panel</p>
                                            </div>

                                            @if(session('error'))
                                            <div class="alert alert-danger">{{ session('error') }}</div>
                                            @endif

                                            <form method="POST" action="{{ route('super.login.post') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="input-group mb-4">
                                                        <span class="input-group-addon">
                                                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 16c-2.69 0-5.77 1.28-6 2h12c-.2-.71-3.3-2-6-2z" opacity=".3"/><circle cx="12" cy="8" opacity=".3" r="2"/><path d="M12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H6zm6-6c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/></svg>
                                                        </span>
                                                        <input type="text" name="username" style="width:80%"
                                                            class="form-control @error('username') is-invalid @enderror"
                                                            placeholder="Username" value="{{ old('username') }}" required autofocus>
                                                        @error('username')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group mb-4">
                                                        <span class="input-group-addon">
                                                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/></svg>
                                                        </span>
                                                        <input type="password" name="password" style="width:80%"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            placeholder="Password" required>
                                                        @error('password')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="submit" class="btn btn-primary px-4">Login</button>
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        <label class="custom-control custom-checkbox mb-0 mt-2">
                                                            <input type="checkbox" name="remember" class="custom-control-input">
                                                            <span class="custom-control-label">Remember me</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card text-white bg-primary py-5 d-md-down-none page-content mt-0">
                                    <div class="card-body text-center justify-content-center page-single-content">
                                        <img src="{{URL::asset('assets/images/pattern/login.png')}}" alt="img">
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
@endsection
