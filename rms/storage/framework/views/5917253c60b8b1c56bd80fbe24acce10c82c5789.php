

<?php $__env->startPush('header_scripts'); ?>
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap-datetimepicker.min.css')); ?>">

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4 d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Bills</h3>
            </div>
            <div class="col-auto float-right ml-auto">
                
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row myinvoice">
        <div class="col-md-12">
            <div class="card px-5">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 m-b-20">
                            <img src="assets/img/lesa.png" class="inv-logo" alt="">
                           
                            <div class="row mt-3">
                                <div class="col-sm-4">
                                    
                                </div> <!-- end col -->

                               <!-- end col -->
                            </div>
                        </div>
                        <div class="col-sm-6 m-b-20">
                            <div class="invoice-details">
                                <h3 class="text-uppercase text-blue">Bill #-<?php echo e($payowners->id); ?></h3>
                                <ul class="list-unstyled">
                                    <li>Date: <span><?php echo e($payowners->created_at); ?></span></li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-lg-7 col-xl-8 m-b-20">
                            <h5>Bill from:</h5>
                            <ul class="list-unstyled">
                                <li>
                                    <h5><strong>
                                    <?php if($payowners->apartment_id > 0 && $payowners->type == 'Rent Collection'): ?>
                                    <?php echo e($payowners->apartment->landlord->full_name); ?>

                                    <?php else: ?>
                                    Lesa International Agencies
                                    <?php endif; ?>
                                    </strong></h5>
                                </li>
                                <li>
                                    <?php if($payowners->apartment_id > 0 && $payowners->type == 'Rent Collection'): ?>
                                   <?php echo e($payowners->apartment->landlord->phone_no); ?>

                                    <?php else: ?>
                                    
                                    <?php endif; ?>
                                    </li>
                                <li class="text-blue">
                                    <?php if($payowners->apartment_id > 0 && $payowners->type == 'Rent Collection'): ?>
                                   <?php echo e($payowners->apartment->landlord->email); ?>

                                    <?php else: ?>
                                    business@lesaagecies.co.ke
                                    <?php endif; ?>
                                    </li>
                                
                            </ul> 
                        </div>
                        <div class="col-sm-6 col-lg-5 col-xl-4 m-b-20">
                            <span class="text-muted">Billing Details:</span>
                            <ul class="list-unstyled invoice-payment-details">
                                <li>
                                    <h5>Total Balance: <span class="text-right font-weight-bold">Ksh
                                            <?php echo e(number_format($payowners->balance)); ?></span>
                                    </h5>
                                </li>
                                
                                <li>Property: <span><?php if($payowners->apartment_id > 0): ?>
                                   <?php echo e($payowners->apartment->name); ?>

                                    <?php else: ?>
                                    Lesa Agencies
                                    <?php endif; ?></span></li>
                               
                                <li>Status:
                                    <?php if($payowners->pay_status===1): ?>
                                    <span class="text-success font-weight-bold"> PAID </span>
                                    <?php else: ?>
                                    <span class="text-danger font-weight-bold"> UNPAID </span>
                                    <?php endif; ?>



                            </ul>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="d-none d-sm-table-cell">DESCRIPTION</th>
                                    <th class="text-right">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr>
                                    <td>1</td>
                                    <?php if($payowners->type == 'Rent Collection'): ?>
                                    <td class="d-none d-sm-table-cell"> Rent Collection </td>
                                    
                                    <?php elseif($payowners->type == '--select--'): ?>
                                    <td class="d-none d-sm-table-cell"> <?php echo e($payowners->new_type); ?></td>
                                    
                                    <?php elseif($payowners->type != 'Rent Collection' && $payowners->type != '--select--'): ?>
                                    <td class="d-none d-sm-table-cell"> <?php echo e($payowners->type); ?> </td>
                                    
                                    <?php endif; ?>
                                    <td class="text-right">Ksh <?php echo e(number_format($payowners->total_owned)); ?></td>
                                </tr>
                               

                                
                            </tbody>
                        </table>
                    </div>
                    <?php if($payowners->proof): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?php echo e(asset('rms/storage/app/agency_files/'.$payowners->proof)); ?>" target="_blank" class="btn btn-primary btn-sm">View Doc</a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div>
                        <div class="row invoice-payment">
                            <div class="col-sm-7">
                            </div>
                            <div class="col-sm-5">
                                <div class="m-b-20">
                                    <div class="table-responsive no-border">
                                        <table class="table mb-0">
                                            <tbody>
                                                <tr>
                                                    <th>Subtotal:</th>
                                                    <td class="text-right">Ksh.
                                                        <?php echo e(number_format($payowners->total_owned)); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Total Paid:</th>
                                                    <td class="text-right text-info text-bold">
                                                        Ksh.
                                                            <?php echo e(number_format($payowners->paid_in)); ?>

                                                        
                                                    </td>
                                                </tr>
                                             <tr>
                                                    <th>Balance: <span class="text-regular"></span></th>
                                                    <td class="text-right text-info text-bold">Ksh <?php echo e(number_format($payowners->balance)); ?></td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/payowners/payowners.blade.php ENDPATH**/ ?>