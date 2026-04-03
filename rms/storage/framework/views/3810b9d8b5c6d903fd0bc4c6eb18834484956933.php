
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
                <div class="card-header">System Logs</p>
                </div>
                
                <div class="card-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">User</th>
                        <th scope="col">Operation</th>
                        <th scope="col">More Info</th>
                        <th scope="col">Date/Time</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$house): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <th scope="row"><?php echo e($key+=1); ?></th>
                      <td><?php echo e(Auth::user()->name); ?></td>
                      <td><?php echo e($house->operation); ?></td>
                      <td><?php echo e($house->more_info); ?></td>
                      <td><?php echo e($house->created_at); ?></td>
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
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/bedahgra/public_html/lesa-demo/rms/resources/views/logs/index.blade.php ENDPATH**/ ?>