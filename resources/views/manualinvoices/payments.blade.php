@extends('layouts.master')

@section('css')
<!-- Data table css -->
<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<!-- Select2 css -->
<link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
<!--Page header-->
<div class="page-header">
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="d-flex">
                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/>
                        <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/>
                    </svg>
                    <span class="breadcrumb-icon"> Home</span>
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Payments</li>
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
            <div class="card-header">
                <h3 class="card-title">Payments Management</h3>
                <div class="card-options">
                  <div class="btn-group btn-group-sm" role="group">
            <!-- Import Button -->
            <button type="button" 
                    class="btn btn-primary" 
                    data-toggle="modal" 
                    data-target="#importModal"
                    title="Import Payments">
                <i class="fe fe-upload"></i>
                <span class="button-text d-none d-md-inline ml-1">Import Payments</span>
            </button>
            
            <!-- Synchronize Button -->
            <a href="{{ route('invoice.synch') }}" 
               class="btn btn-danger" 
               title="Synchronize Payments">
                <i class="fe fe-refresh-cw"></i>
                <span class="button-text d-none d-md-inline ml-1">Synchronize Payments</span>
            </a>
        </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped custom-table mb-0" id="invoices-table">
                        <thead>
                            <tr>
                                <th style="width:2%">#</th>                                    
                                <th style="width:30%">Name</th>
                                <th style="width:20%">Account Number</th>
                                <th style="width:10%">Payment Method</th>
                                <th style="width:15%">Transaction Code</th>
                                <th style="width:10%">Total Paid</th> 
                                <th style="width:20%">Date</th>                                   
                                <th style="width:3%">Action</th>   
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Row -->

<!-- Import Payments Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fe fe-upload mr-2"></i> Import M-Pesa Payments
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form id="importForm" action="{{ route('import.excel') }}" method="POST">
                @csrf
                
                <div class="modal-body">
                    <!-- Progress Container -->
                    <div id="progressContainer" class="d-none">
                        <div class="progress mb-3">
                            <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" 
                                 role="progressbar" style="width: 0%"></div>
                        </div>
                        <div id="progressText" class="text-center small text-muted">Processing...</div>
                        <div id="importResults" class="mt-3"></div>
                    </div>
                    
                    <!-- Form Content -->
                    <div id="formContent">
                        <div class="alert alert-info">
                            <i class="fe fe-info mr-2"></i>
                            Import M-Pesa payments from CSV file. 
                            <small class="d-block mt-1">
                                <strong>Required columns:</strong> Receipt No., Paid In, Completion Time, A/C No.
                            </small>
                        </div>
                        
                        <div class="form-group">
                            <label for="import_file" class="font-weight-bold">M-Pesa Statement File *</label>
                            <div class="custom-file">
                                <input type="file" 
                                       class="custom-file-input" 
                                       id="import_file" 
                                       name="import_file" 
                                       accept=".csv"
                                       required>
                                <label class="custom-file-label" for="import_file">Choose M-Pesa statement CSV file..</label>
                            </div>
                            <small class="form-text text-muted">
                                Maximum file size: 10MB. Supported format: CSV
                                <br>
                                <strong>File should contain:</strong> Receipt No., Paid In, Completion Time, A/C No.
                            </small>
                            <div id="fileError" class="invalid-feedback"></div>
                        </div>
                        
                        <!-- Preview Section -->
                        <div id="previewSection" class="mt-4 d-none">
                            <h6 class="font-weight-bold border-bottom pb-2">File Preview</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="previewTable">
                                    <thead id="previewHeaders"></thead>
                                    <tbody id="previewBody"></tbody>
                                </table>
                            </div>
                            <small class="text-muted">Preview shows first 5 rows. Total rows: <span id="totalRows">0</span></small>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelBtn">Cancel</button>
                    <button type="button" id="importBtn" class="btn btn-primary" onclick="processAndImportFile()">
                        <i class="fe fe-upload mr-1"></i> Import Payments
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Import Modal -->
@endsection

@section('js')
<!-- Data tables -->
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/datatables.js') }}"></script>

