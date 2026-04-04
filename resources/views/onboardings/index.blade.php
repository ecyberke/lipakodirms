@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />

<style>
    .table-responsive {
        overflow: visible !important;
    }

    .dropdown-menu {
        z-index: 1050 !important; /* Above modals and cards */
    }

    .table td, .table th {
        position: relative; /* Required for absolute positioning in dropdown */
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
									<li class="breadcrumb-item active" aria-current="page">Prospectives</li>
								</ol>
							</div>
						</div>
						<!--End Page header-->
@endsection

@section('content')
	<div class="row">

 <div class="col-md-12">
        
            <div class="card">
                <div class="card-body">
                    
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEntryModal">+ New Prospect</button><br><br>

   @include('includes.messages')
   <div class="table-responsive">
    <table class="table table-striped"  style="width:100%">
    <thead>
        <tr >
            <th>Name</th><th>Phone</th><th>Email</th><th>ID Number</th><th>Type</th><th>Status</th><th>Location</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($entries as $entry)
            <tr >
                <td>{{ $entry->full_name }}</td>
                <td>{{ $entry->formatted_phone }}</td>
                <td>{{ $entry->email }}</td>
                <td> {{ $entry->id_number }}</td>
                <td>{{ $entry->type }}</td>
                <td>{{ $entry->status }}</td>
                <td>{{ $entry->location }}</td>
                <td>
    <div class="dropdown">

            <i type="button" data-bs-toggle="dropdown" aria-expanded="false" class="bi bi-three-dots-vertical"></i> <!-- Bootstrap icon -->
        
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#viewEntryModal" onclick='openViewModal(@json($entry))'>View</a>
            </li>
            <li>
                <a class="dropdown-item" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#editEntryModal" onclick='openEditModal(@json($entry))'>Edit</a>
            </li>
            <li>
                <form action="{{ route('onboardings.onboard', $entry->id) }}" method="POST" onsubmit="return confirm('Onboard this entry?')">
                    @csrf
                    <button class="dropdown-item" type="submit">Onboard</button>
                </form>
            </li>
            <li>
                <form action="{{ route('onboardings.destroy', $entry->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this entry?')">
                    @csrf
                    @method('DELETE')
                    <button class="dropdown-item text-danger" type="submit">Delete</button>
                </form>
            </li>
        </ul>
    </div>
</td>

       

               
            </tr>
        @empty
            <tr><td colspan="8" class="text-center">No entries found.</td></tr>
        @endforelse
    </tbody>
</table>
</div>

<!-- Modal -->



     <div class="col-md-12">
        {{ $entries->links() }}
    </div>

    <!-- Modal Form -->
<!-- Add New Entry Modal (Bootstrap) -->
<div class="modal fade" id="addEntryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Prospect</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('onboardings.store') }}" method="POST">
                    @csrf
                          <!-- Type Selector -->
                    <select name="type" id="prospectType" required class="form-control select2-show-search">
                        <option value="null">Select Type</option>
                        <option value="Tenant">Tenant</option>
                        <option value="Seeker">House Seeker</option>
                        <option value ="Placement_fee">Placement Fee</option>
                        <option value="Owner">Property Owner</option>
                    </select><br>
                        <!-- Viewing Fee Dropdown (Hidden by default) -->
                    <div id="viewingFeeContainer" class="mb-2" style="display: none;">
                        <select name="fee" class="form-control">
                            <option value="">Select Viewing Fee</option>
                            <option value="0">No Fee</option>
                            <option value="500">Ksh. 500</option>
                            <option value="1000">Ksh. 1000</option>
                        </select>
                    </div><br>
                    
                     <input type="text" name="full_name" placeholder="Full Name" required class="form-control mb-2" />
                    <input type="text" name="phone" placeholder="Phone" class="form-control mb-2" />
                    <input type="email" name="email" placeholder="Email" class="form-control mb-2" />
                     <input type="text" name="id_number" placeholder="ID Number" class="form-control mb-2" />
           
               

                    <input type="text" name="location" placeholder="Location" class="form-control mb-2" />

                   
                     <input id="placementFeeContainer" type="text" name="fee" placeholder="Placement Fee" required class="form-control mb-2" />
                  
                    <select  name="status" class="form-control select2-show-search">
                        <option value="Prospect">Prospect</option>
                        <option value="Onboarded">Onboarded</option>
                        <option value="Dropped">Dropped</option>
                         <option value="Closed">Closed</option>
                    </select>
                    <br><br>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Entry Modal -->
<div class="modal fade" id="editEntryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Prospect</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="type" id="edit_type"  class="form-control select2-show-search" required>
                        <option value="Tenant">Tenant</option>
                        <option value="Seeker">House Seeker</option>
                        <option value="Owner">Owner</option>
                    </select><br>
                   
                    <input type="text" name="full_name" id="edit_full_name" class="form-control mb-2" required />
                    <input type="text" name="phone" id="edit_phone" class="form-control mb-2" />
                    <input type="email" name="email" id="edit_email" class="form-control mb-2" />
                      <input type="text" name="id_number" id="edit_id_number" class="form-control" /><br>
  
                    

                    <input type="text" name="location" id="edit_location" class="form-control mb-2" />

                    

                   

                    <select name="status" id="edit_status" class="form-control select2-show-search">
                      <option value="Prospect">Prospect</option>
                        <option value="Onboarded">Onboarded</option>
                        <option value="Dropped">Dropped</option>
                         <option value="Closed">Closed</option>
                    </select><br><br>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Entry Modal -->
<div class="modal fade" id="viewEntryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Propspect Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="view_full_name"></span></p>
                <p><strong>Phone:</strong> <span id="view_phone"></span></p>
                <p><strong>Email:</strong> <span id="view_email"></span></p>
                <p><strong>ID Number:</strong> <span id="view_id_number"></span></p>
                <p><strong>Gender:</strong> <span id="view_gender"></span></p>
                <p><strong>Type:</strong> <span id="view_type"></span></p>
                <p><strong>Status:</strong> <span id="view_status"></span></p>
                <p><strong>Location:</strong> <span id="view_location"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
 </div>
    </div>
</div>


</div>
@endsection
@section('js')
<!-- jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function openViewModal(entry) {
    // Fill modal fields
    document.getElementById("view_full_name").textContent = entry.full_name || '';
    document.getElementById("view_phone").textContent = entry.phone || '';
    document.getElementById("view_email").textContent = entry.email || '';
    document.getElementById("view_id_number").textContent = entry.id_number || '';
    document.getElementById("view_type").textContent = entry.type || '';
    document.getElementById("view_status").textContent = entry.status || '';
    document.getElementById("view_location").textContent = entry.location || '';

    // Show modal — this might be redundant if data-bs-toggle="modal" already triggers it, but safe to include:
    var myModal = new bootstrap.Modal(document.getElementById('viewEntryModal'));
    myModal.show();
  }
</script>

<script>
    function openEditModal(entry) {
        // Set form action URL dynamically
        document.getElementById('editForm').action = `/onboardings/${entry.id}`;

        // Prefill the input fields
        document.getElementById('edit_full_name').value = entry.full_name || '';
        document.getElementById('edit_phone').value = entry.phone || '';
        document.getElementById('edit_email').value = entry.email || '';
        document.getElementById('edit_id_number').value = entry.id_number || '';
        document.getElementById('edit_location').value = entry.location || '';
        document.getElementById('edit_type').value = entry.type || '';
        document.getElementById('edit_status').value = entry.status || '';

        // Show modal
        var editModal = new bootstrap.Modal(document.getElementById('editEntryModal'));
        editModal.show();
    }
</script>
<!-- JavaScript to Show/Hide Viewing Fee -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('prospectType');
    const viewingFeeContainer = document.getElementById('viewingFeeContainer');
    const placementFeeContainer = document.getElementById('placementFeeContainer');

    typeSelect.addEventListener('change', function () {
        const selectedType = this.value;
        if (selectedType === 'Tenant' || selectedType === 'Seeker') {
            viewingFeeContainer.style.display = 'block';
        } else {
            viewingFeeContainer.style.display = 'none';
        }
        if (selectedType === 'Placement_fee' ) {
            placementFeeContainer.style.display = 'block';
        } else {
            placementFeeContainer.style.display = 'none';
        }
        if (selectedType === 'null' || selectedType === 'Owner') {
            placementFeeContainer.style.display = 'none';
            viewingFeeContainer.style.display = 'none';
        } 
    });
});
</script>
@endsection
