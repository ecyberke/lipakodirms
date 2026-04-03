<?php $__env->startPush('header_scripts'); ?>
<!-- DataTables -->
<link href="<?php echo e(asset('plugins/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('plugins/datatables/buttons.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo e(asset('plugins/datatables/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">

    

    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    
                    </p>

                    <table id="landlords-table" class="table table-striped custom-table mb-0"
                        >
                        <thead>
                            <tr>
                                
                               <th style="width:37%">Landlord Names</th>
                               <th>Phone</th>
                               <th>Email</th>
                              
                               <th>Owns</th>
                               
                               <th></th>
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
        $('#landlords-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?php echo route('api.landlord.list'); ?>',
            columns: [
                { data: 'full_name', name: 'full_name' },
                { data: 'id', name: 'id' },
                
                { data: 'email', name: 'email' },
                //{ data: 'phone_no', name: 'phone_no', orderable: false },
                { data: 'count', name: 'count', orderable: false },
                //{ data: 'view', name: 'view', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },

            ]
        });

         $(document).on('submit','.delete-landlord',function(event){
            return confirm('Are you sure you want to delete this landlord ? The action cannot be reversed ');            
        });
    });
</script>
<!-- Datatable init js -->

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rms\rms\resources\views/landlords/all.blade.php ENDPATH**/ ?>