

<?php $__env->startPush('header_scripts'); ?>
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap-datetimepicker.min.css')); ?>">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<style>
.table-striped th, .table-striped td {
    padding: 0;
}
</style>


<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">

    <!-- Page Title -->
    <div class="row">
        
    </div>
    <!-- /Page Title -->

    <!-- Content Starts -->
    <div class="card">
        <form action="<?php echo e(route('tenant_statement')); ?>" method="get">
            <?php echo csrf_field(); ?>
            
            
            <div class="row">
               
    
                <div class="col-12">
                    <div class="">
                        <div class="card-body">
                            
    
                            
                            <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            
                            <div class="row">
                                <div class="col-sm-12">
                                <label >Select Tenant <span class="text-danger">*</span></label>
                              
                                
                                <select class="form-control select2-show-search" style="width: 100%"  name="tenant_id">
    
                                    <option selected disabled>-----Select-----</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant=>$key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($key); ?>"><?php echo e($tenant); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    
                                        <?php endif; ?>
    
                                </select>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-6">
                                <label>From <span
                                        class="text-danger">*</span></label>
                                
                                    <div class="form-group">
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" name="from"
                                             placeholder="dd/mm/yyyy"   value="<?php echo e(old('placement_date')); ?>">
                                        </div>
                                    </div>
    
                                </div>
                                <div class="col-sm-6">
                                <label >To<span
                                    class="text-danger">*</span></label>
                            
                                <div class="form-group">
                                    <div class="cal-icon">
                                        <input class="form-control datetimepicker" type="text" name="to"
                                            placeholder="dd/mm/yyyy" value="<?php echo e(old('placement_date')); ?>">
                                    </div>
                                </div>
    
                            </div>
                            </div><br>
    
                            <div class="row mb-4">
                                <div class="col-sm-8">
                                    
                                   
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Get Statement</button></button>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
        </form>
        
        </div>
        <?php if($hasReport): ?>
 <div class="card" style="padding-top:25px; padding-bottom:25px; padding-left:25px; padding-right:25px;">
        <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <h2>TENANT STATEMENT</h2>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-6">
                            <p><strong>Tenant Name:</strong> <span><?php echo e($other_info['name']); ?></span></p>
                            <p><strong>Telephone:</strong> <span><?php echo e($other_info['phone']); ?></span></p>
                            <p><strong>Date of Statement:</strong> <span><?php echo e($other_info['date']); ?></span></p>
                            <p><strong>Statement Period:</strong> <span><?php echo e($other_info['from_to']); ?></span></p>
                        </div> <!-- end col -->
                        <div class="col-xs-6  float-right" style="float:right;text-align:right;">
                            <div class="mt-3 float-right">
                                <img src="https://lesaagencies.co.ke/rms/assets/img/lesa.png" alt="" height="100">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="title text-center">
                            <h4>Detailed Statement</h4>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped">
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
                                
                                <?php if($entry['amount'] === '-'): ?>
                                <td>
                                    <?php echo e($entry['amount']); ?>

                                </td>
                                <?php else: ?> 
                                <td >
                                    <?php echo e(number_format($entry['amount'],2)); ?>

                                </td>
                                <?php endif; ?>

                                <?php if($entry['paid_in'] === '-'): ?>
                                <td>
                                    <?php echo e($entry['paid_in']); ?>

                                </td>
                                <?php else: ?> 
                                <td >
                                    <?php echo e(number_format($entry['paid_in'],2)); ?>

                                </td>
                                <?php endif; ?>
                              </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                          </table>
                    </div>
                    <div class="col-12">
                        <div class="title text-center">
                            <h4>Summary</h4>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                              <tr>
                                <td>Details</td>
                                <td >Amount</td>
                                <td>Payment</td>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Deposit</td>
                                    <td ><?php echo e($deposit_sum); ?></td>
                                    <td >-</td>
                                </tr>
                                <tr>
                                    <td>Rent</td>
                                    <td ><?php echo e($rent_sum); ?></td>
                                    <td>-</td>
                                </tr>
                                
                                <tr>
                                    <td>Others</td>
                                    <td ><?php echo e($others_sum); ?></td>
                                    <td >-</td>
                                </tr>
                                <tr>
                                    <td>Payments</td>
                                    <td >-</td>
                                    <td><?php echo e($payments); ?></td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <th ><?php echo e($total); ?></th>
                                    <th ><?php echo e($payments); ?></th>
                                </tr>
                                <tr>
                                    <th>Balance</th>
                                    <th colspan="2"><?php echo e($balance); ?></th>
                                </tr>
                            </tbody>
                          </table>
                    </div>
                    <!-- end row -->
                    
                    <div class="row">
                        <div class="col-md-12 text-center">
                                <a  href="<?php echo e(\Request::fullUrl()); ?>&download=yes" target="_blank" class="m-2 btn btn-success waves-effect waves-light">Download Statement</a>
                            </div>
                    </div>

                </div> <!-- container -->

            </div> <!-- content -->
        </div>
    </div>


    <!-- /Content End -->
         <?php endif; ?>
</div>

                    
           



<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer_scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
     $(document).ready(function() {
    $('.js-example-basic-single').select2();
});

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/bedahgra/public_html/rms/work/rms/resources/views/report/tenantform.blade.php ENDPATH**/ ?>