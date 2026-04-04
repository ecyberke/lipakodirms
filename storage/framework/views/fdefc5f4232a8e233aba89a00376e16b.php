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
									<li class="breadcrumb-item active" aria-current="page">Property Income Expense Report</li>
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
        <form action="<?php echo e(route('report.property_income_expense_report')); ?>" method="get">
            <?php echo csrf_field(); ?>
          
             <?php if($message != ''): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">×</span>
                             </button>
                             <?php echo e($message); ?>

                             </div>
                             <?php endif; ?>
                       
            <div class="row">
               
    
                <div class="col-12">
                    <div class="">
                        <div class="card-body">
                            <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                          
                            <div class="row">
                                <div class="col-sm-8">
                                <label >Select Property <span class="text-danger">*</span></label>
                              
                                
                                <select class="form-control select2-show-search" style="width: 100%"  name="apartment_id" >
    
                                    <option selected disabled>-----Select-----</option>
                                    <?php $__empty_1 = true; $__currentLoopData = $apartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apartment=>$key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($key); ?>"><?php echo e($apartment); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    
                                        <?php endif; ?>
    
                                </select>
                                </div>
                                <div class="col-sm-4">
                                <label>Month <span
                                        class="text-danger">*</span><i>(Click on the icon to select month)</i></label>
                                       <input class="form-control" type="month" id="start" name="rent_month"
                                          min="2020-10" value="">
                                </div>
                            </div><br>
                           
    
                            <div class="row mb-4">
                                <div class="col-sm-8">
                                    
                                   
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Get Report</button></button>
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
                    <h2>PROPERTY INCOME EXPENSE REPORT</h2>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-6">
                            <p><strong>Report Month:</strong> <span><?php echo e($rent_month); ?></span></p>
                            <p><strong>Property Owner:</strong> <span><?php echo e($property_owner); ?></span></p>
                            <p><strong>Property Name:</strong> <span><?php echo e($property_name); ?></span></p>
                            <p><strong>Property Management Fee (%):</strong> <span><?php echo e($property_mgt); ?></span></p>
                            
                           <p><strong>Total Monthly Rent:</strong> <span><?php echo e(number_format($totals['total_rent'])); ?></span></p>
                        </div> <!-- end col -->
                        <div class="col-xs-6  float-right" style="float:right;text-align:right;">
                            <div class="mt-3 float-right">
                                <img src="https://lesaagencies.co.ke/rms/assets/img/lesa.png" alt="" height="100">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="title text-center">
                            <h4>Property Income Report</h4>
                        </div>
                    </div>
                  <div class="row table-responsive   ">
                        <table class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 500px; width: 100%;">
                            <thead>
                              <tr>
                                <th class="text-right">Acc. Number</th>
                                <th class="text-right">House No.</th>
                                <th class="text-right">Phone Number</th>
                                <th class="text-right">Tenant Name</th>
                                <th class="text-right">Expected Monthly Rent</th>
                                <th class="text-right">Total Expecting</th>
                                <th class="text-right">Rent Paid</th>
                                <th class="text-right">Outstanding Balance</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $income_entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <th><?php echo e($entry['tenant']['account_number']); ?></th>
                                <th><?php echo e($entry['house']['house_no']); ?></th>
                                <th><?php echo e($entry['tenant']['phone']); ?></th>
                                <td><?php echo e($entry['tenant']['full_name']); ?></td>
                                <td class="text-right"><?php echo e(number_format($entry['rent'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($entry['total_payable'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($entry['paid_in'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($entry['balance'])); ?></td>
                              </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                  <th colspan="4">Totals</th>
                                  <th class="text-right text-bold"><?php echo e(number_format($totals['total_rent'])); ?></th>
                                  <th class="text-right text-bold"><?php echo e(number_format($totals['total_payable'])); ?></th>
                                  <th class="text-right text-bold"><?php echo e(number_format($totals['total_paid_in'])); ?></th>
                                  <th class="text-right text-bold"><?php echo e(number_format($totals['total_balance'])); ?></th>
                                </tr>
                            </tbody>
                          </table>
                    </div>
                     <hr><br>
                    <!-- end row -->
                    
                      <div class="col-12">
                        <div class="title text-center">
                            <h4>Property Expense Report</h4>
                        </div>
                    </div>
                  <div class="row table-responsive   ">
                        <table class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 500px; width: 100%;">
                            <thead>
                              <tr>
                                <th class="text-right">Acc. Number</th>
                                <th class="text-right">House No.</th>
                                <th class="text-right">Phone Number</th>
                                <th class="text-right">Tenant Name</th>
                                <th class="text-right">Bill Amount</th>
                                <th class="text-right">Amount Paid</th>
                                <th class="text-right">Outstanding Balance</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $service_request_entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <th><?php echo e($entry['serviceRequest']['tenant']['account_number']); ?></th>
                                <th><?php echo e($entry['serviceRequest']['house']['house_no']); ?></th>
                                <th><?php echo e($entry['serviceRequest']['tenant']['phone']); ?></th>
                                <td><?php echo e($entry['serviceRequest']['tenant']['full_name']); ?></td>
                                <td class="text-right"><?php echo e(number_format($entry['total_owned'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($entry['paid_in'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($entry['balance'])); ?></td>
                              </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                  <th colspan="4">Totals</th>
                                  <th class="text-right text-bold"><?php echo e(number_format($totals['expense_total_owned'])); ?></th>
                                  <th class="text-right text-bold"><?php echo e(number_format($totals['expense_total'])); ?></th>
                                  <th class="text-right text-bold"><?php echo e(number_format($totals['expense_balance'])); ?></th>
                                </tr>
                            </tbody>
                          </table>
                    </div>
                     <hr><br>
                    <div class="col-12">
                        <div class="title text-center">
                            <h4>Property Bills Report</h4>
                        </div>
                    </div>
                  <div class="row table-responsive   ">
                        <table class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 500px; width: 100%;">
                            <thead>
                              <tr>
                                <th class="text-right">Description</th>
                                <th class="text-right">Bill Amount</th>
                                <th class="text-right">Amount Paid</th>
                                <th class="text-right">Outstanding Balance</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $bill_entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                             
                                <td><?php echo e($entry['bill_category']); ?></td>
                                <td class="text-right"><?php echo e(number_format($entry['total_owned'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($entry['paid_in'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($entry['balance'])); ?></td>
                              </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                  <th>Totals</th>
                                  <th class="text-right text-bold"><?php echo e(number_format($totals['paidforbills_total_owned'])); ?></th>
                                  <th class="text-right text-bold"><?php echo e(number_format($totals['paidforbills_total'])); ?></th>
                                  <th class="text-right text-bold"><?php echo e(number_format($totals['paidforbills_balance'])); ?></th>
                                </tr>
                            </tbody>
                          </table>
                    </div>
                    
                    <hr><br>
                    <div class="col-12">
                        <div class="title text-center">
                            <h4>Property Maintenance Report</h4>
                        </div>
                    </div>
                  <div class="row table-responsive   ">
                        <table class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 500px; width: 100%;">
                            <thead>
                              <tr>
                                <th class="text-right">Description</th>
                                <th class="text-right">Bill Amount</th>
                                <th class="text-right">Amount Paid</th>
                                <th class="text-right">Outstanding Balance</th>
                              </tr>
                            </thead>
                            <tbody>
                            
                                
                                <?php if($totals['service_bill_water'] > 0): ?>
                              <tr>
                             
                                 <td>Water Bill</td>
                                
                                
                                <td class="text-right"><?php echo e(number_format($totals['service_bill_water'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($totals['service_bill_water'])); ?></td>
                                <td class="text-right"><?php echo e(number_format(0)); ?></td>
                              </tr>
                              <?php endif; ?>
                               <?php if($totals['service_bill_security'] > 0): ?>
                               <tr>
                             
                                <td>Security Bill</td>
                                
                                
                                 <td class="text-right"><?php echo e(number_format($totals['service_bill_security'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($totals['service_bill_security'])); ?></td>
                                <td class="text-right"><?php echo e(number_format(0)); ?></td>
                              </tr>
                              <?php endif; ?>
                              <?php if($totals['service_bill_electricity'] > 0): ?>
                               <tr>
                             
                                <td>Electricity</td>
                                
                                
                                 <td class="text-right"><?php echo e(number_format($totals['service_bill_electricity'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($totals['service_bill_electricity'])); ?></td>
                                <td class="text-right"><?php echo e(number_format(0)); ?></td>
                              </tr>
                              <?php endif; ?>
                               <?php if($totals['service_bill_sewer'] > 0): ?>
                               <tr>
                             
                                <td>Sewer</td>
                               
                                
                                
                                 <td class="text-right"><?php echo e(number_format($totals['service_bill_sewer'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($totals['service_bill_sewer'])); ?></td>
                                <td class="text-right"><?php echo e(number_format(0)); ?></td>
                              </tr>
                              <?php endif; ?>
                              <?php if($totals['service_bill_cleaning'] > 0): ?>
                              <tr>
                             
                                <td>Cleaning</td>
                               
                                
                                
                               <td class="text-right"><?php echo e(number_format($totals['service_bill_cleaning'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($totals['service_bill_cleaning'])); ?></td>
                                <td class="text-right"><?php echo e(number_format(0)); ?></td>
                              </tr>
                              <?php endif; ?>
                              <?php if($totals['service_bill_garbage'] > 0): ?>
                              <tr>
                             
                                <td>Garbage Collection</td>
                               
                                
                                   <td class="text-right"><?php echo e(number_format($totals['service_bill_garbage'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($totals['service_bill_garbage'])); ?></td>
                                <td class="text-right"><?php echo e(number_format(0)); ?></td>
                              </tr>
                              <?php endif; ?>
                              <?php if($totals['service_bill_internet'] > 0): ?>
                              <tr>
                             
                                <td>Internet Bill</td>
                               
                                
                                
                                <td class="text-right"><?php echo e(number_format($totals['service_bill_internet'])); ?></td>
                                <td class="text-right"><?php echo e(number_format($totals['service_bill_internet'])); ?></td>
                                <td class="text-right"><?php echo e(number_format(0)); ?></td>
                              </tr>
                              <?php endif; ?>
                              
                            
                              <tr>
                                  <th>Totals</th>
                                  <th class="text-right text-bold"><?php echo e(number_format($totals['service_bill_total'])); ?></th>
                                  <th class="text-right text-bold"><?php echo e(number_format($totals['service_bill_total'])); ?></th>
                                  <th class="text-right text-bold"><?php echo e(number_format(0)); ?></th>
                                </tr>
                            </tbody>
                          </table>
                    </div>
              
        </div><hr><hr>
                    <div ><br><br>
                       <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <h4>PROPERTY INCOME EXPENSE SUMMARY</h4>
                </div>
            </div>
        </div>
                        <table class="table dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 500px; width: 100%;">
                             <thead>
                              <tr>
                               
                               
                                <th >Description</th>
                                <th >Amount</th>
                              </tr>
                            </thead>
                             
                              <tr>
                                <!--<th colspan="4"> </th>-->
                                <th >Property Income</th>
                                <th ><?php echo e(number_format($totals['total_paid_in'], 2)); ?></th>
                              </tr>
                              <tr>
                                <!--<th colspan="4"> </th>-->
                                <th >Property Management Fee</th>
                                <th ><?php echo e(number_format(($totals['total_paid_in']* $property_mgt)/100, 2)); ?></th>
                              </tr>
                               <tr>
                                <!--<th colspan="4"> </th>-->
                                <th >Property Expense</th>
                                <th ><?php echo e(number_format($totals['expense_total'], 2)); ?></th>
                              </tr>
                               <tr>
                                <!--<th colspan="4"> </th>-->
                                <th >Property Bill</th>
                                <th ><?php echo e(number_format($totals['paidforbills_total'], 2)); ?></th>
                              </tr>
                              <tr>
                                <!--<th colspan="4"> </th>-->
                                <th >Property Maintenance Fee</th>
                                <th ><?php echo e(number_format($totals['service_bill_total'], 2)); ?></th>
                              </tr>
                              <tr>
                                <!--<th colspan="4"> </th>-->
                                <th >Remittance</th>
                                <th ><?php echo e(number_format($totals['remittance_total'], 2)); ?></th>
                              </tr>
                              <tr>
                                <!--<th colspan="4"> </th>-->
                                <th >Outstanding Total Amount</th>
                                <th ><?php echo e(number_format(($totals['total_paid_in'] - (($totals['total_paid_in']* $property_mgt)/100) - $totals['expense_total'] - $totals['paidforbills_total'] - $totals['service_bill_total'] - $totals['remittance_total'] ), 2)); ?></th>
                              </tr>
                            </tbody>
                          </table>
                    </div>
                    
                   

                </div> <!-- container -->
    <div class="row">
                        <div class="col-md-12 text-center">
                                <a  href="<?php echo e(\Request::fullUrl()); ?>&download=yes" target="_blank" class="m-2 btn btn-success waves-effect waves-light">Download Report</a>
                            </div>
                    </div>
            </div> <!-- content -->
        </div>
    </div>


    <!-- /Content End -->
         <?php endif; ?>
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
    $('#apartment_id').change(function () {
        var id = $(this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "<?php echo route('ajax.houses.filter'); ?>",
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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ecyberco/domains/lipakodi.ecyber.co.ke/public_html/rms/resources/views/report/property_income_expense.blade.php ENDPATH**/ ?>