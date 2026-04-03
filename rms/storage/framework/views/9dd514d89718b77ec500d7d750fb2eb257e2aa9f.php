<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Lesa Property Agency - Agency Status Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <link href=" <?php echo e(asset('assets/css/invoice_style.css')); ?> " rel="stylesheet" type="text/css" />
    
    <style>
.table-hover th, .table-hover td {
    padding: 0;
}
.table-info{
    background-color: #86cfda;
}
</style>
</head>

<body>
    <!-- Begin page -->
    <div id="wrapper">
        <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <h2>Agency Status Report</h2>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                     <div class="row">
                        <div class="col-xs-6">
                            <p><strong>Report Month:</strong> <span><?php echo e($rent_month); ?></span></p>
                            <p><strong>Total Earnings:</strong> <span><?php echo e(number_format($total_paid_in)); ?></span></p>
                        </div> <!-- end col -->
                        <div class="col-xs-6  float-right" style="float:right;text-align:right;">
                             <div class="mt-3 float-right">
                                <img src="<?php echo e(URL::asset('assets/images/les.png')); ?>" alt="" height="100">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-hover">
                            <thead>
                              <tr>
                                  <th>Acc No</th>
                                <th>Tenant Name</th>
                                <th>House</th>
                                <th>Property Name</th>
                                <th>Property Owner</th>
                                <th class="text-right">Expected Monthly Rent</th>
                                <th class="text-right">Total Expected</th>
                                <th class="text-right">Total Paid</th>
                                <th class="text-right">Arrears</th>
                                <th class="text-right">Prepayment</th>
                                <th class="text-right">Outstanding Balance</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                   <th><?php echo e($entry['acc_no']); ?></th>
                                <th><?php echo e($entry['tenant_name']); ?></th>
                                <th><?php echo e($entry['house_name']); ?></th>
                                <th><?php echo e($entry['apartment_name']); ?></th>
                                <td><?php echo e($entry['land_lord']); ?></td>
                                <td class="text-right"><?php echo e(number_format($entry['rent'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($entry['total_payable'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($entry['paid_in'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($entry['carryforward'])); ?></td>
                                <td class="text-right">-</td>
                                <td class="text-right"><?php echo e(number_format($entry['balance'])); ?></td>
                              </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <th colspan="4">Totals</th>
                                <th class="text-right"><?php echo e(number_format($totals['total_rent'])); ?></th>
                                <th class="text-right"><?php echo e(number_format($totals['total_payable'])); ?></th>
                                <th class="text-right"><?php echo e(number_format($totals['total_paid_in'])); ?></th>
                                <th class="text-right"><?php echo e(number_format($totals['total_carryforward'])); ?></th>
                                <td class="text-right">-</td>
                                <th class="text-right"><?php echo e(number_format($totals['total_balance'])); ?></th>
                              </tr>
                            </tbody>
                          </table>
                    </div>

                </div> <!-- container -->

            </div> <!-- content -->
        </div>
    </div>
    <!-- END wrapper -->
</body>

</html><?php /**PATH /home/lesaprop/rmsprop/rms/resources/views/docs/agency_status.blade.php ENDPATH**/ ?>