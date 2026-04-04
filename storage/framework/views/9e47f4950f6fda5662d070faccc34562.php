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
									<li class="breadcrumb-item"><a href="#">Reports</a></li>
									<li class="breadcrumb-item active" aria-current="page">Owner Statement</li>
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
    <form action="<?php echo e(route('property_owner_statement')); ?>" method="get">
        <?php echo csrf_field(); ?>
        
        
        <div class="row">
           

            <div class="col-12">
                <div class="">
                    <div class="card-body">
                        

                        
                        <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        
                        <div class="row">
                            <div class="col-sm-12">
                            <label >Select Property <span class="text-danger">*</span></label>
                          
                            
                                <select class="form-control select2-show-search" style="width: 100%"  name="owner_id">

                                    <option selected disabled>-----Select-----</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $apartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apartment=>$key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($key); ?>"><?php echo e($apartment); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                                        <?php endif; ?>

                                </select>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-sm-6">
                            <label>From <span
                                    class="text-danger">*</span></label>
                            
                                <div class="form-group">
                                    <div class="cal-icon">
                                        <input class="form-control " type="date" name="from"
                                            value="<?php echo e(old('placement_date')); ?>">
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                            <label >To<span
                                class="text-danger">*</span></label>
                        
                            <div class="form-group">
                                <div class="cal-icon">
                                    <input class="form-control " type="date" name="to"
                                        value="<?php echo e(old('placement_date')); ?>">
                                </div>
                            </div>

                        </div>
                        </div><br>

                        <div class="row mb-4">
                            <div class="col-sm-8">
                                
                               
                                <button type="submit" class="btn btn-success waves-effect waves-light">Get Statement</button></button>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </form>
    
    </div>
          <?php if($hasReport): ?>
  <div class="card" style="padding-top:25px; padding-bottom:25px; padding-left:25px; padding-right:25px;">
        <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <h2>Property Owner Statement</h2>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-6">
                            <p><strong>Property Owner Name:</strong> <span><?php echo e($other_info['name']); ?></span></p>
                            <p><strong>Property Name:</strong> <span><?php echo e($other_info['apart_name']); ?></span></p>
                            <p><strong>Telephone:</strong> <span><?php echo e($other_info['phone']); ?></span></p>
                            <p><strong>Date of Statement:</strong> <span><?php echo e($other_info['date']); ?></span></p>
                            <p><strong>Statement Period:</strong> <span><?php echo e($other_info['from_to']); ?></span></p>
                        </div> <!-- end col -->
                        <div class="col-xs-6  float-right" style="float:right;text-align:right;">
                            <!--<div class="mt-3 float-right">-->
                            <!--    <img src="https://lesaagencies.co.ke/rms/assets/img/lesa.png" alt="Your Logo Here" height="100">-->
                            <!--</div>-->
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="title text-center">
                            <h4>Detailed Statement</h4>
                        </div>
                    </div>
                 <div class="row table-responsive   ">
                        <table class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 500px; width: 100%;">
                            <thead>
                              <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Reference</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <!--<th>Commission</th>-->
                              </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $property_owner_info_array_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <td><?php echo e($entry['date']); ?></td>
                                <td><?php echo e($entry['description']); ?></td>
                                <td><?php echo e($entry['reference']); ?></td>
                                <td><?php echo e($entry['amount']); ?></td>
                                <td><?php echo e($entry['paid']); ?></td>
                              </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                          </table>
                    </div>
                    <div class="col-12">
                        <div class="title text-center">
                            <h4>Summary</h4>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped">
                            <thead>
                              <tr>
                                <td>Details</td>
                                <td >Amount</td>
                                <td >Paid</td>
                              </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Rent</td>
                                    <td ><?php echo e($totals['rent']); ?></td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td>Bills</td>
                                    <td >-</td>
                                    <td ><?php echo e($totals['maintenance']); ?></td>
                                </tr>
                                <tr>
                                    <td>Commission</td>
                                    <td >-</td>
                                    <td ><?php echo e($totals['commission']); ?></td>
                                    
                                </tr>
                                <tr>
                                    <th>Sub Total</th>
                                    <th ><?php echo e($totals['sum_amount']); ?></th>
                                     <th >-</th>
                                </tr>
                                <tr>
                                    <th>Sum Remitance</th>
                                    <th >-</th>
                                    <th ><?php echo e($totals['sum_remitance']); ?></th>
                                </tr>
                                <tr>
                                    <th>Balance</th>
                                    <th ><?php echo e($totals['balance']); ?></th>
                                   
                                </tr>
                            </tbody>
                          </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                                <a  href="<?php echo e(\Request::fullUrl()); ?>&download=yes" target="_blank" class="m-2 btn btn-success waves-effect waves-light">Download Statement</a>
                            </div>
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->
        </div>
    </div>

<?php endif; ?>
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ecyberco/domains/lipakodi.ecyber.co.ke/public_html/rms/resources/views/report/landlordform.blade.php ENDPATH**/ ?>