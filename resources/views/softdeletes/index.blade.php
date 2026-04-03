@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
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
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>
@endsection
@section('page-header')
						<!--Page header-->
						<div class="page-header">
						
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{ route('home')}}" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
									<!--<li class="breadcrumb-item"><a href="#">Forms</a></li>-->
									<li class="breadcrumb-item active" aria-current="page">Deleted Files</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
@endsection
@section('content')
						<!-- Row -->
				<div class="row">
        
        <div class="col-md-12">
            @include('includes.messages')
            <div class="card">
                <div class="card-body">
                 <div class="tab">
                  <button class="tablinks" onclick="openCity(event, 'Houses')">Houses</button>
                  <button class="tablinks" onclick="openCity(event, 'Invoices')">Invoices</button>
                  <button class="tablinks" onclick="openCity(event, 'Bills')">Bills</button>
                  <button class="tablinks" onclick="openCity(event, 'Landlord')">Property Owners</button>
                  <button class="tablinks" onclick="openCity(event, 'Apartments')">Properties</button>
                  <button class="tablinks" onclick="openCity(event, 'Tenants')">Tenants</button>
                  <button class="tablinks" onclick="openCity(event, 'Users')">System Users</button>
            
                </div>
                
                <!-- Tab content -->
                 
                <div id="Houses" class="tabcontent">
                    <div class="table-responsive">
                  <table class="table table-striped"  id="houses-table" style="width:100%">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">House Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">Description</th>
                                <th scope="col">Deleted At</th>
                                <th scope="col" class="text-center">Actions</th>
                      </tr>
                                   
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        </div>
                </div>
                <div id="Invoices" class="tabcontent">
                    <div class="table-responsive">
                  <table class="table table-striped"  id="invoices-table" style="width:100%">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Invoice Number</th>
                                <th scope="col">Tenant</th>
                                <th scope="col">Type</th>
                                <th scope="col">Amount Payable</th>
                                <th scope="col">Deleted At</th>
                                <th scope="col" class="text-center">Actions</th>
                           
                      </tr>
                                   
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        </div>
                </div>
                <div id="Landlord" class="tabcontent">
                    <div class="table-responsive">
                  <table class="table table-striped"  id="landlord-table" style="width:100%">
                            <thead>
                                <tr>
                                 <th scope="col">#</th>
                                 <th scope="col">Name</th>
                                 <th scope="col">Phone Number</th>
                                 <th scope="col">Deleted At</th>
                                 <th scope="col" class="text-center">Actions</th>
                           
                                </tr>
                                   
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        </div>
                </div>
                <div id="Apartments" class="tabcontent">
                    <div class="table-responsive">
                  <table class="table table-striped"  id="apartment-table" style="width:100%">
                            <thead>
                                <tr>
                                 <th scope="col">#</th>
                                 <th scope="col">Name</th>
                                 <th scope="col">Type</th>
                                 <th scope="col">Location</th>
                                 <th scope="col">Landlord Phone</th>
                                 <th scope="col">Deleted At</th>
                                 <th scope="col" class="text-center">Actions</th>
                           
                                </tr>
                                   
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        </div>
                </div>
                 <div id="Tenants" class="tabcontent">
                    <div class="table-responsive">
                  <table class="table table-striped"  id="tenants-table" style="width:100%">
                            <thead>
                                <tr>
                         <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Telephone</th>
                        <th scope="col">Account Number</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                           
                                </tr>
                                   
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        </div>
                </div>
                <div id="Users" class="tabcontent">
                    <div class="table-responsive">
                  <table class="table table-striped"  id="user-table" style="width:100%">
                            <thead>
                                <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                           
                                </tr>
                                   
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        </div>
                </div>
                <div id="Bills" class="tabcontent">
                    <div class="table-responsive">
                  <table class="table table-striped"  id="bill-table" style="width:100%">
                            <thead>
                                <tr>
                       <th scope="col">#</th>
                        <th scope="col">Type</th>
                        <th scope="col">Description</th>
                        <th scope="col">Total Owned</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                           
                                </tr>
                                   
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        </div>
                </div>
               
                
                   
                        <!--<div class="dropdown">-->
                        <!--    <button onclick="myFunction()" class="dropbtn">Filter Invoices</button>-->
                        <!--    <div id="myDropdown" class="dropdown-content">-->
                        <!--      <a href="{{ route('invoice.unpaid')}}">Unpaid Invoices</a>-->
                        <!--      <a href="{{ route('invoice.paid')}}">Paid Invoices</a>-->
                             
                        <!--    </div>-->
                        <!--  </div><br><br><br>-->
                        
                        
               
                    </div>
                </div>
            </div>

        </div>
    </div>
							
						<!-- /Row -->

