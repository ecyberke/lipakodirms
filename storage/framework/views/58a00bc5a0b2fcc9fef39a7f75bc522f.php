<?php $__env->startSection('title', 'My Payments'); ?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0" id="payments-table">
                        <thead>
                            <tr>
                                <th style="width:3%">#</th>
                                <th style="width:20%">Name</th>
                                <th style="width:15%">Account No.</th>
                                <th style="width:12%">Payment Method</th>
                                <th style="width:18%">Transaction Code</th>
                                <th style="width:12%">Amount</th>
                                <th style="width:15%">Date</th>
                                <th class="text-right" style="width:5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($i++); ?></td>
                            <td><?php echo e($pay->full_name); ?></td>
                            <td><?php echo e($pay->InvoiceNumber); ?></td>
                            <td><?php echo e($pay->TransactionType); ?></td>
                            <td><?php echo e($pay->TransID); ?></td>
                            <td class="text-success font-weight-bold">
                                <?php echo e($org->currency ?? 'KES'); ?> <?php echo e(number_format($pay->TransAmount)); ?>

                            </td>
                            <td><?php echo e(\Carbon\Carbon::parse($pay->payment_date ?? $pay->created_at)->format('d M Y')); ?></td>
                            <td class="text-right">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-item">
                                            <a class="btn btn-sm btn-success btn-block"
                                                href="<?php echo e(route('tenant.receipt', $pay->id)); ?>">
                                                Download Receipt
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="8" class="text-center text-muted">No payments recorded yet</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php echo e($payments->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')); ?>"></script>
<script>
$(function() {
    $('#payments-table').DataTable({
        "pageLength": 25,
        "order": [[6, "desc"]],
        "columnDefs": [{"orderable": false, "targets": [7]}]
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('tenant.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ecyberco/domains/lipakodi.ecyber.co.ke/public_html/rms/resources/views/tenant/payments.blade.php ENDPATH**/ ?>