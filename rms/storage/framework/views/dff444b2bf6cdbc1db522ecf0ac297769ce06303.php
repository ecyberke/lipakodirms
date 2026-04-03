<?php $__env->startPush('header_scripts'); ?>
<!-- DataTables -->
<link href="<?php echo e(asset('plugins/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('plugins/datatables/buttons.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo e(asset('plugins/datatables/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            

        </div>
    </div>
    <!-- /Page Header -->


    <div class="row">
        
        <div class="col-md-12">
            <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table mb-0" id="invoices-table">
                            <thead>
                                <tr>
                                     <th style="width:5%">#</th> 
                                     <th style="width:15%">Owners</th> 
                                    <th style="width:20%">Property</th>
                                    <th style="width:15%">Bill Type</th>
                                    
                                    
                                    
                                    
                                    
                                    <th>Total Bill</th>      
                                    
                                    <th>Paid In</th>                                     
                                    <th>Balance</th>                                     
                                    <th style="width:20%">Date</th> 
                                    <th style="width:5%">Action</th>  
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

    <!-- /Page Content -->

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer_scripts'); ?>

<!-- Required datatable js -->
<script src="<?php echo e(asset('plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/dataTables.bootstrap4.min.js')); ?>"></script>

<!-- Responsive examples -->
<script src="<?php echo e(asset('plugins/datatables/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/responsive.bootstrap4.min.js')); ?>"></script>

<script>
    $(function () {
        $('#invoices-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?php echo route('api.payowners.list'); ?>',
            "order": [[ 7, "desc" ]],
            columns: [ 
               { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false},     
                    //  { data: 'id', name: 'id' },
                    { data: 'full_name', name: 'full_name',orderable: false },
                    { data: 'apartment', name: 'apartment', orderable: false },
                     
                    //{ data: 'rent_month', name: 'rent_month' },
                    //  { data: 'bills', name: 'bills' },
                    //  { data: 'carryforward', name: 'carryforward', orderable: false, searchable: false },                     
                     //{ data: 'penalty_fee', name: 'penalty_fee', orderable: false, searchable: false },
                     { data: 'type', name: 'type', orderable: false, searchable: false },
                     { data: 'total_owned', name: 'total_owned', orderable: false, searchable: false },
                    { data: 'paid_in', name: 'paid_in', orderable: false, searchable: false },
                    { data: 'balance', name: 'balance', orderable: false, searchable: false },
                    { data: 'created_at', name: 'created_at' },     
                     { data: 'action', name: 'action',searchable:false,orderable:false },             
                     //{ data: 'download', name: 'download', searchable: false , orderable: false },                  
                    //{ data: 'delete', name: 'delete', searchable: false , orderable: false },                  
                             ]
        });
         $(document).on('submit','.delete-house',function(event){
            return confirm('Are you sure you want to delete this Bill ? The action cannot be reversed');            
        });
        
        
    });


</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rms\rms\resources\views/payowners/list.blade.php ENDPATH**/ ?>