<!-- Select2 js -->
<script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable with optimized settings
    var table = $('#invoices-table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        
        ajax: {
            url: '{!! route('api.payments.list') !!}',
            type: 'GET',
            data: function(d) {
                // Add additional parameters if needed
                d._token = '{{ csrf_token() }}';
            },
            error: function(xhr, error, thrown) {
                console.log('DataTable Error:', error);
                showToast('error', 'Error', 'Failed to load payments data');
            }
        },
        columns: [ 
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },     
            { data: 'full_name', name: 'full_name', orderable: true },
            { data: 'InvoiceNumber', name: 'InvoiceNumber', orderable: true },
            { data: 'TransactionType', name: 'TransactionType', orderable: true },
            { data: 'TransID', name: 'TransID', orderable: false },
            { data: 'TransAmount', name: 'TransAmount', orderable: true },
            { data: 'created_at', name: 'created_at', orderable: true },
            { data: 'actions', name: 'actions', searchable: false, orderable: false }             
        ],
        order: [[6, "desc"]], // Order by created_at desc
        // responsive: true, // Make it mobile responsive
        autoWidth: false,
        deferRender: true, // Load data only when needed
        scroller: {
            loadingIndicator: true,
        },
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
            search: "_INPUT_",
            searchPlaceholder: "Search payments...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ payments",
            infoEmpty: "Showing 0 to 0 of 0 payments",
            infoFiltered: "(filtered from _MAX_ total payments)",
            zeroRecords: "No matching payments found"
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        initComplete: function() {
            // Add loading state removal
            $('.dataTables_filter input').addClass('form-control form-control-sm');
            $('.dataTables_length select').addClass('form-control form-control-sm');
        }
    });
    
    // Add debounced search for better performance
    var searchTimeout;
    $('.dataTables_filter input').unbind().bind('input', function(e) {
        var self = this;
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            table.search(self.value).draw();
        }, 500); // Wait 500ms after typing before searching
    });
    
    // Delete confirmation
    $(document).on('submit', '.delete-overpayment', function(event) {
        return confirm('Are you sure you want to delete this Invoice? The action cannot be reversed');            
    });
    
    // Initialize Import Modal
    initializeImportModal();
});

function initializeImportModal() {
    // File input label update
    $('#import_file').on('change', function(e) {
        let fileName = e.target.files[0]?.name || 'Choose file...';
        $(this).next('.custom-file-label').text(fileName);
        $('#fileError').text('').parent().removeClass('has-error');
        
        // Preview the file if it's CSV
        if (this.files && this.files[0]) {
            previewCSVFile(this.files[0]);
        }
    });
    
    // Reset modal on close
    $('#importModal').on('hidden.bs.modal', function() {
        // Only reload if we actually imported something
        if (window.lastImportSuccess) {
            $('#invoices-table').DataTable().ajax.reload(null, false);
            window.lastImportSuccess = false;
        }
        resetImportForm();
    });
    
    // Track successful imports
    window.lastImportSuccess = false;
}

