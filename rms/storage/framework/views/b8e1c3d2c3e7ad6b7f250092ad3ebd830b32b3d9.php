
<?php $__env->startSection('css'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
		<div class="page">
			<div class="page-single">
				<div class="p-5">
					<div class="row">
						<div class="col mx-auto">
							<div class="row justify-content-center">
								<div class="col-lg-9 col-xl-8">
									<div class="card-group mb-0">
										<div class="card p-4 page-content">
											<div class="card-body page-single-content">
												<div class="w-100">
												<div class="">
													<h1 class="mb-2">Request Demo</h1>
													<p class="text-muted">Fill in the phone and we'll be in touch</p>
												</div>
												<?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
												<!--<div class="btn-list d-sm-flex">-->
												<!--	<a href="https://www.google.com/gmail/" class="btn btn-google btn-block">Google</a>-->
												<!--	<a href="https://twitter.com/" class="btn btn-twitter d-block d-sm-inline mr-0 mr-sm-2">Twitter</a>-->
												<!--	<a href="https://www.facebook.com/" class="btn btn-facebook d-block d-sm-inline">Facebook</a>-->
												<!--</div>-->
												<!--<hr class="divider my-6">-->
										<form method="POST" action="<?php echo e(route('demo.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="form-group" >
                       <div class="input-group mb-4">
                           
                      
	
                        <input id="name" style="width:80%" type="text" placeholder="Enter Your Name" class="form-control <?php if ($errors->has('name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('name'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"
                            name="name" value="<?php echo e(old('name')); ?>" required autocomplete="name" autofocus>

                        <?php if ($errors->has('name')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('name'); ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                        </span>
                        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                    </div>
                    </div>
                    <div class="form-group" >
                       <div class="input-group mb-4">
                        
	
                        <input id="email" style="width:80%" type="email" placeholder="Enter Your Email" class="form-control <?php if ($errors->has('username')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('username'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"
                            name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>

                        <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                        </span>
                        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                    </div>
                    </div>
                    <div class="form-group" >
                       <div class="input-group mb-4">
                       
	
                        <input id="phone" style="width:80%" type="text" placeholder="Enter Your Phone Number" class="form-control <?php if ($errors->has('phone')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('phone'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>"
                            name="phone" value="<?php echo e(old('phone')); ?>" required autocomplete="phone" autofocus>

                        <?php if ($errors->has('phone')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('phone'); ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                        </span>
                        <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                    </div>
                    </div>
                    <div class="form-group text-center">
                        <button class="btn btn-primary account-btn" style="width:100%" type="submit"><font color="white">Request Demo</font></button>
                    </div>
                 
                    <div class="account-footer">
                        <p>Home? <a href="/">Click Here</a></p>
                    </div>
                </form>
											
												
											</div>
											</div>
										</div>
										<div class="card text-white bg-primary py-5 d-md-down-none page-content mt-0">
											<div class="card-body text-center justify-content-center page-single-content">
												<img src="<?php echo e(URL::asset('assets/images/pattern/login.png')); ?>" alt="img">
											</div>
										</div>
									</div>
									<!--<div class="text-center pt-4">-->
									<!--	<div class="font-weight-normal fs-16">You Don't have an account <a class="btn-link font-weight-normal" href="#">Register Here</a></div>-->
									<!--</div>-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.master2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lipakodi/domains/lipakodi.co.ke/public_html/v1/rms/resources/views/demo_request/register.blade.php ENDPATH**/ ?>