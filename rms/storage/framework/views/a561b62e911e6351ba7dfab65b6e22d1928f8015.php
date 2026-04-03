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
</head>

<body>
    <!-- Begin page -->
    <div id="wrapper">
        <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <img src="https://rms.lesaagencies.co.ke/assets/images/lesa.png" alt="" height="100">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <h2>Tenant Invoice - Payment Summary</h2>
                    <h5>Date: <?php echo e($date); ?></h5>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    
                    <div class="row">
                         <table class="table table-bordered" style="padding-right:20px;">
                            <thead>
                              <tr class="text-center">
                                <th>#</th>
                                <th>Tenant Name</th>
                                <th>Telephone Number</th>
                                <th>Account Number</th>
                                <th>Total Payable</th>
                             
                                <th>Paid Oct</th>
                                <th>Paid Nov</th>
                                <th>Paid Dec</th>
                                <th>Paid Jan</th>
                                <th>Paid Feb</th>
                                <th>Paid Mar</th>
                                <th>Paid Apr</th>
                                <th>Total Paid</th>
                                <th>Balance</th>
                                
                              </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$tenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                <td><?php echo e($key+=1); ?></td>
                                <td><?php echo e($tenant->full_name); ?></td>
                                <td>+<?php echo e($tenant->phone); ?></td>
                                <td><?php echo e($tenant->account_number); ?></td>
                                <td class="text-right"><?php echo e(number_format($tenant->total_payable,2)); ?></td>
                              
                                <td class="text-right"><?php echo e(number_format($tenant->oct_payment,2)); ?></td>
                                <td class="text-right"><?php echo e(number_format($tenant->nov_payment,2)); ?></td>
                                <td class="text-right"><?php echo e(number_format($tenant->dec_payment,2)); ?></td>
                                <td class="text-right"><?php echo e(number_format($tenant->jan_payment,2)); ?></td>
                                <td class="text-right"><?php echo e(number_format($tenant->feb_payment,2)); ?></td>
                                <td class="text-right"><?php echo e(number_format($tenant->march_payment,2)); ?></td>
                                <td class="text-right"><?php echo e(number_format($tenant->april_payment,2)); ?></td>
                                <td class="text-right"><?php echo e(number_format($tenant->total_paid_mpesa,2)); ?></td>
                                <td class="text-right"><?php echo e(number_format($tenant->balance,2)); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

</html><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/docs/testInvoiceView.blade.php ENDPATH**/ ?>