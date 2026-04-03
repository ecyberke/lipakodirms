
<?php $__env->startSection('content'); ?>
<div class="content container-fluid">



  <!-- BEGIN: Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Frest admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Frest admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    
    <link rel="apple-touch-icon" href="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/css/components.min.css">
    <link rel="stylesheet" type="text/css" href="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/css/themes/dark-layout.min.css">
    <link rel="stylesheet" type="text/css" href="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/css/themes/semi-dark-layout.min.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/css/core/menu/menu-types/vertical-menu.min.css">
    <link rel="stylesheet" type="text/css" href="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/css/pages/app-file-manager.min.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/assets/css/style.css">
    <!-- END: Custom CSS-->

  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  
 <!-- BEGIN: Content-->
 
    <div class="content-area-wrapper">
      <div class="sidebar-left">
    <div class="app-file-sidebar sidebar-content d-flex">
<!-- App File sidebar - Left section Starts -->
<div class="app-file-sidebar-left">
  <!-- sidebar close icon starts -->
  
  <!-- sidebar close icon ends -->
  <div class="form-group add-new-file text-center">
    <!-- Add File Button -->
    <label for="getFile" class="btn btn-primary btn-block glow my-2 add-file-btn text-capitalize"></i></label>
    <input type="file" class="d-none" id="getFile">
  </div><br><br><br><br><br>
  <div class="app-file-sidebar-content">
    <!-- App File Left Sidebar - Drive Content Starts -->
    
    <div class="list-group list-group-messages ">
        <a href="<?php echo e(route('filemanager.index')); ?>"  class="list-group-item list-group-item-action " >
            All Files </a>
        
      
      <a href="<?php echo e(route('filemanager.recent')); ?>"  
      class="list-group-item list-group-item-action">
        
        Recent Files
      </a>
     
      <a href="<?php echo e(route('filemanager.images')); ?>"  class="list-group-item list-group-item-action" style="color: rgb(1, 111, 255);">
        
        Images
      </a>
      <a href="<?php echo e(route('filemanager.contract')); ?>" class="list-group-item list-group-item-action">
       
        Contracts
      </a>
    </div>
    <!-- App File Left Sidebar - Drive Content Ends -->

  
   
    <!-- App File Left Sidebar - Storage Content Ends -->
  </div>
</div>



        </div>
      </div><br><br><br><br>
      <div >
          <form action="" method="post">
            <?php echo csrf_field(); ?>
            
            
            <div class="row">
                <?php echo e(csrf_field()); ?>

    
                <div class="col-8">
                    <div class="">
                        <div class="card-body">
                          
                            <p class="section-title">House Images</p><hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="display: flex; overflow: auto;">
                                        <?php if(count($house_imgs) > 0): ?> 
                                        <?php $__currentLoopData = $house_imgs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $number): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                        <?php $__currentLoopData = $number['filename']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                        <div class="card m-2" style="max-width:13em; min-width:12em;">
                                            <div class="card-img-top" style="height:150px;background-image: url('<?=asset('rms/storage/app/filemanager/'.$num)?>');background-size: cover;background-position: center;">
                                            </div>
                                            
                                            <div class="card-body">
                                              <h5 class="card-title"><?php echo e($number['details']['house_no']); ?></h5>
                                              <h5 class="card-title"><?php echo e($number['details']['house_type']); ?></h5>
                                              <h5 class="card-title"><?php echo e($number['details']['house_description']); ?></h5>
                                              <form method="POST" action="<?php echo e(url('filemanager/delete/'.$number['id'].'/'.$num)); ?>">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                <a target="_blank" href="<?php echo e(asset('rms/storage/app/filemanager/'.$num)); ?>" class="btn btn-primary btn-sm">View</a>
                                            </form>
                                            </div>
                                          </div>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                          <?php else: ?>
                                          <div class="text-center">
                        <i>No files found</i>
                                          </div>
                                          <?php endif; ?>
                                    </div></div>
                            </div>
                           
                            
                        
                        </div>
    
                            
                        </div>
                    </div>
                </div>            
            </div>
        </form>
       
        
        </div>
    
    
        <!-- /Content End -->
    
    </div>
      

    

 
    
  </div>
  <!-- App File - Files Section Ends -->
</div>
</div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END: Content-->


    
  

  

    <!-- BEGIN: Vendor JS-->
    <script src="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/vendors/js/vendors.min.js"></script>
    <script src="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.min.js"></script>
    <script src="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.min.js"></script>
    <script src="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/js/scripts/configs/vertical-menu-dark.min.js"></script>
    <script src="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/js/core/app-menu.min.js"></script>
    <script src="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/js/core/app.min.js"></script>
    <script src="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/js/scripts/components.min.js"></script>
    <script src="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/js/scripts/footer.min.js"></script>
    <script src="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/js/scripts/customizer.min.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="https://www.pixinvent.com/demo/frest-clean-bootstrap-admin-dashboard-template/app-assets/js/scripts/pages/app-file-manager.min.js"></script>
    <!-- END: Page JS-->

  </body>
  <!-- END: Body-->
</div>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/filemanager/images.blade.php ENDPATH**/ ?>