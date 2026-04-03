@extends('layouts.main')

@section('content')
<div class="account-content">
    <div class="container">
        <!-- Account Logo -->
        <div class="account-logo">
            <a href=""><img src="" alt="Your Logo Here"></a>
        </div>
        <!-- /Account Logo -->

        <div class="account-box">
            <div class="account-wrapper">
                <h3 class="account-title">Property Owner Login</h3>
                <p class="account-subtitle">Sorry can not login as a property owner</p>

                <!-- Account Form -->
                {{-- <form method="POST" action="{{ route('landlord.login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="password">Password</label>
                            </div>
                            <div class="col-auto">
                                <a class="text-muted" href="">
                                    Forgot password?
                                </a>
                            </div>
                        </div>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary account-btn" type="submit">Login</button>
                    </div>
                    <div class="account-footer"> --}}
                        <p>Please login back as agency user: <a href="/index.php/login">User login</a></p>
                    </div>
                </form>
                <!-- /Account Form -->

            </div>
        </div>
    </div>
</div>
@endsection