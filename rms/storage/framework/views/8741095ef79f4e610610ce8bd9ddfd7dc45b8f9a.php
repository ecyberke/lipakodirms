
<?php $__env->startSection('css'); ?>
<!---jvectormap css-->
<link href="<?php echo e(URL::asset('assets/plugins/jvectormap/jqvmap.css')); ?>" rel="stylesheet" />
<!-- Data table css -->
<link href="<?php echo e(URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" />
<!--Daterangepicker css-->
<link href="<?php echo e(URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?><br><br>
						<!--Row-->
						<div class="row">
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="row">
									<div class="col-xl-3 col-lg-3 col-md-12">
										<div class="card">
											<div class="card-body">
												<svg class="card-custom-icon text-success icon-dropshadow-success" x="1008" y="1248" viewBox="0 0 24 24" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
													<path d="M18.121,9.88l-7.832-7.836c-0.155-0.158-0.428-0.155-0.584,0L1.842,9.913c-0.262,0.263-0.073,0.705,0.292,0.705h2.069v7.042c0,0.227,0.187,0.414,0.414,0.414h3.725c0.228,0,0.414-0.188,0.414-0.414v-3.313h2.483v3.313c0,0.227,0.187,0.414,0.413,0.414h3.726c0.229,0,0.414-0.188,0.414-0.414v-7.042h2.068h0.004C18.331,10.617,18.389,10.146,18.121,9.88 M14.963,17.245h-2.896v-3.313c0-0.229-0.186-0.415-0.414-0.415H8.342c-0.228,0-0.414,0.187-0.414,0.415v3.313H5.032v-6.628h9.931V17.245z M3.133,9.79l6.864-6.868l6.867,6.868H3.133z"></path>
												</svg>
												<p class=" mb-1 ">Occupied Houses</p>
												<h2 class="mb-1 font-weight-bold"><?php echo e($occupied_house); ?></h2>
												
												<div class="progress progress-sm mt-3 bg-success-transparent">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 80%"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-lg-3 col-md-12">
										<div class="card">
											<div class="card-body">
												<svg class="card-custom-icon text-secondary icon-dropshadow-secondary" x="1008" y="1248" viewBox="0 0 24 24" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
												<path d="M18.121,9.88l-7.832-7.836c-0.155-0.158-0.428-0.155-0.584,0L1.842,9.913c-0.262,0.263-0.073,0.705,0.292,0.705h2.069v7.042c0,0.227,0.187,0.414,0.414,0.414h3.725c0.228,0,0.414-0.188,0.414-0.414v-3.313h2.483v3.313c0,0.227,0.187,0.414,0.413,0.414h3.726c0.229,0,0.414-0.188,0.414-0.414v-7.042h2.068h0.004C18.331,10.617,18.389,10.146,18.121,9.88 M14.963,17.245h-2.896v-3.313c0-0.229-0.186-0.415-0.414-0.415H8.342c-0.228,0-0.414,0.187-0.414,0.415v3.313H5.032v-6.628h9.931V17.245z M3.133,9.79l6.864-6.868l6.867,6.868H3.133z"></path></svg>
												<p class=" mb-1 ">Vacant Houses</p>
												<h2 class="mb-1 font-weight-bold"><?php echo e($vacant_house); ?></h2>
												
												<div class="progress progress-sm mt-3 bg-secondary-transparent">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-secondary" style="width: 20%"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-lg-3 col-md-12">
										<div class="card">
											<div class="card-body">
												<svg class="card-custom-icon text-primary icon-dropshadow-primary" x="1008" y="1248" viewBox="0 0 24 24" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
													<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
												<p class=" mb-1 ">Registered Tenants</p>
												<h2 class="mb-1 font-weight-bold"><?php echo e($tenants); ?></h2>
												
												<div class="progress progress-sm mt-3 bg-primary-transparent">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 99%"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-lg-3 col-md-12">
										<div class="card">
											<div class="card-body">
												<svg class="card-custom-icon text-warning icon-dropshadow-warning" x="1008" y="1248" viewBox="0 0 24 24" fit="" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
													<path d="M17.431,2.156h-3.715c-0.228,0-0.413,0.186-0.413,0.413v6.973h-2.89V6.687c0-0.229-0.186-0.413-0.413-0.413H6.285c-0.228,0-0.413,0.184-0.413,0.413v6.388H2.569c-0.227,0-0.413,0.187-0.413,0.413v3.942c0,0.228,0.186,0.413,0.413,0.413h14.862c0.228,0,0.413-0.186,0.413-0.413V2.569C17.844,2.342,17.658,2.156,17.431,2.156 M5.872,17.019h-2.89v-3.117h2.89V17.019zM9.587,17.019h-2.89V7.1h2.89V17.019z M13.303,17.019h-2.89v-6.651h2.89V17.019z M17.019,17.019h-2.891V2.982h2.891V17.019z"></path></svg>
												<p class=" mb-1 ">Managed Properties</p>
												<h2 class="mb-1 font-weight-bold"><?php echo e($apartments); ?></h2>
												
												<div class="progress progress-sm mt-3 bg-orange-transparent">
													<div class="progress-bar progress-bar-striped progress-bar-animated bg-orange" style="width: 60%"></div>
												</div>
											</div>
										</div>
									</div>
									
								</div>
							</div>

							<div class="col-xl-12 col-lg-6">
								<div class="row">
									<div class="col-xl-3 col-md-12 col-lg-12">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col">
														<p class="mb-1">Today Income</p>
														<h2 class="mb-0 font-weight-bold">Ksh.<?php echo e(number_format($income_today)); ?></h2>
													</div>
													<div class="col col-auto">
														<div id="spark1"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-12 col-lg-12">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col">
														<p class="mb-1">This Month's Income</p>
														<h2 class="mb-0 font-weight-bold">Ksh.<?php echo e(number_format($month_income)); ?></h2>
													</div>
													<div class="col col-auto">
														<div id="spark2"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-12 col-lg-12">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col">
														<p class="mb-1">Today's Expenses</p>
														<h2 class="mb-0 font-weight-bold">Ksh.<?php echo e(number_format($bill_today)); ?></h2>
													</div>
													<div class="col col-auto">
														<div id="spark3"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xl-3 col-md-12 col-lg-12">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col">
														<p class="mb-1">This Month's Expenses</p>
														<h2 class="mb-0 font-weight-bold">Ksh.<?php echo e(number_format($month_bill)); ?></h2>
													</div>
													<div class="col col-auto">
														<div id="spark3"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!--Row-->
						<div class="row row-deck">
								<div class="col-xl-4 col-lg-4 col-md-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Recent Tenants</h3>
										<div class="card-options ">
											<div class="btn-group ml-3 mb-0">
												<a href="#" class="option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="#">All Tenants</a>
													<a class="dropdown-item" href="#">Houses</a>
													<a class="dropdown-item" href="#">Properties</a>
													<!--<div class="dropdown-divider"></div>-->
													<a class="dropdown-item" href="#">Property Owners</a>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body overflow-hidden">
										<div class="h-400 scrollbar3" id="scrollbar3">
										    <div class="table-responsive">
                                <table class="table table-bordered  table-nowrap datatable" id="balance-table">
                                       <thead> <tr>
                                            <th>Name</th>
                                            <th>Phone</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php $__empty_1 = true; $__currentLoopData = $tenats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objects): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td class=""><?php echo e(($objects->full_name)); ?></td>
                                            <td class="text-uppercase"><?php echo e(($objects->phone)); ?></td>
                                            
                                         


                                           

                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                         No Recent Tenant.

                                        <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
										
										</div>
									</div>
								</div>
							</div>
							

							<div class="col-xl-8 col-lg-7 col-md-12">
								<div class="card card-block">
									<div class="card-header d-sm-flex d-block">
										<h3 class="card-title">Recent Payments</h3>
										<div class="ml-auto mt-4 mt-sm-0">
											<!--<a class="btn btn-white" href="#">Week</a>-->
											<!--<a class="btn btn-white" href="#">Month</a>-->
											<!--<a class="btn btn-primary" href="#">Year</a>-->
											<div class="btn-group ml-3 mb-0">
												<!--<a href="#" class="option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>-->
												<div class="dropdown-menu p-0">
													<!--<a class="dropdown-item" href="#"><i class="fa fa-download"></i> Download</a>-->
													<!--<a class="dropdown-item" href="#"><i class="fa fa-cog mr-2"></i> Settings</a>-->
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
										 <div class="table-responsive">
                               <table class="table table-striped custom-table mb-0" id="invoices-table">
                            <thead>
                                <tr>
                                    <th style="width:2%">#</th>
                                    <!--<th style="width:13%">House</th>-->
                                    <th style="width:37%">Tenant</th>
                                    <th style="width:25%">Rent Month</th>
                                    
                                    
                                    
                                    <!--<th style="width:10%">Total Payable</th>                                    -->
                                    <th style="width:15%">Paid In</th>                                    
                                    <!--<th style="width:10%">Balance</th>                                    -->
                                    <th style="width:5%">Status</th>  
                                    <th style="width:3%">Action</th>  
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                            </div>
									</div>
								</div>
							</div>
							<div class="col-xl-12 col-lg-12 col-md-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Recent Service Requests</h3>
										<div class="card-options ">
											<!--<div class="btn-group ml-3 mb-0">-->
											<!--	<a href="#" class="option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>-->
												<!--<div class="dropdown-menu">-->
												<!--	<a class="dropdown-item" href="#">Today</a>-->
												<!--	<a class="dropdown-item" href="#">Last Week</a>-->
												<!--	<a class="dropdown-item" href="#">Last Month</a>-->
												<!--	<a class="dropdown-item" href="#">Last Year</a>-->
												<!--	<div class="dropdown-divider"></div>-->
												<!--	<a class="dropdown-item" href="#"><i class="fa fa-cog mr-2"></i> Settings</a>-->
												<!--</div>-->
											<!--</div>-->
										</div>
									</div>
									<div class="card-body overflow-hidden">
										<div class="h-400 scrollbar2" id="scrollbar2">
										     <div class="table-responsive">
                                <table class="table table-striped table-bordered text-nowrap" style="width:100%" >
                                       <thead> <tr>
                                            <th>Tenant</th>
                                            <th>Property</th>
                                            <th>House No</th>
                                            <th>Request Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php $__empty_1 = true; $__currentLoopData = $servicerequest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $object): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td class=""><?php echo e(($object->tenant->full_name)); ?></td>
                                            <td class=""><?php echo e(($object->apartment->name)); ?></td>
                                            <td class="text-uppercase"><?php echo e(($object->house->house_no)); ?></td>
                                             <td class="">
                                             <?php if($object->approval == 0): ?>
                                   <span class="badge badge-info">PENDING</span>
                                    <?php elseif($object->approval == 1): ?>  <span class="badge badge-success">APPROVED</span>
                                   <?php elseif($object->approval == 3): ?><span class="badge badge-secondary">AMEND</span>
                                   <?php else: ?>
                                   <span class="badge badge-danger">DECLINED</span>
                                   <?php endif; ?></td>
                                   <td class="">
                                        <a href="<?php echo e(route('servicerequests.show', $object->id)); ?>"> View</a>
                                    </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                         No Recent Service Request.

                                        <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
											
										</div>
									</div>
								</div>
							</div>
						
							<!--<div class="col-xl-12 col-lg-12 col-md-12">-->
							<!--	<div class="card">-->
							<!--		<div class="card-header">-->
							<!--			<h3 class="card-title">Best Sellers</h3>-->
							<!--			<div class="card-options">-->
							<!--				<div class="btn-group ml-5 mb-0">-->
							<!--					<button type="button" class="btn btn-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-plus"></i> Add New Order</button>-->
							<!--					<div class="dropdown-menu">-->
							<!--						<a class="dropdown-item" href="#"><i class="fa fa-plus mr-2"></i>Add new Order</a>-->
							<!--						<a class="dropdown-item" href="#"><i class="fa fa-eye mr-2"></i>View all new tab</a>-->
							<!--						<a class="dropdown-item" href="#"><i class="fa fa-edit mr-2"></i>Edit Page</a>-->
							<!--						<div class="dropdown-divider"></div>-->
							<!--						<a class="dropdown-item" href="#"><i class="fa fa-cog mr-2"></i> Settings</a>-->
							<!--					</div>-->
							<!--				</div>-->
							<!--			</div>-->
							<!--		</div>-->
							<!--		<div class="card-body">-->
							<!--			<div class="table-responsive">-->
							<!--				<table id="example1" class="table table-striped table-bordered text-nowrap" style="width:100%">-->
							<!--					<thead>-->
							<!--						<tr class="bold">-->
							<!--							<th class="border-bottom-0">Seller </th>-->
							<!--							<th class="border-bottom-0">Total Sales</th>-->
							<!--							<th class="border-bottom-0">Active Stocks</th>-->
							<!--							<th class="border-bottom-0">Category</th>-->
							<!--							<th class="border-bottom-0">Revenue</th>-->
							<!--							<th class="text-center border-bottom-0">Status</th>-->
							<!--						</tr>-->
							<!--					</thead>-->
							<!--					<tbody>-->
							<!--						<tr>-->
							<!--							<td class="font-weight-bold">SREE Enrprices</td>-->
							<!--							<td>20,125</td>-->
							<!--							<td>10513.00</td>-->
							<!--							<td>Watch</td>-->
							<!--							<td class="font-weight-bold">$13,206</td>-->
							<!--							<td><i class="fa fa-caret-up text-danger mr-1"></i>.01%</td>-->
							<!--						</tr>-->
							<!--						<tr>-->
							<!--							<td class="font-weight-bold">Granite Cake</td>-->
							<!--							<td>1,250,103</td>-->
							<!--							<td>425.25</td>-->
							<!--							<td>Medical</td>-->
							<!--							<td class="font-weight-bold">$21,762</td>-->
							<!--							<td><i class="fa fa-caret-down text-success mr-1"></i>.05%</td>-->
							<!--						</tr>-->
							<!--						<tr>-->
							<!--							<td class="font-weight-bold">GOODS Best</td>-->
							<!--							<td>425.25</td>-->
							<!--							<td>1.2029</td>-->
							<!--							<td>Cake</td>-->
							<!--							<td class="font-weight-bold">$42,282</td>-->
							<!--							<td><i class="fa fa-caret-down text-success mr-1"></i>.05%</td>-->
							<!--						</tr>-->
							<!--						<tr>-->
							<!--							<td class="font-weight-bold">Multi Shop</td>-->
							<!--							<td>28,470</td>-->
							<!--							<td>1547.67</td>-->
							<!--							<td>Elactronics</td>-->
							<!--							<td class="font-weight-bold">$86,334</td>-->
							<!--							<td><i class="fa fa-caret-up text-danger mr-1"></i>.01%</td>-->
							<!--						</tr>-->
							<!--						<tr>-->
							<!--							<td class="font-weight-bold">Sagar Limited</td>-->
							<!--							<td>24,983</td>-->
							<!--							<td>723.48</td>-->
							<!--							<td>Mobile</td>-->
							<!--							<td class="font-weight-bold">$24,983</td>-->
							<!--							<td><i class="fa fa-caret-down text-success mr-1"></i>.05%</td>-->
							<!--						</tr>-->
							<!--						<tr>-->
							<!--							<td class="font-weight-bold">Indo Allinone</td>-->
							<!--							<td>81,865</td>-->
							<!--							<td>149.18</td>-->
							<!--							<td>Fashion</td>-->
							<!--							<td class="font-weight-bold">$86,334</td>-->
							<!--							<td><i class="fa fa-caret-down text-success mr-1"></i>.05%</td>-->
							<!--						</tr>-->
							<!--						<tr>-->
							<!--							<td class="font-weight-bold">Spark Limited</td>-->
							<!--							<td>32,309</td>-->
							<!--							<td>149.18</td>-->
							<!--							<td>Gift</td>-->
							<!--							<td class="font-weight-bold">$25,000</td>-->
							<!--							<td><i class="fa fa-caret-up text-danger mr-1"></i>.01%</td>-->
							<!--						</tr>-->
							<!--						<tr>-->
							<!--							<td class="font-weight-bold">Stranger Seller</td>-->
							<!--							<td>149.18</td>-->
							<!--							<td>25,000</td>-->
							<!--							<td>Manufecture</td>-->
							<!--							<td class="font-weight-bold">$58.39</td>-->
							<!--							<td><i class="fa fa-caret-up text-danger mr-1"></i>.01%</td>-->
							<!--						</tr>-->
							<!--						<tr>-->
							<!--							<td class="font-weight-bold">Altanta Products</td>-->
							<!--							<td>149.18</td>-->
							<!--							<td>10,120</td>-->
							<!--							<td>Cloths</td>-->
							<!--							<td class="font-weight-bold">$2,167.83</td>-->
							<!--							<td><i class="fa fa-caret-up text-danger mr-1"></i>.01%</td>-->
							<!--						</tr>-->
							<!--						<tr>-->
							<!--							<td class="font-weight-bold">Suprtmarket Online</td>-->
							<!--							<td>2,142</td>-->
							<!--							<td>149.18</td>-->
							<!--							<td>Elactrical</td>-->
							<!--							<td class="font-weight-bold">$5,196</td>-->
							<!--							<td><i class="fa fa-caret-up text-danger mr-1"></i>.01%</td>-->
							<!--						</tr>-->
							<!--					</tbody>-->
							<!--				</table>-->
							<!--			</div>-->
							<!--		</div>-->
							<!--	</div>-->
							<!--</div>-->

						</div>
						<!--End row-->

					</div>
				</div><!-- end app-content-->
			</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<!-- ECharts js -->
