
<style>
    
.section-title {
    font-family: Rubik, Helvetica, Arial, serif;
    letter-spacing: 1px;
    margin: 1.2rem 0 .5rem;
    color: #BAC0C7;
    font-size: 1.8rem;
    font-weight: 500;
}

</style>
<link href="<?php echo e(asset('assets/fontawesom-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">
<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
    <div class="row">
        
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-header">Deleted Houses</p>
                </div>
                
                <div class="card-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">House Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Description</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $houses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$house): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <th scope="row"><?php echo e($key+=1); ?></th>
                      <td><?php echo e($house->house_no); ?></td>
                      <td><?php echo e($house->house_type); ?></td>
                      <td><?php echo e($house->description); ?></td>
                      <td><?php echo e($house->deleted_at); ?></td>
                        <td class="text-center">
                            <form method="POST" action="<?php echo e(url('softdeletes/restore/'.$house->id.'/House')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                            <form method="POST" action="<?php echo e(url('softdeletes/delete/'.$house->id.'/House')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                            </form>
                            
                        </td>
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
            
            
                </div>
            
                </div>
            
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-header">Deleted Invoices</p>
                </div>
                
                <div class="card-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Invoice Number</th>
                        <th scope="col">Type</th>
                        <th scope="col">Amount Payable</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$house): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <th scope="row"><?php echo e($key+=1); ?></th>
                      <td>INV00<?php echo e($house->id); ?></td>
                      <td><?php echo e($house->type); ?></td>
                      <td><?php echo e($house->total_payable); ?></td>
                      <td><?php echo e($house->deleted_at); ?></td>
                        <td class="text-center">
                            <form method="POST" action="<?php echo e(url('softdeletes/restore/'.$house->id.'/Invoice')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                            <form method="POST" action="<?php echo e(url('softdeletes/delete/'.$house->id.'/Invoice')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                            </form>
                            
                        </td>
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
            
            
                </div>
            
                </div>
            
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-header">Deleted Landlords</p>
                </div>
                
                <div class="card-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">telephone</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $landlords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$house): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <th scope="row"><?php echo e($key+=1); ?></th>
                      <td><?php echo e($house->full_name); ?></td>
                      <td><?php echo e($house->id); ?></td>
                      <td><?php echo e($house->deleted_at); ?></td>
                        <td class="text-center">
                            <form method="POST" action="<?php echo e(url('softdeletes/restore/'.$house->id.'/Landlord')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                            <form method="POST" action="<?php echo e(url('softdeletes/delete/'.$house->id.'/Landlord')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                            </form>
                            
                        </td>
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
            
            
                </div>
            
                </div>
            
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-header">Deleted Apartments</p>
                </div>
                
                <div class="card-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Location</th>
                        <th scope="col">Landlord Phone</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $apartments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$house): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <th scope="row"><?php echo e($key+=1); ?></th>
                      <td><?php echo e($house->name); ?></td>
                      <td><?php echo e($house->type); ?></td>
                      <td><?php echo e($house->location); ?></td>
                      <td><?php echo e($house->landlord_id); ?></td>
                      <td><?php echo e($house->deleted_at); ?></td>
                        <td class="text-center">
                            <form method="POST" action="<?php echo e(url('softdeletes/restore/'.$house->id.'/Apartment')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                            <form method="POST" action="<?php echo e(url('softdeletes/delete/'.$house->id.'/Apartment')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                            </form>
                            
                        </td>
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
            
            
                </div>
            
                </div>
            
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-header">Deleted Tenants</p>
                </div>
                
                <div class="card-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Telephone</th>
                        <th scope="col">Account Number</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $tenants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$house): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <th scope="row"><?php echo e($key+=1); ?></th>
                      <td><?php echo e($house->full_name); ?></td>
                      <td><?php echo e($house->id); ?></td>
                      <td><?php echo e($house->account_number); ?></td>
                      <td><?php echo e($house->deleted_at); ?></td>
                        <td class="text-center">
                            <form method="POST" action="<?php echo e(url('softdeletes/restore/'.$house->id.'/Tenant')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                            <form method="POST" action="<?php echo e(url('softdeletes/delete/'.$house->id.'/Tenant')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                            </form>
                            
                        </td>
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
            
            
                </div>
            
                </div>
            
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-header">Deleted Users</p>
                </div>
                
                <div class="card-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$house): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <th scope="row"><?php echo e($key+=1); ?></th>
                      <td><?php echo e($house->name); ?></td>
                      <td><?php echo e($house->email); ?></td>
                      <td><?php echo e($house->deleted_at); ?></td>
                        <td class="text-center">
                            <form method="POST" action="<?php echo e(url('softdeletes/restore/'.$house->id.'/User')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                            <form method="POST" action="<?php echo e(url('softdeletes/delete/'.$house->id.'/User')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                            </form>
                            
                        </td>
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
            
            
                </div>
            
                </div>
            
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-header">Deleted Bills</p>
                </div>
                
                <div class="card-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Type</th>
                        <th scope="col">Description</th>
                        <th scope="col">Total Owned</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $bills; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$house): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <th scope="row"><?php echo e($key+=1); ?></th>
                      <td><?php echo e($house->type); ?></td>
                      <td><?php echo e($house->description); ?></td>
                      <td><?php echo e($house->total_owned); ?></td>
                      <td><?php echo e($house->deleted_at); ?></td>
                        <td class="text-center">
                            <form method="POST" action="<?php echo e(url('softdeletes/restore/'.$house->id.'/PayOwners')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                            <form method="POST" action="<?php echo e(url('softdeletes/delete/'.$house->id.'/PayOwners')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                            </form>
                            
                        </td>
                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
            
            
                </div>
            
                </div>
            
        </div>
    </div>
	

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/bedahgra/public_html/rms/work/rms/resources/views/softdeletes/index.blade.php ENDPATH**/ ?>