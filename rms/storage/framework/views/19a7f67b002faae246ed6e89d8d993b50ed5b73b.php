
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
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">

        <?php echo $__env->yieldPushContent('header_scripts'); ?>
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="<?php echo e(asset('assets/js/html5shiv.min.js')); ?>"></script>
			<script src="<?php echo e(asset('assets/js/respond.min.js')); ?>"></script>
		<![endif]-->		
    </head>
    <body class="account-page">
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">            
            <?php echo $__env->yieldContent('content'); ?>
        </div>
		<!-- /Main Wrapper -->		
        
        <!-- jQuery -->
        <script src="<?php echo e(asset('assets/js/jquery-3.2.1.min.js')); ?>"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="<?php echo e(asset('assets/js/popper.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
		 
		<!-- Custom JS -->
		<script src="<?php echo e(asset('assets/js/app.js')); ?>"></script>
		
    </body>
</html><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/layouts/main.blade.php ENDPATH**/ ?>