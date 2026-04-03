<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Lipakodi Property Management System - Property Management System" name="description">
		<meta content="author" name="Bedah">
		<meta name="keywords" content="The best rent management system that enables one to have access to all payments, real-time monitoring of units and properties and records of all tenants who get alerts via sms when their rents are due and overdue."/>
		@include('layouts.custom-head')
	</head>
		
	<body class="h-100vh page-style1 light-mode default-sidebar">	    
		@yield('content')		
		@include('layouts.custom-footer-scripts')	
	</body>
</html>