

<?php $__env->startSection('content'); ?>

<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                
                
            </div>
        </div>
    </div>
    <div class="mb-2"><a class="btn btn-sm btn-danger"
        href="<?php echo e(route('landlord.index')); ?>">Back to the list</a>
</div>
    <!-- /Page Header -->

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
                                <div class="col-md-7">
                                    <ul class="personal-info">
                                        <li>
                                            <div class="title">Phone:</div>
                                            <div class="text"><a href=""><?php echo e($landlord->id); ?></a></div>
                                        </li>
                                        
                                        <li>
                                            <div class="title">Physical Address:</div>
                                            <div class="text"><?php echo e($landlord->address); ?></div>
                                        </li>
                                        <li>
                                            <div class="title">Email:</div>
                                            <div class="text"><a href=""><span class="__cf_email__"
                                                        data-cfemail="39535651575d565c795c41585449555c175a5654"><?php echo e($landlord->email); ?></span></a>
                                            </div>
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

    
    <div class="card mb-3">
        <div class="card-body">
    <div class="">
        
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
</div>


<?php $__env->startPush('footer_scripts'); ?>
<!-- Required datatable js -->
<script src="<?php echo e(asset('plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/dataTables.bootstrap4.min.js')); ?>"></script>

<!-- Responsive examples -->
<script src="<?php echo e(asset('plugins/datatables/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/responsive.bootstrap4.min.js')); ?>"></script>

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

<?php $__env->stopPush(); ?>
</div>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/bedahgra/public_html/lesa-demo/rms/resources/views/landlords/show.blade.php ENDPATH**/ ?>