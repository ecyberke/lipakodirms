<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Lesa Property Agency - Tenant Statement</title>
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
                             <p><strong>Tenant Account Number:</strong> <span><?php echo e($other_info['acc_number']); ?></span></p>
                            <p><strong>House Number:</strong> <span>
                                                                    <?php echo e($other_info['house_no']); ?>

                                                                   </span></p>
                            <p><strong>Property:</strong> <span>
                                                                   <?php echo e($other_info['apartment_name']); ?>

                                                                  </span></p>
                            <p><strong>Property Owner:</strong> <span>
                                                                      <?php echo e($other_info['landlord_name']); ?>

                                                                      </span></p>
                            <p><strong>Date of Statement:</strong> <span><?php echo e($other_info['date']); ?></span></p>
                            <p><strong>Statement Period:</strong> <span><?php echo e($other_info['from_to']); ?></span></p>
                            
                        </div> <!-- end col -->
                        <div class="col-xs-6  float-right" style="float:right;text-align:right;">
                            <div class="mt-3 float-right">
                                <img src="<?php echo e(URL::asset('assets/images/les.png')); ?>" alt="" height="100">
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
                              <tr style="padding-top:0px; padding-bottom:0px;">
                                <th style="padding-top:0px; padding-bottom:0px;">Date</th>
                                <th style="padding-top:0px; padding-bottom:0px;">Description</th>
                                <th style="padding-top:0px; padding-bottom:0px;">Reference</th>
                                <th style="padding-top:0px; padding-bottom:0px;">Amount</th>
                                <th style="padding-top:0px; padding-bottom:0px;">Paid</th>
                              </tr>
                            </thead>
                            <tbody style="padding-top:0px; padding-bottom:0px;">
                                <?php $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <th style="padding-top:0px; padding-bottom:0px;"><?php echo e($entry['date']); ?></th>
                                <td style="padding-top:0px; padding-bottom:0px;"><?php echo e($entry['description']); ?></td>
                                <td style="padding-top:0px; padding-bottom:0px;"><?php echo e($entry['reference']); ?></td>
                                
                                <?php if($entry['amount'] === '-'): ?>
                                <td style="padding-top:0px; padding-bottom:0px;">
                                    <?php echo e($entry['amount']); ?>

                                </td>
                                <?php else: ?> 
                                <td style="padding-top:0px; padding-bottom:0px;">
                                    <?php echo e(number_format($entry['amount'],2)); ?>

                                </td>
                                <?php endif; ?>

                                <?php if($entry['paid_in'] === '-'): ?>
                                <td style="padding-top:0px; padding-bottom:0px;">
                                    <?php echo e($entry['paid_in']); ?>

                                </td>
                                <?php else: ?> 
                                <td style="padding-top:0px; padding-bottom:0px;">
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
                              <tr style="padding-top:0px; padding-bottom:0px;">
                                <td style="padding-top:0px; padding-bottom:0px;">Details</td>
                                <td style="padding-top:0px; padding-bottom:0px;">Amount</td>
                                <td style="padding-top:0px; padding-bottom:0px;" >Payment</td>
                              </tr>
                            </thead>
                            <tbody style="padding-top:0px; padding-bottom:0px;">
                                <tr style="padding-top:0px; padding-bottom:0px;">
                                    <td style="padding-top:0px; padding-bottom:0px;">Deposit</td>
                                    <td style="padding-top:0px; padding-bottom:0px;"><?php echo e($deposit_sum); ?></td>
                                    <td style="padding-top:0px; padding-bottom:0px;">-</td>
                                </tr>
                                <tr style="padding-top:0px; padding-bottom:0px;">
                                    <td style="padding-top:0px; padding-bottom:0px;">Rent</td>
                                    <td style="padding-top:0px; padding-bottom:0px;"><?php echo e($rent_sum); ?></td>
                                    <td style="padding-top:0px; padding-bottom:0px;">-</td>
                                </tr>
                                
                                <tr style="padding-top:0px; padding-bottom:0px;">
                                    <td style="padding-top:0px; padding-bottom:0px;">Others (Arrears & Bills)</td>
                                    <td style="padding-top:0px; padding-bottom:0px;"><?php echo e($others_sum); ?></td>
                                    <td style="padding-top:0px; padding-bottom:0px;">-</td>
                                </tr>
                                <tr style="padding-top:0px; padding-bottom:0px;">
                                    <td style="padding-top:0px; padding-bottom:0px;">Payments</td>
                                    <td style="padding-top:0px; padding-bottom:0px;">-</td>
                                    <td style="padding-top:0px; padding-bottom:0px;"><?php echo e($payments); ?></td>
                                </tr>
                                <tr style="padding-top:0px; padding-bottom:0px;">
                                    <th style="padding-top:0px; padding-bottom:0px;">Total</th>
                                    <th style="padding-top:0px; padding-bottom:0px;"><?php echo e($total); ?></th>
                                    <th style="padding-top:0px; padding-bottom:0px;"><?php echo e($payments); ?></th>
                                </tr>
                                <tr style="padding-top:0px; padding-bottom:0px;">
                                    <th style="padding-top:0px; padding-bottom:0px;">Balance</th>
                                    <th colspan="2" style="padding-top:0px; padding-bottom:0px;"><?php echo e($balance); ?></th>
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

</html><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/docs/tenantStatement.blade.php ENDPATH**/ ?>