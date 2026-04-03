

<?php $__env->startPush('header_scripts'); ?>
<!-- DataTables -->
<link href="<?php echo e(asset('plugins/datatables/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('plugins/datatables/buttons.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo e(asset('plugins/datatables/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
.btn-group button {
  background-color: #ffffff; /* Green background */
  border: 2px solid #2196f3; /* Green border */
  color: grey; /* White text */
  padding: 10px 24px; /* Some padding */
  cursor: pointer; /* Pointer/hand icon */
  float: left; /* Float the buttons side by side */
}

/* Clear floats (clearfix hack) */
.btn-group:after {
  content: "";
  clear: both;
  display: table;
}

.btn-group button:not(:last-child) {
  border-right: none; /* Prevent double borders */
}

/* Add a background color on hover */
.btn-group button:hover {
  background-color: #2196f3;
  color: #ffffff;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content container-fluid">

    

    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    </p>
                    <div class="btn-group" style="width:40%">
                   <button  style="border-top-left-radius:10px; border-bottom-left-radius: 10px;"><a href="<?php echo e(route('house.list')); ?>">All</a></button>
                    <button ><a href="<?php echo e(route('house.occupied')); ?>">Occupied</a></button>
                    <button class="w3-button w3-blue" style="border-top-right-radius:10px; border-bottom-right-radius: 10px;"><a href="<?php echo e(route('house.vacant')); ?>">Vacant</a></button>
                    </div>
                    <br><br><br>

                    <table id="vacants-table" class="table table-striped custom-table mb-0"
                        >
                        <thead>
                              <tr>
                                     <th style="width:10%">#</th>
                                     <th style="width:15%">House No</th>                                    
                                    <th style="width:15%">Building</th>
                                    <th style="width:20%">Town</th>
                                    <th style="width:25%">Location</th>                                    
                                    <th style="width:15%">Action</th>                                    
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
        $('#vacants-table').DataTable({
            
            processing: true,
            serverSide: true,
             "pageLength": 25,
            ajax: '<?php echo route('api.house.vacant'); ?>',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false},
                { data: 'house_no', name: 'houses.house_no' },                
                { data: 'apartment.name', name: 'apartment.name' },
                { data: 'apartment.town', name: 'apartment.town' },
                { data: 'apartment.location', name: 'apartment.location' ,orderable: false},                
                { data: 'action', name: 'action',orderable: false , searchable:false},  
                     
 ]
        });
    });
</script>
<!-- Datatable init js -->

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/houses/vacant.blade.php ENDPATH**/ ?>