function previewCSVFile(file) {
    if (!file) return;
    
    const validTypes = [
        'text/csv',
        'text/plain',
        'application/octet-stream',
        'application/csv'
    ];
    
    const validExtensions = ['.csv'];
    const fileExtension = file.name.substring(file.name.lastIndexOf('.')).toLowerCase();
    
    if (!validTypes.includes(file.type) && !validExtensions.includes(fileExtension)) {
        $('#fileError').text('Please upload a valid CSV file').show();
        $('#import_file').addClass('is-invalid');
        $('#previewSection').addClass('d-none');
        return;
    }
    
    if (file.size > 10 * 1024 * 1024) { // 10MB
        $('#fileError').text('File size must be less than 10MB').show();
        $('#import_file').addClass('is-invalid');
        $('#previewSection').addClass('d-none');
        return;
    }
    
    $('#fileError').hide();
    $('#import_file').removeClass('is-invalid');
    
    const reader = new FileReader();
    
    reader.onload = function(e) {
        try {
            const csvContent = e.target.result;
            const lines = csvContent.split(/\r\n|\n|\r/);
            
            // Find header row (should be row 7, index 6)
            let headerRowIndex = -1;
            let headers = [];
            
            for (let i = 0; i < Math.min(15, lines.length); i++) {
                const row = parseCSVLine(lines[i]);
                const rowLower = row.map(cell => cell.toLowerCase().trim());
                
                // Check if this row contains required headers
                const hasReceiptNo = rowLower.includes('receipt no.') || rowLower.includes('receipt no');
                const hasPaidIn = rowLower.includes('paid in');
                const hasCompletionTime = rowLower.includes('completion time');
                const hasAcNo = rowLower.includes('a/c no.') || rowLower.includes('a/c no') || rowLower.includes('ac no');
                
                if (hasReceiptNo && hasPaidIn && hasCompletionTime && hasAcNo) {
                    headerRowIndex = i;
                    headers = row.map(h => h.trim());
                    break;
                }
            }
            
            // Default to row 7 if not found
            if (headerRowIndex === -1 && lines.length > 6) {
                const row6 = parseCSVLine(lines[6]);
                headerRowIndex = 6;
                headers = row6.map(h => h.trim());
            }
            
            if (headers.length === 0) {
                $('#fileError').html(`
                    <strong>Could not find headers in the file.</strong><br>
                    Make sure your CSV has these exact headers on row 7:<br>
                    <code>Receipt No., Paid In, Completion Time, A/C No.</code>
                `).show();
                $('#import_file').addClass('is-invalid');
                $('#previewSection').addClass('d-none');
                return;
            }
            
            // Check which headers we found
            const headersLower = headers.map(h => h.toLowerCase().trim());
            const requiredHeaders = ['receipt no.', 'paid in', 'completion time', 'a/c no.'];
            const foundHeaders = [];
            const missingHeaders = [];
            
            requiredHeaders.forEach(required => {
                const found = headersLower.some(h => h === required || h.includes(required.replace('.', '')));
                if (found) {
                    foundHeaders.push(required);
                } else {
                    missingHeaders.push(required);
                }
            });
            
            if (missingHeaders.length > 0) {
                $('#fileError').html(`
                    <strong>Missing required headers:</strong><br>
                    Found: ${foundHeaders.length > 0 ? foundHeaders.join(', ') : 'None'}<br>
                    Missing: ${missingHeaders.join(', ')}
                `).show();
                $('#import_file').addClass('is-invalid');
                $('#previewSection').addClass('d-none');
                return;
            }
            
            // Display preview
            displayPreview(headers, lines, headerRowIndex);
            
        } catch (error) {
            console.error('Error reading file:', error);
            $('#fileError').html(`
                <strong>Error reading file:</strong><br>
                ${error.message}<br>
                <small>Make sure it's a valid CSV file</small>
            `).show();
            $('#import_file').addClass('is-invalid');
            $('#previewSection').addClass('d-none');
        }
    };
    
    reader.onerror = function() {
        $('#fileError').text('Error reading file. Please try again.').show();
        $('#import_file').addClass('is-invalid');
        $('#previewSection').addClass('d-none');
    };
    
    reader.readAsText(file, 'UTF-8');
}

function parseCSVLine(line) {
    const result = [];
    let current = '';
    let inQuotes = false;
    
    for (let i = 0; i < line.length; i++) {
        const char = line[i];
        const nextChar = line[i + 1];
        
        if (char === '"' && !inQuotes) {
            inQuotes = true;
        } else if (char === '"' && inQuotes && nextChar === '"') {
            current += '"';
            i++; // Skip next quote
        } else if (char === '"' && inQuotes) {
            inQuotes = false;
        } else if (char === ',' && !inQuotes) {
            // Trim and clean the value
            result.push(current.trim().replace(/\0/g, ''));
            current = '';
        } else {
            current += char;
        }
    }
    
    // Add the last field and clean it
    result.push(current.trim().replace(/\0/g, ''));
    
    return result;
}

