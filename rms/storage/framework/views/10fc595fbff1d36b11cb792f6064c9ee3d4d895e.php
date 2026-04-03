

<?php $__env->startSection('content'); ?>

<!-- Page Content -->
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-9">
                
                
            </div>
            <!--<div>-->
            <!--    <a href="<?php echo e(route('admin.create')); ?>" class="btn btn-success">-->
            <!--        Add User</a>-->
            <!--</div>-->
        </div>
    </div>
    <!-- /Page Header -->


<div class="card">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">

                <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <table class="table table-striped custom-table mb-0">
                    <thead>
                        <tr>
                            <th style="width:40%">Notification</th>
                            <th style="width:40%">Type</th>
                            <th style="width:20%">Date</th>
                            
                           
                        </tr>
                    </thead>
                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $service; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td >
                                <?php echo e($user->notification); ?>

                            </td>
                            <td >
                                 <a class="btn btn-sm btn-info"
            href="<?php echo e(route('servicerequests.show', $user->id)); ?>">
                                Service Request Number <?php echo e($user->id); ?></a>
                            </td>
                            <td><?php echo e($user->updated_at); ?></td>
                            
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <?php endif; ?>
                        <?php $__empty_1 = true; $__currentLoopData = $bill; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td >
                                <?php echo e($user->notification); ?>

                            </td>
                            <td >
                                 <a class="btn btn-sm btn-info"
            href="<?php echo e(route('payowner.show', $user->id)); ?>">
                                Bill Number <?php echo e($user->id); ?></a>
                            </td>
                            <td><?php echo e($user->updated_at); ?></td>
                            
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <?php endif; ?>
                        <?php $__empty_1 = true; $__currentLoopData = $managerpayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td >
                                <?php if($user->status == 0): ?>
                               The payment is awaiting approval
                               <?php elseif($user->status == 1): ?>
                               The payment has been approved
                               <?php else: ?>
                               The payment has been rejected, should be deleted
                               <?php endif; ?>
                            </td>
                            <td >
                                <?php if($user->status == 0): ?>
                                 <a class="btn btn-sm btn-info"
            href="<?php echo e(route('managerpayment.edit', $user->id)); ?>">
                                Pending Payment - Edit Payment</a>
                                <?php elseif($user->status == 1): ?>
                                <a class="btn btn-sm btn-success"
            href="#">
                                Authorized Payment - Approved</a>
                                <?php else: ?>
                                <a class="btn btn-sm btn-danger"
            href="<?php echo e(route('managerpayment.delete', $user->id)); ?>">
                                Rejected Payment - Delete</a>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($user->updated_at); ?></td>
                            
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div></div>
<!-- /Page Content -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer_scripts'); ?>
<script>
   $(document).on('submit','.delete-form',function(event){
           return confirm(" Are you sure you want to delete this admin ? ");
   });

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/authorization/notification.blade.php ENDPATH**/ ?>