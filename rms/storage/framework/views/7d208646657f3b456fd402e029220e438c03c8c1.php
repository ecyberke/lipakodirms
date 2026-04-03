

<?php $__env->startSection('content'); ?><br><br>
<div class="content container-fluid">
<div class="card" style="padding-top:25px; padding-bottom:25px; padding-left:25px; padding-right:25px;" >
    <form action="<?php echo e(route('admin.updatepassword')); ?>" method="post">

        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="row">
            <div class="col-md-6 offset-md-3">

                <!-- Page Header -->
                <!--<div class="page-header">-->
                <!--    <div class="row">-->
                <!--        <div class="col-sm-12">-->
                <!--            <h3 class="page-title">Update Your Password</h3>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <!-- /Page Header -->

                <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <form>
                    <div class="form-group">
                        <label>Current Password <span class="text-danger"> *</span></label>
                        <input type="password" class="form-control" name="current_password">
                    </div>
                                     
                    <div class="form-group">
                        <label>New Password <span class="text-danger"> *</span></label>
                        <input type="password" class="form-control" name="new_password">
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password <span class="text-danger"> *</span></label>
                        <input type="password" class="form-control" name="new_confirm_password">
                    </div>
                    <div class="submit-section">
                        <button class="btn btn-success submit-btn" type="submit">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </form>
</div>
</div>
<!-- /Page Content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/authorization/changepass.blade.php ENDPATH**/ ?>