function displayPreview(headers, lines, headerRowIndex) {
    // Get data rows for preview
    const previewRows = [];
    let totalDataRows = 0;
    
    for (let i = headerRowIndex + 1; i < lines.length && previewRows.length < 5; i++) {
        const row = parseCSVLine(lines[i]);
        if (row.length === 0 || row.every(cell => !cell || cell.trim() === '')) {
            continue;
        }
        
        // Skip metadata rows
        const rowString = row.join(',');
        if (rowString.includes('Account Holder:') || 
            rowString.includes('Short Code:') || 
            rowString.includes('Time Period:')) {
            continue;
        }
        
        previewRows.push(row);
    }
    
    // Count total data rows
    for (let i = headerRowIndex + 1; i < lines.length; i++) {
        const row = parseCSVLine(lines[i]);
        const rowString = row.join(',');
        if (!rowString.includes('Account Holder:') && 
            !rowString.includes('Short Code:') && 
            !rowString.includes('Time Period:')) {
            totalDataRows++;
        }
    }
    
    // Clear previous preview
    $('#previewHeaders').empty();
    $('#previewBody').empty();
    
    // Create headers
    const headerRow = $('<tr>');
    headers.forEach((header, index) => {
        const isRequired = ['receipt no.', 'paid in', 'completion time', 'a/c no.'].some(req => 
            header.toLowerCase().trim().includes(req.replace('.', '')));
        const headerClass = isRequired ? 'bg-success text-white' : 'bg-light';
        
        headerRow.append(`
            <th class="${headerClass} position-relative">
                ${header || 'Column ' + (index + 1)}
                <small class="text-muted float-right mr-1">Col ${index + 1}</small>
                ${isRequired ? '<span class="badge badge-warning float-right mr-1">Required</span>' : ''}
            </th>
        `);
    });
    $('#previewHeaders').append(headerRow);
    
    // Create data rows
    previewRows.forEach(row => {
        const dataRow = $('<tr>');
        headers.forEach((header, index) => {
            const cellValue = row[index] !== undefined ? row[index] : '';
            dataRow.append(`<td>${cellValue}</td>`);
        });
        $('#previewBody').append(dataRow);
    });
    
    // Update row count
    $('#totalRows').text(totalDataRows);
    
    // Show preview
    $('#previewSection').removeClass('d-none');
}

function processAndImportFile() {
    const fileInput = $('#import_file')[0];
    const file = fileInput.files[0];
    
    if (!file) {
        $('#fileError').text('Please select a M-Pesa statement file').show();
        $('#import_file').addClass('is-invalid');
        return;
    }
    
    const submitBtn = $('#importBtn');
    const originalText = submitBtn.html();
    
    // Disable button and show loading
    submitBtn.prop('disabled', true).html('<i class="fe fe-loader mr-1"></i> Processing...');
    
    // Show progress
    $('#formContent').addClass('d-none');
    $('#progressContainer').removeClass('d-none');
    updateProgress(10);
    
    // Process the file
    processCSVFileForImport(file)
        .then(processedData => {
            updateProgress(50);
            
            // Clean the data before sending
            const cleanedData = cleanJSONData(processedData);
            
            // Create a hidden input for the data
            const dataInput = $('<input>').attr({
                type: 'hidden',
                name: 'import_data',
                value: JSON.stringify(cleanedData)
            }).appendTo('#importForm');
            
            // Submit the form
            return submitFormWithAJAX();
        })
        .then(response => {
            updateProgress(100);
            
            if (response.success) {
                // Track successful import
                window.lastImportSuccess = true;
                
                showSuccessMessage(response);
                
                // Update cancel button text
                $('#cancelBtn').html('<i class="fe fe-x mr-1"></i> Close');
                
                // Remove the hidden input
                $('#importForm input[name="import_data"]').remove();
                
            } else {
                throw new Error(response.message || 'Import failed');
            }
        })
        .catch(error => {
            updateProgress(100);
            showErrorMessage(error.message || 'An error occurred during import');
            submitBtn.prop('disabled', false).html(originalText);
            $('#formContent').removeClass('d-none');
            $('#progressContainer').addClass('d-none');
            // Remove the hidden input if it exists
            $('#importForm input[name="import_data"]').remove();
        });
}