<script src="<?php echo e(URL::asset('assets/plugins/echarts/echarts.js')); ?>"></script>
<!-- Peitychart js-->
<script src="<?php echo e(URL::asset('assets/plugins/peitychart/jquery.peity.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/peitychart/peitychart.init.js')); ?>"></script>
<!-- Apexchart js-->
<script src="<?php echo e(URL::asset('assets/js/apexcharts.js')); ?>"></script>
<!--Moment js-->
<script src="<?php echo e(URL::asset('assets/plugins/moment/moment.js')); ?>"></script>
<!-- Daterangepicker js-->
<script src="<?php echo e(URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/daterange.js')); ?>"></script>
<!---jvectormap js-->
<script src="<?php echo e(URL::asset('assets/plugins/jvectormap/jquery.vmap.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/jvectormap/jquery.vmap.world.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/jvectormap/jquery.vmap.sampledata.js')); ?>"></script>
<!-- Index js-->
<script src="<?php echo e(URL::asset('assets/js/index1.js')); ?>"></script>
<!-- Data tables js-->
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/jszip.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/datatables.js')); ?>"></script>
<!--Counters -->
<script src="<?php echo e(URL::asset('assets/plugins/counters/counterup.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/counters/waypoints.min.js')); ?>"></script>
<!--Chart js -->
<script src="<?php echo e(URL::asset('assets/plugins/chart/chart.bundle.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/chart/utils.js')); ?>"></script>
<script>
    $(function () {
        $('#invoices-table').DataTable({
            processing: true,
            serverSide: true,
             "order": [[ 0, "desc" ]],
            ajax: '<?php echo route('api.invoice.paid'); ?>',
            columns: [ 
               // { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false},     
                     { data: 'id', name: 'id' },
                    //  { data: 'house.house_no', name: 'house.house_no', orderable: false },
                     { data: 'tenant.full_name', name: 'tenant.full_name',orderable: false },
                     { data: 'rent_month', name: 'rent_month' },
                    //  { data: 'bills', name: 'bills' },
                    //  { data: 'carryforward', name: 'carryforward', orderable: false, searchable: false },                     
                     //{ data: 'penalty_fee', name: 'penalty_fee', orderable: false, searchable: false },
                    //  { data: 'total_payable', name: 'total_payable', orderable: false, searchable: false },
                    { data: 'paid_in', name: 'paid_in', orderable: false, searchable: false },
                    //  { data: 'balance', name: 'balance', orderable: false, searchable: false },
                     { data: 'is_paid', name: 'is_paid' },     
                      { data: 'action', name: 'action',searchable:false,orderable:false },             
                     //{ data: 'download', name: 'download', searchable: false , orderable: false },                  
                    //{ data: 'delete', name: 'delete', searchable: false , orderable: false },                  
                             ]
        });
         $(document).on('submit','.delete-overpayment',function(event){
            return confirm('Are you sure you want to delete this Invoice ? The action cannot be reversed');            
        });
        
    });


