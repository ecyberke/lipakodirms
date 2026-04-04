<?php $__env->startSection('title', 'My Statement'); ?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('assets/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(URL::asset('assets/plugins/date-picker/date-picker.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <!-- Filter Form - same as company -->
    <div class="card">
        <form action="<?php echo e(route('tenant.statement')); ?>" method="GET">
            <div class="row">
                <div class="col-12">
                    <div class="card-body">
                        <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <label>From <span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <div class="cal-icon">
                                        <input class="form-control" type="date" name="from"
                                            value="<?php echo e($from ?? ''); ?>" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label>To <span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <div class="cal-icon">
                                        <input class="form-control" type="date" name="to"
                                            value="<?php echo e($to ?? ''); ?>" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-8">
                                <button type="submit" name="generate" value="1"
                                    class="btn btn-success waves-effect waves-light">
                                    Get Statement
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <?php if($hasReport): ?>
    <div class="card" style="padding:25px;">
        <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <h2>TENANT STATEMENT</h2>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-6">
                            <p><strong>Tenant Name:</strong> <span><?php echo e($other_info['name']); ?></span></p>
                            <p><strong>Telephone:</strong> <span><?php echo e($other_info['phone']); ?></span></p>
                            <p><strong>Tenant Account Number:</strong> <span><?php echo e($other_info['acc_number']); ?></span></p>
                            <p><strong>House Number:</strong> <span><?php echo e($other_info['house_no']); ?></span></p>
                            <p><strong>Property:</strong> <span><?php echo e($other_info['apartment_name']); ?></span></p>
                            <p><strong>Property Owner:</strong> <span><?php echo e($other_info['landlord_name']); ?></span></p>
                            <p><strong>Date of Statement:</strong> <span><?php echo e($other_info['date']); ?></span></p>
                            <p><strong>Statement Period:</strong> <span><?php echo e($other_info['from_to']); ?></span></p>
                        </div>
                        <div class="col-xs-6 float-right" style="float:right;text-align:right;">
                            <div class="mt-3 float-right">
                                <?php if($org && $org->logo): ?>
                                <img src="<?php echo e(asset('storage/'.$org->logo)); ?>" alt="<?php echo e($org->name); ?>" height="80">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="title text-center"><h4>Detailed Statement</h4></div>
                    </div>

                    <div class="row table-responsive">
                        <table class="table dt-responsive nowrap" style="border-collapse:collapse;width:100%;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Reference</th>
                                    <th>Amount</th>
                                    <th>Paid</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th><?php echo e($entry['date']); ?></th>
                                <td><?php echo e($entry['description']); ?></td>
                                <td><?php echo e($entry['reference']); ?></td>
                                <td><?php echo e($entry['amount'] === '-' ? '-' : number_format($entry['amount'], 2)); ?></td>
                                <td><?php echo e($entry['paid_in'] === '-' ? '-' : number_format($entry['paid_in'], 2)); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-12">
                        <div class="title text-center"><h4>Summary</h4></div>
                    </div>

                    <div class="row table-responsive">
                        <table class="table dt-responsive nowrap" style="border-collapse:collapse;width:100%;">
                            <thead>
                                <tr><td>Details</td><td>Amount</td><td>Payment</td></tr>
                            </thead>
                            <tbody>
                                <tr><td>Deposit</td><td><?php echo e($deposit_sum); ?></td><td>-</td></tr>
                                <tr><td>Electricity Deposit</td><td><?php echo e($electricity_deposit_sum); ?></td><td>-</td></tr>
                                <tr><td>Rent</td><td><?php echo e($rent_sum); ?></td><td>-</td></tr>
                                <tr><td>Others (Arrears & Bills)</td><td><?php echo e($others_sum); ?></td><td>-</td></tr>
                                <tr><td>Payments</td><td>-</td><td><?php echo e($payments); ?></td></tr>
                                <tr><th>Total</th><th><?php echo e($total); ?></th><th><?php echo e($payments); ?></th></tr>
                                <tr><th>Balance</th><th colspan="2"><?php echo e($balance); ?></th></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <a href="<?php echo e(request()->fullUrl()); ?>&download=yes" target="_blank"
                               class="m-2 btn btn-success waves-effect waves-light">
                                Download Statement
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(URL::asset('assets/plugins/select2/select2.full.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/date-picker/date-picker.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/date-picker/jquery-ui.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('tenant.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ecyberco/domains/lipakodi.ecyber.co.ke/public_html/rms/resources/views/tenant/statement.blade.php ENDPATH**/ ?>