// Update the cleanJSONData function to filter out non-numeric account numbers:
function cleanJSONData(data) {
    try {
        // Deep clean the data
        const cleanObject = (obj) => {
            if (obj === null || obj === undefined) {
                return null;
            }
            
            if (typeof obj !== 'object') {
                if (typeof obj === 'string') {
                    // Remove any problematic characters
                    return obj
                        .replace(/\0/g, '')  // Remove null bytes
                        .trim();
                }
                if (typeof obj === 'number') {
                    // Ensure numbers are finite
                    return isFinite(obj) ? obj : 0;
                }
                return obj;
            }
            
            if (Array.isArray(obj)) {
                return obj.map(item => cleanObject(item)).filter(item => item !== null);
            }
            
            const cleaned = {};
            for (const [key, value] of Object.entries(obj)) {
                if (key.startsWith('_')) {
                    continue; // Skip metadata keys
                }
                
                const cleanedValue = cleanObject(value);
                if (cleanedValue !== null) {
                    cleaned[key] = cleanedValue;
                }
            }
            return cleaned;
        };
        
        const cleanedData = cleanObject(data);
        
        // Ensure the structure is correct
        if (!cleanedData.rows || !Array.isArray(cleanedData.rows)) {
            throw new Error('Invalid data structure after cleaning');
        }
        
        // Clean each row and filter out non-numeric account numbers
        cleanedData.rows = cleanedData.rows.map(row => {
            const invoiceNumber = String(row.InvoiceNumber || '').trim();
            
            // Skip rows with non-numeric account numbers
            if (!invoiceNumber.match(/^\d+$/)) {
                console.log('Skipping row with non-numeric account number:', invoiceNumber);
                return null;
            }
            
            // Clean date format - remove any extra whitespace or invalid characters
            let transTime = String(row.TransTime || '').trim();
            
            // Try to standardize date format (DD-MM-YYYY HH:MM:SS)
            const dateMatch = transTime.match(/(\d{1,2})[-/](\d{1,2})[-/](\d{2,4})\s+(\d{1,2}):(\d{2})(?::(\d{2}))?/);
            if (dateMatch) {
                const day = dateMatch[1].padStart(2, '0');
                const month = dateMatch[2].padStart(2, '0');
                const year = dateMatch[3].length === 2 ? '20' + dateMatch[3] : dateMatch[3];
                const hour = dateMatch[4].padStart(2, '0');
                const minute = dateMatch[5];
                const second = dateMatch[6] ? dateMatch[6].padStart(2, '0') : '00';
                
                transTime = `${day}-${month}-${year} ${hour}:${minute}:${second}`;
            }
            
            return {
                TransID: String(row.TransID || '').substring(0, 50),
                TransTime: transTime,
                TransAmount: parseFloat(row.TransAmount) || 0,
                OrgAccountBalance: parseFloat(row.OrgAccountBalance) || 0,
                ThirdPartyTransID: String(row.ThirdPartyTransID || ''),
                InvoiceNumber: invoiceNumber
            };
        }).filter(row => 
            row !== null && 
            row.TransID && 
            row.InvoiceNumber && 
            row.TransTime && 
            row.TransAmount > 0
        );
        
        console.log('Filtered rows count:', cleanedData.rows.length);
        return cleanedData;
        
    } catch (error) {
        console.error('Error cleaning JSON data:', error);
        throw error;
    }
}

