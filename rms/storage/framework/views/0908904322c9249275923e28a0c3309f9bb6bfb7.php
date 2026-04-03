

<?php $__env->startSection('content'); ?>
<div class="account-content">
    <div class="container">
        <!-- Account Logo -->
        <div class="account-logo">
            <a href=""><img src="" alt="Your Logo Here"></a>
        </div>
        <!-- /Account Logo -->

        <div class="account-box">
            <div class="account-wrapper">
                <h3 class="account-title">Tenant Login</h3>
                <p class="account-subtitle">Sorry can not login as a tenant</p>

                <!-- Account Form -->
                
                        <p>Please login back as agency user: <a href="/index.php/login">User login</a></p>
                    </div>
                </form>
                <!-- /Account Form -->

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lesaprop/rmsprop/rms/resources/views/auth/tenantLogin.blade.php ENDPATH**/ ?>