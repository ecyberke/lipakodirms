

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
    <form  action="<?php echo e(route('sms.sendSms')); ?>" method="post">
        <?php echo csrf_field(); ?>
        
        
        <div class="row">
            <?php echo e(csrf_field()); ?>


            <div class="col-12">
                <div class="">
                    <div class="card-body">
                        

                        
                        <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="row">
                            <div class="col-sm-8">
                            <label>Select SMS Type <span class="text-danger">*</span></label>
                            <select id="smsGroupSelector" class="js-example-basic-single select" style="width: 100%"  name="group_sms">

                                
                                <option value="group" selected>SMS Group</option>
                                <option value="tenant">SMS Tenants</option>
                                <option value="owners">SMS Owners</option>
                                
                           

                            </select>
                            </div></div> <br>
                        <div class="row">
                            <div class="col-sm-8" id="groupSection">
                            <label>Select Category <span class="text-danger">*</span></label>
                            <select class="js-example-basic-single select" style="width: 100%"  name="group_type">

                                <option selected disabled>-----Select-----</option>
                                <option value="all_tenants">All Tenants</option>
                                <option value="unpaid_tenants">Unpaid Tenants</option>
                                <option value="paid_tenants">Paid Tenants</option>
                                <option value="all_property_owners">All Property Owners</option>
                           

                            </select>
                            </div></div> <br>
                            <div class="row">
                                <div class="col-sm-8" id="tenantsSection">
                                <label>Select Tenants <span class="text-danger">*</span></label>
                                <select class="js-example-basic-single select" style="width: 100%"  name="sms_tenant[]" multiple>

                                    
                                    <?php $__empty_1 = true; $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant=>$key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($key); ?>"><?php echo e($tenant); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    
                                        <?php endif; ?>
    
                                </select>
                                </div></div> <br>
                                <div class="row">
                                    <div class="col-sm-8" id="propOwnersSection">
                                    <label>Select Property Owners  <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single select" style="width: 100%"  name="owners_id[]" multiple>
        
                                        
                                        <?php $__empty_1 = true; $__currentLoopData = $landlords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $landlord=>$key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <option value="<?php echo e($key); ?>"><?php echo e($landlord); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        
                                            <?php endif; ?>
        
                                    </select>
                                    </div></div> <br>
                            <div class="row">
                                                <div class="col-sm-8">
                                                    <label>Message</label>
                                                    <textarea name="message" class="form-control" rows="6"  ></textarea>
                                                        
                                                    </div>
                                        </div><br>
                                                
                                                        
                                
                      
                         
                                

                        <div class="row mb-4">
                            <div class="col-sm-8">
                                
                               
                                <button type="submit" class="btn btn-success waves-effect waves-light">Send Message</button></button>
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
        var x = document.getElementById("smsGroupSelector").value;
        $("#groupSection").hide();
        $("#tenantsSection").hide();
        $("#propOwnersSection").hide();
        if ( x == 'group')
        {
            $("#groupSection").show();
        }else if ( x == 'tenant'){
            $("#tenantsSection").show();
        }else if(x == 'owners'){
            $("#propOwnersSection").show();
        }
    });

    $('#smsGroupSelector').change(function(){
        var x = document.getElementById("smsGroupSelector").value;
        $("#groupSection").hide();
        $("#tenantsSection").hide();
        $("#propOwnersSection").hide();
        if ( x == 'group')
        {
            $("#groupSection").show();
        }else if ( x == 'tenant'){
            $("#tenantsSection").show();
        }else if(x == 'owners'){
            $("#propOwnersSection").show();
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
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/bedahgra/public_html/lesa-demo/rms/resources/views/sms/custom.blade.php ENDPATH**/ ?>