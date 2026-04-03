


<?php $__env->startPush('header_scripts'); ?>
<link href="<?php echo e(URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')); ?>"  rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" />
<!-- Slect2 css -->
<link href="<?php echo e(URL::asset('assets/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                
                
            </div>
        </div>
    </div>
    <!-- /Page Header -->
    <div class="mb-2"><a class="btn btn-sm btn-danger"
        href="<?php echo e(route('house.occupied')); ?>">Back to the list</a>
</div>
    <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="card mb-0">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="profile-img-wrap">
                            <div class="profile-img">
                                <a href="#"><img alt="" src="<?php echo e(asset('assets/img/tenant.jpg')); ?>"></a>
                            </div>
                        </div>
                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0"><?php echo e($tenant->full_name); ?></h3>
                                        <h6 class="text-muted"><?php echo e($tenant->occupation); ?></h6>
                                        <small class="text-muted"><?php echo e($tenant->occupation_at); ?></small>
                                        <div class="staff-id">Tenant Phone Number : <?php echo e($tenant->phone); ?></div>
                                        <div class="small doj text-muted mb-2">Registered :
                                            <?php echo e($tenant->created_at->diffForHumans()); ?></div>
                                        <div class="mb-2"><a class="btn btn-sm btn-primary"
                                                href="<?php echo e(route('tenant.edit', $tenant->id )); ?>">Edit Tenant Details</a>
                                        </div>
                                        <div class="mb-2"><a class="btn btn-sm btn-success"
                                                href="<?php echo e(route('sms.welcome', $tenant->id )); ?>">Resend Welcoming Message</a>
                                        </div>
                                      
                                         
                                      
                                        
                                       <!--  <div class=""><a class="btn btn-sm btn-white"
                                                href="<?php echo e(route('tenant.changepassword',$tenant->id)); ?>">Update
                                                Password</a>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h3 class="card-title">Details </h3>
                                    <ul class="personal-info">
                                         <li>
                                           <b>Account Number:</b> &nbsp;<?php echo e($tenant->account_number); ?> | 
                                            <b>Tenant ID Number:</b> &nbsp;<?php echo e($tenant->id_number); ?> |
                                             <b>Email:</b>&nbsp;<span class="__cf_email__"
                                                        data-cfemail="39535651575d565c795c41585449555c175a5654"><?php echo e($tenant->email); ?></span>
                                        </li>
                                       
                                       
                                       
                                    </ul><hr>
                            <h3 class="card-title">Emergency Contact </h3>
                            <ul class="personal-info">
                                <li>
                                    <b>Name</b>
                                    <?php echo e($tenant->emergency_person); ?>| 
                                    <b>Contact</b>
                                    <?php echo e($tenant->emergency_number); ?> | 
                                    <b>ID/Passport Number</b>
                                    <?php echo e($tenant->kin_id); ?> | 
                                    <b>Relationship</b>
                                    <?php echo e($tenant->relationship); ?>

                                </li>
                               

                            </ul><hr>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>


    <div class="tab-content">

        <!-- Profile Info Tab -->
        <div id="emp_profile" class="pro-overview tab-pane fade show active">
            <div class="row">
                <div class="col-md-6 d-flex">
                    <div class="card  flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Monthly Balances </h3>
                                        
                          <div class="table-responsive">
                                <table class="table table-bordered  table-nowrap datatable" id="balance-table">
                                       <thead> <tr>
                                            <th>Invoice No</th>
                                            <th>Month</th>
                                            <th>Amount to Pay</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <?php $__empty_1 = true; $__currentLoopData = $tenant->invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td class="text-uppercase">INV0<?php echo e(($invoice->id)); ?></td>
                                            <td class="text-uppercase"><?php echo e(($invoice->rent_month)); ?></td>
                                            <td>Ksh. <?php echo e(number_format($invoice->balance)); ?></td>
                                         


                                           

                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                         No Invoice generated yet.

                                        <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!---Assigned Houses---->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Occupant In </h3>
                            <div class="table-responsive">
                                <table class="table table-bordered  table-nowrap datatable" id="house-table">
                                       <thead> <tr>
                                            <th>Hse No</th>
                                            <th>Type</th>
                                            <th>Apartment</th>
                                            <th>Placement Date</th>
                                            <th class="text-right no-sort">Action</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $houzez; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $houze): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td class="text-uppercase"><?php echo e($houze->house->house_no); ?></td>
                                            <td class="text-uppercase"><?php echo e($houze->house->house_type); ?></td>
                                            <td><?php echo e($houze->house->apartment->name); ?></td>
                                            <td><?php echo e($houze->placement_date); ?></td>

                                             <td>
                                                <div class="text-right">
                            <div class="dropdown dropdown-action">
						    	<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-danger btn-block" href="<?php echo e(route ('tenant.vacate1', $houze->house->id)); ?>"> Vacate</a>
                                    </div>
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-primary btn-block" href="<?php echo e(route('tenant.assignRoomedit', $houze->id )); ?>"> Reassign House</a>
                                    </div>
                                     <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-success btn-block" href="<?php echo e(route('lease.pdf', $houze->house->id )); ?>" > Download Lease Agreement</a>
                                    </div>
                                    <!-- <div class="dropdown-item ">-->
                                    <!--   <a class="btn btn-sm btn-success btn-block" href="<?php echo e(route('tenant.missingInvoices', $houze->id )); ?>"> Generate Invoice</a>-->
                                    <!--</div>-->
                                    <!--<div class="dropdown-item ">-->
                                    <!--    <div class="dropdown dropdown-action">-->
                                    <!--        <a class="btn btn-sm btn-success btn-block" href="<?php echo e(route('tenant.missingInvoices', $houze->id )); ?>"> Generate Invoice</a>-->
                                        <!--<div class="dropdown-item ">-->
                                        <!--<a href="<?php echo e(route('tenant.missingInvoices', $houze->id )); ?>"> Past 1 Month</a>-->
                                        <!--</div>-->
                                        
                                    <!--</div>-->
                                    </div>
                                    <!--<div class="dropdown-item ">-->
                                    <!--    <a class="btn btn-sm btn-success btn-block" href="<?php echo e(route('tenant.change_room', $houze->id)); ?>" > Change House</a>-->
                                    <!--</div>-->
                                    

						    	</div>
                            </div>
                        </div>
                                                
                                            </td>
                                             

                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                        <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row">
                

                <!---Invoice Section---->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Tenant Invoices </h3>
                            <div class="table-responsive">
                                <table class="table table-bordered  table-nowrap datatable" id="invoices-table">
                                    <thead>
                                        <tr>
                                            <th style="width:20%">#INV</th>
                                            <th style="width:20%">Month</th>
                                            <th style="width:30%">Status</th>
                                            <th style="width:30%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $tenant->invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($invoice->id); ?></td>
                                            <td><?php echo e($invoice->rent_month); ?></td>
                                            <td>
                                                <?php if($invoice->is_paid > 0): ?>
                                                <span class="badge badge-success">PAID  
                                                <?php elseif($invoice->is_paid == 0 && $invoice->paid_in > 0 ): ?>
                                                <span class="badge badge-warning">PARTIAL</span>
                                                <?php else: ?> <span
                                                    class="badge badge-danger">UNPAID</span> <?php endif; ?>
                                            </td>
                                            

                                            <!--<td><a href="<?php echo e(route('invoice.show',$invoice->id)); ?>" class="btn btn-sm btn-primary">View</a> </td>-->
                                            <td>
                                                <div class="text-right">
                            <div class="dropdown dropdown-action">
						    	<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-info btn-block" href="<?php echo e(route('invoice.show', $invoice->id)); ?>"> View</a>
                                    </div>
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-success btn-block" href="<?php echo e(route('invoice.edit', $invoice->id)); ?>"> Edit</a>
                                    </div>
                                    

						    	</div>
                            </div>
                        </div>
                                                
                                            </td>
                                        </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                        <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!---Payment Section---->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Tenant Payments </h3>
                            <div class="table-responsive">
                                <table class="table table-bordered  table-nowrap datatable" id="deposit-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Reference</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Receipt</th>
                                        </tr>
                                    </thead>

                                    <?php
                                    $count=1;
                                    ?>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $tenant_payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($count); ?></td>
                                            <td class="text-uppercase"><?php echo e($deposit->TransID); ?></td>
                                            <td class="text-uppercase">Ksh.<?php echo e(number_format( $deposit->TransAmount)); ?></td>
                                            <td><?php echo e($deposit->created_at); ?></td>
                                            <td>
                                                <div class="dropdown-item ">
                                                    <?php if($deposit->receipt): ?>
                                        <a class="btn btn-sm btn-success btn-block" href="<?php echo e(route('receipt.index', $deposit->receipt)); ?>" target="blank_">Download</a>
                                        <?php else: ?>
                                        <p>No receipt</p>
                                        <?php endif; ?>
                                    </div>
                                    </td>
                                        </tr>

                                        <?php
                                        $count+=1;
                                        ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                       
                                         <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                


                <!---Deposit list Section---->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Tenant Deposits </h3>
                            <div class="table-responsive">
                                <table class="table table-bordered  table-nowrap datatable" id="deposit-list-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>House</th>
                                            <th>Deposit Amount</th>
                                            <th>Date Entered</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <?php
                                    $count=1;
                                    ?>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $invoiz; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposits): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($count); ?></td>
                                            <td class="text-uppercase"><?php echo e($deposits->house->house_no); ?></td>
                                            <td class="text-uppercase">Ksh.<?php echo e(number_format( $deposits->deposit_paid + $deposits->electricity_deposit_paid)); ?></td>
                                            <td><?php echo e($deposits->created_at); ?></td>
                                            <td>
                                                <div class="text-right">
                            <div class="dropdown dropdown-action">
						    	<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-info btn-block" href="<?php echo e(route('invoice.show', $deposits->id)); ?>"> View</a>
                                    </div>
                                   
                                    <?php if($deposits->locking == null): ?>
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-danger btn-block" href="<?php echo e(route('tenant.deposit_refund', $deposits->id)); ?>"> Initiate Refund</a>
                                    </div>
                                    <?php elseif($deposits->locking == 1): ?>
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-warning btn-block" href=""> Refund in Progress</a>
                                    </div>
                                    <?php else: ?>
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-success btn-block" href=""> Refund Completed</a>
                                    </div>
                                   <?php endif; ?>
                                    

						    	</div>
                            </div>
                        </div>
                                                
                                            </td>
                                           
                                        </tr>

                                        <?php
                                        $count+=1;
                                        ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                        
                                        <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!---Tenant Bill Section---->
                <div class="col-md-6 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            <h3 class="card-title">Tenant Deposit Bills </h3>
                            <div class="table-responsive">
                                <table class="table table-bordered  table-nowrap datatable" id="tenant-bill-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>House</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <?php
                                    $count=1;
                                    ?>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $tenant_bill; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $depo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                           <td><?php echo e($count); ?></td>
                                            <td class="text-uppercase"><?php echo e($depo->house_name); ?></td>
                                            <td class="text-uppercase">Ksh.<?php echo e(number_format( $depo->deposit_amount)); ?></td>
                                            <td>
                                                <?php if($depo->status > 0): ?>
                                                <span class="badge badge-success">PAID  
                                                <?php elseif($depo->status == 2 ): ?>
                                                <span class="badge badge-warning">PARTIAL</span>
                                                <?php else: ?> <span
                                                    class="badge badge-danger">UNPAID</span> <?php endif; ?>
                                            </td>
                                            <td><?php echo e($depo->created_at); ?></td>
                                            <td>
                                                <div class="text-right">
                            <div class="dropdown dropdown-action">
						    	<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-info btn-block" href="<?php echo e(route('tenant_bill.show', $depo->id)); ?>"> View</a>
                                    </div>
                                   
                                    <?php if($depo->status == 0): ?>
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-danger btn-block" href="<?php echo e(route('tenant.pay', $depo->id)); ?>"> Make Payment</a>
                                    </div>
                                    <?php else: ?>
                                    <div class="dropdown-item ">
                                        <a class="btn btn-sm btn-success btn-block" href=""> Refund Completed</a>
                                    </div>
                                   <?php endif; ?>
                                    

						    	</div>
                            </div>
                        </div>
                                                
                                            </td>
                                        </tr>

                                        <?php
                                        $count+=1;
                                        ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                        <?php endif; ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <!-- /Profile Info Tab -->



    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<!-- Data tables -->
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
<!-- Select2 js -->
<script src="<?php echo e(URL::asset('assets/plugins/select2/select2.full.min.js')); ?>"></script>