@endsection
@section('js')
<script>
    $(function () {
        $('#houses-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 25,
            ajax: '{!! route('api.houses.trashed') !!}',
          
        
            columns: [ 
              { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false}, 
                    { data: 'house_no', name: 'house_no' },
                    
                    { data: 'house_type', name: 'house_type' },
                    { data: 'description', name: 'description' },
                    { data: 'deleted_at', name: 'deleted_at'},
                    { data: 'actions', name: 'actions'},
                                     
                             ]
        });
         $(document).on('submit','.delete-overpayment',function(event){
            return confirm('You are about to delete the house parmanently are you sure?');            
        });
        
    });


</script>
<script>
    $(function () {
        $('#invoices-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 25,
            ajax: '{!! route('api.invoices.trashed') !!}',
            

            columns: [ 
              { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false}, 
                    { data: 'id', name: 'id' },
                    { data: 'tenant_name', name: 'tenant_name' },
                    { data: 'type', name: 'type' },
                    { data: 'total_payable', name: 'total_payable'},
                    { data: 'deleted_at', name: 'deleted_at'},
                    { data: 'actions', name: 'actions'},
                                     
                             ]
        });
         $(document).on('submit','.delete-tenant',function(event){
            return confirm('You are about to delete the invoice parmanently are you sure?');            
        });
        
    });


</script>
<script>
    $(function () {
        $('#landlord-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 25,
            ajax: '{!! route('api.landlord.trashed') !!}',
            columns: [ 
              { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false}, 
                    { data: 'full_name', name: 'full_name' },
                    { data: 'id', name: 'id' },
                    { data: 'deleted_at', name: 'deleted_at'},
                    { data: 'actions', name: 'actions'},
                                     
                             ]
        });
         $(document).on('submit','.delete-tenant',function(event){
            return confirm('You are about to delete the landlord parmanently are you sure?');            
        });
        
    });


</script>
<script>
    $(function () {
        $('#apartment-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 25,
            ajax: '{!! route('api.apartments.trashed') !!}',
            columns: [ 
              { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false}, 
                    { data: 'name', name: 'name' },
                    { data: 'type', name: 'type' },
                    { data: 'location', name: 'location' },
                    { data: 'landlord_id', name: 'landlord_id' },
                    { data: 'deleted_at', name: 'deleted_at'},
                    { data: 'actions', name: 'actions'},
                                     
                             ]
        });
         $(document).on('submit','.delete-tenant',function(event){
            return confirm('You are about to delete the apartment parmanently are you sure?');            
        });
        
    });


</script>
<script>
    $(function () {
        $('#tenants-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 25,
            ajax: '{!! route('api.tenants.trashed') !!}',
            columns: [ 
              { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false}, 
                    { data: 'full_name', name: 'full_name' },
                    { data: 'phone', name: 'phone' },
                    { data: 'account_number', name: 'account_number' },
                    { data: 'deleted_at', name: 'deleted_at'},
                    { data: 'actions', name: 'actions'},
                                     
                             ]
        });
         $(document).on('submit','.delete-tenant',function(event){
            return confirm('You are about to delete the tenant parmanently are you sure?');            
        });
        
    });


</script>
<script>
    $(function () {
        $('#user-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 25,
            ajax: '{!! route('api.systemuser.trashed') !!}',
            
            columns: [ 
              { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false}, 
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'deleted_at', name: 'deleted_at'},
                    { data: 'actions', name: 'actions'},
                                     
                             ]
        });
         $(document).on('submit','.delete-tenant',function(event){
            return confirm('You are about to delete the tenant parmanently are you sure?');            
        });
        
    });


</script>
<script>
    $(function () {
        $('#bill-table').DataTable({
            processing: true,
            serverSide: true,
            "pageLength": 25,
            ajax: '{!! route('api.bills.trashed') !!}',
            columns: [ 
              { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false , searchable:false}, 
                    { data: 'type', name: 'type' },
                    { data: 'description', name: 'description' },
                    { data: 'total_owned', name: 'total_owned' },
                    { data: 'deleted_at', name: 'deleted_at'},
                    { data: 'actions', name: 'actions'},
                                     
                             ]
        });
         $(document).on('submit','.delete-tenant',function(event){
            return confirm('You are about to delete the bill parmanently are you sure?');            
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
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables.js')}}"></script>
<!-- Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
@endsection

