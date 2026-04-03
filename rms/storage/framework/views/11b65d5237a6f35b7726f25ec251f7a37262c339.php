
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
									<li class="breadcrumb-item"><a href="<?php echo e(route('admin.index')); ?>">Users</a></li>
									<li class="breadcrumb-item active" aria-current="page">Edit User's Details</li></li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content container-fluid">

    <!-- Page Title -->
    
    <!-- /Page Title -->

    <!-- Content Starts -->
    <div class="content container-fluid">
    <form action="<?php echo e(route('admin.update',$user->id )); ?>" method="post">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
              
                               
            <div class="row">
    
    
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!--<h4 class="mt-0 header-title mb-4">Update User Details</h4>-->
    
                            <!--<hr class="mt-2 mb-4">-->
                            <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
                          <div class="row">
                          <div class="col-sm-6">
                                <label> Name </label>
                                    <input type="text" class="form-control" name="name" value="<?php echo e($user->name); ?>" readonly>
                         </div>
                         <div class="col-sm-6">
                                <label >UserName </label>
                                    <input type="text" class="form-control" name="username" value="<?php echo e($user->username); ?>" readonly>
                                </div>
                         </div><br>
    
    
                            <div class="row">
                                <div class="col-sm-6">
                                        <label >Phone Number</label>
                                            <input type="text" class="form-control" name="user_id" pattern=".{12,}"   required title="Phone number must begin with 254 and contain 12 characters"
                                            value="<?php echo e($user->user_id); ?>">
                                            
                                        </div>
                               
                                <div class="col-sm-6">
                                <label>Email Address</label>
                                
                                    <input class="form-control" type="email" id="agent_name" name="email"
                                        value="<?php echo e($user->email); ?>">
                                </div>
                                
                            </div><br>
                            <div class="row">
                                <div class="col-sm-6">
                                <label >User Level </label>
                                
                                    <div class="form-group">
                                     
                                        <select class="form-control select2-show-search" name="is_admin">
                                            <option value="0" <?php echo e($user->is_admin===0 ? 'selected' : ''); ?> >Agent</option>
                                            <option value="1" <?php echo e($user->is_admin===1 ? 'selected' : ''); ?> >Office Manager</option>
                                            <option value="2" <?php echo e($user->is_admin===2 ? 'selected' : ''); ?> >Administrator</option>
                                        </select>
                                    </div>
    
                                </div>
                                <!--<div class="col-sm-6">-->
                                <!--<label >User Can Make Payments </label>-->
                                
                                <!--    <div class="form-group">-->
                                     
                                <!--        <select class="form-control select2-show-search" name="authorize_payment">-->
                                <!--            <option value="0" <?php echo e($user->authorize_payment===0 ? 'selected' : ''); ?> >No</option>-->
                                <!--            <option value="1" <?php echo e($user->authorize_payment===1 ? 'selected' : ''); ?> >Yes</option>-->
                                <!--        </select>-->
                                <!--    </div>-->
    
                                <!--</div>-->
                               
                            </div>
                            
                            
                            
                            
                            
    
                            <div class="row mb-4">
                                <div class="col-sm-8 ">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Update User</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
        </form>
        
    </div>
</div>
</form>

       
        

</div>

    <!-- /Content End -->

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/authorization/edit.blade.php ENDPATH**/ ?>