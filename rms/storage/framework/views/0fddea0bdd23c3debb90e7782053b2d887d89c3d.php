
<?php $__env->startSection('css'); ?>
<!-- Select2 css -->
<link href="<?php echo e(URL::asset('assets/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
<!-- File Uploads css -->
<link href="<?php echo e(URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')); ?>" rel="stylesheet" />
<!-- Time picker css -->
<link href="<?php echo e(URL::asset('assets/plugins/time-picker/jquery.timepicker.css')); ?>" rel="stylesheet" />
<!-- Date Picker css -->
<link href="<?php echo e(URL::asset('assets/plugins/date-picker/date-picker.css')); ?>" rel="stylesheet" />
<!-- File Uploads css-->
 <link href="<?php echo e(URL::asset('assets/plugins/fileupload/css/fileupload.css')); ?>" rel="stylesheet" type="text/css" />
<!--Mutipleselect css-->
<link rel="stylesheet" href="<?php echo e(URL::asset('assets/plugins/multipleselect/multiple-select.css')); ?>">
<!--Sumoselect css-->
<link rel="stylesheet" href="<?php echo e(URL::asset('assets/plugins/sumoselect/sumoselect.css')); ?>">
<!--intlTelInput css-->
<link rel="stylesheet" href="<?php echo e(URL::asset('assets/plugins/intl-tel-input-master/intlTelInput.css')); ?>">
<!--Jquerytransfer css-->
<link rel="stylesheet" href="<?php echo e(URL::asset('assets/plugins/jQuerytransfer/jquery.transfer.css')); ?>">
<link rel="stylesheet" href="<?php echo e(URL::asset('assets/plugins/jQuerytransfer/icon_font/icon_font.css')); ?>">
<!--multi css-->
<link rel="stylesheet" href="<?php echo e(URL::asset('assets/plugins/multi/multi.min.css')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-header'); ?>
						<!--Page header-->
						<div class="page-header">
							<!--<div class="page-leftheader">-->
							<!--	<h4 class="page-title">Advanced Foms</h4>-->
							<!--</div>-->
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
									<!--<li class="breadcrumb-item"><a href="#">Forms</a></li>-->
									<li class="breadcrumb-item active" aria-current="page">Create Bill</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
						<!-- Row -->
						<div class="row">
							<div class="col-lg-12 col-md-12">
	<form action="<?php echo e(route('manualinvoice.store')); ?>" method="post" class="card">
        <?php echo csrf_field(); ?>
        
        
        <div class="row">
            <?php echo e(csrf_field()); ?>


            <div class="col-12">
                <div class="">
                    <div class="card-body">
                        

                        
                        <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="row">
                            <div class="col-sm-12">
                            <label>Select Income<span class="text-danger">*</span></label>
                            <select id="placementSelector" class="form-control select2-show-search" style="width: 100%"  name="type">

                                
                                <option value="placement" selected>Placement Fee</option>
                                <option value="management">Management Fee</option>
                                <option value="viewing">Viewing Fee</option>
                                <option value="others">Others</option>
                                
                           

                            </select>
                            </div></div> <br>
                            <div class="row">
                                <div class="col-sm-6" >
                                    <div class="form-group">
                                        <label id="tenantName"> Tenant Name<span class="text-danger">*</span></label>
                                        <label id="incomeSource">Income Source<span class="text-danger">*</span></label>
                                        <div>
                                            <input class="form-control" type="text" id="example-text-input" name="tenant_name"
                                        value="<?php echo e(old('')); ?>">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Apartment <span class="text-danger">*</span></label>
                                        <div>
                                            <div class="form-group">
                                               
                                                    <input class="form-control " type="text" name="apartment_name"
                                            value="">
                                               
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>House <span class="text-danger">*</span></label>
                                        <div>
                                            <div class="form-group">
                                               
                                                    <input class="form-control" type="text" name="house_name"
                                            value="">
                                               
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6" >
                                    <div class="form-group">
                                        <label id="tenantPhone">Tenant Phone Number<span class="text-danger">*</span></label>
                                        <label id="sourcePhone">Source Phone Number<span class="text-danger">*</span></label>
                                        <div>
                                            <div class="form-group">
                                               
                                                    <input class="form-control " type="tel" name="tenant_phone"
                                            value="">
                                               
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6" >
                                    <div class="form-group">
                                        <label id="placement_amount">Placement Fee<span class="text-danger">*</span></label>
                                        <label id="management_amount">Management Fee<span class="text-danger">*</span></label>
                                        <label id="viewing_amount">Viewing Fee<span class="text-danger">*</span></label>
                                        <label id="others_amount">Amount<span class="text-danger">*</span></label>
                                        <div>
                                            <div class="form-group">
                                               
                                                    <input class="form-control" type="number" name="total_payable"
                                            value="">
                                               
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                    
                           
                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Income Description <span class="text-danger">*</span></label>
                                                    <textarea name="description" class="form-control" rows="6"  ></textarea>
                                                        
                                                    </div>
                                        </div><br>
                                                
                                                        
                                
                      
                         
                                

                        <div class="row mb-4">
                            <div class="col-sm-8">
                                
                               
                                <button type="submit" class="btn btn-success waves-effect waves-light">Add Invoice</button></button>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </form>
							

								
							</div>
						
					</div>
			
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<!--Select2 js -->
<script src="<?php echo e(URL::asset('assets/plugins/select2/select2.full.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/select2.js')); ?>"></script>
<!-- Timepicker js -->
<script src="<?php echo e(URL::asset('assets/plugins/time-picker/jquery.timepicker.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/time-picker/toggles.min.js')); ?>"></script>
<!-- Datepicker js -->
<script src="<?php echo e(URL::asset('assets/plugins/date-picker/date-picker.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/date-picker/jquery-ui.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')); ?>"></script>
<!--File-Uploads Js-->
<script src="<?php echo e(URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')); ?>"></script>
<!-- File uploads js -->
<script src="<?php echo e(URL::asset('assets/plugins/fileupload/js/dropify.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/filupload.js')); ?>"></script>
<!-- Multiple select js -->
<script src="<?php echo e(URL::asset('assets/plugins/multipleselect/multiple-select.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/multipleselect/multi-select.js')); ?>"></script>
<!--Sumoselect js-->
<script src="<?php echo e(URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')); ?>"></script>
<!--intlTelInput js-->
<script src="<?php echo e(URL::asset('assets/plugins/intl-tel-input-master/intlTelInput.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/intl-tel-input-master/country-select.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/intl-tel-input-master/utils.js')); ?>"></script>
<!--jquery transfer js-->
<script src="<?php echo e(URL::asset('assets/plugins/jQuerytransfer/jquery.transfer.js')); ?>"></script>
<!--multi js-->
<script src="<?php echo e(URL::asset('assets/plugins/multi/multi.min.js')); ?>"></script>
<!-- Form Advanced Element -->
<script src="<?php echo e(URL::asset('assets/js/formelementadvnced.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/form-elements.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/file-upload.js')); ?>"></script>
<script>
     $(document).ready(function () {
        var x = document.getElementById("placementSelector").value;
        $("#viewing_amount").hide();
        $("#others_amount").hide();
        $("#management_amount").hide();
        $("#placement_amount").hide();
        $("#incomeSource").hide();
        $("#tenantName").hide();
        $("#sourcePhone").hide();
        $("#tenantPhone").hide();
        if ( x == 'placement')
        {
            $("#placement_amount").show();
            $("#tenantName").show();
            $("#tenantPhone").show();
        }else if ( x == 'management'){
            $("#management_amount").show();
            $("#tenantName").show();
            $("#tenantPhone").show();
        }else if(x == 'viewing'){
            $("#viewing_amount").show();
            $("#tenantName").show();
            $("#tenantPhone").show();
        }else if(x == 'others'){
            $("#others_amount").show();
            $("#incomeSource").show();
            $("#sourcePhone").show();
        }
    });

    $('#placementSelector').change(function(){
        var x = document.getElementById("placementSelector").value;
        $("#viewing_amount").hide();
        $("#others_amount").hide();
        $("#management_amount").hide();
        $("#placement_amount").hide();
        $("#incomeSource").hide();
        $("#tenantName").hide();
        $("#sourcePhone").hide();
        $("#tenantPhone").hide();
        if ( x == 'placement')
        {
            $("#placement_amount").show();
            $("#tenantName").show();
            $("#tenantPhone").show();
        }else if ( x == 'management'){
            $("#management_amount").show();
            $("#tenantName").show();
            $("#tenantPhone").show();
        }else if(x == 'viewing'){
            $("#viewing_amount").show();
            $("#tenantName").show();
            $("#tenantPhone").show();
        }else if(x == 'others'){
            $("#others_amount").show();
            $("#incomeSource").show();
            $("#sourcePhone").show();
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

    
   

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/bedahgra/public_html/rms/work/rms/resources/views/manualinvoices/create.blade.php ENDPATH**/ ?>