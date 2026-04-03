
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
									<li class="breadcrumb-item active" aria-current="page">All Houses</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
						<!-- Row -->
						<div class="row">
							<div class="col-12">
								
					

								
								<!--div-->
								<div class="card">
									
									<div class="card-body">
										<div class="">
											<div class="table-responsive">
												 <table id="houses-table" id="example"  class="table table-striped custom-table mb-0 text-nowrap key-buttons"
                        >
                        
                        <thead>
                           
                              <tr>
                                     <th style="width:5%">#</th>
                                      <th style="width:15%">House</th>
                                     <th style="width:20%">Property</th>
                                     <th style="width:20%">Town</th>                                                                      
                                    <th style="width:25%">Owner</th> 
                                    <th style="width:10%">Rent</th>
                                   
                                    
                                    
                                    <th>Status</th>                                   
                                    <th class="text-right">Action</th>                                    
                                </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    
                    </table>
											</div>
										</div>
									</div>
								</div>
								<!--/div-->

								
										</div>
									</div>
							
						<!-- /Row -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script>
    $(function () {
        $('#houses-table').DataTable({
            processing: true,
            serverSide: true,
             "pageLength": 25,
            ajax: '<?php echo route('api.house.list'); ?>',
            
            columns: [
                { data: 'id', name: 'houses.id' },
                { data: 'house_no', name: 'houses.house_no' },
                { data: 'apartment.name', name: 'apartment.name' },
                { data: 'apartment.town', name: 'apartment.town' },                              
                { data: 'owner', name: 'owner' }, 
                { data: 'rent', name: 'rent' ,searchable:false,orderable:false},
                
                
                  
                { data: 'is_occupied', name: 'is_occupied' },         
                { data: 'action', name: 'action',searchable:false,orderable:false },           
                    ]
        });
      

       
        $(document).on('submit','.delete-house',function(event){
            return confirm('Are you sure you want to delete this house ? The action cannot be reversed');            
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




<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/bedahgra/public_html/rms/work/rms/resources/views/houses/list.blade.php ENDPATH**/ ?>