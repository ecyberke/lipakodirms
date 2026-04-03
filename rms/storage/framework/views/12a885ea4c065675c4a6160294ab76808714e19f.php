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
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <!-- Logo & title -->
                                <div class="clearfix">
                                    <div class="float-left">
                                         <img src="https://rms.lesaagencies.co.ke/assets/images/lesa.png" alt="Lesa Logo" height="100">
                                    </div>
                                    <div class="float-right">
                                        
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                      

                                    </div><!-- end col -->
                                    <div class="col-xs-4 offset-xs-2 float-right" style="float:right;text-align:right;">
                                        <div class="mt-3 float-right">
                                            <p class="m-b-10"><strong>Generated On : </strong> <span
                                                    class="float-right">
                                                    <?php echo e($invoice->created_at); ?></span></p>
                                            <p class="m-b-10"><strong>Payment Status : </strong>
                                                <span
                                                class="float-right">
                                                    <?php if($invoice->status===1): ?>
                                                    <span style="color: seagreen;">Paid</span>
                                                    <?php elseif($invoice->status===0 && $invoice->paid_in > 0 ): ?>
                                                    <span style="color: orange;">Partial Payment</span>
                                                    <?php else: ?>
                                                    <span style="color: red;">Unpaid</span>
                                                    <?php endif; ?>
                                                    
                                   



                                                </span></p>
                                            <p class="m-b-10"><strong>Bill No. : </strong> <span
                                                    class="float-right" style="color: royalblue;">#<?php echo e($invoice->id); ?> </span></p>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                              <div class="row mt-3">
                                    <div class="col-xs-4">
                                        <p><b>Tenant Details</b> </p>
                                        <address>
                                    
                                             Name: <?php echo e($invoice->tenant_name); ?>

                                              <br>
                                             
                                      
                                       
                                        Phone Number: +<?php echo e($invoice->tenant->phone); ?>

                                             <br>
                                               Account Number:<?php echo e($invoice->tenant->account_number); ?>

                                             <br>
                                          
                                        </address>
                                    </div> <!-- end col -->

                                    <div class="col-xs-6">
                                        <p><b>House Details</b> </p>
                                        <address>
                                           
                                           <li>House:
                                            <span class="text-success "> <?php echo e($invoice->house->house_no); ?> </span>
                                            
                                </li>
                                <li>Property:
                                            <span class="text-success"> <?php echo e($invoice->house->apartment->name); ?> </span>
                                          
                                </li>
                                <li>Property Type:
                                            <span class="text-success "> <?php echo e($invoice->house->house_type); ?> </span>
                                            </li>
                             
                                                                       
                                        </address>
                                    </div> <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover text-nowrap">
											    
												<tr>
                                   
                                    <th class="d-none d-sm-table-cell">DESCRIPTION</th>
                                    <th class="text-right">TOTAL</th>
                                </tr>
                                
                                <tr>
                              
                                    <td class="d-none d-sm-table-cell"> Deposit Amount </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->deposit_amount )); ?> </td>
                                </tr>
                                <?php if($invoice->total_repair_amount > 0): ?>
                                <tr>
                                
                                   
                                    <td class="d-none d-sm-table-cell"> Repairs </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->total_repair_amount)); ?></td>
                                </tr>
                                <?php endif; ?>
                               
                               
                                

                                <?php
                                $count=3;
                                ?>

                               
												
												
											
											
                                
                                                <tr>
                                                   	<td colspan="1" class="font-weight-bold text-uppercase text-right h5 mb-0">Sub Total</td>
                                                    <td class="text-right">Ksh
                                                        <?php echo e(number_format($invoice->deposit_amount - $invoice->total_repair_amount  )); ?> 
                                                    </td>
                                                </tr>
                                                <tr>
                                                   	<td colspan="1" class="font-weight-bold text-uppercase text-right h5 mb-0">Total Paid</td>
                                                    <?php if($invoice->paid_in === null): ?>
                                                    <td class="text-right text-danger text-bold">Ksh. 0
                                                    </td>
                                                    <?php else: ?>
                                                    <td class="text-right text-success text-bold">Ksh.<?php echo e(number_format($invoice->paid_in - $invoice->total_repair_amount  )); ?>

                                                    </td>
                                                    <?php endif; ?>
                                                </tr>
                                                
                                             <tr>
													<td colspan="1" class="font-weight-bold text-uppercase text-right h5 mb-0">Total Due</td>
													<?php if($invoice->balance === null): ?>
													<td class="text-right text-danger text-bold">Ksh <?php echo e(number_format($invoice->deposit_amount - $invoice->total_repair_amount )); ?></td>
													<?php else: ?>
													<td class="text-right text-danger text-bold">Ksh <?php echo e(number_format($invoice->balance)); ?></td>
													<?php endif; ?>
												</tr>
                                    			
												<tr>
												    
													<td colspan="5" class="text-right">
													</td>
												</tr>
											</table>
                                            </table>
                                        </div> <!-- end table-responsive -->
                                    </div> <!-- end col -->
                                </div>
                                <br/>
                   
                    
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-xs-9">
                                        <div class="clearfix pt-5">
                                           
                                        </div>
                                        
                                    </div> <!-- end col -->
                                   
                                </div>
                                <!-- end row -->
                            </div> <!-- end card-box -->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->
        </div>
    </div>
    <!-- END wrapper -->
</body>

</html>
<?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/tenants/invoicepdf.blade.php ENDPATH**/ ?>