// Update the processCSVFileForImport function to better handle date formats:
function processCSVFileForImport(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            try {
                const csvContent = e.target.result;
                const lines = csvContent.split(/\r\n|\n|\r/);
                
                // Debug: Show CSV structure
                console.log('CSV Lines:', lines.length);
                for (let i = 0; i < Math.min(10, lines.length); i++) {
                    console.log(`Line ${i}: "${lines[i]}"`);
                }
                
                // Find header row (M-Pesa statements usually have headers on row 7)
                let headerRowIndex = 6; // Default to row 7 (index 6)
                let headers = [];
                
                // Try to find headers
                for (let i = 0; i < Math.min(15, lines.length); i++) {
                    const row = parseCSVLine(lines[i]);
                    const rowLower = row.map(cell => cell.toLowerCase().trim());
                    
                    // Look for M-Pesa headers
                    const hasTransactionFields = rowLower.some(cell => 
                        cell.includes('receipt') || 
                        cell.includes('transid') || 
                        cell.includes('transaction')
                    );
                    
                    if (hasTransactionFields && row.length >= 4) {
                        headerRowIndex = i;
                        headers = row.map(h => h.trim());
                        console.log('Found headers at row', i + 1, headers);
                        break;
                    }
                }
                
                if (headers.length === 0 && lines.length > 6) {
                    // Use row 7 as default
                    headers = parseCSVLine(lines[6]).map(h => h.trim());
                    console.log('Using default row 7 headers:', headers);
                }
                
                if (headers.length === 0) {
                    reject(new Error('Could not find headers in the CSV file. Please check the file format.'));
                    return;
                }
                
                // Process data rows
                const processedRows = [];
                
                for (let i = headerRowIndex + 1; i < lines.length; i++) {
                    const rawRow = lines[i];
                    if (!rawRow || rawRow.trim() === '') {
                        continue;
                    }
                    
                    const row = parseCSVLine(rawRow);
                    if (row.length === 0 || row.every(cell => !cell || cell.trim() === '')) {
                        continue;
                    }
                    
                    // Skip metadata rows
                    const rowString = row.join(',').toLowerCase();
                    if (rowString.includes('account holder:') || 
                        rowString.includes('short code:') || 
                        rowString.includes('time period:') ||
                        rowString.includes('---')) {
                        continue;
                    }
                    
                    // Map columns
                    const rowData = {};
                    headers.forEach((header, index) => {
                        const value = row[index] || '';
                        const cleanValue = value.toString().replace(/\0/g, '').trim();
                        const cleanHeader = header.toLowerCase().trim();
                        
                        if (cleanHeader.includes('receipt no') || cleanHeader.includes('transid')) {
                            rowData.TransID = cleanValue;
                        } else if (cleanHeader.includes('paid in') || cleanHeader.includes('amount')) {
                            // Extract numeric value
                            const amountMatch = cleanValue.match(/[\d,]+\.?\d*/);
                            if (amountMatch) {
                                rowData.TransAmount = parseFloat(amountMatch[0].replace(/,/g, ''));
                            }
                        } else if (cleanHeader.includes('completion time') || cleanHeader.includes('date')) {
                            rowData.TransTime = cleanValue;
                        } else if (cleanHeader.includes('a/c no') || cleanHeader.includes('account no') || cleanHeader.includes('invoice')) {
                            rowData.InvoiceNumber = cleanValue.replace(/[^\d]/g, '');
                        } else if (cleanHeader.includes('balance')) {
                            const balanceMatch = cleanValue.match(/[\d,]+\.?\d*/);
                            if (balanceMatch) {
                                rowData.OrgAccountBalance = parseFloat(balanceMatch[0].replace(/,/g, ''));
                            }
                        }
                    });
                    
                    // Only include if we have the essentials
                    if (rowData.TransID && rowData.InvoiceNumber && rowData.TransTime && rowData.TransAmount > 0) {
                        // Ensure InvoiceNumber is numeric
                        if (!rowData.InvoiceNumber.match(/^\d+$/)) {
                            console.log('Skipping non-numeric account:', rowData.InvoiceNumber);
                            continue;
                        }
                        
                        processedRows.push({
                            TransID: rowData.TransID,
                            TransTime: rowData.TransTime,
                            TransAmount: rowData.TransAmount,
                            OrgAccountBalance: rowData.OrgAccountBalance || 0,
                            ThirdPartyTransID: rowData.ThirdPartyTransID || '',
                            InvoiceNumber: rowData.InvoiceNumber
                        });
                    }
                }
                
                if (processedRows.length === 0) {
                    reject(new Error('No valid transaction data found. Please check the CSV format.'));
                    return;
                }
                
                console.log('Processed', processedRows.length, 'rows');
                
                resolve({
                    rows: processedRows,
                    short_code: '743994',
                    total_rows: processedRows.length
                });
                
            } catch (error) {
                console.error('Error processing CSV:', error);
                reject(new Error('Error processing CSV file: ' + error.message));
            }
        };
        
        reader.onerror = function() {
            reject(new Error('Error reading file. Please try again.'));
        };
        
        reader.readAsText(file, 'UTF-8');
    });
}

function submitFormWithAJAX() {
    return new Promise((resolve, reject) => {
        // Get the form data
        const formData = new FormData($('#importForm')[0]);
        
        // Log what we're sending for debugging
        const importDataInput = $('#importForm input[name="import_data"]');
        if (importDataInput.length > 0) {
            const jsonData = importDataInput.val();
            console.log('JSON data being sent (first 500 chars):', jsonData.substring(0, 500));
            console.log('JSON data length:', jsonData.length);
            
            try {
                // Try to parse it to ensure it's valid JSON
                const parsed = JSON.parse(jsonData);
                console.log('JSON is valid, row count:', parsed.rows ? parsed.rows.length : 0);
            } catch (e) {
                console.error('Invalid JSON before sending:', e.message);
                // Try to fix common JSON issues
                try {
                    // Remove any trailing commas
                    let fixedJson = jsonData.replace(/,\s*}/g, '}').replace(/,\s*]/g, ']');
                    // Parse again to check
                    JSON.parse(fixedJson);
                    // Update the hidden input with fixed JSON
                    importDataInput.val(fixedJson);
                    console.log('Fixed JSON issues');
                } catch (e2) {
                    console.error('Could not fix JSON:', e2.message);
                }
            }
        }
        
        $.ajax({
            url: $('#importForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('Server response:', response);
                resolve(response);
            },
            error: function(xhr) {
                console.error('AJAX Error:', xhr);
                let errorMessage = 'An error occurred during import';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                } else if (xhr.responseText) {
                    // Try to extract error message from HTML response
                    try {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = xhr.responseText;
                        const errorElement = tempDiv.querySelector('.exception-message, .message, .error');
                        if (errorElement) {
                            errorMessage = errorElement.textContent.trim().substring(0, 200);
                        }
                    } catch (e) {
                        // Ignore
                    }
                }
                
                reject(new Error(errorMessage));
            }
        });
    });
}

