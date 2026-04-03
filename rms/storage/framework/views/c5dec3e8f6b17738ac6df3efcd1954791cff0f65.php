<link href="<?php echo e(asset('assets/fontawesom-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">
<?php $__env->startSection('content'); ?>
<div class="content container-fluid">
	
	<div class="row">
		<div class="col-xxl-3 col-lg-3">
			<div class="card bg-primary text-white mb-4">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75">Registered Tenants</div>
							<div class="text-lg font-weight-bold"><?php echo e($tenants); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="calendar"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color: #4e73df;">
					<a class="small text-white stretched-link" href="<?php echo e(route('tenant.all')); ?>" >List Tenants</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-3">
			<div class="card bg-warning text-white mb-4">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">Registered Owners</div>
							<div class="text-lg font-weight-bold"><?php echo e($landlords); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="dollar-sign"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color: #f6c23e;">
					<a class="small text-white stretched-link" href="<?php echo e(route('landlord.index')); ?>">List Property Owners</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-3">
			<div class="card bg-secondary text-white mb-4">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">Managed Properties</div>
							<div class="text-lg font-weight-bold"><?php echo e($apartments); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="check-square"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color: #858796;">
					<a class="small text-white stretched-link" href="<?php echo e(route('apartment.list')); ?>">List Properties</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-3">
			<div class="card bg-info text-white mb-4">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">Registered Houses </div>
							<div class="text-lg font-weight-bold"><?php echo e($houses); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="message-circle"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color: #36b9cc">
					<a class="small text-white stretched-link" href="<?php echo e(route('house.list')); ?>">List All Houses</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-3">
			<div class="card text-white mb-4" style="background-color: #b4df4e;" >
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75">Today's Income</div>
							<div class="text-lg font-weight-bold">Ksh.<?php echo e(number_format($income_today)); ?>

								
						</div>
						</div>
						<i class="feather-xl text-white-50" data-feather="calendar"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color: #b4df4e;">
					<a class="small text-white stretched-link" href="<?php echo e(route('invoice.paid')); ?>" >List Paid Invoices</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-3">
			<div class="card text-white mb-4" style="background-color: #e87c3e">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">This Month's Income</div>
							<div class="text-lg font-weight-bold">Ksh.<?php echo e(number_format($month_income)); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="dollar-sign"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color:#e87c3e;">
					<a class="small text-white stretched-link" href="<?php echo e(route('manualinvoice.payments')); ?>">List Payments</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-3">
			<div class="card text-white mb-4" style="background-color: #e83e8c">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">Today's Expenses</div>
							<div class="text-lg font-weight-bold">Ksh.<?php echo e(number_format($bill_today)); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="check-square"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color: #e83e8c">
					<a class="small text-white stretched-link" href="<?php echo e(route('payowners.list')); ?>">List Bills</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-3">
			<div class="card  text-white mb-4" style="background-color: #6f42c1;">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">This Month's Expenses </div>
							<div class="text-lg font-weight-bold">Ksh.<?php echo e(number_format($month_bill)); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="message-circle"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color: #6f42c1">
					<a class="small text-white stretched-link" href="<?php echo e(route('servicerequests.index')); ?>">List Service Requests</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-6">
			<div class="card bg-success text-white mb-4">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">Occupied Houses </div>
						<div class="text-lg font-weight-bold"><?php echo e($occupied_house); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="message-circle"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color:#1cc88a">
					<a class="small text-white stretched-link" href="<?php echo e(route('house.occupied')); ?>">List Occupied Houses</a>
					
				</div>
			</div>
		</div>
		<div class="col-xxl-3 col-lg-6">
			<div class="card bg-danger text-white mb-4">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<div class="mr-3">
							<div class="text-white-75 ">Vacant Houses </div>
						<div class="text-lg font-weight-bold"><?php echo e($vacant_house); ?></div>
						</div>
						<i class="feather-xl text-white-50" data-feather="message-circle"></i>
					</div>
				</div>
				<div class="card-footer d-flex align-items-center justify-content-between" style="background-color:#e74a3b">
					<a class="small text-white stretched-link" href="<?php echo e(route('house.vacant')); ?>">List Vacant Houses</a>
					
				</div>
			</div>
		</div>
	</div>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
        <script>
        var url = "<?php echo e(url('admin.index')); ?>";
        var rent_month = new Array();
        var Labels = new Array();
        var amount = new Array();
        $(document).ready(function(){
          $.get(url, function(response){
            response.forEach(function(data){
                Years.push(data.stockYear);
                Labels.push(data.stockName);
                Prices.push(data.stockPrice);
            });
            var ctx = document.getElementById("canvas").getContext('2d');
                var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels: ['Jan','Feb'],
                      datasets: [{
                          label: 'Infosys Price',
                          data: Prices,
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      }
                  }
              });
          });
        });
		</script>
	

		 <!-- Page level custom scripts -->
		 <script src="<?php echo e(asset('assets/js/chart.js/Chart.min.js')); ?>"></script>
		 <script src="<?php echo e(asset('assets/js/demo/chart-area-demo.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rms\rms\resources\views/admins/index.blade.php ENDPATH**/ ?>