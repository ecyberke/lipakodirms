

<?php $__env->startSection('content'); ?>

<!-- Page Content -->
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-9">
                
                
            </div>
            <div>
                <a href="<?php echo e(route('admin.create')); ?>" class="btn btn-success">
                    Add User</a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->


<div class="card" style="padding-top:25px; padding-bottom:25px; padding-left:25px; padding-right:25px;">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">

                <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <table class="table table-striped " >
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>User-Name</th>
                            <th>Role</th>
                            
                            <th style="width: 10%;">Password</th>
                            <th style="width: 10%;">Action</th>
                           
                        </tr>
                    </thead>
                    <tbody>

                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <?php echo e($user->name); ?>

                            </td>
                            <td><?php echo e($user->username); ?></td>
                            <td>
                                <?php if($user->is_admin===1): ?>
                                <span class="badge bg-inverse-primary">Office Manager</span>
                                <?php elseif($user->is_admin===2): ?>
                                <span class="badge bg-inverse-danger">Administrator</span>
                                <?php else: ?>
                                <span class="badge bg-inverse-success">Agent</span>
                                <?php endif; ?>
                            </td>
                            <!--<td>-->

                            <!--    <form action="<?php echo e(route('admin.toggleRole',$user->id)); ?>" method="post">-->
                            <!--        <?php echo csrf_field(); ?>-->
                            <!--        <?php if($user->is_admin===1): ?>-->
                            <!--        <input type="submit" class="btn btn-success btn-sm " value="Make Agent">-->
                            <!--        <?php elseif($user->is_super===1 && $user->is_admin===1 ): ?>-->
                            <!--        <input type="submit" class="btn btn-secondary btn-sm" value="Make Office Manager">-->
                            <!--        <?php else: ?>-->
                            <!--        <input type="submit" class="btn btn-danger btn-sm" value="Make Administrator">-->
                            <!--        <?php endif; ?>-->
                            <!--    </form>-->



                            <!--</td>-->
                            <td>

                                 <div class="dropdown-item ">
                                                <a class="btn btn-sm btn-success btn-block" href="<?php echo e(route('admin.editpassword', $user->id)); ?>"> Edit</a>
                                            </div>



                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-item ">
                                                <a class="btn btn-sm btn-info btn-block" href="<?php echo e(route('admin.edit', $user->id)); ?>"> Edit</a>
                                            </div>
                                            
                                            <div class="dropdown-item ">
                                                <form action="<?php echo e(route('admin.delete',$user->id)); ?>" method="post" class="delete-form">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                
                                                    <input type="submit" class="btn btn-danger btn-sm btn-block" value="Delete">
                                                </form>
                                                
                                            </div>
        
                                           
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                        <?php endif; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</div>
<!-- /Page Content -->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('footer_scripts'); ?>
<script>
   $(document).on('submit','.delete-form',function(event){
           return confirm(" Are you sure you want to delete this admin ? ");
   });

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/bedahgra/public_html/rms/work/rms/resources/views/authorization/listadmins.blade.php ENDPATH**/ ?>