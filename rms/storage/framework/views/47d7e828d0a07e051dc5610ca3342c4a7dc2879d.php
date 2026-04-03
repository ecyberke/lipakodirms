<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Lesa International Agencies  - Rent Management System" name="description">
		<meta content="Bedah" name="author">
		<meta name="keywords" content="Rent, RMS, Management Systems, Information, Systems, Properties, Property Management, Admin, Admin Template, Dashboard, Responsive, Admin Dashboard, Bootstrap, Bootstrap 4, Clean, Backend, Jquery, Modern, Web App, Admin Panel, Ui, Premium Admin Templates, Flat, Admin Theme, Ui Kit, Bootstrap Admin, Responsive Admin, Application, Template, Admin Themes, Dashboard Template"/>
		<?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</head>

	<body class="app sidebar-mini light-mode default-sidebar">
		<!---Global-loader-->
		<!--<div id="global-loader" >-->
		<!--	<img src="<?php echo e(URL::asset('assets/images/svgs/loader.svg')); ?>" alt="loader">-->
		<!--</div>-->

		<div class="page">
			<div class="page-main">
				<?php echo $__env->make('layouts.side-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<div class="app-content main-content">
					<div class="side-app">
						<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						<?php echo $__env->yieldContent('page-header'); ?>
						<?php echo $__env->yieldContent('content'); ?>
            			<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div><!-- End Page -->
			<?php echo $__env->make('layouts.footer-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>	
	</body>
</html><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/layouts/master.blade.php ENDPATH**/ ?>