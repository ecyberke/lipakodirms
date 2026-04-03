<div class="header ">
			
				<!-- Logo -->
                <div class="header-left">
                    <a href="<?php echo e(route('home')); ?>" class="logo">
						<img src="<?php echo e(asset('assets/img/lesa-white.png')); ?>" width="130" height="50" alt="">
					</a>
                </div>
				<!-- /Logo -->
				
				<!--<a id="toggle_btn" href="javascript:void(0);">-->
				<!--	<span class="bar-icon">-->
				<!--		<span></span>-->
				<!--		<span></span>-->
				<!--		<span></span>-->
				<!--	</span>-->
				<!--</a>-->
				
				<!-- Header Title -->
                <div class="page-title-box">
					<h3>Lesa International Agencies</h3>
                </div>
				<!-- /Header Title -->
				
				<a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
				
				<!-- Header Menu -->
				<ul class="nav user-menu">
				
					<?php if ($__env->exists('view.name', ['some' => 'data'])) echo $__env->make('view.name', ['some' => 'data'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				
				<li class="dropdown has-arrow main-drop">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<span class="user-img"><img src="<?php echo e(asset('assets/img/logo.jpg')); ?>" alt="">
							<span class="status online"></span></span>
							<span><?php echo e(Auth::user()->name); ?></span>
						</a>
						<div class="dropdown-menu">	
						<?php if(Auth::user()->is_admin  ): ?>
						<a class="dropdown-item" href="<?php echo e(route('admin.notification')); ?>">Notifications</a>
						<?php endif; ?>
							<a class="dropdown-item" href="<?php echo e(route('admin.changepassword')); ?>">Change Password</a>
							
							<a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                    <?php echo csrf_field(); ?>
                                </form>
						</div>
					</li>
				</ul>
				<!-- /Header Menu -->
				
				<!-- Mobile Menu -->
				<div class="dropdown mobile-user-menu">
					<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
					<div class="dropdown-menu dropdown-menu-right">						
						
						 <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                    <?php echo csrf_field(); ?>
                                </form>
					</div>
				</div>
				<!-- /Mobile Menu -->
				
            </div><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/includes/top_bar.blade.php ENDPATH**/ ?>