

<?php $__env->startPush('header_scripts'); ?>
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap-datetimepicker.min.css')); ?>">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />


<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">

    <!-- Page Title -->
    <div class="row">
        
    </div>
    <!-- /Page Title -->

    <!-- Content Starts -->
    <div class="card">
    <form action="<?php echo e(route('bill.store')); ?>" method="post">
        <?php echo csrf_field(); ?>
        
        
        <div class="row">
            <?php echo e(csrf_field()); ?>


            <div class="col-12">
                <div class="">
                    <div class="card-body">
                        

                        
                        <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                         <div class="row">
                            <div class="col-md-12">
                                <label>Bill Type<span class="text-danger">*</span></label>
                            <select id="billTypeSelector" class="js-example-basic-single select" style="width: 100%"  name="bill_type">
                                <option value="property" selected>Property Bills</option>
                                <option value="agency">Agency Bills</option>
                            </select>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-sm-12" id="propertyBillsInput">
                            <label>Select Bills<span class="text-danger">*</span></label>
                            <select id="billSelector" class="js-example-basic-single select" style="width: 100%"  name="type">

                                
                                <option value="Service Request" selected>Service Requests</option>
                                <option value="Litter Collection">Litter Collection</option>
                                <option value="Compound Cleaning and Maintenance">Compound Cleaning and Maintenance</option>
                                <option value="Electricity and Water">Electricity and Water</option>
                                <option value="Others">Others</option>
                                
                           

                            </select>
                            </div></div> <br>
                            <div class="row">
                                <div class="col-sm-6 conditionalSections" id="serviceRequestSection">
                                    <div class="form-group">
                                        <label> Select a Request<span class="text-danger">*</span></label>
                                        <div>
                                            <select class="js-example-basic-single select" style="width: 100%"  name="apartment_id">

                                                <option selected disabled>-----Select-----</option>
                                                <?php $__empty_1 = true; $__currentLoopData = $service_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($test->apartment->id); ?>">Service Request - <?php echo e($test->id); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                
                                                    <?php endif; ?>
                
                                            </select>
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 conditionalSections" id="apartmentSection">
                                    <div class="form-group">
                                        <label> Apartment<span class="text-danger">*</span></label>
                                        <div>
                                            <select class="js-example-basic-single select" style="width: 100%"  name="apartment_id">

                                                 <option selected disabled>-----Select-----</option> 
                                                <?php $__empty_1 = true; $__currentLoopData = $apartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apartment=>$key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($key); ?>"><?php echo e($apartment); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                
                                                    <?php endif; ?>
                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 conditionalSections" id="agencySection">
                                    <div class="form-group">
                                        <label> Agency User</label>
                                        <div>
                                            
                                            
                                            <input class="form-control " type="text" id="example-text-input" name="agency_user"
                                        value="<?php echo e(Auth::user()->name); ?>" readonly>
                                        
                                        </div>
                                    </div>
                                </div>
                                
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Amount<span class="text-danger">*</span></label>
                                            <div>
                                                <div class="form-group">
                                                   
                                                        <input class="form-control " type="text" id="example-text-input" name="bill_amount"
                                                value="">
                                                   
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                
                                
                                
                                
                                
                            </div>
                            
                            
                            
                    
                           
                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Bill Description <span class="text-danger">*</span></label>
                                                    <textarea name="bill_description" class="form-control" rows="6"  ></textarea>
                                                        
                                                    </div>
                                        </div><br>
                                                
                                                        
                                        
                      
                         
                                

                        <div class="row mb-4">
                            <div class="col-sm-8">
                                
                               
                                <button type="submit" class="btn btn-success waves-effect waves-light">Add Bill</button></button>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </form>
    
    </div>


    <!-- /Content End -->

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer_scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        var x = document.getElementById("billSelector").value;
        var y = document.getElementById("billTypeSelector").value;
        $("#serviceRequestSection").hide();
        $("#apartmentSection").hide();
        $("#agencySection").hide();
        $('#billSelector').hide();
        if ( y == 'property')
        {
            $("#billSelector").show();
        }
        if ( x == 'serviceRequest')
        {
            $("#serviceRequestSection").show();
        }else if ( x == 'agency'){
            $("#agencySection").show();
        } else{
            $("#apartmentSection").show();
        }
    });

    $('#billTypeSelector').change(function(){
        var x = document.getElementById("billTypeSelector").value;
        $("#propertyBillsInput").hide();
        $("#agencySection").hide();
        $('#serviceRequestSection').hide();
        if ( x == 'property'){
            $("#propertyBillsInput").show();
            $('#serviceRequestSection').show();
        }else if(x == 'agency'){
            $("#agencySection").show();
        }
    });
    $('#billSelector').change(function(){
        var x = document.getElementById("billSelector").value;
        $("#serviceRequestSection").hide();
        $("#apartmentSection").hide();
        
        $("#agencySection").hide();
        if ( x == 'serviceRequest')
        {
            $("#serviceRequestSection").show();
        }else if ( x == 'agency'){
            $("#agencySection").show();
        } else{
            $("#apartmentSection").show();
        }
    });
    $('#apartment_id').change(function () {
       var id = $(this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "<?php echo route('ajax.houses.occupied'); ?>",
            method: 'POST',
            data: { 'id': id, '_token': token },
            success: function (data) {
                $('#house-rent').val('');
                $('#section-bills').html('');
                $("select[name='house_id']").html('');
                $("select[name='house_id']").html(data.options);
            },
            error: function () {
                alert("error!!!!");
            }
        });
    });

    $('#houses_select').change(function () {
        var id = $(this).val();
        var token = $("input[name='_token']").val();

        $.ajax({
            url: "<?php echo route('ajax.house.bills'); ?>",
            method: 'POST',
            data: { 'id': id, '_token': token },
            success: function (data) {
                $('#house-rent').val('');
                $('#house-rent').val(data.house_rent);
            },
            error: function () {
                alert("error!!!!");
            }
        });

    });

    $(document).on('change', '#off-switch', function () {
        if ($(this).prop("checked") == true) {
            $("#new-tenant-row").prop('hidden', false);
            $("#checked-tenant").attr("name", "is_new_tenant");
        }
        else {
            $("#new-tenant-row").prop('hidden', true);
            $("#checked-tenant").removeAttr('name');
        }
    });

    $(function () {
        $('#datetimepicker10').datetimepicker({
            viewMode: 'years',
            format: 'MM/YYYY'
        });
    });

    $(document).on('focusout', '#tenant-id', function () {

        var id = $(this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "<?php echo route('ajax.tenant.validate'); ?>",
            method: 'POST',
            data: { 'id': id, '_token': token },
            success: function (data) {

                if (data.exists) {
                    $('#tenant-names').removeClass('is-invalid');
                    $('#tenant-names').addClass('is-valid');
                    $('#tenant-names').val('');
                    $('#tenant-names').val(data.tenant_name);
                } else {
                     $('#tenant-names').removeClass('is-valid');
                     $('#tenant-names').addClass('is-invalid');
                    $('#tenant-names').val('');
                    $('#tenant-names').val(data.tenant_name);
                }

            },
            error: function () {
                alert("error!!!!");
            }
        });

    });

    
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/bedahgra/public_html/lesa-demo/rms/resources/views/bills/create.blade.php ENDPATH**/ ?>