<script>
    $(function () {
        $(document).ready(function () {
            $('#invoices-table').DataTable(
                {
                    "pageLength": 12,
                    "order": [[ 0, "desc" ]],
                    "bLengthChange": false
                }
            );
        });
    });
</script>
<script>
    $(function () {
        $(document).ready(function () {
            $('#house-table').DataTable(
                {
                    "pageLength": 2,
                    "order": [[ 2, "asc" ]],
                    "bLengthChange": false
                }
            );
        });
    });
</script>
<script>
    $(function () {
        $(document).ready(function () {
            $('#balance-table').DataTable(
                {
                    "pageLength": 2,
                    "order": [[ 2, "desc" ]],
                    "bLengthChange": false
                     
                }
            );
        });
    });
</script>
<script>
    $(function () {
        $(document).ready(function () {
            $('#deposit-table').DataTable(
                {
                    "pageLength": 8,
                    "order": [[ 3, "desc" ]],
                    "bLengthChange": false
                }
            );
        });
    });
</script>
<script>
    $(function () {
        $(document).ready(function () {
            $('#deposit-list-table').DataTable(
                {
                    "pageLength": 12,
                    "bLengthChange": false
                }
            );
        });
    });
</script>
<script>
    $(function () {
        $(document).ready(function () {
            $('#tenant-bill-table').DataTable(
                {
                    "pageLength": 12,
                    "bLengthChange": false
                }
            );
        });
    });
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lesaprop/rmsprop/rms/resources/views/tenants/show.blade.php ENDPATH**/ ?>