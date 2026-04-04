<?php $__env->startSection('title', 'Submit Notice'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <form method="POST" action="<?php echo e(route('tenant.notice.submit')); ?>" class="card">
            <?php echo csrf_field(); ?>
            <div class="card-body">
                <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
                <?php endif; ?>
                <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <div class="alert alert-warning">
                    <i class="fe fe-alert-triangle"></i>
                    <strong>Important:</strong> Submitting this notice will notify management and your landlord immediately.
                    All outstanding balances will be reconciled before vacating.
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Notice Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input type="date" class="form-control" name="notice_date"
                                    min="<?php echo e(now()->format('Y-m-d')); ?>"
                                    value="<?php echo e(now()->format('Y-m-d')); ?>" required>
                            </div>
                            <small class="text-muted">Cannot be a past date</small>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Intended Vacating Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input type="date" class="form-control" name="vacating_date"
                                    min="<?php echo e(now()->addDays(30)->format('Y-m-d')); ?>" required>
                            </div>
                            <small class="text-muted">Minimum 30 days from today</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Reasons for Moving <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="reason" rows="5"
                                placeholder="Please state your reasons for vacating..." required></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary"
                            onclick="return confirm('Are you sure you want to submit this notice? Management will be notified immediately.')">
                            <i class="fe fe-send"></i> Submit Notice
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('tenant.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ecyberco/domains/lipakodi.ecyber.co.ke/public_html/rms/resources/views/tenant/notice.blade.php ENDPATH**/ ?>