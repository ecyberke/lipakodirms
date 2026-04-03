
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="RMS">
		<meta name="keywords" content="">
        <meta name="author" content="RMS">
        <meta name="robots" content="noindex, nofollow">
        <title>RMS</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css')}}">
		
		<!-- Lineawesome CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/line-awesome.min.css')}}">
         <!-- Select2 CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css')}}">		
		
		{{-- Datepicker --}}
	
		
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">

        @stack('header_scripts')
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="{{ asset('assets/js/html5shiv.min.js')}}"></script>
			<script src="{{ asset('assets/js/respond.min.js')}}"></script>
		<![endif]-->		
    </head>
    <body>
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			<!-- Loader -->
			{{-- <div id="loader-wrapper">
				<div id="loader">
					<div class="loader-ellips">
					  <span class="loader-ellips__dot"></span>
					  <span class="loader-ellips__dot"></span>
					  <span class="loader-ellips__dot"></span>
					  <span class="loader-ellips__dot"></span>
					</div>
				</div>
			</div> --}}
			<!-- /Loader -->
		
			<!-- Header -->
            @include('includes.top_bar')
			<!-- /Header -->
			
			<!-- Sidebar -->
            @include('includes.sidebar1')
			<!-- /Sidebar -->
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
				<!-- Page Content -->
                @yield('content')
				<!-- /Page Content -->

            </div>
			<!-- /Page Wrapper -->
			
        </div>
		<!-- /Main Wrapper -->
		
		<!-- Sidebar Overlay -->
		<div class="sidebar-overlay" data-reff=""></div>
		
		<!-- jQuery -->
        <script src="{{ asset('assets/js/jquery-3.2.1.min.js')}}"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="{{ asset('assets/js/popper.min.js')}}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
		
		<!-- Slimscroll JS -->
        <script src="{{ asset('assets/js/jquery.slimscroll.min.js')}}"></script>
        
         <!-- Select2 JS -->
		<script src="{{ asset('assets/js/select2.min.js')}}"></script>	
		<!-- Datetimepicker JS -->
		<script src="{{ asset('assets/js/moment.min.js')}}"></script>
		<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>	
		
		
		<!-- Custom JS -->
		<script src="{{ asset('assets/js/app.js')}}"></script>
		
		        
        <!-- Page specific js -->
        @stack('footer_scripts')
		
    </body>
</html>