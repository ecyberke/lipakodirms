

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
    <form action="<?php echo e(route('invoice.payNow')); ?>" method="post">
        <?php echo csrf_field(); ?>
        
        
        <div class="row">
            <?php echo e(csrf_field()); ?>


            <div class="col-12">
                <div class="">
                    <div class="card-body">
                        

                        
                        <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="row">
                            <div class="col-md-12">
                                    <label>Invoice Type <span class="text-danger">*</span></label>
                                    
                                    <div>
                                         <div class="form-group">
                                    <select id="invoiceTypeSelector" class="js-example-basic-single select" style="width: 100%" name="invoice_type">
    
                                        
                                        <option value="property" selected>Property Invoice</option>
                                            <option value="agency">Agency Invoice</option>
    
                                    </select>
                                    </div>
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="tenantSelector" class="col-md-6">
                                <label>Select Tenant <span class="text-danger">*</span></label>
                                
                                <div>
                                     <div class="form-group">
                                <select class="js-example-basic-single select" style="width: 100%" name="tenant_id">

                                    <option selected disabled>-----Select-----</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant=>$key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($key); ?>"><?php echo e($tenant); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                        <?php endif; ?>

                                </select>
                                </div>
                                </div>
                               
                            </div>
                            <div id="invoiceSelector" class="col-md-6">
                                <label>Select Invoice <span class="text-danger">*</span></label>
                                
                                <div>
                                     <div class="form-group">
                                <select class="js-example-basic-single select" style="width: 100%" name="tenant_id">

                                    <option selected disabled>-----Select-----</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option value="<?php echo e($inv->id); ?>">Type: <?php echo e($inv->type); ?> Tenant: <?php echo e($inv->tenant_id); ?> Balance: <?php echo e($inv->balance); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                        <?php endif; ?>

                                </select>
                                </div>
                                </div>
                               
                            </div>
                           
                            <div class="col-md-6">
                                <label>Transaction Code<span class="text-danger">*</span></label>
                                    <div>
                                        <div class="form-group">
                                            
                                                <input class="form-control " type="text" id="example-text-input" name="reference"
                                        value="">
                                            
                                        </div>
                                        
                                    </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="example-text-input">Payment Method <span class="text-danger">*</span></label>
                                <select class="custom-select"  name="payment_type">

                                    <option selected disabled>-----Select-----</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Cheque">Bank</option>
                                    <option value="Mpesa">Mpesa</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Amount<span class="text-danger">*</span></label>
                                    <div>
                                        <div class="form-group">
                                            
                                                <input class="form-control " type="number" id="example-text-input" name="amount"
                                        value="">
                                            
                                        </div>
                                        
                                    </div>
                            </div>
                            <div class="col-sm-6">
                                <label>Date </label>
                                
                                    <div class="form-group">
                                        <div class="cal-icon">
                                            <input class="form-control datetimepicker" type="text" name="payment_date"
                                                value="">
                                        </div>
                                    </div>
    
                                </div>
                           
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                
                               
                                <button type="submit" class="btn btn-success waves-effect waves-light">Pay Invoices</button>
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

    $(document).ready(function () {
        var x = document.getElementById("invoiceTypeSelector").value;
        $("#tenantSelector").hide();
        $("#invoiceSelector").hide();
        if ( x == 'property')
        {
            $("#tenantSelector").show();
        $("#invoiceSelector").hide();
        }else if ( x == 'agency'){
            $("#tenantSelector").hide();
        $("#invoiceSelector").show();
        }
    });
    
    $('#invoiceTypeSelector').change(function(){
        var x = document.getElementById("invoiceTypeSelector").value;
        $("#tenantSelector").hide();
        $("#invoiceSelector").hide();
        if ( x == 'property')
        {
            $("#tenantSelector").show();
        $("#invoiceSelector").hide();
        }else if ( x == 'agency'){
            $("#tenantSelector").hide();
        $("#invoiceSelector").show();
        }
    });
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
});

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/bedahgra/public_html/lesa-demo/rms/resources/views/manualinvoices/pay.blade.php ENDPATH**/ ?>