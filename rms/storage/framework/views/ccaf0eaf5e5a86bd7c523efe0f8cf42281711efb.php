

<?php $__env->startSection('content'); ?>

<div class="content container-fluid">

    <!-- Page Title -->
    
    <!-- /Page Title -->

    <!-- Content Starts -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    
                    <p class="text-muted m-b-10 font-14">
                    </p>
                    <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="p-20 pt-2">
                        <form action="<?php echo e(route('tenant.change')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Full Names <span class="text-danger">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" 
                                        value="" readonly>
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-4">                                
                                <div class="form-group">
                                    <label>House:</label>
                                    <div>
                                       <select class="js-example-basic-single select" style="width: 100%"  name="house_id">

                                        <option selected><?php echo e($house->house->house_no); ?></option>

                                        <?php $__empty_1 = true; $__currentLoopData = $house; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $house): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($house->house_id); ?>"><?php echo e($house->house->house_no); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                        <?php endif; ?>

                                    </select>
                                    </div>
                                </div>
                            </div>
                            
                            
                           
                        </div>
                        <!-- end row -->
                       
                       
                       
                            

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">
                                               Change House
                                            </button>                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- /Content End -->

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer_scripts'); ?>      

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/bedahgra/public_html/rms/work/rms/resources/views/tenants/change_room.blade.php ENDPATH**/ ?>