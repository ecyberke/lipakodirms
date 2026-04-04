<?php $__env->startSection('page-header'); ?>
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">Setup Wizard</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Home</a></li>
            <li class="breadcrumb-item active">Setup Wizard</li>
        </ol>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Progress -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">Overall Progress</h5>
                    <span class="badge badge-primary"><?php echo e($completedSteps); ?>/<?php echo e($totalSteps); ?> Steps Complete</span>
                </div>
                <div class="progress mb-3" style="height: 10px; border-radius: 10px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo e($progressPercent); ?>%; border-radius: 10px;">
                        <?php echo e($progressPercent); ?>%
                    </div>
                </div>
                <?php if($nextStep): ?>
                <div class="alert alert-info mb-0">
                    <i class="fe fe-arrow-right"></i> <strong>Next Step:</strong> <?php echo e($nextStep['title']); ?>

                    <a href="<?php echo e(route($nextStep['route'])); ?>" class="btn btn-sm btn-primary ml-3">Start Now</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Section 1: Onboard Property -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fe fe-briefcase text-primary"></i> Onboard Property
                </h4>
                <p class="text-muted mb-0">Set up your property and owner details</p>
            </div>
            <div class="card-body">
                <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($step['section'] === 'property'): ?>
                <div class="d-flex align-items-center p-3 mb-3 rounded" 
                    style="background: <?php echo e($step['completed'] ? '#f0f4ff' : '#fffbf0'); ?>; border: 1px solid <?php echo e($step['completed'] ? '#b8cef5' : '#ffeaa7'); ?>;">
                    <div class="mr-3" style="width:45px;height:45px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:<?php echo e($step['completed'] ? '#1A4FA8' : '#F47920'); ?>;">
                        <i class="<?php echo e($step['icon']); ?> text-white" style="font-size:1.1rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Step <?php echo e($num); ?>: <?php echo e($step['title']); ?></strong><br>
                                <small class="text-muted"><?php echo e($step['description']); ?></small>
                            </div>
                            <div class="ml-3">
                                <?php if($step['completed']): ?>
                                    <span class="badge badge-primary">
                                        <i class="fe fe-check"></i> Done (<?php echo e($step['count']); ?>)
                                    </span><br>
                                    <a href="<?php echo e(route($step['route'])); ?>" class="btn btn-sm btn-outline-primary mt-1">Add More</a>
                                <?php else: ?>
                                    <a href="<?php echo e(route($step['route'])); ?>" class="btn btn-sm btn-primary">Start</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <!-- Section 2: Onboard Tenant -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fe fe-users text-success"></i> Onboard Tenant
                </h4>
                <p class="text-muted mb-0">Add tenants and assign them to units</p>
            </div>
            <div class="card-body">
                <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($step['section'] === 'tenant'): ?>
                <div class="d-flex align-items-center p-3 mb-3 rounded"
                    style="background: <?php echo e($step['completed'] ? '#f0f4ff' : '#fffbf0'); ?>; border: 1px solid <?php echo e($step['completed'] ? '#b8cef5' : '#ffeaa7'); ?>;">
                    <div class="mr-3" style="width:45px;height:45px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:<?php echo e($step['completed'] ? '#1A4FA8' : '#F47920'); ?>;">
                        <i class="<?php echo e($step['icon']); ?> text-white" style="font-size:1.1rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Step <?php echo e($num); ?>: <?php echo e($step['title']); ?></strong><br>
                                <small class="text-muted"><?php echo e($step['description']); ?></small>
                            </div>
                            <div class="ml-3">
                                <?php if($step['completed']): ?>
                                    <span class="badge badge-primary">
                                        <i class="fe fe-check"></i> Done (<?php echo e($step['count']); ?>)
                                    </span><br>
                                    <a href="<?php echo e(route($step['route'])); ?>" class="btn btn-sm btn-outline-primary mt-1">Add More</a>
                                <?php else: ?>
                                    <a href="<?php echo e(route($step['route'])); ?>" class="btn btn-sm btn-primary">Start</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<?php if($completedSteps > 0): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="fe fe-bar-chart-2"></i> Quick Overview</h4>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($step['completed']): ?>
                    <div class="col-md-2 col-4 mb-3">
                        <h4 class="text-primary mb-1"><?php echo e($step['count']); ?></h4>
                        <small class="text-muted"><?php echo e($step['title']); ?></small>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ecyberco/domains/lipakodi.ecyber.co.ke/public_html/rms/resources/views/onboarding/wizard.blade.php ENDPATH**/ ?>