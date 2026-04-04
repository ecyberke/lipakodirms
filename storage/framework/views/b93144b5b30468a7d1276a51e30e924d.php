<?php $__env->startSection('title', 'My Invoices'); ?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
        <?php endif; ?>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tenant-invoices-table">
                        <thead>
                            <tr>
                                <th style="width:4%">#</th>
                                <th style="width:13%">INV #</th>
                                <th style="width:15%">Month</th>
                                <th style="width:10%">Rent</th>
                                <th style="width:10%">Bills</th>
                                <th style="width:12%">Total Payable</th>
                                <th style="width:10%">Paid In</th>
                                <th style="width:10%">Balance</th>
                                <th style="width:5%">Status</th>
                                <th style="width:8%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($i++); ?></td>
                            <td>INV #<?php echo e($inv->id); ?></td>
                            <td><?php echo e($inv->rent_month); ?></td>
                            <td><?php echo e($org->currency ?? 'KES'); ?> <?php echo e(number_format($inv->rent ?? 0)); ?></td>
                            <td><?php echo e($org->currency ?? 'KES'); ?> <?php echo e(number_format($inv->bills ?? 0)); ?></td>
                            <td><strong><?php echo e($org->currency ?? 'KES'); ?> <?php echo e(number_format($inv->total_payable ?? 0)); ?></strong></td>
                            <td class="text-success"><?php echo e($org->currency ?? 'KES'); ?> <?php echo e(number_format($inv->paid_in ?? 0)); ?></td>
                            <td class="<?php echo e(($inv->balance ?? 0) > 0 ? 'text-danger font-weight-bold' : 'text-success'); ?>">
                                <?php echo e($org->currency ?? 'KES'); ?> <?php echo e(number_format($inv->balance ?? 0)); ?>

                            </td>
                            <td>
                                <?php if(($inv->balance ?? 0) <= 0): ?>
                                    <span class="badge badge-success">Paid</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Unpaid</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="text-right">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-item">
                                                <a class="btn btn-sm btn-info btn-block" href="<?php echo e(route('tenant.invoice.show', $inv->id)); ?>"> View</a>
                                            </div>
                                            <?php if(($inv->balance ?? 0) > 0): ?>
                                            <div class="dropdown-item">
                                                <a class="btn btn-sm btn-success btn-block" href="#"
                                                    data-toggle="modal" data-target="#stkModal<?php echo e($inv->id); ?>"> Pay Now</a>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="10" class="text-center text-muted">No invoices found</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if(($inv->balance ?? 0) > 0): ?>
<div class="modal fade" id="stkModal<?php echo e($inv->id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-mobile text-primary"></i>
                    INV #<?php echo e($inv->id); ?> — <?php echo e($inv->rent_month); ?> Payment
                </h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="<?php echo e(route('mpesa.stk.push', $inv->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <img src="https://www.safaricom.co.ke/images/Lipanampesa.png" alt="M-PESA" style="height:70px;width:auto;">
                    </div>
                    <div class="form-group">
                        <label>Amount to Pay <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo e($org->currency ?? 'KES'); ?></span>
                            <input type="number" class="form-control form-control-lg"
                                name="amount" value="<?php echo e($inv->balance); ?>"
                                min="1" max="<?php echo e($inv->balance); ?>" step="1" required>
                        </div>
                        <small class="text-muted">Balance: <?php echo e($org->currency ?? 'KES'); ?> <?php echo e(number_format($inv->balance)); ?></small>
                    </div>
                    <div class="form-group">
                        <label>M-PESA Phone Number <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fe fe-phone"></i></span>
                            <input type="text" class="form-control"
                                name="phone" value="<?php echo e($tenant->phone); ?>"
                                placeholder="e.g. 0712345678" required>
                        </div>
                    </div>
                    <div class="bg-light p-3 rounded">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Month:</span><strong><?php echo e($inv->rent_month); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between pt-2" style="border-top:1px solid #dee2e6;">
                            <span class="font-weight-bold">Balance Due:</span>
                            <span class="font-weight-bold text-danger"><?php echo e($org->currency ?? 'KES'); ?> <?php echo e(number_format($inv->balance)); ?></span>
                        </div>
                    </div>
                    <div class="alert alert-info p-2 mt-3 mb-0">
                        <i class="fe fe-info"></i>
                        <small>You will receive an M-Pesa prompt. Enter your PIN to complete payment.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fe fe-smartphone"></i> Send M-Pesa Prompt
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')); ?>"></script>
<script>
$(function() {
    $('#tenant-invoices-table').DataTable({
        "pageLength": 25,
        "order": [[2, "desc"]],
        "columnDefs": [{"orderable": false, "targets": [9]}]
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('tenant.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ecyberco/domains/lipakodi.ecyber.co.ke/public_html/rms/resources/views/tenant/invoices.blade.php ENDPATH**/ ?>