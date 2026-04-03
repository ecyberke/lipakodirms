<div class="header ">
			
				<!-- Logo -->
                <div class="header-left">
                    <a href="{{route('home')}}" class="logo">
						<img src="{{asset('assets/img/lesa-white.png') }}" width="130" height="50" alt="">
					</a>
                </div>
				<!-- /Logo -->
				
				<!--<a id="toggle_btn" href="javascript:void(0);">-->
				<!--	<span class="bar-icon">-->
				<!--		<span></span>-->
				<!--		<span></span>-->
				<!--		<span></span>-->
				<!--	</span>-->
				<!--</a>-->
				
				<!-- Header Title -->
                <div class="page-title-box">
					<h3>Lesa International Agencies</h3>
                </div>
				<!-- /Header Title -->
				
				<a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
				
				<!-- Header Menu -->
				<ul class="nav user-menu">
				
					@includeIf('view.name', ['some' => 'data'])
				
				<li class="dropdown has-arrow main-drop">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<span class="user-img"><img src="{{asset('assets/img/logo.jpg') }}" alt="">
							<span class="status online"></span></span>
							<span>{{ Auth::user()->name}}</span>
						</a>
						<div class="dropdown-menu">	
						@if(Auth::user()->is_admin  )
						<a class="dropdown-item" href="{{route('admin.notification')}}">Notifications</a>
						@endif
							<a class="dropdown-item" href="{{route('admin.changepassword')}}">Change Password</a>
							
							<a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
						</div>
					</li>
				</ul>
				<!-- /Header Menu -->
				
				<!-- Mobile Menu -->
				<div class="dropdown mobile-user-menu">
					<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
					<div class="dropdown-menu dropdown-menu-right">						
						
						 <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
					</div>
				</div>
				<!-- /Mobile Menu -->
				
            </div>