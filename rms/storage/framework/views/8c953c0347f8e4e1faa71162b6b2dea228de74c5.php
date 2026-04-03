<?php $__env->startPush('header_scripts'); ?>
<!-- DataTables -->
<link href="<?php echo e(asset('plugins/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('plugins/datatables/buttons.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo e(asset('plugins/datatables/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    .dropbtn {
      background-color: #3498DB;
      color: white;
      padding: 5px;
      font-size: 13px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
    }
    
    .dropbtn:hover, .dropbtn:focus {
      background-color: #2980B9;
    }
    
    .dropdown {
      position: relative;
      display: inline-block;
    }
    
    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 160px;
      overflow: auto;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }
    
    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }
    
    .dropdown a:hover {background-color: #ddd;}
    
    .show {display: block;}
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">

    

    <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    <div class="dropdown">
                        <button onclick="myFunction()" class="dropbtn">Filter Houses</button>
                        <div id="myDropdown" class="dropdown-content">
                          <a href="<?php echo e(route('house.vacant')); ?>">Vacant</a>
                          <a href="<?php echo e(route('house.occupied')); ?>">Occupied</a>
                          <a href="<?php echo e(route('house.unpaid')); ?>">Unpaid</a>
                        </div>
                      </div><br><br><br>
                    
                    
                    
                    

                    <table id="houses-table" class="table table-striped custom-table mb-0"
                        >
                        
                        <thead>
                           
                              <tr>
                                     <th style="width:5%">#</th>
                                     <th style="width:20%">Property</th>
                                    <th style="width:10%">Rent</th>
                                    <th style="width:15%">House No</th>
                                    
                                    <th style="width:20%">Town</th>                                                                      
                                    <th style="width:25%">Owner</th> 
                                    <th>Status</th>                                   
                                    <th class="text-right">Action</th>                                    
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
<script>
    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction() {
      document.getElementById("myDropdown").classList.toggle("show");
    }
    
    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }
    </script>
<!-- Responsive examples -->
<script src="<?php echo e(asset('plugins/datatables/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatables/responsive.bootstrap4.min.js')); ?>"></script>
<script>
    $(function () {
        $('#houses-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?php echo route('api.house.list'); ?>',
            
            columns: [
                { data: 'id', name: 'houses.id' },
                { data: 'apartment.name', name: 'apartment.name' },
                { data: 'rent', name: 'rent' ,searchable:false,orderable:false},
                { data: 'house_no', name: 'houses.house_no' },
                
                { data: 'apartment.town', name: 'apartment.town' },                              
                { data: 'owner', name: 'owner' },   
                { data: 'is_occupied', name: 'is_occupied' },         
                { data: 'action', name: 'action',searchable:false,orderable:false },           
                    ]
        });
      

       
        $(document).on('submit','.delete-house',function(event){
            return confirm('Are you sure you want to delete this house ? The action cannot be reversed');            
        });
       
    });
</script>

<!-- Datatable init js -->

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rms\rms\resources\views/houses/list.blade.php ENDPATH**/ ?>