<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Lesa International Agencies  - Rent Management System" name="description">
		<meta content="Bedah" name="author">
		<meta name="keywords" content="Rent, RMS, Management Systems, Information, Systems, Properties, Property Management, Admin, Admin Template, Dashboard, Responsive, Admin Dashboard, Bootstrap, Bootstrap 4, Clean, Backend, Jquery, Modern, Web App, Admin Panel, Ui, Premium Admin Templates, Flat, Admin Theme, Ui Kit, Bootstrap Admin, Responsive Admin, Application, Template, Admin Themes, Dashboard Template"/>
		@include('layouts.head')
	</head>

	<body class="app sidebar-mini light-mode default-sidebar">
		<!---Global-loader-->
		<!--<div id="global-loader" >-->
		<!--	<img src="{{URL::asset('assets/images/svgs/loader.svg')}}" alt="loader">-->
		<!--</div>-->

		<div class="page">
			<div class="page-main">
				@include('layouts.side-menu')
				<div class="app-content main-content">
					<div class="side-app">
						@include('layouts.header')
						@yield('page-header')
						@yield('content')
            			@include('layouts.footer')
		</div><!-- End Page -->
			@include('layouts.footer-scripts')	
	</body>
</html>