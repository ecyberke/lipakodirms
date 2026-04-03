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
                    <h2>Preprinted Agency Management Form | Property:<?php echo e($ten->apartment->name); ?> </h2>
                    <h5>Date: <?php echo e($date); ?></h5>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="col-12">
                        <div class="title text-center">
                       
                            <h4></h4>
                           
                        </div>
                    </div> 
                    <div class="row">
                         <table class="table table-bordered">
                            <thead>
                              <tr class="text-center">
                                <th>#</th>
                                <th>Account Number</th>
                                <th>Phone Number</th>
                                <th>Tenant Name</th>
                                <th>Expected Monthly</th>
                                <th>Total Expected</th>
                                <th>Rent_Paid</th>
                                
                                <th>Bills_Paid</th>
                                <th>Arrears</th>
                                <th>Prepayment</th>
                                <th>Outstanding Balance</th>
                              
                                
                              </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$tenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                <td><?php echo e($key+=1); ?></td>
                                <td><?php echo e($tenant->tenant->account_number); ?></td>
                                <td>+<?php echo e($tenant->tenant->phone); ?></td>
                                <td><?php echo e($tenant->tenant->full_name); ?></td>
                                <td class="text-right"><?php echo e(number_format($tenant->rent,2)); ?></td>
                                <td class="text-right"><?php echo e(number_format($tenant->balance,2)); ?></td>
                              
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                               
                                <tr>
                                
                                <td colspan="4" >TOTALS</td>
                                <td class="text-right"><?php echo e(number_format($all_rents,2)); ?></td>
                                <td class="text-right"><?php echo e(number_format($total_balance,2)); ?></td>
                              
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                </tr>
                                
                            </tfoot>
                          </table>
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->
        </div>
    </div>
    <!-- END wrapper -->
</body>

</html><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/docs/preprinted.blade.php ENDPATH**/ ?>