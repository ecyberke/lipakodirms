@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
						<!--Page header-->
						<div class="page-header">
							
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
									
									<li class="breadcrumb-item"><a href="#">Email</a></li>
									<li class="breadcrumb-item active" aria-current="page">Read Email</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
@endsection
@section('content')
						<div class="row">
							<div class="col-md-12 col-lg-4 col-xl-3">
							<div class="card">
									<div class="list-group list-group-transparent mb-0 mail-inbox pb-3">
										<div class="mt-4 mb-4 ml-4 mr-4 text-center">
											<a href="{{ url('/chat/' . $page='email-compose') }}" class="btn btn-primary btn-lg btn-block">Compose</a>
										</div>
										<a href="{{ url('/chat/' . $page='email-inbox') }}" class="list-group-item list-group-item-action d-flex align-items-center ">
											<svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 8l-8 5-8-5v10h16zm0-2H4l8 4.99z" opacity=".3"/><path d="M4 20h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM20 6l-8 4.99L4 6h16zM4 8l8 5 8-5v10H4V8z"/></svg> Inbox <span class="ml-auto badge badge-success">{{$inbox->count()}}</span>
										</a>
										<a href="{{ url('/chat/' . $page='email-sent') }}" class="list-group-item list-group-item-action d-flex align-items-center">
											<svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M20 16V6H4v10.01L20 16zm-7-1.53v-2.19c-2.78 0-4.61.85-6 2.72.56-2.67 2.11-5.33 6-5.87V7l4 3.73-4 3.74z" opacity=".3"/><path d="M20 18c1.1 0 1.99-.9 1.99-2L22 6c0-1.11-.9-2-2-2H4c-1.11 0-2 .89-2 2v10c0 1.1.89 2 2 2H0v2h24v-2h-4zM4 16V6h16v10.01L4 16zm9-6.87c-3.89.54-5.44 3.2-6 5.87 1.39-1.87 3.22-2.72 6-2.72v2.19l4-3.74L13 7v2.13z"/></svg>Sent Mail<span class="ml-auto badge badge-primary">{{$sent->count()}}</span>
										</a>
										<a href="{{ url('/chat/' . $page='email-important') }}" class="list-group-item list-group-item-action d-flex align-items-center">
											<svg class="svg-icon mr-2" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M18.49 9.89l.26-2.79-2.74-.62-1.43-2.41L12 5.18 9.42 4.07 7.99 6.48l-2.74.62.26 2.78L3.66 12l1.85 2.11-.26 2.8 2.74.62 1.43 2.41L12 18.82l2.58 1.11 1.43-2.41 2.74-.62-.26-2.79L20.34 12l-1.85-2.11zM13 17h-2v-2h2v2zm0-4h-2V7h2v6z" opacity=".3"/><path d="M20.9 5.54l-3.61-.82-1.89-3.18L12 3 8.6 1.54 6.71 4.72l-3.61.81.34 3.68L1 12l2.44 2.78-.34 3.69 3.61.82 1.89 3.18L12 21l3.4 1.46 1.89-3.18 3.61-.82-.34-3.68L23 12l-2.44-2.78.34-3.68zM18.75 16.9l-2.74.62-1.43 2.41L12 18.82l-2.58 1.11-1.43-2.41-2.74-.62.26-2.8L3.66 12l1.85-2.12-.26-2.78 2.74-.61 1.43-2.41L12 5.18l2.58-1.11 1.43 2.41 2.74.62-.26 2.79L20.34 12l-1.85 2.11.26 2.79zM11 15h2v2h-2zm0-8h2v6h-2z"/></svg> Important <span class="ml-auto badge badge-danger">{{$email->count()}}</span>
										</a>
									
									</div>
							
								</div>
							</div>
							<div class="col-md-12 col-lg-8 col-xl-9">
								<div class="card">
								
									<div class="card-body">
										<div class="email-media">
											<div class="mt-0 d-sm-flex">
												<!--<img class="mr-2 rounded-circle avatar avatar-lg" src="{{URL::asset('assets/images/users/2.jpg')}}" alt="avatar">-->
												<div class="media-body pt-0">
												
													<div class="media-title text-dark font-weight-semibold mt-1">From: {{$emails->user->name}} <span class="text-muted font-weight-semibold">( {{$emails->user->email}} )</span></div>
													<small class="mb-0">To: {{ Auth::user()->name}} - {{ Auth::user()->email}}</small>
													
												</div>
											</div>
										</div>
										<div class="eamil-body mt-5">
											<u><h6>{{$emails->subject}}</h6></u>
											<p>{{$emails->message}}</p>
										</div>
										<hr>
										<div class="eamil-body mt-5">
										      @forelse ($reply as $replies)
										      <small class="mb-0"><b>Reply From:</b>
										      @if($replies->user->id == Auth::user()->id)
										      You - ({{$replies->user->email}})
										      @else
										      {{$replies->user->name}} - ({{$replies->user->email}})
										      @endif
										      </small>
										      
                                              <p>{{$replies->reply}}</p><hr>
                                              @empty
                                              No Reply.

                                        @endforelse
								
										</div>
										
									</div>
									<div class="card-footer">
									<a class="btn btn-primary mt-1 mb-1" href="/chat/{{$emails->id}}/email-read-reply"><i class="fa fa-reply"></i> Reply</a>
										<!--<a class="btn btn-secondary mt-1 mb-1" href="#"><i class="fa fa-share"></i> Forward</a>-->
									</div>
								</div>
							</div>
						</div>

					</div>
				</div><!-- end app-content-->
			</div>
@endsection
@section('js')
@endsection