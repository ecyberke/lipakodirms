

<?php $__env->startPush('header_scripts'); ?>
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap-datetimepicker.min.css')); ?>">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />


<?php $__env->stopPush(); ?>
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
									<li class="breadcrumb-item active" aria-current="page">Edit Bill</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content container-fluid">

    <!-- Page Title -->
    <div class="row">
        
    </div>
    <!-- /Page Title -->

    <!-- Content Starts -->
    <div class="card">
    <form action="<?php echo e(route('payowner.update', $payowners->id)); ?>" method="post">
        <?php echo csrf_field(); ?>
        
        
        <div class="row">
            <?php echo e(csrf_field()); ?>


            <div class="col-12">
                <div class="">
                    <div class="card-body">
                        

                        
                        <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        
                            <div class="row">
                                <div class="col-sm-6 conditionalSections" id="serviceRequestSection">
                                    <div class="form-group">
                                        <label> Bill Type</label>
                                       
                                        <div>
                                            <?php if($payowners->type != '--select--'): ?>
                                            <input class="form-control " type="text" id="example-text-input" 
                                        value="<?php echo e($payowners->type); ?>" readonly>
                                        <?php else: ?>
                                         <input class="form-control " type="text" id="example-text-input" 
                                        value="Agency Bill" readonly>
                                        <?php endif; ?>
                                           
                                        </div>
                                    </div>
                                </div>
                                <?php if($payowners->apartment_id != null): ?>
                                <div class="col-sm-6 conditionalSections" id="apartmentSection">
                                    <div class="form-group">
                                        <label> Apartment<span class="text-danger">*</span></label>
                                        <div>
                                             <input class="form-control " type="text" id="example-text-input" 
                                        value="<?php echo e($payowners->apartment->name); ?>" readonly>
                                          
                                                
                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="col-sm-6 conditionalSections" id="agencySection">
                                    <div class="form-group">
                                        <label> Authorizing User</label>
                                        <div>
                                            
                                            
                                            <input class="form-control " type="text" id="example-text-input" name="agency_user"
                                        value="<?php echo e(Auth::user()->name); ?>" readonly>
                                        
                                        </div>
                                    </div>
                                </div>
                                <?php if(Auth::user()->is_super ): ?>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <div>
                                                <div class="form-group">
                                                    <?php if($payowners->total_owned_edit == 0  ): ?>
                                                        <input class="form-control " type="text" id="example-text-input" name="bill_amount"
                                                value="<?php echo e($payowners->total_owned); ?>">
                                                <?php elseif($payowners->total_owned_edit == $payowners->total_owned ): ?>
                                                <input class="form-control " type="text" id="example-text-input" name="bill_amount"
                                                value="<?php echo e($payowners->total_owned); ?>">
                                                <?php elseif($payowners->approval == 2  ): ?>
                                                <input class="form-control " type="text" id="example-text-input" name="bill_amount"
                                                value="<?php echo e($payowners->total_owned); ?>">
                                                <?php else: ?>
                                                <input class="form-control " type="text" id="example-text-input" name="bill_amount"
                                                value="<?php echo e($payowners->total_owned_edit); ?>">
                                                <?php endif; ?>
                                                   
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                      <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Bill Description </label>
                                    
                                                <?php if($payowners->description_edit == null  ): ?>
                                                <textarea name="bill_description" class="form-control" rows="6" value=""  ><?php echo e($payowners->description); ?></textarea>
                                                <?php elseif($payowners->description_edit == $payowners->description ): ?>
                                               <textarea name="bill_description" class="form-control" rows="6" value=""  ><?php echo e($payowners->description); ?></textarea>
                                                <?php elseif($payowners->approval == 2  ): ?>
                                                <textarea name="bill_description" class="form-control" rows="6" value=""  ><?php echo e($payowners->description); ?></textarea>
                                                <?php else: ?>
                                                <textarea name="bill_description" class="form-control" rows="6" value=""  ><?php echo e($payowners->description_edit); ?></textarea>
                                                <?php endif; ?>     
                                                    </div>
                                        </div><br>
                                    
                                    <?php else: ?>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <div>
                                              
                                                   <div class="form-group">
                                                    <?php if($payowners->total_owned_edit == 0  ): ?>
                                                        <input class="form-control " type="text" id="example-text-input" name="bill_amount_edit"
                                                value="<?php echo e($payowners->total_owned); ?>">
                                                <?php elseif($payowners->total_owned_edit == $payowners->total_owned ): ?>
                                                <input class="form-control " type="text" id="example-text-input" name="bill_amount_edit"
                                                value="<?php echo e($payowners->total_owned); ?>">
                                                <?php elseif($payowners->approval == 2  ): ?>
                                                <input class="form-control " type="text" id="example-text-input" name="bill_amount_edit"
                                                value="<?php echo e($payowners->total_owned); ?>">
                                                <?php else: ?>
                                                <input class="form-control " type="text" id="example-text-input" name="bill_amount_edit"
                                                value="<?php echo e($payowners->total_owned_edit); ?>">
                                                <?php endif; ?>
                                                   
                                                </div>
                                                        
                                                
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                      <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Bill Description </label>
                                                    
                                                      <?php if($payowners->description_edit == 0  ): ?>
                                                        <textarea name="bill_description_edit" class="form-control" rows="6" value=""  ><?php echo e($payowners->description); ?></textarea>
                                                <?php elseif($payowners->description_edit == $payowners->description ): ?>
                                               <textarea name="bill_description_edit" class="form-control" rows="6" value=""  ><?php echo e($payowners->description); ?></textarea>
                                                <?php elseif($payowners->approval == 2  ): ?>
                                                <textarea name="bill_description_edit" class="form-control" rows="6" value=""  ><?php echo e($payowners->description); ?></textarea>
                                                <?php else: ?>
                                                <textarea name="bill_description_edit" class="form-control" rows="6" value=""  ><?php echo e($payowners->description_edit); ?></textarea>
                                                <?php endif; ?>   
                                                    </div>
                                        </div><br>
                                        <?php endif; ?>
                                
                                
                                
                                
                                
                        
                            
                           
                            
                             <div class="row">
                            <?php if(Auth::user()->is_super ): ?>
                                     <div class="col-sm-6">
                                         <div class="form-group">
                                    <label>Authorize</label>
                                     <select  name="approval" class="form-control select2-show-search">

                                    <option selected value="<?php echo e($payowners->approval); ?>">
                                    <?php if($payowners->approval == 2): ?>
                                        <p style="color: #FF0000;">Decline</p>
                                    <?php elseif($payowners->approval == 0): ?>
                                        <p style="color: #00bfff;">Pending</p>
                                        <?php elseif($payowners->approval == 3): ?>
                                        <p style="color: #00bfff;">Amend</p>
                                    <?php elseif($payowners->approval == 1): ?>
                                        <p style="color: #66CD00;">Approved</p>
                                    <?php endif; ?>
                                    </option>

                                  
                                    <option value="0">Pending</option>
                                    <option value="1">Approve</option>
                                    <option value="3">Amend</option>
                                    <option value="2">Decline</option>
                                    

                                </select>
                                    </div>
                                    </div>
                                    <?php else: ?>
                                    <input class="form-control" type="text" readonly name="approval"
                                        value="0" hidden>
                                        <input class="form-control" type="text" readonly name="agency_user"
                                        value="<?php echo e(Auth::user()->name); ?>" hidden>
                                        <?php if($payowners->balance <= 0): ?>
                                         <input class="form-control" type="text" readonly name="pay_status"
                                        value="1" hidden>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    </div> <br>
                           
                                                
                                                        
                                        
                      
                         
                                

                        <div class="row mb-4">
                            <div class="col-sm-8">
                                
                               
                                <button type="submit" class="btn btn-success waves-effect waves-light">Update Bill</button></button>
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/payowners/edit.blade.php ENDPATH**/ ?>