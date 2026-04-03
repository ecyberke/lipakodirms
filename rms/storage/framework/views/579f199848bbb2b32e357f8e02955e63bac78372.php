<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Lipakodi Property Management System - Property Management System" name="description">
		<meta content="author" name="Bedah">
		<meta name="keywords" content="The best rent management system that enables one to have access to all payments, real-time monitoring of units and properties and records of all tenants who get alerts via sms when their rents are due and overdue."/>
		<?php echo $__env->make('layouts.custom-head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</head>
		
	<body class="h-100vh page-style1 light-mode default-sidebar">	    
		<?php echo $__env->yieldContent('content'); ?>		
		<?php echo $__env->make('layouts.custom-footer-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	
	</body>
</html><?php /**PATH /home/lipakodi/domains/lipakodi.co.ke/public_html/v1/rms/resources/views/layouts/master2.blade.php ENDPATH**/ ?>