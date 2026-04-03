


<?php $__env->startPush('header_scripts'); ?>
<!-- DataTables -->
<link href="<?php echo e(asset('plugins/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('plugins/datatables/buttons.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo e(asset('plugins/datatables/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?><br><br>

<div class="content container-fluid">
    <!-- Page Header -->
    
    <!-- /Page Header -->

    <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row">
        <div class="col-md-8">
            
            <div class="job-content job-widget">
            <h3 class="job-title"><?php echo e($service_requests->apartment->name); ?></h3>
                <ul class="job-post-det mb-2">
                <li><i class="fa fa-calculator"></i> Request Number: <span
                            class="text-blue"></span><?php echo e($service_requests->id); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                    <li><i class="fa fa-calendar"></i> Requested Date:&nbsp; <span
                            class="text-blue"></span><?php echo e($service_requests->created_at); ?></li>
                            <!--<li><i class="fa fa-money"></i> Total Spent Amount:&nbsp; <span-->
                            <!--class="text-blue"></span><?php echo e($service_requests->amount); ?></li>-->
                        <!--    <li><i class="fa fa-money"></i> Payment Status:&nbsp; <span-->
                        <!--    class="text-blue"></span><?php if($service_requests->pay_status == 0): ?>-->
                        <!--<span style="color: #FF0000;">Unpaid</span>-->
                        <!--<?php elseif($service_requests->pay_status == 1): ?>-->
                        <!--<span style="color: #66CD00;">Paid</span>-->
                        <!--<?php elseif($service_requests->pay_status == 2): ?>-->
                        <!--<span style="color: #00bfff;">Partial</span>-->
                        <!--<?php endif; ?></li>-->
                    
                </ul>
                <hr>
                <div class="job-desc-title">
                    <h4>Requested Service</h4>
                </div>
                <div class="table-responsive">
                    <?php if($service_requests->service_request_edit == null  ): ?>
                    <p><?php echo e($service_requests->service_request); ?> </p>
                    <?php elseif($service_requests->service_request_edit == $service_requests->service_request ): ?>
                    <p><?php echo e($service_requests->service_request); ?> </p>
                    <?php elseif($service_requests->approval == 2  ): ?>
                    <p><?php echo e($service_requests->service_request); ?> </p>
                    <?php else: ?>
                    <p><?php echo e($service_requests->service_request_edit); ?> </p>
                    <?php endif; ?>
                </div>

            </div>
          <?php if(Auth::user()->is_super): ?>
            <?php if($service_requests->status != 1): ?>
            <div class="mb-2"><a class="btn btn-sm btn-info"
            href="<?php echo e(route('servicerequests.edit', $service_requests->id)); ?>">Authorize Update</a>
            
    </div>
    <?php endif; ?>
    <?php endif; ?>
    <?php if(Auth::user()->is_super == 0 ): ?>
            <?php if($service_requests->approval == 3): ?>
            <div class="mb-2"><a class="btn btn-sm btn-info"
            href="<?php echo e(route('servicerequests.edit', $service_requests->id)); ?>">Amend</a>
            
    </div>
    <?php endif; ?>
    <?php endif; ?>
        </div>
        <div class="col-md-4 order-first">
            <div class=" card">
                <div class="card-body">
                    
                    <div class="info-list">
                        <span><i class="fa fa-user"></i></span>
                        <h5>Tenant Name</h5>
                        <p> <?php echo e($service_requests->tenant->full_name); ?>

                            </p>
                    </div>
                    
                    
                    <div class="info-list">
                        <span><i class="fa fa-home"></i></span>
                        <h5>House</h5>
                        <p> <?php echo e($service_requests->house->house_no); ?></p>
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-edit"></i></span>
                        <h5>Status</h5>
                        <?php if($service_requests->status_edit == 0  ): ?>
                        <h6><?php if($service_requests->status == 1): ?>
                        <p style="color: #FF0000;">CLOSED</p>
                        <?php elseif($service_requests->status == 2): ?>
                        <p style="color: #00bfff;">IN PROGRESS</p>
                        <?php elseif($service_requests->status == 0): ?>
                        <p style="color: #66CD00;">OPEN</p>
                        <?php endif; ?></h6>
                        <?php elseif($service_requests->status_edit == $service_requests->status ): ?>
                        <h6><?php if($service_requests->status == 1): ?>
                        <p style="color: #FF0000;">CLOSED</p>
                        <?php elseif($service_requests->status == 2): ?>
                        <p style="color: #00bfff;">IN PROGRESS</p>
                        <?php elseif($service_requests->status == 0): ?>
                        <p style="color: #66CD00;">OPEN</p>
                        <?php endif; ?></h6>
                        <?php elseif($service_requests->approval == 2  ): ?>
                        <h6><?php if($service_requests->status == 1): ?>
                        <p style="color: #FF0000;">CLOSED</p>
                        <?php elseif($service_requests->status == 2): ?>
                        <p style="color: #00bfff;">IN PROGRESS</p>
                        <?php elseif($service_requests->status == 0): ?>
                        <p style="color: #66CD00;">OPEN</p>
                        <?php endif; ?></h6>
                        <?php else: ?>
                         <h6><?php if($service_requests->status_edit == 1): ?>
                        <p style="color: #FF0000;">CLOSED</p>
                        <?php elseif($service_requests->status_edit == 2): ?>
                        <p style="color: #00bfff;">IN PROGRESS</p>
                        <?php elseif($service_requests->status_edit == 0): ?>
                        <p style="color: #66CD00;">OPEN</p>
                        <?php endif; ?></h6>
                        <?php endif; ?>
                    
                    </div>
                    <div class="info-list">
                        <span><i class="fa fa-list"></i></span>
                        <h5>Phone Number</h5>
                        <p><?php echo e($service_requests->tenant->phone); ?> </p>
                    </div>
                    

                    <div class="row py-3">
                        
                        
                    </div> 

                </div>


            </div>
        </div>
        
    </div>


</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer_scripts'); ?>
<!-- Required datatable js -->


<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/bedahgra/public_html/rms/work/rms/resources/views/servicerequests/show.blade.php ENDPATH**/ ?>