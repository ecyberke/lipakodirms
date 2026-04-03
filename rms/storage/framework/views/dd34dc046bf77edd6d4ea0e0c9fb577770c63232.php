<?php $__env->startSection('content'); ?>
<div class="account-content">
    <div class="container">
        <!-- Account Logo -->
        <div class="account-logo">
            <a href=""><img src="<?php echo e(asset('assets/img/lesa.png')); ?>" width="390" height="50" alt="LIA Properties"></a>
        </div>
        <!-- /Account Logo -->

        <div class="account-box">
            <div class="account-wrapper">
                <h3 class="account-title">RMS Login</h3><br>
                

                <!-- Account Form -->
                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="form-group" >
                        <label for="username">Username</label>
                        <input id="username" style="width:100%" type="text" class="form-control <?php if ($errors->has('username')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('username'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"
                            name="username" value="<?php echo e(old('username')); ?>" required autocomplete="username" autofocus>

                        <?php if ($errors->has('username')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('username'); ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                        </span>
                        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col" >
                                <label for="password">Password</label>
                            </div>
                            

                            
                        </div>
                        <input id="password" type="password" style="width:100%"
                            class="form-control <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="password" required
                            autocomplete="current-password">

                        <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                        </span>
                        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary account-btn" style="width:100%" type="submit"><font color="white">Login</font></button>
                    </div>
                    <div class="col-auto">                                
                                <?php if(Route::has('password.request')): ?>
                                    <a class="text-primary" href="<?php echo e(route('password.request')); ?>">
                                        Forgot password ?
                                    </a>
                                <?php endif; ?>
                            </div>
                    
                </form>
                <!-- /Account Form -->

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rms\rms\resources\views/auth/login.blade.php ENDPATH**/ ?>