// Update the showSuccessMessage function to show better information:
function showSuccessMessage(response) {
    const stats = response.statistics || {};
    const failedRows = response.failed_rows || [];
    const importedRows = response.imported_rows || [];
    
    let html = `
        <div class="alert ${stats.success > 0 ? 'alert-success' : 'alert-warning'}">
            <h5><i class="fe fe-${stats.success > 0 ? 'check-circle' : 'alert-triangle'} mr-2"></i> Import ${stats.success > 0 ? 'Completed' : 'Partially Completed'}</h5>
            <p>${response.message || 'Processing completed.'}</p>
            <hr>
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="h4 mb-1">${stats.total || 0}</div>
                    <small class="text-muted">Total Rows</small>
                </div>
                <div class="col-md-4 text-center">
                    <div class="h4 mb-1 ">${stats.success || 0}</div>
                    <small class="text-muted">Successful</small>
                </div>
                <div class="col-md-4 text-center">
                    <div class="h4 mb-1 text-danger">${stats.failed || 0}</div>
                    <small class="text-muted">Failed</small>
                </div>
             
            </div>
    `;
    
    if (stats.success_percentage !== undefined) {
        html += `
            <div class="mt-2 text-center">
                <small class="text-muted">Success rate: <strong>${stats.success_percentage}%</strong></small>
            </div>
        `;
    }
    
    // Show imported rows if any
    if (importedRows.length > 0) {
        html += `
            <div class="mt-3">
                <h6 class="mb-2"><i class="fe fe-check-circle mr-1 text-success"></i> Imported Payments (${importedRows.length})</h6>
                <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Trans ID</th>
                                <th>Account</th>
                                <th>Amount</th>
                                <th>Tenant</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
        `;
        
        importedRows.slice(0, 10).forEach((row) => {
            html += `
                            <tr>
                                <td class="small">${row.TransID || 'N/A'}</td>
                                <td>${row.InvoiceNumber || 'N/A'}</td>
                                <td>KES ${row.TransAmount ? parseFloat(row.TransAmount).toFixed(2) : '0.00'}</td>
                                <td>${row.FullName || 'N/A'}</td>
                                <td><small>${row.PaymentDate || row.TransTime || 'N/A'}</small></td>
                            </tr>
            `;
        });
        
        if (importedRows.length > 10) {
            html += `
                            <tr>
                                <td colspan="5" class="text-center text-muted small">
                                    ... and ${importedRows.length - 10} more successful imports
                                </td>
                            </tr>
            `;
        }
        
        html += `
                        </tbody>
                    </table>
                </div>
            </div>
        `;
    }
    
    // Show failed rows if any
    if (failedRows.length > 0) {
        html += `
            <div class="mt-3">
                <h6 class="mb-2"><i class="fe fe-alert-triangle mr-1 text-warning"></i> Failed Imports (${failedRows.length})</h6>
                <div class="alert alert-info small">
                    <i class="fe fe-info mr-1"></i>
                    <strong>Common reasons for failure:</strong>
                    <ul class="mb-0">
                        <li>Account number doesn't exist in the system</li>
                        <li>Date format could not be parsed</li>
                        <li>Payment already exists with same Transaction ID</li>
                        <li>Non-numeric account numbers (like "Lesa")</li>
                    </ul>
                </div>
                <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Row</th>
                                <th>Account No.</th>
                                <th>Error</th>
                            </tr>
                        </thead>
                        <tbody>
        `;
        
        failedRows.slice(0, 10).forEach((failed) => {
            html += `
                            <tr>
                                <td>${failed.row || 'N/A'}</td>
                                <td>${failed.account_no || 'N/A'}</td>
                                <td class="text-danger small">${failed.error || 'Unknown error'}</td>
                            </tr>
            `;
        });
        
        if (failedRows.length > 10) {
            html += `
                            <tr>
                                <td colspan="3" class="text-center text-muted small">
                                    ... and ${failedRows.length - 10} more failed rows
                                </td>
                            </tr>
            `;
        }
        
        html += `
                        </tbody>
                    </table>
                </div>
            </div>
        `;
    }
    
    html += `
            <hr class="my-2">
            <div class="mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="resetImportForm()">
                            <i class="fe fe-x mr-1"></i> Close Results
                        </button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="closeAndReload()">
                            <i class="fe fe-check mr-1"></i> Done & View Payments
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('#importResults').html(html).removeClass('d-none');
}


function closeAndReload() {
    // Close the modal
    $('#importModal').modal('hide');
    
    // Show toast notification
    showToast('success', 'Import Complete', 'Payments have been imported successfully!');
}

function showErrorMessage(message, errors = null) {
    let html = `
        <div class="alert alert-danger">
            <h5><i class="fe fe-alert-triangle mr-2"></i> Import Failed</h5>
            <p>${message}</p>
    `;
    
    if (errors) {
        html += `<ul class="mb-0">`;
        if (typeof errors === 'object') {
            for (const [field, errorMessages] of Object.entries(errors)) {
                if (Array.isArray(errorMessages)) {
                    errorMessages.forEach(error => {
                        html += `<li>${field}: ${error}</li>`;
                    });
                } else {
                    html += `<li>${field}: ${errorMessages}</li>`;
                }
            }
        } else if (Array.isArray(errors)) {
            errors.forEach(error => {
                if (typeof error === 'object') {
                    html += `<li>${error.error || JSON.stringify(error)}</li>`;
                } else {
                    html += `<li>${error}</li>`;
                }
            });
        }
        html += `</ul>`;
    }
    
    html += `
            <hr class="my-2">
            <div class="mt-2 text-right">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="resetImportForm()">
                    <i class="fe fe-x mr-1"></i> Try Again
                </button>
            </div>
        </div>
    `;
    
    $('#importResults').html(html).removeClass('d-none');
}

function resetImportForm() {
    // If we're in the results view, just show the form again
    if ($('#progressContainer').is(':visible') && $('#importResults').html().trim() !== '') {
        $('#progressContainer').addClass('d-none');
        $('#formContent').removeClass('d-none');
        $('#importResults').empty();
        $('#importBtn').prop('disabled', false).html('<i class="fe fe-upload mr-1"></i> Import Payments');
        $('#cancelBtn').html('Cancel');
    } else {
        // Full reset
        $('#importForm')[0].reset();
        $('.custom-file-label').text('Choose M-Pesa statement CSV file..');
        $('.invalid-feedback').hide();
        $('.form-control').removeClass('is-invalid');
        $('#previewSection').addClass('d-none');
        $('#progressContainer').addClass('d-none');
        $('#formContent').removeClass('d-none');
        $('#importResults').empty();
        $('#importBtn').prop('disabled', false).html('<i class="fe fe-upload mr-1"></i> Import Payments');
        $('#cancelBtn').html('Cancel');
    }
}

function validateImportForm() {
    let isValid = true;
    
    // Validate file
    const fileInput = $('#import_file');
    if (!fileInput[0].files.length) {
        $('#fileError').text('Please select a M-Pesa statement file').show();
        fileInput.addClass('is-invalid');
        isValid = false;
    } else {
        $('#fileError').hide();
        fileInput.removeClass('is-invalid');
    }
    
    return isValid;
}

function updateProgress(percent) {
    $('#progressBar').css('width', percent + '%');
    $('#progressText').text(`Processing: ${Math.round(percent)}%`);
}

function showToast(type, title, message) {
    const toastId = 'toast-' + Date.now();
    const toastHtml = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
            <div class="toast-header bg-${type} text-white">
                <strong class="mr-auto">${title}</strong>
                <small>just now</small>
                <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;
    
    if ($('.toast-container').length === 0) {
        $('body').append('<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999"></div>');
    }
    
    $('.toast-container').append(toastHtml);
    $(`#${toastId}`).toast('show');
    
    $(`#${toastId}`).on('hidden.bs.toast', function () {
        $(this).remove();
    });
}
</script>
@endsection