</script>
<?php $__env->stopSection(); ?>



<link href="<?php echo e(asset('assets/fontawesom-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">
<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
	
	<div class="row">
		<div class="col-xxl-3 col-lg-3">
			<div class="card bg-primary text-white mb-4">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75">Registered Tenants</div>
							<div class="text-lg font-weight-bold"><?php echo e($tenants); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="calendar"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color: #4e73df;">
					<a class="small text-white stretched-link" href="<?php echo e(route('tenant.all')); ?>" >List Tenants</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-3">
			<div class="card bg-warning text-white mb-4">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">Registered Owners</div>
							<div class="text-lg font-weight-bold"><?php echo e($landlords); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="dollar-sign"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color: #f6c23e;">
					<a class="small text-white stretched-link" href="<?php echo e(route('landlord.index')); ?>">List Property Owners</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-3">
			<div class="card bg-secondary text-white mb-4">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">Managed Properties</div>
							<div class="text-lg font-weight-bold"><?php echo e($apartments); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="check-square"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color: #858796;">
					<a class="small text-white stretched-link" href="<?php echo e(route('apartment.list')); ?>">List Properties</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-3">
			<div class="card bg-info text-white mb-4">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">Registered Houses </div>
							<div class="text-lg font-weight-bold"><?php echo e($houses); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="message-circle"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color: #36b9cc">
					<a class="small text-white stretched-link" href="<?php echo e(route('house.list')); ?>">List All Houses</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-3">
			<div class="card text-white mb-4" style="background-color: #b4df4e;" >
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75">Today's Income</div>
							<div class="text-lg font-weight-bold">Ksh.<?php echo e(number_format($income_today)); ?>

								
						</div>
						</div>
						<i class="feather-xl text-white-50" data-feather="calendar"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color: #b4df4e;">
					<a class="small text-white stretched-link" href="<?php echo e(route('invoice.paid')); ?>" >List Paid Invoices</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-3">
			<div class="card text-white mb-4" style="background-color: #e87c3e">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">This Month's Income</div>
							<div class="text-lg font-weight-bold">Ksh.<?php echo e(number_format($month_income)); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="dollar-sign"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color:#e87c3e;">
					<a class="small text-white stretched-link" href="<?php echo e(route('manualinvoice.payments')); ?>">List Payments</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-3">
			<div class="card text-white mb-4" style="background-color: #e83e8c">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">Today's Expenses</div>
							<div class="text-lg font-weight-bold">Ksh.<?php echo e(number_format($bill_today)); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="check-square"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color: #e83e8c">
					<a class="small text-white stretched-link" href="<?php echo e(route('payowners.list')); ?>">List Bills</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-3">
			<div class="card  text-white mb-4" style="background-color: #6f42c1;">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">This Month's Expenses </div>
							<div class="text-lg font-weight-bold">Ksh.<?php echo e(number_format($month_bill)); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="message-circle"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color: #6f42c1">
					<a class="small text-white stretched-link" href="<?php echo e(route('servicerequests.index')); ?>">List Service Requests</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-6">
			<div class="card bg-success text-white mb-4">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">Occupied Houses </div>
						<div class="text-lg font-weight-bold"></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="message-circle"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color:#1cc88a">
					<a class="small text-white stretched-link" href="<?php echo e(route('house.occupied')); ?>">List Occupied Houses</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-6">
			<div class="card bg-danger text-white mb-4">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">Vacant Houses </div>
						<div class="text-lg font-weight-bold"><?php echo e($vacant_house); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="message-circle"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color:#e74a3b">
					<a class="small text-white stretched-link" href="<?php echo e(route('house.vacant')); ?>">List Vacant Houses</a>
					
				</div>
			</div>
		</div>
	</div>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
        <script>
        var url = "<?php echo e(url('admin.index')); ?>";
        var rent_month = new Array();
        var Labels = new Array();
        var amount = new Array();
        $(document).ready(function(){
          $.get(url, function(response){
            response.forEach(function(data){
                Years.push(data.stockYear);
                Labels.push(data.stockName);
                Prices.push(data.stockPrice);
            });
            var ctx = document.getElementById("canvas").getContext('2d');
                var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels: ['Jan','Feb'],
                      datasets: [{
                          label: 'Infosys Price',
                          data: Prices,
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      }
                  }
              });
          });
        });
		</script>
		
	

		 <!-- Page level custom scripts -->
		 <script src="<?php echo e(asset('assets/js/chart.js/Chart.min.js')); ?>"></script>
		 <script src="<?php echo e(asset('assets/js/demo/chart-area-demo.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/bedahgra/public_html/rms/work/rms/resources/views/admins/index.blade.php ENDPATH**/ ?>