

<?php $__env->startPush('header_scripts'); ?>
<!-- DataTables -->
<link href="<?php echo e(asset('plugins/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('plugins/datatables/buttons.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link href="<?php echo e(asset('plugins/datatables/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<!-- Page Content -->
<div class="content container-fluid">

    <!-- Page Title -->
    
    <!-- /Page Title -->

    <!-- Content Starts -->

    <div class="row">
        
        <div class="col-12">
            <div class="card">
            <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <form action="<?php echo e(route('apartment.store_unit')); ?>" method="post" enctype='multipart/form-data'>
                <?php echo csrf_field(); ?>
                
                                
                               


                
                <div class="p-20">
                    <form action="<?php echo e(route('apartment.store')); ?>" method="post"  enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php if(isset($var)): ?>
                                    
                        <div class="col-md-5">
                            <div class="form-group form-focus">
                                <input type="text" class="form-control floating" readonly
                                    value="<?php echo e($apartment_name->name); ?>">
                                <label class="focus-label">Property Name</label>
                            </div>

                            <input type="hidden" name="apartment_id" value="<?php echo e($var); ?>"
                                id="apartment-id-hidden">
                        </div>
                        <div class="col-3">
                            <a href="<?php echo e(route('apartment.add_unit')); ?>" class="btn btn-secondary btn-block">
                                Change
                            </a>
                        </div>
                        <?php else: ?>
                        <div class="row">
                            <div class="col-sm-6">
                            <label >Property<span class="text-danger"> *</span></label>
                            
                            
                                
                                <select class="js-example-basic-single select" style="width: 100%" name="apartment_id" id="apartment_id">
                                    <option >--choose--</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $apartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apartment=>$key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <option value="<?php echo e($key); ?>"><?php echo e($apartment); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>

                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label >House Type<span class="text-danger"> *</span></label>
                                
                                
                                <select class="js-example-basic-single select" style="width: 100%" name="house_type">
                                    <option>---choose---</option>
                                        <option>Standalone</option>
                                        <option>Flats</option>
                                        <option>Bungalow</option>
                                        <option>Plots</option>
                                        <option>Others</option>
                                </select>
                       
                            
                            </div>
                                
                            
                        </div>
                        <?php endif; ?>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                            <label >House</label>
                            
                           
                                <input type="text" class="form-control text-uppercase" name="house_no" value="1">
                                <span class="form-text text-muted text-info">Defaults to " 1 " if the house is standalone.</span>        
                        </div>
                        <div class="col-sm-6">
                        <label >Monthly Rent<span class="text-danger"> *</span></label>
                        
                        
                            <input type="text" class="form-control" name="rent_amount">
               
                    
                    </div>
                    </div>
                    <div class="form-group row">
                           
                        
                </div>
                        

                        

                        <div class="row">
                            <div class="col-sm-12">
                            <label >House
                                Description <span class="text-muted test-small"></span></label>
                            
                                <input type="text" class="form-control" name="house_description">
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                            <label >Add House Images<span class="text-muted test-small"></span></label>
                            
                            <input type="file" multiple name="filenames[]" class="myfrm form-control">
                        </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-8 ">
                                <button type="submit" class="btn btn-success mr-3">Save House
                                </button>

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
<!-- /Page Content -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer_scripts'); ?>
<!-- Required datatable js -->
<script src="<?php echo e(asset('plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/dataTables.bootstrap4.min.js')); ?>"></script>

<!-- Responsive examples -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="<?php echo e(asset('plugins/datatables/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/responsive.bootstrap4.min.js')); ?>"></script>
<!-- Add Table Row JS -->
<script>
    $(function () { 
        var oTable = $('#table-houses').DataTable(
            {
                destroy: true,
                "pageLength": 10,
                "bLengthChange": false,
                processing: true,
                serverSide: true,
                ajax: {
                    method: 'GET',
                    url: '<?php echo route('api.houses.apartment'); ?>',
                    data: function (d) {
                        d.token = $("input[name='_token']").val();
                        d.id = $("#apartment_id option:selected").val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'house_no', name: 'house_no' },
                    { data: 'house_type', name: 'house_type' },
                    { data: 'rent', name: 'rent' },

                ]
            }
           );

        //change datatable on selected apartment
        $('#apartment_id').on('change', function (event) {            
            oTable.draw();
            event.preventDefault();
        });


        $('#btn-check').on('click', function (event2) {           
            oTable.draw();
            event.preventDefault();
        })







    });
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/bedahgra/public_html/lesa-demo/rms/resources/views/apartments/add_uit.blade.php ENDPATH**/ ?>