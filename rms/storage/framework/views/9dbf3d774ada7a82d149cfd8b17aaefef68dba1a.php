<?php $__env->startSection('content'); ?>

<div class="content container-fluid">

    <div class="row">
        <div class="col-md-10">

            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    
                </div>
            </div>
            <!-- /Page Header -->

            <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <form action="<?php echo e(route('house.update',$house->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-3 col-form-label">Property Name <span class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" readonly value="<?php echo e($house->apartment->name); ?>" >
                                </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-3 col-form-label">House No <span class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                    <input type="text" class="form-control text-uppercase" name="house_no" value="<?php echo e($house->house_no); ?>">
                                </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-3 col-form-label">House Type <span class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                    <select class="js-example-basic-single js-states form-control" name="house_type">
                                        <option selected><?php echo e($house->house_type); ?></option>
                                        
                                        <option>Standalone</option>
                                        <option>Flats</option>
                                        <option>Bungalow</option>
                                        <option>Plots</option>
                                        <option>Others</option>
                                                       </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-3 col-form-label">Monthly Rent <span
                                            class="text-danger">*</span></label>
                                            <div class="col-sm-5">
                                                
                                            <input type="text" class="form-control" name="rent_amount" value="<?php echo e($house->rent->amount); ?>">
                                            </div>
                                </div>
                              
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-3 col-form-label">House
                                        Description <span class="text-muted test-small"></span></label>
                                    <div class="col-sm-5">
                                    <input type="text" class="form-control" name="house_description" value="<?php echo e($house->description); ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="example-text-input" class="col-sm-3 col-form-label">Add House Images<span class="text-muted test-small"></span></label>
                                    <div class="col-sm-5">
                                        <input type="file" multiple name="filenames[]" class="myfrm form-control">
                                    </div>
                                </div>
                                


                                <button class="btn btn-success" type="submit">  Update
                                    House</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
                                            
        </div>

            </form>

            

               
        </div>
    </div>




</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rms\rms\resources\views/houses/edit.blade.php ENDPATH**/ ?>