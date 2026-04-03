<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>LIA Invoices</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    
    <link href=" <?php echo e(asset('assets/css/invoice_style.css')); ?> " rel="stylesheet" type="text/css" />
    
    <style>
.table-striped th, .table-striped td {
    padding: 0;
}
</style>
</head>

<body>
    <!-- Begin page -->
    <div id="wrapper">
        <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <h2>Agency Statement</h2>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-6">
                            <p><strong>Admin Name:</strong> <span><?php echo e($other_info['name']); ?></span></p>
                            <p><strong>Email:</strong> <span><?php echo e($other_info['email']); ?></span></p>
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
                                <th>Reference</th>
                                <th>Details</th>
                                <th>Income</th>
                                <th>Expense</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <th><?php echo e($entry['date']); ?></th>
                                <td><?php echo e($entry['reference']); ?></td>
                                <td><?php echo e($entry['description']); ?></td>
                                
                                <?php if($entry['income'] === '-'): ?>
                                <td class="text-center">
                                    <?php echo e($entry['income']); ?>

                                </td>
                                <?php else: ?> 
                                <td class="text-right">
                                    <?php echo e($entry['income']); ?>

                                </td>
                                <?php endif; ?>
                                <?php if($entry['expense'] === '-'): ?>
                                <td class="text-center">
                                    <?php echo e($entry['expense']); ?>

                                </td>
                                <?php else: ?> 
                                <td class="text-right">
                                    <?php echo e($entry['expense']); ?>

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
                                <td class="text-left">Details</td>
                                <td class="text-right">Amount</td>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-left">Rent Collection Commission</td>
                                    <td class="text-right"><?php echo e($rent_collection_commission); ?></td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td class="text-left">Placement Fees Income</td>
                                    <td class="text-right"><?php echo e($placement_fee_income); ?></td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td class="text-left">Other Income</td>
                                    <td class="text-right"><?php echo e($other_incomes_totals); ?></td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td class="text-left">Total</td>
                                    <td class="text-right"><?php echo e($income_total); ?></td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td class="text-left">Expenses</td>
                                    <td class="text-right">-<?php echo e($total_expense); ?></td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td class="text-left">Balance</td>
                                    <td class="text-right"><?php echo e($balance); ?></td>
                                </tr>
                            </tbody>
                          </table>
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->
        </div>
    </div>
    <!-- END wrapper -->
</body>

</html><?php /**PATH /home2/bedahgra/public_html/lesa-demo/rms/resources/views/docs/agencyStatement.blade.php ENDPATH**/ ?>