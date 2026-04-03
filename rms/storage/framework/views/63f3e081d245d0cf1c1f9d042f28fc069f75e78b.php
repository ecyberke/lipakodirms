
<?php $__env->startSection('css'); ?>
<!-- Data table css -->
<link href="<?php echo e(URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')); ?>"  rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" />
<!-- Slect2 css -->
<link href="<?php echo e(URL::asset('assets/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
<style>
    /* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #bfd7ff;
}

/* Style the buttons that are used to open the tab content */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 1px 1px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-header'); ?>
						<!--Page header-->
						<div class="page-header">
						
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
									<!--<li class="breadcrumb-item"><a href="#">Forms</a></li>-->
									<li class="breadcrumb-item active" aria-current="page">Houses</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
						<!-- Row -->
				<div class="row">
        
        <div class="col-md-12">
            <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="card">
                <div class="card-body">
                 <div class="tab">
                  <button class="tablinks" onclick="openCity(event, 'List')">Rent Collection Bills</button>
                  <button class="tablinks" onclick="openCity(event, 'OtherBills')">Other Bills</button>
                  <!--<button class="tablinks" onclick="openCity(event, 'Vacant')">Vacant Houses</button>-->
                 
                </div>
                
                <!-- Tab content -->
                 
                <div id="List" class="tabcontent">
                    
                  <table class="table table-striped"  id="invoices-table" style="width:100%">
                            <thead>
                               <tr>
                                     <th style="width:5%">#</th> 
                                     <th style="width:25%">Owners</th> 
                                    <th>Property</th>
                                    
                                    
                                    <th style="width:15%">Bill Month</th>
                                    
                                    
                                    
                                    <th>Total Bill</th> 
                                    <th>Total Expenses</th>     
                                    
                                    <th>Total Paid</th>                                     
                                    <th>To Pay</th>                                     
                                   
                                    
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        
                </div>
                <div id="OtherBills" class="tabcontent">
                    <div class="table-responsive">
                  <table class="table table-striped"  id="bill-table" style="width:100%">
                            <thead>
                                 <tr>
                                     <th style="width:5%">#</th> 
                                     <th style="width:15%">Owners</th> 
                                    <th style="width:20%">Property</th>
                                    <th style="width:15%">Bill Type</th>
                                    <th>Approval</th>
                                    
                                    <!--<th>Monthly Bills</th>-->
                                    
                                    
                                    <th>Total Bill</th>      
                                    
                                    <th>Paid In</th>                                     
                                    <th>Balance</th>                                     
                                    <th style="width:20%">Date</th> 
                                    <th style="width:5%">Action</th>  
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        </div>
                        </div>
                <!--<div id="Vacant" class="tabcontent">-->
                <!--    <div class="table-responsive">-->
                <!--  <table class="table table-striped"  id="vacants-table" style="width:100%">-->
                <!--            <thead>-->
                <!--                <tr>-->
                <!--                     <th style="width:10%">#</th>-->
                <!--                     <th style="width:15%">House No</th>                                    -->
                <!--                    <th style="width:15%">Building</th>-->
                <!--                    <th style="width:20%">Town</th>-->
                <!--                    <th style="width:25%">Location</th>                                    -->
                <!--                    <th style="width:15%">Action</th>                                    -->
                <!--                </tr>-->
                <!--            </thead>-->
                <!--            <tbody>-->

                <!--            </tbody>-->
                <!--        </table>-->
                <!--</div>-->
                <!--</div>-->
               
               
                    </div>
                </div>
            </div>

        </div>
    </div>
							
						<!-- /Row -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
<script>
    $(function () {
        $('#invoices-table').DataTable({
            processing: true,
            serverSide: true,
             "pageLength": 25,
            ajax: '<?php echo route('api.payowners.totals'); ?>',
            
         
            columns: [ 
               { data: 'DT_RowIndex', name: 'DT_RowIndex',  searchable:false},     
                    //  { data: 'id', name: 'id' },
                    { data: 'full_name', name: 'full_name', orderable: false},
                    { data: 'apartment', name: 'apartment', orderable: false},
                    
                     
                  { data: 'rent_month', name: 'rent_month'},
                // { data: 'bill', name: 'bill' },
                    //  { data: 'carryforward', name: 'carryforward', orderable: false, searchable: false },                     
                     //{ data: 'penalty_fee', name: 'penalty_fee', orderable: false, searchable: false },
                    // { data: 'type', name: 'type', orderable: false, searchable: false },
                     { data: 'sum_bills', name: 'sum_bills', orderable: false, searchable: false },
                     { data: 'bill', name: 'bill', orderable: false, searchable: false },
                    { data: 'pay', name: 'pay', orderable: false, searchable: false },
                    { data: 'bal', name: 'bal', orderable: false, searchable: false },
                    // { data: 'created_at', name: 'created_at' },     
                    //  { data: 'action', name: 'action',searchable:false,orderable:false },             
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
        $('#bill-table').DataTable({
            processing: true,
            serverSide: true,
             "pageLength": 25,
            ajax: '<?php echo route('api.payowners.list'); ?>',
            "order": [[ 8, "desc" ]],
            columns: [ 
               { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false},     
                    //  { data: 'id', name: 'id' },
                    { data: 'full_name', name: 'full_name',orderable: false },
                    { data: 'apartment', name: 'apartment', orderable: false },
                     
                    //{ data: 'rent_month', name: 'rent_month' },
                    //  { data: 'bills', name: 'bills' },
                    //  { data: 'carryforward', name: 'carryforward', orderable: false, searchable: false },                     
                     //{ data: 'penalty_fee', name: 'penalty_fee', orderable: false, searchable: false },
                     { data: 'type', name: 'type', orderable: false, searchable: false },
                      { data: 'approval', name: 'approval', orderable: false, searchable: false },
                     { data: 'total_owned', name: 'total_owned', orderable: false, searchable: false },
                    { data: 'paid_in', name: 'paid_in', orderable: false, searchable: false },
                    { data: 'balance', name: 'balance', orderable: false, searchable: false },
                    { data: 'created_at', name: 'created_at' },     
                     { data: 'action', name: 'action',searchable:false,orderable:false },             
                     //{ data: 'download', name: 'download', searchable: false , orderable: false },                  
                    //{ data: 'delete', name: 'delete', searchable: false , orderable: false },                  
                             ]
        });
         $(document).on('submit','.delete-house',function(event){
            return confirm('Are you sure you want to delete this Bill ? The action cannot be reversed');            
        });
        
        
    });


</script>


<script>
    function openCity(evt, cityName) {
  // Declare all variables
  var i, tabcontent, tablinks;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
<!-- Data tables -->

<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/jszip.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/vfs_fonts.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.print.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/js/datatables.js')); ?>"></script>
<!-- Select2 js -->
<script src="<?php echo e(URL::asset('assets/plugins/select2/select2.full.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>







<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/lesaagen/rmslesa/rms/resources/views/payowners/list.blade.php ENDPATH**/ ?>