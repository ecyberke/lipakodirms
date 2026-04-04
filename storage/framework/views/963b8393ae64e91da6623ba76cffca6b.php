<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($org->name ?? 'Tenant Portal'); ?> - <?php echo $__env->yieldContent('title', 'Dashboard'); ?></title>
    <link rel="icon" href="<?php echo e(URL::asset('assets/images/brand/favicon.ico')); ?>" type="image/x-icon"/>
    <link href="<?php echo e(URL::asset('assets/plugins/bootstrap/css/bootstrap.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(URL::asset('assets/css/style.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(URL::asset('assets/css/dark.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(URL::asset('assets/css/skins.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(URL::asset('assets/css/animated.css')); ?>" rel="stylesheet" />
    <link id="theme" href="<?php echo e(URL::asset('assets/css/sidemenu.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/plugins/p-scrollbar/p-scrollbar.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(URL::asset('assets/plugins/web-fonts/icons.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(URL::asset('assets/plugins/web-fonts/font-awesome/font-awesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(URL::asset('assets/plugins/web-fonts/plugin.css')); ?>" rel="stylesheet" />
</head>
<body class="app sidebar-mini light-mode default-sidebar">
<div class="page">
    <div class="page-main">

        
        <div class="app-sidebar app-sidebar2">
            <div class="app-sidebar__logo">
                <a class="header-brand" href="<?php echo e(route('tenant.dashboard')); ?>">
                    <img src="<?php echo e(URL::asset('assets/images/lipakodi_main_logo.png')); ?>" style="width:100px;height:60px;" class="header-brand-img desktop-lgo" alt="Lipakodi">
                    <img src="<?php echo e(URL::asset('assets/images/lipakodi_main_logo.png')); ?>" style="width:100px;height:60px;" class="header-brand-img dark-logo" alt="Lipakodi">
                    <img src="<?php echo e(URL::asset('assets/images/lipakodi_main_logo.png')); ?>" class="header-brand-img mobile-logo" alt="Lipakodi">
                    <img src="<?php echo e(URL::asset('assets/images/lipakodi_main_logo.png')); ?>" class="header-brand-img darkmobile-logo" alt="Lipakodi">
                </a>
            </div>
        </div>

        
        <aside class="app-sidebar app-sidebar3">
            <ul class="side-menu">
                <li class="menutitles">MAIN</li>
                <li class="slide">
                    <a class="side-menu__item <?php echo e(request()->routeIs('tenant.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('tenant.dashboard')); ?>">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span class="side-menu__label">Dashboard</span>
                    </a>
                </li>
                <li class="menutitles">INVOICING</li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('/')); ?>">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        <span class="side-menu__label">Invoices</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="<?php echo e(route('tenant.invoices')); ?>" class="slide-item"> My Invoices</a></li>
                        <li><a href="<?php echo e(route('tenant.payments')); ?>" class="slide-item"> My Payments</a></li>
                    </ul>
                </li>
                <li class="menutitles">MAINTENANCE</li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('/')); ?>">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        <span class="side-menu__label">Service Request</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="<?php echo e(route('tenant.service-requests')); ?>" class="slide-item"> Add Request</a></li>
                        <li><a href="<?php echo e(route('tenant.service-requests.list')); ?>" class="slide-item"> My Requests</a></li>
                    </ul>
                </li>
                <li class="menutitles">NOTICE</li>
                <li class="slide">
                    <a class="side-menu__item <?php echo e(request()->routeIs('tenant.notice') ? 'active' : ''); ?>" href="<?php echo e(route('tenant.notice')); ?>">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 3H6a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-4-5z"/></svg>
                        <span class="side-menu__label">Submit Notice</span>
                    </a>
                </li>
                <li class="menutitles">REPORTS</li>
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="<?php echo e(url('/')); ?>">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        <span class="side-menu__label">Reports</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="<?php echo e(route('tenant.statement')); ?>" class="slide-item"> My Statement</a></li>
                    </ul>
                </li>
            </ul>
            </ul>
        </aside>

        
        <div class="app-content main-content">
            <div class="side-app">

                
                <?php echo $__env->make('tenant.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                
                <?php if(isset($show_renewal_notice) && $show_renewal_notice): ?>
                <div class="alert alert-warning alert-dismissible fade show mx-4 mt-2">
                    <i class="fe fe-alert-triangle"></i> <strong>Notice:</strong> Subscription expires in <?php echo e($subscription_days_left); ?> days. Contact management.
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
                <?php endif; ?>
                <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mx-4 mt-2">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
                <?php endif; ?>
                <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mx-4 mt-2">
                    <?php echo e(session('error')); ?>

                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
                <?php endif; ?>
                <?php if($errors->any()): ?>
                <div class="alert alert-danger mx-4 mt-2">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                
                <div class="page-header">
                    <div class="page-leftheader">
                        <h4 class="page-title"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h4>
                        <small class="text-muted"><?php echo e(Auth::guard('tenant')->user()->full_name ?? ''); ?> &mdash; <?php echo e(Auth::guard('tenant')->user()->account_number ?? ''); ?></small>
                    </div>
                    <div class="page-rightheader ml-auto d-lg-flex d-none">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('tenant.dashboard')); ?>">Home</a></li>
                            <li class="breadcrumb-item active"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></li>
                        </ol>
                    </div>
                </div>

                
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>

                
                <?php echo $__env->make('tenant.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('layouts.footer-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /home/ecyberco/domains/lipakodi.ecyber.co.ke/public_html/rms/resources/views/tenant/layouts/master.blade.php ENDPATH**/ ?>