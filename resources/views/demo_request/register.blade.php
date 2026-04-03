@extends('layouts.master2')
@section('css')
@endsection
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
												<div class="">
													<h1 class="mb-2">Request Demo</h1>
													<p class="text-muted">Fill in the phone and we'll be in touch</p>
												</div>
												@include('includes.messages')
												<!--<div class="btn-list d-sm-flex">-->
												<!--	<a href="https://www.google.com/gmail/" class="btn btn-google btn-block">Google</a>-->
												<!--	<a href="https://twitter.com/" class="btn btn-twitter d-block d-sm-inline mr-0 mr-sm-2">Twitter</a>-->
												<!--	<a href="https://www.facebook.com/" class="btn btn-facebook d-block d-sm-inline">Facebook</a>-->
												<!--</div>-->
												<!--<hr class="divider my-6">-->
										<form method="POST" action="{{ route('demo.store') }}">
                    @csrf
                    <div class="form-group" >
                       <div class="input-group mb-4">
                           
                      
	
                        <input id="name" style="width:80%" type="text" placeholder="Enter Your Name" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    </div>
                    <div class="form-group" >
                       <div class="input-group mb-4">
                        
	
                        <input id="email" style="width:80%" type="email" placeholder="Enter Your Email" class="form-control @error('username') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    </div>
                    <div class="form-group" >
                       <div class="input-group mb-4">
                       
	
                        <input id="phone" style="width:80%" type="text" placeholder="Enter Your Phone Number" class="form-control @error('phone') is-invalid @enderror"
                            name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>

                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary account-btn" style="width:100%" type="submit"><font color="white">Request Demo</font></button>
                    </div>
                 
                    <div class="account-footer">
                        <p>Home? <a href="/">Click Here</a></p>
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
									<!--<div class="text-center pt-4">-->
									<!--	<div class="font-weight-normal fs-16">You Don't have an account <a class="btn-link font-weight-normal" href="#">Register Here</a></div>-->
									<!--</div>-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection
@section('js')
@endsection




