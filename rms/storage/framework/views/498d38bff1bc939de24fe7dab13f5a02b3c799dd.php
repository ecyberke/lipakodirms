
<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-header'); ?>
						<!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title">Invoice</h4>
							</div>
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
									<!--<li class="breadcrumb-item"><a href="#">Forms</a></li>-->
									<li class="breadcrumb-item active" aria-current="page">Invoices</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
						<!-- Row-->
						<div class="row">
							<div class="col-md-12">
								<div class="card overflow-hidden">
									<div class="card-status bg-primary"></div>
									<div class="card-body">
										<h2 class="text-muted font-weight-bold">INVOICE</h2>
										<!--<div class="">-->
										<!--	<h5 class="mb-1">Hi <strong>Jessica Allen</strong>,</h5>-->
										<!--	This is the receipt for a payment of <strong>$450.00</strong> (USD) for your works-->
										<!--</div>-->

										<div class="card-body pl-0 pr-0">
											<div class="row">
												<div class="col-sm-6">
													<span>Invoice No.</span><br>
													<strong>INV #<?php echo e($invoice->id); ?></strong>
												</div>
												<div class="col-sm-6 text-right">
													<span>Generated Date</span><br>
													<strong><?php echo e($invoice->created_at); ?></strong>
												</div>
											</div>
										</div>
										<div class="dropdown-divider"></div>
										<div class="row pt-4">
											<div class="col-lg-6 ">
												<p class="h5 font-weight-bold">Billing Details</p>
												<address>
													<li>House:  <?php if($invoice->house_id > 0): ?>
                                            <span class="text-success "> <?php echo e($invoice->house->house_no); ?> </span>
                                            <?php elseif($invoice->house_id == 0): ?>
                                            <span class="text-success "> <?php echo e($invoice->house_name); ?> </span>
                                            <?php else: ?>
                                            <span class="text-success "> NO HOUSE </span>
                                            
                                            <?php endif; ?>
                                </li>
                                <li>Property: 
                                            <?php if($invoice->apartment_id > 0): ?>
                                            <span class="text-success"> <?php echo e($invoice->house->apartment->name); ?> </span>
                                            <?php elseif($invoice->apartment_id == 0): ?>
                                            <span class="text-success "> <?php echo e($invoice->apartment_name); ?> </span>
                                            <?php else: ?>
                                            <span class="text-success "> NO APARTMENT </span>
                                            
                                            <?php endif; ?>
                                
                                <!--<li>Property Type: -->
                                <!--            <?php if($invoice->house_id > 0): ?>-->
                                <!--            <span class="text-success "> <?php echo e($invoice->house->house_type); ?> </span>-->
                                            
                                <!--            <?php else: ?>-->
                                <!--            <span class="text-success"> NO TYPE INDICATED </span>-->
                                            
                                <!--            <?php endif; ?>-->
                             
                                <li>Status:
                                    <?php if($invoice->is_paid===1): ?>
                                    <span class="text-success font-weight-bold"> PAID </span>
                                    <?php elseif($invoice->is_paid===0 && $invoice->paid_in > 0 ): ?>
                                    <span class="text-warning font-weight-bold"> PARTIAL PAYMENT</span>
                                    <?php else: ?>
                                    <span class="text-danger font-weight-bold"> UNPAID </span>
                                    <?php endif; ?>

												</address>
											</div>
											<div class="col-lg-6 text-right">
												<p class="h5 font-weight-bold">Bill To</p>
												 <address>
                                        Name: <?php if($invoice->tenant_id > 0): ?>
                                              <?php echo e($invoice->tenant->full_name); ?>

                                              <?php else: ?>
                                              <?php echo e($invoice->tenant_name); ?>

                                              <?php endif; ?> <br>
                                             
                                      
                                       
                                        Phone Number: <?php if($invoice->tenant_phone == 0): ?>
                                              <?php echo e($invoice->tenant->phone); ?>

                                              <?php else: ?>
                                              <?php echo e($invoice->tenant_phone); ?>

                                              <?php endif; ?><br>
                                        
                                    </address>
											</div>
										</div>
										<div class="table-responsive push">
											<table class="table table-bordered table-hover text-nowrap">
											    
												<tr>
                                    <th>#</th>
                                    <th class="d-none d-sm-table-cell">DESCRIPTION</th>
                                    <th class="text-right">TOTAL</th>
                                </tr>
												<?php if($invoice->deposit_paid == 0 && $invoice->carryforward == 0 && $invoice->type != 'rent and deposit' && $invoice->type != 'others' && $invoice->litter_bill == 0  ): ?>
                                <tr>
                                    <td>1</td>
                                    <td class="d-none d-sm-table-cell"> House Rent </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->rent)); ?></td>
                                </tr>
                                 <?php elseif($invoice->deposit_paid > 0 && $invoice->carryforward == 0 ): ?>
                                <tr>
                                    <td>1</td>
                                    <td class="d-none d-sm-table-cell"> House Rent </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->rent)); ?></td>
                                </tr>
                                <tr>
                                
                                    <td>2</td>
                                    <td class="d-none d-sm-table-cell"> Deposit </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->deposit_paid)); ?></td>
                                </tr>
                               
                               
                                
                                <?php elseif($invoice->carryforward > 0 && $invoice->deposit_paid == 0): ?>
                                 <tr>
                                    <td>1</td>
                                    <td class="d-none d-sm-table-cell"> House Rent </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->rent)); ?></td>
                                </tr>
                                
                                 <tr>
                                    
                                    <td>2</td>
                                    <td class="d-none d-sm-table-cell"> Arrears</td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->carryforward)); ?></td>
                                </tr>
                                
                                <?php elseif($invoice->carryforward > 0 && $invoice->deposit_paid > 0): ?>
                                 <tr>
                                    <td>1</td>
                                    <td class="d-none d-sm-table-cell"> House Rent </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->rent)); ?></td>
                                </tr>
                                <tr>
                                
                                    <td>2</td>
                                    <td class="d-none d-sm-table-cell"> Deposit </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->deposit_paid )); ?></td>
                                </tr>
                                 <tr>
                                    
                                    <td>3</td>
                                    <td class="d-none d-sm-table-cell"> Arrears</td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->carryforward)); ?></td>
                                </tr>
                                
                                <?php elseif($invoice->carryforward > 0 && $invoice->deposit_paid == 0): ?>
                                 <tr>
                                    <td>1</td>
                                    <td class="d-none d-sm-table-cell"> House Rent </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->rent)); ?></td>
                                </tr>
                                
                                 <tr>
                                    
                                    <td>2</td>
                                    <td class="d-none d-sm-table-cell"> Arrears</td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->carryforward)); ?></td>
                                </tr>
                                
                                <?php elseif($invoice->carryforward > 0 && $invoice->deposit_paid > 0): ?>
                                 <tr>
                                    <td>1</td>
                                    <td class="d-none d-sm-table-cell"> House Rent </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->rent)); ?></td>
                                </tr>
                                <tr>
                                
                                    <td>2</td>
                                    <td class="d-none d-sm-table-cell"> Deposit </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->deposit_paid )); ?></td>
                                </tr>
                                 <tr>
                                    
                                    <td>3</td>
                                    <td class="d-none d-sm-table-cell"> Arrears</td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->carryforward)); ?></td>
                                </tr>
                                
                                 <?php elseif($invoice->rent > 0 && $invoice->electricity_bill > 0 && $invoice->litter_bill == 0 ): ?>
                                 <tr>
                                    <td>1</td>
                                    <td class="d-none d-sm-table-cell"> House Rent </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->rent)); ?></td>
                                </tr>
                                <tr>
                                
                                    <td>2</td>
                                    <td class="d-none d-sm-table-cell"> Deposit </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->deposit_paid )); ?></td>
                                </tr>
                                 <tr>
                                    
                                    <td>3</td>
                                    <td class="d-none d-sm-table-cell"> Arrears</td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->carryforward)); ?></td>
                                </tr>
                                <tr>
                                    
                                    <td>4</td>
                                    <td class="d-none d-sm-table-cell"> Electricity & Water</td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->electricity_bill)); ?></td>
                                </tr>
                                <?php elseif($invoice->rent > 0 && $invoice->electricity_bill > 0 && $invoice->litter_bill > 0 && $invoice->overpayment == 0): ?>
                                 <tr>
                                    <td>1</td>
                                    <td class="d-none d-sm-table-cell"> House Rent </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->rent)); ?></td>
                                </tr>
                                <tr>
                                
                                    <td>2</td>
                                    <td class="d-none d-sm-table-cell"> Electricity & Water Bill </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->electricity_bill )); ?></td>
                                </tr>
                                 <tr>
                                    
                                    <td>3</td>
                                    <td class="d-none d-sm-table-cell"> Litter Bill</td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->litter_bill)); ?></td>
                                </tr>
                                
                                <?php elseif($invoice->rent > 0 && $invoice->compound_bill > 0): ?>
                                 <tr>
                                    <td>1</td>
                                    <td class="d-none d-sm-table-cell"> House Rent </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->rent)); ?></td>
                                </tr>
                                <tr>
                                
                                    <td>2</td>
                                    <td class="d-none d-sm-table-cell"> Deposit </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->deposit_paid )); ?></td>
                                </tr>
                                 <tr>
                                    
                                    <td>3</td>
                                    <td class="d-none d-sm-table-cell"> Arrears</td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->carryforward)); ?></td>
                                </tr>
                                <tr>
                                    
                                    <td>4</td>
                                    <td class="d-none d-sm-table-cell"> Compound Cleaning and Maintenance</td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->compound_bill)); ?></td>
                                </tr>
                                 <?php elseif($invoice->rent > 0 && $invoice->litter_bill > 0 && $invoice->overpayment == 0 && $invoice->electricity_bill == 0): ?>
                                 <tr>
                                    <td>1</td>
                                    <td class="d-none d-sm-table-cell"> House Rent </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->rent)); ?></td>
                                </tr>
                                
                                <tr>
                                    
                                    <td>2</td>
                                    <td class="d-none d-sm-table-cell"> Litter Collection</td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->litter_bill)); ?></td>
                                </tr>
                                <?php elseif($invoice->rent > 0 && $invoice->other_bill > 0): ?>
                                 <tr>
                                    <td>1</td>
                                    <td class="d-none d-sm-table-cell"> House Rent </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->rent)); ?></td>
                                </tr>
                                <tr>
                                
                                    <td>2</td>
                                    <td class="d-none d-sm-table-cell"> Deposit </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->deposit_paid )); ?></td>
                                </tr>
                                 <tr>
                                    
                                    <td>3</td>
                                    <td class="d-none d-sm-table-cell"> Arrears</td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->carryforward)); ?></td>
                                </tr>
                                <tr>
                                    
                                    <td>4</td>
                                    <td class="d-none d-sm-table-cell"> Other Bills</td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->other_bill)); ?></td>
                                </tr>
                                <?php elseif($invoice->litter_bill > 0 && $invoice->electricty_bill > 0 ): ?>
                                 <tr>
                                    <td>1</td>
                                    <td class="d-none d-sm-table-cell"> House Rent </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->rent)); ?></td>
                                </tr>
                                <tr>
                                
                                    <td>2</td>
                                    <td class="d-none d-sm-table-cell"> Litter Bill </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->litter_bill )); ?></td>
                                </tr>
                                <tr>
                                
                                    <td>3</td>
                                    <td class="d-none d-sm-table-cell"> Electricity & Water Bill </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->electricity_bill )); ?></td>
                                </tr>
                                
                                
                               
                                 
                            
                                
                                    
                                   
                               
                          
                                
                               
                                
                                <?php else: ?>
                                <tr>
                                    <td>1</td>
                                     <?php if($invoice->type === 'placement'): ?>
                                    <td class="d-none d-sm-table-cell">Placement Fee</td>
                                    <?php elseif($invoice->type === 'management'): ?>
                                    <td class="d-none d-sm-table-cell">Management Fee</td>
                                    <?php elseif($invoice->type === 'viewing'): ?>
                                     <td class="d-none d-sm-table-cell">Viewing Fee</td>
                                     <?php else: ?>
                                     <td class="d-none d-sm-table-cell">Others - <?php echo e($invoice->description); ?></td>
                                      <?php endif; ?>
                                    <td class="text-right">Ksh <?php echo e(number_format($invoice->total_payable)); ?></td>
                                </tr>
                                 <?php endif; ?>
                                

                                <?php
                                $count=3;
                                ?>

                                <?php $__empty_1 = true; $__currentLoopData = $billings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $billing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>


                                <tr>
                                    <td> <?php echo e($count++); ?></td>
                                    <td class="d-none d-sm-table-cell"> <?php echo e($billing->billing_name); ?> </td>
                                    <td class="text-right">Ksh <?php echo e(number_format($billing->billing_amount )); ?></td>
                                </tr>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                <?php endif; ?>
												
												
											
											
                                
                                                <tr>
                                                   	<td colspan="2" class="font-weight-bold text-uppercase text-right h5 mb-0">Sub Total</td>
                                                    <td class="text-right">Ksh
                                                        <?php echo e(number_format($invoice->total_payable )); ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                   	<td colspan="2" class="font-weight-bold text-uppercase text-right h5 mb-0">Total Paid</td>
                                                    <td class="text-right text-success text-bold">Ksh
                                                        <?php echo e(number_format($invoice->paid_in )); ?>

                                                    </td>
                                                </tr>
                                                
                                                    
                                                <!--    <tr>-->
                                                <!--    <th>To pay:</th>-->
                                                <!--    <td class="text-right">Ksh <?php echo e(number_format($invoice->total_payable- $invoice->paid_in )); ?> -->
                                                <!--    </td>-->
                                                <!--</tr>-->
                                                
                                             <tr>
													<td colspan="2" class="font-weight-bold text-uppercase text-right h5 mb-0">Total Due</td>
													<td class="text-right text-danger text-bold">Ksh <?php echo e(number_format($invoice->balance)); ?></td>
												</tr>
                                    			
												<tr>
												    
													<td colspan="5" class="text-right">
													
														
														<!--<button type="button" class="btn btn-primary" onClick="javascript:window.print();"><i class="si si-wallet"></i> Pay Invoice</button>-->
														<button type="button" class="btn btn-secondary" onClick="javascript:window.print();"><i class="si si-paper-plane"></i> Send Invoice</button>
														<a href="<?php echo e(route('invoice.show',[$invoice->id,'action'=>'pdf'])); ?>" target="_blank"><button type="button" class="btn btn-success" ><i class="fa fa-download"></i> Download PDF</button></a>
														<button type="button" class="btn btn-info" onClick="javascript:window.print();"><i class="si si-printer"></i> Print Invoice</button>
													</td>
												</tr>
											</table>
										</div>
										<h5>Other information</h5>
                            <p class="text-muted">To be paid by MPesa Paybill Number.<br>
                                The invoiced tenant has a balance of <strong>Ksh <?php echo e(number_format($invoice->balance )); ?></strong> <br />
                                </p>
									</div>
								</div>
							</div>
						</div>
						<!-- End row-->

					</div>
				</div><!-- end app-content-->
			</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>


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
                <h3 class="page-title">Invoice</h3>
            </div>
            <div class="col-auto float-right ml-auto">
                <div class="btn-group">
                    
                    &nbsp;
                    <a href="<?php echo e(route('invoice.show',[$invoice->id,'action'=>'print'])); ?>" target="_blank" class="btn btn-white" id="btn-invoice"><i class="fa fa-print fa-lg"></i>Print Invoice</a>
                </div>
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
                            <!--<img src="" class="inv-logo" alt="Your Logo Here">-->
                            <h3>Tenant Details</h3>
                                   
                            <div class="row mt-3">
                                <div class="col-sm-4">
                                    
                                </div> <!-- end col -->

                               <!-- end col -->
                            </div>
                        </div>
                        <div class="col-sm-6 m-b-20">
                            <div class="invoice-details">
                                <h3 class="text-uppercase text-blue">Invoice #-</h3>
                                <ul class="list-unstyled">
                                    <li>Generated On: <span class="text-info "></span></li>
                                    <!--<li>Due date: <span>5th <?php echo e(\Carbon\Carbon::createFromFormat('M-Y',$invoice->rent_month)->format('M-Y')); ?></span></li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-lg-7 col-xl-8 m-b-20">
                          
                        </div>
                        <div class="col-sm-6 col-lg-5 col-xl-4 m-b-20">
                            <span class="text-muted">Billing Details:</span>
                            <ul class="list-unstyled invoice-payment-details">
                                <li>
                                    <h5>Total Due: <span class="text-right font-weight-bold">Ksh
                                            <?php echo e(number_format($invoice->balance + $invoice->penalty_fee)); ?></span>
                                    </h5>
                                </li>
            
                                


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
                                
                            </tbody>
                        </table>
                    </div> 
                    <br/>
                    
                    
                    <div>
                        <div class="row invoice-payment">
                            <div class="col-sm-7">
                            </div>
                           
                        </div>
                        <div class="invoice-info">
                            <h5>Other information</h5>
                            <p class="text-muted">To be paid by MPesa Paybill Number.<br>
                                The invoiced tenant has a balance of <strong>Ksh <?php echo e(number_format($invoice->balance )); ?></strong> <br />
                                </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/bedahgra/public_html/rms/work/rms/resources/views/invoices/invoice.blade.php ENDPATH**/ ?>