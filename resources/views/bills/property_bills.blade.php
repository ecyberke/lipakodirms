<!-- START OF PROPERTY BILL FORM -->
@extends('layouts.master') 
@section('css')
<!-- Keep all current CSS intact -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/time-picker/jquery.timepicker.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/date-picker/date-picker.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/fileupload/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{URL::asset('assets/plugins/multipleselect/multiple-select.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/sumoselect/sumoselect.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/intl-tel-input-master/intlTelInput.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/jQuerytransfer/jquery.transfer.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/jQuerytransfer/icon_font/icon_font.css')}}">
<link rel="stylesheet" href="{{URL::asset('assets/plugins/multi/multi.min.css')}}">
@endsection

@section('page-header')
<div class="page-header">
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home')}}" class="d-flex"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/><path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/></svg><span class="breadcrumb-icon"> Home</span></a></li>
            <li class="breadcrumb-item active" aria-current="page">Create Property Bill</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <form action="{{route('bill.store')}}" method="post" class="card" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                @include('includes.messages')
                
                <!-- Hidden field to set bill type as property -->
                <input type="hidden" name="bill_type" value="property">
                
                <!-- Hidden field to set bill category as service (since it's the only option) -->
                <input type="hidden" name="bill_category" value="service_request">
                
                <div class="row" id="propertySelectWrapper">
                    <div class="col-md-12">
                        <label>Select Property <span class="text-danger">*</span></label>
                        <select class="form-control select2-show-search" name="apartment_id" id="apartmentSelect" required>
                            <option disabled selected>-----Select Property-----</option>
                            @foreach($apartments as $apartment => $id)
                                <option value="{{$id}}">{{$apartment}}</option>
                            @endforeach
                        </select>
                    </div>
                </div><br>

                <div class="row" id="billOptionsWrapper">
                    <div class="col-md-12">
                        <label>Select Service Request <span class="text-danger">*</span></label>
                        <select class="form-control select2-show-search" name="selected_bill" id="selectedBill" required>
                            <option value="" disabled selected>-- First select a property --</option>
                        </select>
                        
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-12">
                        <label>Select Supplier / Service Provider <span class="text-danger">*</span></label>
                        <select name="service_provider_id" class="form-control" required>
                            <option value="">-- Select Provider --</option>
                            @foreach($providers as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                            @endforeach
                        </select>
                        <small><a href="{{ route('service-providers.create') }}">Add new service provider</a></small>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-12">
                        <label>Bill Details <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="bill_description" required>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-6">
                        <label>Attach Document</label>
                        <input type="file" name="proof" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label>Amount <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="bill_amount" required>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-6">
                        <label>Transaction Code</label>
                        <input type="text" class="form-control" name="transaction_code">
                    </div>
                    <div class="col-md-6">
                        <label>Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="bill_date" required>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-md-12">
                        <label>Payment By</label>
                        <select class="form-control select2-show-search" name="paid_by">
                            <option value="owner">Property Owner</option>
                            <option value="tenant">Tenant</option>
                        </select>
                    </div>
                </div><br>

                <input type="hidden" name="approval" value="{{ Auth::user()->is_admin == 2 ? 1 : 0 }}">

                <div class="row mb-4">
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-success waves-effect waves-light">Add Property Bill</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<script>
$(document).ready(function () {
    
    // Log to confirm jQuery is working
    console.log('Document ready - Property bill form loaded');
    
    // Initialize select2 for apartment dropdown if not already initialized
    if ($.fn.select2) {
        $('#apartmentSelect').select2({
            placeholder: '-----Select Property-----',
            allowClear: true
        });
        console.log('Select2 initialized for apartment dropdown');
    }
    
    // Handle property selection change - load service requests immediately
    $('#apartmentSelect').change(function() {
        const propertyId = $(this).val();
        const propertyText = $(this).find('option:selected').text();
        
        console.log('Property selection changed - Selected Property ID:', propertyId);
        console.log('Property selection changed - Selected Property Name:', propertyText);
        
        // Clear any previous console logs
        console.clear(); // Optional: Remove if you don't want to clear previous logs
        
        if (propertyId && propertyId !== '-----Select-----' && propertyId !== '') {
            console.log('Valid property selected with ID:', propertyId);
            console.log('Calling loadServiceRequests function...');
            loadServiceRequests(propertyId);
        } else {
            console.log('No valid property selected - resetting service requests dropdown');
            // Reset the service requests dropdown
            $('#selectedBill').html('<option value="" disabled selected>-- First select a property --</option>');
            
            // If using select2, update it
            if ($.fn.select2) {
                $('#selectedBill').select2({
                    placeholder: '-- First select a property --',
                    allowClear: true
                });
            }
        }
    });
    
    // Function to load service requests for a specific property
    function loadServiceRequests(propertyId) {
        console.log('========== LOADING SERVICE REQUESTS ==========');
        console.log('Property ID received:', propertyId);
        console.log('Property ID type:', typeof propertyId);
        console.log('Timestamp:', new Date().toISOString());
        
        // Show loading state
        $('#selectedBill').html('<option value="">Loading service requests...</option>');
        console.log('Loading message displayed in dropdown');
        
        // If using select2, destroy and reinitialize after loading
        if ($.fn.select2 && $('#selectedBill').data('select2')) {
            console.log('Destroying existing select2 instance');
            $('#selectedBill').select2('destroy');
        }
        
        // Get the base URL
        const baseUrl = window.location.origin;
        console.log('Base URL:', baseUrl);
        
        // Construct the URL - using both possible routes for testing
        const url1 = baseUrl + '/get-service-requests/' + propertyId;
        const url2 = baseUrl + '/service-requests/by-property/' + propertyId;
        
        console.log('Attempt 1 URL:', url1);
        console.log('Attempt 2 URL (alternative):', url2);
        
        // Make AJAX call to get service requests for this specific property
        $.ajax({
            url: '/get-service-requests/' + propertyId,  // First try this URL
            type: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            dataType: 'json',
            timeout: 10000, // 10 second timeout
            beforeSend: function(xhr) {
                console.log('AJAX request starting...');
                console.log('Request headers set');
            },
            success: function(data) {
                console.log('========== AJAX SUCCESS ==========');
                console.log('Response received:', data);
                console.log('Response type:', typeof data);
                console.log('Is Array?', Array.isArray(data));
                console.log('Response length:', data ? (data.length || Object.keys(data).length) : 0);
                
                if (data && data.length > 0) {
                    console.log('Service requests found:', data.length);
                } else {
                    console.log('No service requests found or empty response');
                }
                
                let options = '<option value="" disabled selected>-- Select Service Request --</option>';
                
                // Check if data exists and has items
                if (!data || data.length === 0) {
                    console.log('No service requests data available');
                    options += '<option value="" disabled>No service requests found for this property</option>';
                } else {
                    console.log('Processing service requests:');
                    data.forEach(function(request, index) {
                        console.log(`Request ${index + 1}:`, {
                            id: request.id,
                            service_request: request.service_request + ' - ' + request.service_type + ' - ' + request.affected_area,
                            description: request.service_type + ' - ' + request.affected_area,
                            house_no: request.house_no || request.house_number || 'N/A',
                            full_object: request
                        });
                        
                        // Handle different possible response formats
                        const requestId = request.id || request.service_request_id || request.request_id;
                        const requestName = request.service_request || request.name || request.title || 'Unknown';
                        
                        // Get house number - try different possible field names
                        const houseNo = request.house_no || request.house_number || request.house?.house_no || request.house?.house_number || '';
                        
                        // Build the description with service type, affected area, and house number in brackets at the end
                        let requestDesc = '';
                        
                        // Add service type and affected area if they exist
                        if (request.service_type || request.affected_area) {
                            requestDesc = (request.service_type || '') + 
                                         (request.service_type && request.affected_area ? ' in the ' : '') + 
                                         (request.affected_area || '');
                        } else {
                            requestDesc = request.details || '';
                        }
                        
                        // Add house number in brackets at the end if it exists
                        if (houseNo) {
                            requestDesc += ` [House ${houseNo}]`;
                        }
                        
                        options += `<option value="${requestId}">${requestName} ${requestDesc ? '- ' + requestDesc : ''}</option>`;
                    });
                }
                
                console.log('Setting dropdown HTML with options');
                $('#selectedBill').html(options);
                
                // Reinitialize select2 if it's being used
                if ($.fn.select2) {
                    console.log('Reinitializing select2 for service requests dropdown');
                    $('#selectedBill').select2({
                        placeholder: '-- Select Service Request --',
                        allowClear: true
                    });
                }
                
                console.log('========== LOADING COMPLETE ==========');
            },
            error: function(xhr, status, error) {
                console.log('========== AJAX ERROR ==========');
                console.log('Error status:', status);
                console.log('Error message:', error);
                console.log('HTTP Status:', xhr.status);
                console.log('HTTP Status Text:', xhr.statusText);
                console.log('Response Text:', xhr.responseText);
                
                // Try to parse error response if it's JSON
                try {
                    if (xhr.responseText) {
                        const errorResponse = JSON.parse(xhr.responseText);
                        console.log('Parsed error response:', errorResponse);
                    }
                } catch (e) {
                    console.log('Could not parse error response as JSON');
                }
                
                console.log('Request URL that failed:', this.url);
                
                // Try alternative URL if first attempt failed
                if (this.url.includes('/get-service-requests/')) {
                    console.log('Trying alternative URL...');
                    $.ajax({
                        url: '/service-requests/by-property/' + propertyId,
                        type: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log('========== ALTERNATIVE URL SUCCESS ==========');
                            console.log('Alternative URL worked!');
                            console.log('Response:', data);
                            
                            let options = '<option value="" disabled selected>-- Select Service Request --</option>';
                            
                            if (!data || data.length === 0) {
                                options += '<option value="" disabled>No service requests found for this property</option>';
                            } else {
                                data.forEach(function(request) {
                                    const requestId = request.id || request.service_request_id || request.request_id;
                                    const requestName = request.service_request || request.name || request.title || 'Unknown';
                                    
                                    // Get house number - try different possible field names
                                    const houseNo = request.house_no || request.house_number || request.house?.house_no || request.house?.house_number || '';
                                    
                                    // Build the description with service type, affected area, and house number in brackets at the end
                                    let requestDesc = '';
                                    
                                    if (request.service_type || request.affected_area) {
                                        requestDesc = (request.service_type || '') + 
                                                     (request.service_type && request.affected_area ? ' in the ' : '') + 
                                                     (request.affected_area || '');
                                    } else {
                                        requestDesc = request.details || '';
                                    }
                                    
                                    // Add house number in brackets at the end if it exists
                                    if (houseNo) {
                                        requestDesc += ` [House ${houseNo}]`;
                                    }
                                    
                                    options += `<option value="${requestId}">${requestName} ${requestDesc ? '- ' + requestDesc : ''}</option>`;
                                });
                            }
                            
                            $('#selectedBill').html(options);
                            
                            if ($.fn.select2) {
                                $('#selectedBill').select2({
                                    placeholder: '-- Select Service Request --',
                                    allowClear: true
                                });
                            }
                        },
                        error: function(altXhr, altStatus, altError) {
                            console.log('========== ALTERNATIVE URL ALSO FAILED ==========');
                            console.log('Alternative URL error:', altError);
                            console.log('Alternative URL status:', altStatus);
                            console.log('Alternative URL HTTP status:', altXhr.status);
                            
                            // Show error message to user
                            $('#selectedBill').html('<option value="" disabled>Error loading service requests. Please check console for details.</option>');
                            
                            if ($.fn.select2) {
                                $('#selectedBill').select2({
                                    placeholder: 'Error loading service requests',
                                    disabled: true
                                });
                            }
                            
                            // Log helpful debugging information
                            console.log('========== DEBUGGING INFORMATION ==========');
                            console.log('Check the following:');
                            console.log('1. Is the route defined? Run: php artisan route:list | grep service-request');
                            console.log('2. Is the controller method created?');
                            console.log('3. Does the ServiceRequest model exist?');
                            console.log('4. Check Laravel logs: storage/logs/laravel.log');
                        }
                    });
                } else {
                    // Show error message to user
                    $('#selectedBill').html('<option value="" disabled>Error loading service requests. Status: ' + xhr.status + '</option>');
                    
                    if ($.fn.select2) {
                        $('#selectedBill').select2({
                            placeholder: 'Error loading service requests',
                            disabled: true
                        });
                    }
                }
                
                console.log('========== ERROR HANDLING COMPLETE ==========');
            },
            complete: function(xhr, status) {
                console.log('AJAX request completed with status:', status);
            }
        });
    }
    
    // Add change event listener to log when service request is selected
    $('#selectedBill').on('change', function() {
        const selectedId = $(this).val();
        const selectedText = $(this).find('option:selected').text();
        console.log('Service request selected - ID:', selectedId, 'Text:', selectedText);
    });
    
    // Log initial state
    console.log('Initial apartment select value:', $('#apartmentSelect').val());
    console.log('Initial service requests dropdown:', $('#selectedBill').html());
    
});
</script>
@endsection