<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="The system aims at enabling efficient rental management by using computerized centralized system. Users of this system are able to receive or send information relevant to them by SMS. All activities are coordinated effectively, so as to minimize chances of inconvenience." name="description">
		<meta content="Bedah" name="author">
		<meta name="keywords" content="">
		@include('layouts.custom-head')
	</head>
		
	<body class="h-100vh page-style1 light-mode default-sidebar">	    
		@yield('content')		
		@include('layouts.custom-footer-scripts')	
	</body>
</html>