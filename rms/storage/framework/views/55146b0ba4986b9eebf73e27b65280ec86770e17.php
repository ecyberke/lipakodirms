
<?php $__env->startSection('css'); ?>
<!-- Data table css -->
<link href="<?php echo e(URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')); ?>"  rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" />
<!-- Slect2 css -->
<link href="<?php echo e(URL::asset('assets/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-header'); ?>
						<!--Page header-->
						<div class="page-header">
						
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
									<!--<li class="breadcrumb-item"><a href="#">Forms</a></li>-->
									<li class="breadcrumb-item active" aria-current="page">Invoices</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
						<!-- Row -->
				<div class="row">
        
        <div class="col-md-12">
            <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <!--<div class="dropdown">-->
                        <!--    <button onclick="myFunction()" class="dropbtn">Filter Invoices</button>-->
                        <!--    <div id="myDropdown" class="dropdown-content">-->
                        <!--      <a href="<?php echo e(route('invoice.unpaid')); ?>">Unpaid Invoices</a>-->
                        <!--      <a href="<?php echo e(route('invoice.paid')); ?>">Paid Invoices</a>-->
                             
                        <!--    </div>-->
                        <!--  </div><br><br><br>-->
                        
                        <table class="table table-striped"  id="invoices-table">
                            <thead>
                                <tr>
                                    <th style="width:4%">#</th>  
                                    <th style="width:13%">INV #</th>
                                    <th style="width:30%">Tenant</th>
                                    
                                    <th style="width:15%">Invoice Month</th>
                                    
                                    
                                    
                                    <th style="width:10%">Total Payable</th>                                    
                                    <th style="width:10%">Paid In</th>                                    
                                    <th style="width:10%">Balance</th>                                    
                                    <th style="width:5%">Status</th>  
                                    <th style="width:3%">Action</th>   
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
               
                    </div>
                </div>
            </div>

        </div>
    </div>
							
						<!-- /Row -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script>
    $(function () {
        $('#invoices-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 25,
            ajax: '<?php echo route('api.invoice.list'); ?>',
            "order": [[ 1, "desc" ]],
            columns: [ 
               { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false},     
                    { data: 'id', name: 'id' },
                    //  { data: 'house.house_no', name: 'house.house_no', orderable: false },
                     { data: 'tenant_name', name: 'tenant.full_name', searchable: true },
                    { data: 'rent_month', name: 'rent_month' },
                    //  { data: 'bills', name: 'bills' },
                    //  { data: 'carryforward', name: 'carryforward', orderable: false, searchable: false },                     
                     //{ data: 'penalty_fee', name: 'penalty_fee', orderable: false, searchable: false },
                     { data: 'total_payable', name: 'total_payable', orderable: false},
                     { data: 'paid_in', name: 'paid_in', orderable: false },
                     { data: 'balance', name: 'balance', orderable: false },
                     { data: 'is_paid', name: 'is_paid' },     
                      { data: 'action', name: 'action',searchable:false,orderable:false },             
                     //{ data: 'download', name: 'download', searchable: false , orderable: false },                  
                    //{ data: 'delete', name: 'delete', searchable: false , orderable: false },                  
                             ]
        });
         $(document).on('submit','.delete-overpayment',function(event){
            return confirm('Are you sure you want to delete this Invoice ? The action cannot be reversed');            
        });
        
    });


</script>
<!-- Data tables -->
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/jszip.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/datatables.js')); ?>"></script>
<!-- Select2 js -->
<script src="<?php echo e(URL::asset('assets/plugins/select2/select2.full.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/manualinvoices/list.blade.php ENDPATH**/ ?>