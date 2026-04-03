<option selected disabled>-------Select-------</option>
<?php $__empty_1 = true; $__currentLoopData = $houses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

<option value="<?php echo e($item->id); ?>"><?php echo e($item->house_no); ?> - <?php echo e($item->house_type); ?> </option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

<?php endif; ?>


<?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/partials/houses.blade.php ENDPATH**/ ?>