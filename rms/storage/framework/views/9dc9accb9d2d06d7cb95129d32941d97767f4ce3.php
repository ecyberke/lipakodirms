
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
									<li class="breadcrumb-item active" aria-current="page">Edit Bill</li></li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
						<!-- Row -->
						<div class="row">
							<div class="col-lg-12 col-md-12">
	  <form action="<?php echo e(route('servicerequests.update',$service_requests->id)); ?>" method="POST" class="card">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?php if(Auth::user()->is_admin == 2 ): ?>
                                    <label>Service Request </label>
                                   
                                                <?php if($service_requests->service_request_edit == null  ): ?>
                                                <textarea name="service_request" class="form-control" rows="4" cols="66" value="<?php echo e($service_requests->service_request); ?>" ><?php echo e($service_requests->service_request); ?></textarea>
                                                <?php elseif($service_requests->service_request_edit == $service_requests->service_request ): ?>
                                               <textarea name="service_request" class="form-control" rows="4" cols="66" value="<?php echo e($service_requests->service_request); ?>" ><?php echo e($service_requests->service_request); ?></textarea>
                                                <?php elseif($service_requests->approval == 2  ): ?>
                                                <textarea name="service_request" class="form-control" rows="4" cols="66" value="<?php echo e($service_requests->service_request); ?>" ><?php echo e($service_requests->service_request); ?></textarea>
                                                <?php else: ?>
                                                 <textarea name="service_request" class="form-control" rows="4" cols="66" value="<?php echo e($service_requests->service_request); ?>" ><?php echo e($service_requests->service_request_edit); ?></textarea>
                                                <?php endif; ?>   
                                    </div>
                                    
                                    </div> <br>
                                    <div class="row">
                                    <div class="col-sm-6">
                                    <label>Service Status</label>
                                     <select class="select"  name="status">
                                      <?php if($service_requests->status_edit == 0  ): ?>
                                    <option selected value="<?php echo e($service_requests->status); ?>">
                                    <?php if($service_requests->status == 1): ?>
                                        <p style="color: #FF0000;">Closed</p>
                                    <?php elseif($service_requests->status == 2): ?>
                                        <p style="color: #00bfff;">In Progress</p>
                                    <?php elseif($service_requests->status == 0): ?>
                                        <p style="color: #66CD00;">Open</p>
                                    <?php endif; ?>
                                    </option>
                                     <?php elseif($service_requests->status_edit == $service_requests->status ): ?>
                                      <option selected value="<?php echo e($service_requests->status); ?>">
                                    <?php if($service_requests->status == 1): ?>
                                        <p style="color: #FF0000;">Closed</p>
                                    <?php elseif($service_requests->status == 2): ?>
                                        <p style="color: #00bfff;">In Progress</p>
                                    <?php elseif($service_requests->status == 0): ?>
                                        <p style="color: #66CD00;">Open</p>
                                    <?php endif; ?>
                                    </option>
                                      <?php elseif($service_requests->approval == 2  ): ?>
                                       <option selected  value="<?php echo e($service_requests->status); ?>">
                                    <?php if($service_requests->status == 1): ?>
                                        <p style="color: #FF0000;">Closed</p>
                                    <?php elseif($service_requests->status == 2): ?>
                                        <p style="color: #00bfff;">In Progress</p>
                                    <?php elseif($service_requests->status == 0): ?>
                                        <p style="color: #66CD00;">Open</p>
                                    <?php endif; ?>
                                    </option>
                                       <?php else: ?>
                                        <option selected  value="<?php echo e($service_requests->status_edit); ?>">
                                    <?php if($service_requests->status_edit == 1): ?>
                                        <p style="color: #FF0000;">Closed</p>
                                    <?php elseif($service_requests->status_edit == 2): ?>
                                        <p style="color: #00bfff;">In Progress</p>
                                    <?php elseif($service_requests->status_edit == 0): ?>
                                        <p style="color: #66CD00;">Open</p>
                                    <?php endif; ?>
                                    </option>
                                       <?php endif; ?>

                                  
                                    <option value="0">Open</option>
                                    <option value="2">In Progress</option>
                                    <option value="1">Closed</option>

                                </select>
                                    </div>
                                    <?php else: ?>
                                    <?php if($service_requests->approval != 1): ?>
                                    <label>Service Request </label>
                                    
                                                <?php if($service_requests->service_request_edit == null  ): ?>
                                                <textarea name="service_request_edit" class="form-control" rows="4" cols="66"  ><?php echo e($service_requests->service_request); ?></textarea>
                                                <?php elseif($service_requests->service_request_edit == $service_requests->service_request ): ?>
                                               <textarea name="service_request_edit" class="form-control" rows="4" cols="66"  ><?php echo e($service_requests->service_request); ?></textarea>
                                                <?php elseif($service_requests->approval == 2  ): ?>
                                                <textarea name="service_request_edit" class="form-control" rows="4" cols="66"  ><?php echo e($service_requests->service_request); ?></textarea>
                                                <?php else: ?>
                                                 <textarea name="service_request_edit" class="form-control" rows="4" cols="66"  ><?php echo e($service_requests->service_request_edit); ?></textarea>
                                                <?php endif; ?> 
                                    <?php endif; ?>
                                    </div>
                                    
                                    </div> <br>
                                    <div class="row">
                                    <div class="col-sm-12">
                                    <label>Service Status</label>
                                     <select class="select"  name="status_edit">
                                      <?php if($service_requests->status_edit == 0  ): ?>
                                    <option selected value="<?php echo e($service_requests->status); ?>" >
                                    <?php if($service_requests->status == 1): ?>
                                        <p style="color: #FF0000;">Closed</p>
                                    <?php elseif($service_requests->status == 2): ?>
                                        <p style="color: #00bfff;">In Progress</p>
                                    <?php elseif($service_requests->status == 0): ?>
                                        <p style="color: #66CD00;">Open</p>
                                    <?php endif; ?>
                                    </option>
                                     <?php elseif($service_requests->status_edit == $service_requests->status ): ?>
                                      <option selected value="<?php echo e($service_requests->status); ?>">
                                    <?php if($service_requests->status == 1): ?>
                                        <p style="color: #FF0000;">Closed</p>
                                    <?php elseif($service_requests->status == 2): ?>
                                        <p style="color: #00bfff;">In Progress</p>
                                    <?php elseif($service_requests->status == 0): ?>
                                        <p style="color: #66CD00;">Open</p>
                                    <?php endif; ?>
                                    </option>
                                      <?php elseif($service_requests->approval == 2  ): ?>
                                       <option selected value="<?php echo e($service_requests->status); ?>">
                                    <?php if($service_requests->status == 1): ?>
                                        <p style="color: #FF0000;">Closed</p>
                                    <?php elseif($service_requests->status == 2): ?>
                                        <p style="color: #00bfff;">In Progress</p>
                                    <?php elseif($service_requests->status == 0): ?>
                                        <p style="color: #66CD00;">Open</p>
                                    <?php endif; ?>
                                    </option>
                                       <?php else: ?>
                                        <option selected value="<?php echo e($service_requests->status_edit); ?>">
                                    <?php if($service_requests->status_edit == 1): ?>
                                        <p style="color: #FF0000;">Closed</p>
                                    <?php elseif($service_requests->status_edit == 2): ?>
                                        <p style="color: #00bfff;">In Progress</p>
                                    <?php elseif($service_requests->status_edit == 0): ?>
                                        <p style="color: #66CD00;">Open</p>
                                    <?php endif; ?>
                                    </option>
                                       <?php endif; ?>

                                  
                                    <option value="0">Open</option>
                                    <option value="2">In Progress</option>
                                    <option value="1">Closed</option>

                                </select>
                                    </div>
                                    <?php endif; ?>
                                    <?php if(Auth::user()->is_admin==2 ): ?>
                                     <div class="col-sm-6">
                                    <label>Authorize</label>
                                     <select class="select"  name="approval">

                                    <option selected value="<?php echo e($service_requests->approval); ?>" >
                                    <?php if($service_requests->approval == 2): ?>
                                        <p style="color: #FF0000;">Decline</p>
                                    <?php elseif($service_requests->approval == 0): ?>
                                        <p style="color: #00bfff;">Pending</p>
                                    <?php elseif($service_requests->approval == 1): ?>
                                        <p style="color: #66CD00;">Approved</p>
                                        <?php elseif($service_requests->approval == 3): ?>
                                        <p style="color: #66CD00;">Amend</p>
                                    <?php endif; ?>
                                    </option>

                                  
                                    <option value="0">Pending</option>
                                    <option value="1">Approve</option>
                                    <option value="2">Decline</option>
                                    <option value="3">Amend</option>

                                </select>
                                    </div>
                                    <?php else: ?>
                                    <input class="form-control" type="text" readonly name="approval"
                                        value="0" hidden>
                                        <input class="form-control" type="text" readonly name="manager"
                                        value="<?php echo e(Auth::user()->name); ?>" hidden>
                                    <?php endif; ?>
                                    
                                    </div> <br>
                                    
                            
                                       
                                
                    
                                
                                
                                
                              
                                
                                

                               
                                <div class="row mb-4">
                            <div class="col-sm-8">
                                
                               
                                <button type="submit" class="btn btn-success waves-effect waves-light">Update Request</button></button>
                            </div>
                           
                        </div>

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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/servicerequests/edit.blade.php ENDPATH**/ ?>