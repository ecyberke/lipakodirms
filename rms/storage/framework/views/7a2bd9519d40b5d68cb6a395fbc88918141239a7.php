
<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-header'); ?>
						<!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title">Deposit Bill</h4>
							</div>
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
									<!--<li class="breadcrumb-item"><a href="#">Forms</a></li>-->
									<li class="breadcrumb-item active" aria-current="page">Tenant Deposit Bill</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
						<!-- Row-->
						<div class="row">
							<div class="col-md-12">
							    <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								<div class="card overflow-hidden">
									<div class="card-status bg-primary"></div>
									<div class="card-body">
										<h2 class="text-muted font-weight-bold">Deposit Bill</h2>
										<!--<div class="">-->
										<!--	<h5 class="mb-1">Hi <strong>Jessica Allen</strong>,</h5>-->
										<!--	This is the receipt for a payment of <strong>$450.00</strong> (USD) for your works-->
										<!--</div>-->

										<div class="card-body pl-0 pr-0">
											<div class="row">
												<div class="col-sm-6">
													<span>Bill No.</span><br>
													<strong>Bill #<?php echo e($invoice->id); ?></strong>
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
													<li>House:  <?php if($invoice->house_name == null): ?>
                                            <span class="text-success "> <?php echo e($invoice->house->house_no); ?> </span>
                                            <?php elseif($invoice->house_id == 0): ?>
                                            <span class="text-success "> <?php echo e($invoice->house_name); ?> </span>
                                            <?php elseif($invoice->house_id != 0 && $invoice->house_name != null ): ?>
                                            <span class="text-success "> <?php echo e($invoice->house_name); ?> </span>
                                            <?php else: ?>
                                            <span class="text-success "> NO HOUSE </span>
                                            
                                            <?php endif; ?>
                                </li>
                                <li>Property: 
                                            <?php if($invoice->apartment_id > 0): ?>
                                            <span class="text-success"> <?php echo e($invoice->apartment->name); ?> </span>
                                            <?php elseif($invoice->apartment_id == 0): ?>
                                            <span class="text-success "> <?php echo e($invoice->apartment_name); ?> </span>
                                            <?php else: ?>
                                            <span class="text-success "> NO APARTMENT </span>
                                            
                                            <?php endif; ?>
                                
                              
                             
                                <li>Status:
                                    <?php if($invoice->status===1): ?>
                                    <span class="text-success font-weight-bold"> PAID </span>
                                    <?php elseif($invoice->is_paid===0 && $invoice->paid_in > 0 ): ?>
                                    <span class="text-warning font-weight-bold"> PARTIAL PAYMENT</span>
                                    <?php else: ?>
                                    <span class="text-danger font-weight-bold"> UNPAID </span>
                                    <?php endif; ?>

												</address>
											</div>
											<div class="col-lg-6 text-right">
												<p class="h5 font-weight-bold">Bill From</p>
												 <address>
                                        Name:<?php echo e($invoice->tenant_name); ?>

                                              <br>
                                             
                                      
                                       
                                        Phone Number: +<?php echo e($invoice->tenant->phone); ?>

                                              <br>
                                        Account Number: <?php echo e($invoice->tenant->account_number); ?>

                                             <br>
                                        
                                    </address>
											</div>
										</div>
										<div class="table-responsive push">
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
                                                
                                                    
                                                <!--    <tr>-->
                                                <!--    <th>To pay:</th>-->
                                                <!--    <td class="text-right">Ksh <?php echo e(number_format($invoice->total_payable- $invoice->paid_in )); ?> -->
                                                <!--    </td>-->
                                                <!--</tr>-->
                                                
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
													
														
														<!--<button type="button" class="btn btn-primary" onClick="javascript:window.print();"><i class="si si-wallet"></i> Pay Invoice</button>-->
														<!--<a type="button" class="btn btn-secondary" href="<?php echo e(route('invoice.show',[$invoice->id,'action'=>'message'])); ?>"><i class="si si-paper-plane"></i> Send Message</a>-->
														<a href="<?php echo e(route('tenant.tenant_bill.show',[$invoice->id,'action'=>'pdf'])); ?>" target="_blank"><button type="button" class="btn btn-success" ><i class="fa fa-download"></i> Download PDF</button></a>
														<!--<button type="button" class="btn btn-info" onClick="javascript:window.print();"><i class="si si-printer"></i> Print Bill</button>-->
													</td>
												</tr>
											</table>
										</div>
									
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


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/tenants/tenant_invoice_view.blade.php ENDPATH**/ ?>