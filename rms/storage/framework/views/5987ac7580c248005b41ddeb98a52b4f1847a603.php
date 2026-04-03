

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

    

    
    <!-- /Search Filter -->

    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    </p>
                    <div class="dropdown">
                        <button onclick="myFunction()" class="dropbtn">Filter Houses</button>
                        <div id="myDropdown" class="dropdown-content">
                          <a href="<?php echo e(route('house.vacant')); ?>">Vacant</a>
                          <a href="<?php echo e(route('house.occupied')); ?>">Occupied</a>
                          <a href="<?php echo e(route('house.list')); ?>">All Houses</a>
                        </div>
                      </div><br><br><br>

                    <table id="unpaid-invoices-table" class="table table-striped custom-table mb-0"
                        >
                        <thead>
                            <tr>
                                     <th style="width:10%">#INV</th>
                                     <th>Tenant</th>
                                     <th>Property</th>
                                     <th>House</th>
                                    
                                     
                                    <th>Balance</th>                                    
                                    <th>Action</th>                                   
                                    
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
        $('#unpaid-invoices-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '<?php echo route('api.invoice.unpaid'); ?>',
            columns: [ 
               // { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false},     
                     { data: 'id', name: 'id' },
                     { data: 'tenant.full_name', name: 'tenant.full_name',orderable: false },
                     { data: 'apartment.name', name: 'apartment.name',orderable: false },
                     { data: 'house.house_no', name: 'house.house_no', orderable: false },
                     
                   // { data: 'rent_month', name: 'rent_month' },
                    //  { data: 'bills', name: 'bills' },
                    //  { data: 'carryforward', name: 'carryforward', orderable: false, searchable: false },                     
                     //{ data: 'penalty_fee', name: 'penalty_fee', orderable: false, searchable: false },
                     //{ data: 'total_payable', name: 'total_payable', orderable: false, searchable: false },
                     //{ data: 'paid_in', name: 'paid_in', orderable: false, searchable: false },
                     { data: 'balance', name: 'balance', orderable: false, searchable: false },
                    // { data: 'is_paid', name: 'is_paid'  },     
                      { data: 'action', name: 'action',searchable:false,orderable:false },             
                     //{ data: 'download', name: 'download', searchable: false , orderable: false },                  
                    //{ data: 'delete', name: 'delete', searchable: false , orderable: false },                  
                             ]
        });
         $(document).on('submit','.delete-overpayment',function(event){
            return confirm('Are you sure you want to delete this Invoice ? The action cannot be reversed');            
        });
        
    });


</script>
<script>
    $(function () {
         

        var oTable = $('').DataTable({
            processing: true,
            serverSide: true,
             "pageLength": 25,
            ajax: {
                method: 'GET',
                url: '<?php echo route('api.invoice.unpaid'); ?>',
                 data: function (d) {
                    d.token = $("input[name='_token']").val();
                    d.month = $("#month option:selected").val();
                    d.year = $("#year option:selected").val();                   
                }
            },
             columns: [            
                     { data: 'id', name: 'id' },
                     { data: 'tenant.full_name', name: 'tenant.full_name',orderable: false },
                    
                     { data: 'house_no', name: 'house_no', orderable: false },
                    //  { data: 'rent', name: 'rent' }, 
                    //  { data: 'bills', name: 'bills' },     
                    //  { data: 'total_payable', name: 'total_payable', orderable: false, searchable: false },              
                    //  { data: 'paid_in', name: 'paid_in', orderable: false, searchable: false },
                     { data: 'balance', name: 'balance', orderable: false, searchable: false },
                     { data: 'action', name: 'action',orderable: false, searchable: false  },                  
                             ]
        });

        $('#btn-search').on("click", function (event) {
                oTable.draw();
                event.preventDefault();
         });


    });
</script>
<!-- Datatable init js -->

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/houses/unpaid.blade.php ENDPATH**/ ?>