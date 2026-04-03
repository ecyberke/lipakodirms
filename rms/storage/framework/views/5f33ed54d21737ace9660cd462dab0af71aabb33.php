


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
        href="<?php echo e(route('landlord.index')); ?>">Back to the list</a>
</div>
    <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

       <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="profile-view">
                        <div class="profile-img-wrap">
                            <div class="profile-img">
                                <a href="#"><img alt="" src="<?php echo e(asset('assets/img/landlord.jpg')); ?>"></a>
                            </div>
                        </div>
                        <div class="profile-basic">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="profile-info-left">
                                        <h3 class="user-name m-t-0 mb-0"><?php echo e($landlord->full_name); ?></h3>
                                        <h6 class="text-muted"></h6>
                                        <small class="text-muted"></small>
                                        <div class="staff-id">Property Owner's ID Number : <?php echo e($landlord->landlordid_number); ?></div>
                                        <div class="small doj text-muted mb-2">Registered :
                                            <?php echo e($landlord->created_at->diffForHumans()); ?></div>
                                        <div class="mb-2"><a class="btn  btn-sm btn-secondary"
                                                href="<?php echo e(route('landlord.edit',$landlord->id)); ?>">Edit Owner
                                                Details</a>
                                        </div>
                                        <div class=""><a class="btn btn-info btn-sm"
                                        href="<?php echo e(route('apartment.create', $landlord->id)); ?>">Add Property</a>
                                        </div>
                                       <!--  <div class=""><a class="btn btn-custom btn-sm"
                                        href="<?php echo e(route('landlord.changepassword',$landlord->id)); ?>">Update Password</a>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="col-md-4">
                                   <ul class="personal-info">
                                       <li>
                                           <?php if($landlord->bank_name != null): ?>
                                            <div ><b>Bank name:</b> <?php echo e($landlord->bank_name); ?></div>
                                            <?php else: ?>
                                            <div ><b>Bank name:</b>  <em style=color:red;>Not yet submitted</em></div>
                                            <?php endif; ?>
                                           
                                        </li>
                                        <li>
                                             <?php if($landlord->bank_branch != null): ?>
                                            <div ><b>Bank branch:</b> <?php echo e($landlord->bank_branch); ?></div>
                                            <?php else: ?>
                                            <div ><b>Bank branch:</b> <em style=color:red;>Not yet submitted</em></div>
                                            <?php endif; ?>
                                           
                                        </li>
                                        <li>
                                            <?php if($landlord->bank_acc_name != null): ?>
                                            <div ><b>Bank account name:</b> <?php echo e($landlord->bank_acc_name); ?></div>
                                            <?php else: ?>
                                            <div ><b>Bank account name:</b> <em style=color:red;>Not yet submitted</em></div>
                                            <?php endif; ?>
                                           
                                        </li>
                                        <li>
                                            <?php if($landlord->bank_acc_no != null): ?>
                                            <div ><b>Bank account number:</b> <?php echo e($landlord->bank_acc_no); ?></div>
                                             <?php else: ?>
                                            <div ><b>Bank account number:</b> <em style=color:red;>Not yet submitted</em></div>
                                            <?php endif; ?>
                                           
                                        </li>
                                        <li>
                                            <div ><b>Phone:</b> <?php echo e($landlord->id); ?></div>
                                           
                                        </li>
                                        
                                        <li>
                                            <div ><b>Physical Address:</b> <?php echo e($landlord->address); ?></div>
                                            
                                        </li>
                                        <li>
                                            <div ><b>Email:</b> <?php echo e($landlord->email); ?></div>
                                            
                                        </li>
                                    </ul>
                                </div>
                                 <div class="col-md-3">
                                     <h3>Next of Kin</h3><hr>
                                   <ul class="personal-info">
                                       <li>
                                           <?php if($landlord->emergency_person != null): ?>
                                            <div ><b>Full Name:</b> <?php echo e($landlord->emergency_person); ?></div>
                                            <?php else: ?>
                                            <div ><b>Full Name:</b>  <em style=color:red;>Not yet submitted</em></div>
                                            <?php endif; ?>
                                           
                                        </li>
                                         <li>
                                             <?php if($landlord->emergency_id != null): ?>
                                            <div ><b>ID/Passport Number:</b> <?php echo e($landlord->id); ?></div>
                                            <?php else: ?>
                                            <div ><b>ID/Passport Number:</b> <em style=color:red;>Not yet submitted</em></div>
                                            <?php endif; ?>
                                           
                                        </li>
                                        <li>
                                             <?php if($landlord->emergency_number != null): ?>
                                            <div ><b>Phone Number:</b> <?php echo e($landlord->emergency_number); ?></div>
                                            <?php else: ?>
                                            <div ><b>Phone Number:</b> <em style=color:red;>Not yet submitted</em></div>
                                            <?php endif; ?>
                                           
                                        </li>
                                        <li>
                                            <?php if($landlord->relationship != null): ?>
                                            <div ><b>Relationship:</b> <?php echo e($landlord->relationship); ?></div>
                                            <?php else: ?>
                                            <div ><b>Relationship:</b> <em style=color:red;>Not yet submitted</em></div>
                                            <?php endif; ?>
                                           
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

   <div class="tab-content">

        <!-- Profile Info Tab -->
        <div id="emp_profile" class="pro-overview tab-pane fade show active">
     <div class="row">
                


                <!---Deposit list Section---->
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                           <h3 class="card-title">Owner Properties </h3> 
                            <div class="table-responsive">
                                 <table id="invoices-table" class="table table-bordered"
                        >
                        <thead>
                            <tr>
                             
                                <th style="width:10%">#</th>
                                <th>Property Name</th>
                                
                                <th>Town</th>
                                <th>Management Fee</th>
                                <th>Total Houses</th>
                            </tr>
                        </thead>
                        <?php
                        $count=1;
                        ?>
                        <tbody>
                            
                            <?php $__empty_1 = true; $__currentLoopData = $apartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apartment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($count); ?></td>
                                <td><?php echo e($apartment->name); ?></td>
                                
                                <td><?php echo e($apartment->town); ?></td>
                                <td><?php echo e($apartment->management_fee_percentage); ?> %</td>
                                <td><?php echo e($apartment->houses->count()); ?></td>
                             
                                
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
                </div></div></div>
              
                 <div class="row">
                


                <!---Deposit list Section---->
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            
                            <h3 class="card-title">Owner Invoices </h3>
                            <div class="table-responsive">
                                <table id="owner_invoices-table" class="table table-bordered"
                        >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tenant Name</th>
                                            <th>Property</th>
                                            <th>House</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>

                                    <?php
                                    $count=1;
                                    ?>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $owner_invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $depo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                           <td><?php echo e($count); ?></td>
                                            <td class="text-uppercase"><?php echo e($depo->tenant_name); ?></td>
                                            <td class="text-uppercase"><?php echo e($depo->apartment_name); ?></td>
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
                <div class="col-md-12 d-flex">
                    <div class="card profile-box flex-fill">
                        <div class="card-body">
                            
                            <h3 class="card-title">Repairs </h3>
                            <div class="table-responsive">
                                <table id="repair_invoices-table" class="table table-bordered"
                        >
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Property</th>
                                            <th>House</th>
                                            <th>Tenant Name</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>

                                    <?php
                                    $count=1;
                                    ?>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $repair_invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $depo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                           <td><?php echo e($count); ?></td>
                                           
                                            <td class="text-uppercase"><?php echo e($depo->apartment_name); ?></td>
                                            <td class="text-uppercase"><?php echo e($depo->house_name); ?></td>
                                             <td class="text-uppercase"><?php echo e($depo->tenant_name); ?></td>
                                             <td><?php echo e($depo->repaired_items); ?></td>
                                            <td class="text-uppercase">Ksh.<?php echo e(number_format( $depo->total_repair_amount)); ?></td>
                                            <td><?php echo e($depo->created_at); ?></td>
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
                    "pageLength": 10 ,
                    "bLengthChange": true
                }
            );
        });
    });
</script>
<script>
    $(function () {
        $(document).ready(function () {
            $('#owner_invoices-table').DataTable(
                {
                    "pageLength": 10 ,
                    "bLengthChange": true
                }
            );
        });
    });
</script>
<script>
    $(function () {
        $(document).ready(function () {
            $('#repair_invoices-table').DataTable(
                {
                    "pageLength": 10 ,
                    "bLengthChange": true
                }
            );
        });
    });
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/landlords/show.blade.php ENDPATH**/ ?>