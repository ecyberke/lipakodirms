<?php $__env->startPush('header_scripts'); ?>
<!-- DataTables -->
<link href="<?php echo e(asset('plugins/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('plugins/datatables/buttons.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo e(asset('plugins/datatables/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">

    

    <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    
                    


                    <script type="text/javascript">
                        jQuery( document ).ready( function( $ ) {
                            var $servicerequest-table = jQuery( "#servicerequest-table" );
                
                            $servicerequest-table.DataTable( {
                                dom: 'Bfrtip',
                                buttons: [
                                    'copyHtml5',
                                    'excelHtml5',
                                    'csvHtml5',
                                    'pdfHtml5'
                                ]
                            } );
                        } );
                    </script>
                    <table id="servicerequest-table" class="table table-striped custom-table mb-0">
                        
                        <thead>
                           
                              <tr>
                                     <th style="width:10%">#</th>
                                     <th>Tenant Name</th>
                                    <th>Property</th>
                                    <th style="width:10%">House No</th>
                                    <th>Status</th> 
                                    
                                    <th>Date of request</th>  
                                                                      
                                    <th class="text-right">Action</th>                                    
                                </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    
                    </table>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

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
        $('#servicerequest-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?php echo route('api.service.request'); ?>',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'full_name', name: 'full_name' },
                { data: 'name', name: 'name' },
                { data: 'house_no', name: 'house_no' },
                { data: 'status', name: 'status' }, 
              // { data: 'service_request', name: 'service_request' },                              
                { data: 'created_at', name: 'created_at' },  
                         
                { data: 'action', name: 'action',searchable:false,orderable:false },           
                    ]
        });
      

       
        $(document).on('submit','.delete-house',function(event){
            return confirm('Are you sure you want to delete this house ? The action cannot be reversed');            
        });
       
    });
</script>

<!-- Datatable init js -->

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rms\rms\resources\views/servicerequests/index.blade.php ENDPATH**/ ?>