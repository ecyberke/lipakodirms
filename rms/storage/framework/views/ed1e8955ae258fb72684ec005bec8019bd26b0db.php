
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
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('assets/img/favicon.png')); ?>">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/font-awesome.min.css')); ?>">
		
		<!-- Lineawesome CSS -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/line-awesome.min.css')); ?>">
         <!-- Select2 CSS -->
		<link rel="stylesheet" href="<?php echo e(asset('assets/css/select2.min.css')); ?>">		
		
		
	
		
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">

        <?php echo $__env->yieldPushContent('header_scripts'); ?>
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="<?php echo e(asset('assets/js/html5shiv.min.js')); ?>"></script>
			<script src="<?php echo e(asset('assets/js/respond.min.js')); ?>"></script>
		<![endif]-->		
    </head>
    <body>
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			<!-- Loader -->
			
			<!-- /Loader -->
		
			<!-- Header -->
            <?php echo $__env->make('includes.top_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<!-- /Header -->
			
			<!-- Sidebar -->
            <?php echo $__env->make('includes.sidebar1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<!-- /Sidebar -->
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <?php echo $__env->yieldContent('content'); ?>
				<!-- /Page Content -->

            </div>
			<!-- /Page Wrapper -->
			
        </div>
		<!-- /Main Wrapper -->
		
		<!-- Sidebar Overlay -->
		<div class="sidebar-overlay" data-reff=""></div>
		
		<!-- jQuery -->
        <script src="<?php echo e(asset('assets/js/jquery-3.2.1.min.js')); ?>"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="<?php echo e(asset('assets/js/popper.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
		
		<!-- Slimscroll JS -->
        <script src="<?php echo e(asset('assets/js/jquery.slimscroll.min.js')); ?>"></script>
        
         <!-- Select2 JS -->
		<script src="<?php echo e(asset('assets/js/select2.min.js')); ?>"></script>	
		<!-- Datetimepicker JS -->
		<script src="<?php echo e(asset('assets/js/moment.min.js')); ?>"></script>
		<script src="<?php echo e(asset('assets/js/bootstrap-datetimepicker.min.js')); ?>"></script>	
		
		
		<!-- Custom JS -->
		<script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>
		
		        
        <!-- Page specific js -->
        <?php echo $__env->yieldPushContent('footer_scripts'); ?>
		
    </body>
</html><?php /**PATH C:\xampp\htdocs\rms\rms\resources\views/layouts/home.blade.php ENDPATH**/ ?>