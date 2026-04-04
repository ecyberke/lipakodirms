<?php $__env->startSection('css'); ?>
<!-- Add Bootstrap CSS if not already included in master layout -->
<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">-->
<style>
    .modal.fade.show {
        opacity: 1;
    }
    .modal-backdrop {
        z-index: 1040 !important;
    }
    .modal {
        z-index: 1050 !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-header-unused'); ?>
<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">Invoice</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>" class="d-flex">
                <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                    <path d="M0 0h24v24H0V0z" fill="none"/>
                    <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/>
                    <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/>
                </svg>
                <span class="breadcrumb-icon"> Home</span>
            </a></li>
            <li class="breadcrumb-item active" aria-current="page">Invoices</li>
        </ol>
    </div>
</div>
<!--End Page header-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Row-->
<div class="row">
    <div class="col-md-12">
       
        
        <div class="card overflow-hidden">
            <div class="card-status bg-primary"></div>
            <div class="card-body">
                <h2 class="text-muted font-weight-bold">INVOICE</h2>
                 <?php echo $__env->make('includes.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
   
        
        <!-- Success/Error Messages for STK Push - Add this if not already there -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                <i class="fa fa-check-circle"></i> 
                <?php echo e(session('success')); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                <i class="fa fa-exclamation-circle"></i> 
                <?php echo e(session('error')); ?>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if($errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle"></i> 
                <ul class="mb-0">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
                <div class="col-sm-6 col-md-4 col-xl-3">
                    <!-- STK Push Modal Trigger Button - FIXED -->
                    <button type="button" class="btn btn-success d-grid mb-3" data-toggle="modal" data-target="#stkPushModal">
                        Initiate Payment Prompt
                    </button>
                    
                    <!-- Manual Payment Modal Trigger Button - FIXED -->
                    <!--<button type="button" class="btn btn-info d-grid mb-3" data-toggle="modal" data-bs-target="#manualPaymentModal">-->
                    <!--    <i class="fa fa-info-circle"></i> Pay Later? - Get Mpesa Details-->
                    <!--</button>-->
                </div>

                <div class="card-body pl-0 pr-0">
                    <div class="row">
                        <div class="col-sm-6">
                            <span>Invoice No.</span><br>
                            <strong>INV #<?php echo e($invoice->id); ?></strong>
                        </div>
                        <div class="col-sm-6 text-right">
                            <span>Generated Date</span><br>
                            <strong><?php echo e($invoice->created_at->format('d M Y, H:i')); ?></strong>
                        </div>
                    </div>
                </div>
                
                <div class="dropdown-divider"></div>
                
                <div class="row pt-4">
                    <div class="col-lg-6">
                        <p class="h5 font-weight-bold">Billing Details</p>
                        <address>
                            <li>House:  
                                <?php if($invoice->type == 'House Viewing'): ?>
                                    <span class="text-success">NO DEFINED HOUSE</span>
                                <?php elseif($invoice->house_name == null): ?>
                                    <span class="text-success"><?php echo e($invoice->house->house_no ?? 'N/A'); ?></span> -  
                                    Rent Paid after every <strong><?php echo e($invoice->house->rent_const ?? 'N/A'); ?> month(s)</strong>
                                <?php elseif($invoice->house_id == 0): ?>
                                    <span class="text-success"><?php echo e($invoice->house_name); ?></span>
                                <?php elseif($invoice->house_id != 0 && $invoice->house_name != null): ?>
                                    <span class="text-success"><?php echo e($invoice->house_name); ?></span> - 
                                    Rent Paid after every <strong><?php echo e($invoice->house->rent_const ?? 'N/A'); ?> month(s)</strong>
                                <?php else: ?>
                                    <span class="text-success">NO HOUSE</span>
                                <?php endif; ?>
                            </li>
                            <li>Property: 
                                <?php if($invoice->type == 'House Viewing'): ?>
                                    <span class="text-success">NO DEFINED PROPERTY</span>
                                <?php elseif($invoice->apartment_id > 0): ?>
                                    <span class="text-success"><?php echo e($invoice->apartment->name ?? 'N/A'); ?></span>
                                <?php elseif($invoice->apartment_id == 0): ?>
                                    <span class="text-success"><?php echo e($invoice->apartment_name); ?></span>
                                <?php else: ?>
                                    <span class="text-success">NO APARTMENT</span>
                                <?php endif; ?>
                            </li>
                            <li>Status:
                                <?php if($invoice->is_paid == 1): ?>
                                    <span class="text-success font-weight-bold">PAID</span>
                                <?php elseif($invoice->is_paid == 0 && $invoice->paid_in > 0): ?>
                                    <span class="text-warning font-weight-bold">PARTIAL PAYMENT</span>
                                <?php else: ?>
                                    <span class="text-danger font-weight-bold">UNPAID</span>
                                <?php endif; ?>
                            </li>
                        </address>
                    </div>
                    
                    <div class="col-lg-6 text-right">
                        <p class="h5 font-weight-bold">Invoice To</p>
                        <address>
                            Name: 
                            <?php if($invoice->tenant_id > 0): ?>
                                <?php echo e($invoice->tenant->full_name ?? 'N/A'); ?>

                            <?php else: ?>
                                <?php echo e($invoice->tenant_name ?? 'N/A'); ?>

                            <?php endif; ?> 
                            <br>
                            
                            Phone Number: 
                            <?php if($invoice->tenant_id > 0): ?>
                                <?php echo e($invoice->tenant->phone ?? 'N/A'); ?>

                            <?php elseif($invoice->tenant_phone > 0): ?>
                                <?php echo e($invoice->tenant_phone); ?>

                            <?php else: ?>
                                <span class="text-danger">NO PHONE</span>
                            <?php endif; ?>
                            <br>
                            
                            Account Number: 
                            <?php if($invoice->tenant_id > 0): ?>
                                <?php echo e($invoice->tenant->account_number ?? 'N/A'); ?>

                            <?php elseif($invoice->tenant_acc != null): ?>
                                <?php echo e($invoice->tenant_acc); ?>

                            <?php else: ?>
                                <span class="text-danger">NO ACCOUNT NUMBER</span>
                            <?php endif; ?>
                            <br>
                        </address>
                    </div>
                </div>
                
            <div class="table-responsive push">
    <table class="table table-bordered table-hover text-nowrap">
        <tr>
            <th class="d-none d-sm-table-cell">DESCRIPTION</th>
            <th class="text-right">TOTAL</th>
        </tr>
        
        <?php if($invoice->type == 'Monthly Rent' || $invoice->type == 'rent and deposit' || $invoice->type == null || $invoice->type == 'House Viewing'): ?>
            <?php if($invoice->rent > 0): ?>
            <tr>
                <td class="d-none d-sm-table-cell"> House Rent </td>
                <td class="text-right">Ksh <?php echo e(number_format($invoice->rent)); ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($invoice->deposit_paid > 0): ?>
            <tr>
                <td class="d-none d-sm-table-cell"> Deposit </td>
                <td class="text-right">Ksh <?php echo e(number_format($invoice->deposit_paid)); ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($invoice->electricity_deposit_paid > 0): ?>
            <tr>
                <td class="d-none d-sm-table-cell">Electricity Deposit </td>
                <td class="text-right">Ksh <?php echo e(number_format($invoice->electricity_deposit_paid)); ?></td>
            </tr>
            <?php endif; ?>
              <?php if($invoice->service_charge > 0): ?>
            <tr>
                <td class="d-none d-sm-table-cell">Service Charge </td>
                <td class="text-right">Ksh <?php echo e(number_format($invoice->service_charge)); ?></td>
            </tr>
            <?php endif; ?>
              <?php if($invoice->other_charges > 0): ?>
            <tr>
                <td class="d-none d-sm-table-cell">Other Charges </td>
                <td class="text-right">Ksh <?php echo e(number_format($invoice->other_charges)); ?></td>
            </tr>
            <?php endif; ?>
              <?php if($invoice->statutory_fee > 0): ?>
            <tr>
                <td class="d-none d-sm-table-cell">Statutory Fee </td>
                <td class="text-right">Ksh <?php echo e(number_format($invoice->statutory_fee)); ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($invoice->carryforward > 0): ?>
            <tr>
                <td class="d-none d-sm-table-cell"> Arrears </td>
                <td class="text-right">Ksh <?php echo e(number_format($invoice->carryforward)); ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($invoice->electricity_bill > 0): ?>
            <tr>
                <td class="d-none d-sm-table-cell"> Electricity Bill </td>
                <td class="text-right">Ksh <?php echo e(number_format($invoice->electricity_bill)); ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($invoice->water_bill > 0): ?>
            <tr>
                <td class="d-none d-sm-table-cell"> Water Bill </td>
                <td class="text-right">Ksh <?php echo e(number_format($invoice->water_bill)); ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($invoice->litter_bill > 0): ?>
            <tr>
                <td class="d-none d-sm-table-cell"> Litter Bill </td>
                <td class="text-right">Ksh <?php echo e(number_format($invoice->litter_bill)); ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($invoice->compound_bill > 0): ?>
            <tr>
                <td class="d-none d-sm-table-cell"> Compound Maintenance Bill </td>
                <td class="text-right">Ksh <?php echo e(number_format($invoice->compound_bill)); ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($invoice->security > 0): ?>
            <tr>
                <td class="d-none d-sm-table-cell"> Security Bill </td>
                <td class="text-right">Ksh <?php echo e(number_format($invoice->security)); ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($invoice->other_bill > 0 && $invoice->type != 'House Viewing'): ?>
            <tr>
                <td class="d-none d-sm-table-cell"> Other Bills </td>
                <td class="text-right">Ksh <?php echo e(number_format($invoice->other_bill)); ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($invoice->type == 'House Viewing'): ?>
            <tr>
                <td class="d-none d-sm-table-cell"> House Viewing </td>
                <td class="text-right">Ksh <?php echo e(number_format($invoice->other_bill)); ?></td>
            </tr>
            <?php endif; ?>
        <?php else: ?>
            <tr>
                <?php if($invoice->type === 'placement'): ?>
                <td class="d-none d-sm-table-cell">Placement Fee</td>
                <?php elseif($invoice->type === 'management'): ?>
                <td class="d-none d-sm-table-cell">Management Fee</td>
                <?php elseif($invoice->type === 'viewing'): ?>
                <td class="d-none d-sm-table-cell">Viewing Fee</td>
                <?php else: ?>
                <td class="d-none d-sm-table-cell">Others - <?php echo e($invoice->description); ?></td>
                <?php endif; ?>
                <td class="text-right">Ksh <?php echo e(number_format($invoice->total_payable)); ?></td>
            </tr>
        <?php endif; ?>
        
        <?php $count=3; ?>
        
        <tr>
            <td colspan="1" class="font-weight-bold text-uppercase text-right h5 mb-0">Sub Total</td>
            <td class="text-right">Ksh <?php echo e(number_format($invoice->total_payable )); ?></td>
        </tr>
        <tr>
            <td colspan="1" class="font-weight-bold text-uppercase text-right h5 mb-0">Total Paid</td>
            <td class="text-right text-success text-bold">Ksh <?php echo e(number_format($invoice->paid_in )); ?></td>
        </tr>
        <tr>
            <td colspan="1" class="font-weight-bold text-uppercase text-right h5 mb-0">Total Due</td>
            <td class="text-right text-danger text-bold">Ksh <?php echo e(number_format($invoice->balance)); ?></td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">
                <a href="<?php echo e(route('invoice.show',[$invoice->id,'action'=>'pdf'])); ?>" target="_blank"><button type="button" class="btn btn-success" ><i class="fa fa-download"></i> Download PDF</button></a>
                <button type="button" class="btn btn-info" onClick="javascript:window.print();"><i class="si si-printer"></i> Print Invoice</button>
            </td>
        </tr>
    </table>
</div>
                
                
                <?php if($invoice->balance > 0): ?>
                    <div class="alert alert-info">
                        <h5><i class="fa fa-info-circle"></i> How to pay</h5>
                        <p class="mb-1"><strong>Option 1: Pay via STK Push (Instant)</strong><br>
                           Click the "Pay Now via Mpesa" button above to receive an STK push on your phone.</p>
                        
                        <p class="mb-0"><strong>Option 2: Pay via Lipa na Mpesa (Paybill)</strong><br>
                           Business Number: <b>743994</b><br>
                           Account Number: 
                           <?php if($invoice->tenant_id != null && $invoice->tenant): ?>
                               <?php echo e($invoice->tenant->account_number); ?>

                           <?php else: ?>
                               <?php echo e($invoice->tenant_acc ?? $invoice->invoice_number); ?>

                           <?php endif; ?>
                           <br>
                           Amount: Ksh <?php echo e(number_format($invoice->balance)); ?>

                        </p>
                    </div>
                <?php endif; ?>
                
                <p class="text-muted mt-3">
                    <i class="fa fa-calendar"></i> All rent payments are due on or before 5th <?php echo e($invoice->rent_month); ?>

                </p>
            </div>
        </div>
    </div>
</div>


<!-- STK PUSH MODAL - With Editable Amount -->
<div class="modal fade" id="stkPushModal" tabindex="-1" aria-labelledby="stkPushModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stkPushModalLabel">
                    <i class="fa fa-mobile text-primary"></i> 
                    Account #<?php echo e($invoice->tenant->account_number); ?> - STK Push Payment
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="<?php echo e(route('mpesa.stk.push', $invoice->id)); ?>" method="POST"><input type="hidden" name="from_tenant_portal" value="1">
                <?php echo csrf_field(); ?>
                
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img src="https://www.safaricom.co.ke/images/Lipanampesa.png" alt="M-PESA Logo" style="height: 100px; width: auto;">
                        <!--<h6 class="mt-2">Lipa Na M-PESA Online (STK Push)</h6>-->
                    </div>
                    
                    <!-- Amount Input - Editable -->
                    <div class="form-group mb-3">
                        <label for="amount">Amount to Pay <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Ksh</span>
                            <input type="number" 
                                   class="form-control form-control-lg" 
                                   id="amount" 
                                   name="amount" 
                                   value="<?php echo e($invoice->balance); ?>" 
                                   min="1" 
                                   max="<?php echo e($invoice->balance); ?>"
                                   step="1"
                                   required>
                        </div>
                        <small class="text-muted">
                            <i class="fa fa-info-circle"></i> 
                            Min: 1 | Max: <?php echo e(number_format($invoice->balance)); ?> (Full balance: <?php echo e(number_format($invoice->balance)); ?>)
                        </small>
                    </div>
                    
                    <!-- Phone Number Input -->
                    <div class="form-group mb-3">
                        <label for="phone">M-PESA Phone Number <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-phone"></i>
                            </span>
                            <input type="text" 
                                   class="form-control" 
                                   id="phone" 
                                   name="phone" 
                                   value="<?php echo e(old('phone', $invoice->tenant_phone ?? ($invoice->tenant->phone ?? ''))); ?>" 
                                   placeholder="e.g., 0712345678 or 254712345678" 
                                   required>
                        </div>
                    </div>
                    
                    <!-- Payment Summary - Clean design without extra lines -->
                    <div class="bg-light p-3 rounded mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Account Number:</span>
                            <span class="fw-bold"><?php echo e($invoice->tenant->account_number); ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Balance:</span>
                            <span class="fw-bold text-danger">Ksh <?php echo e(number_format($invoice->balance)); ?></span>
                        </div>
                        <div class="d-flex justify-content-between pt-2 border-top">
                            <span class="h6 mb-0">Amount to be paid:</span>
                            <span class="h6 mb-0 text-primary" id="displayAmount">Ksh <?php echo e(number_format($invoice->balance)); ?></span>
                        </div>
                    </div>
                    
                    <!-- Instructions -->
                    <div class="alert alert-info p-2 mb-0">
                        <i class="fa fa-info-circle"></i> 
                        <small>STK push will be sent to the phone in the input above, they will put their Mpesa PIN to update the invoice.</small>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fa fa-mobile"></i> Initiate Prompt Ksh. <span id="submitAmount"><?php echo e(number_format($invoice->balance)); ?></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MANUAL PAYMENT MODAL - FIXED with proper ID and structure -->
<div class="modal fade" id="manualPaymentModal" tabindex="-1" aria-labelledby="manualPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manualPaymentModalLabel">
                    <i class="fa fa-info-circle text-warning"></i> 
                    Manual M-PESA Payment Instructions
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="text-center mb-4">
                    <img src="https://www.safaricom.co.ke/images/Lipanampesa.png" alt="M-PESA Logo" style="height: 50px;">
                    <h5 class="mt-2">Lipa Na M-PESA (Paybill)</h5>
                </div>
                
                <div class="card bg-light">
                    <div class="card-body">
                        <h6 class="text-primary">Follow these steps:</h6>
                        <ol class="list-group list-group-numbered mb-3">
                            <li class="list-group-item">Go to <strong>M-PESA</strong> on your phone</li>
                            <li class="list-group-item">Select <strong>Lipa Na M-PESA</strong></li>
                            <li class="list-group-item">Select <strong>Paybill</strong></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Enter Business Number
                                <span class="badge bg-primary rounded-pill fs-6">743994</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Enter Account Number
                                <span class="badge bg-warning rounded-pill fs-6">
                                    <?php if($invoice->tenant_id != null && $invoice->tenant): ?>
                                        <?php echo e($invoice->tenant->account_number); ?>

                                    <?php else: ?>
                                        <?php echo e($invoice->tenant_acc ?? $invoice->invoice_number); ?>

                                    <?php endif; ?>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Enter Amount
                                <span class="badge bg-danger rounded-pill fs-6">Ksh <?php echo e(number_format($invoice->balance)); ?></span>
                            </li>
                            <li class="list-group-item">Enter your <strong>M-PESA PIN</strong> and confirm</li>
                        </ol>
                        
                        <div class="alert alert-success mb-0">
                            <i class="fa fa-check-circle"></i> 
                            <strong>Note:</strong> Your payment will be processed automatically within a few minutes.
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-check"></i> Got it
                </button>
            </div>
        </div>
    </div>
</div>
<!-- End row-->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<!-- Add Bootstrap JavaScript if not already included in master layout -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Add Font Awesome if not already included -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
$(document).ready(function() {
    // Initialize Bootstrap modals manually if needed
    var stkModal = new bootstrap.Modal(document.getElementById('stkPushModal'));
    var manualModal = new bootstrap.Modal(document.getElementById('manualPaymentModal'));
    
    // Phone number validation and formatting
    $('#phone').on('input', function() {
        var phone = $(this).val().replace(/\D/g, '');
        $(this).val(phone);
    });
    
    // Form submission handling with loading state
    $('#stkPushForm').on('submit', function() {
        var $btn = $('#submitStkBtn');
        $btn.html('<i class="fa fa-spinner fa-spin"></i> Processing...').attr('disabled', true);
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('#success-alert, #error-alert').fadeOut('slow');
    }, 5000);
    
    // Debug: Check if modals are initialized
    console.log('STK Modal:', stkModal);
    console.log('Manual Modal:', manualModal);
});
</script>

<!-- Alternative: Use vanilla JavaScript if jQuery is not available -->
<script>
// Fallback for Bootstrap 5 without jQuery
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all modals
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function(modal) {
        try {
            new bootstrap.Modal(modal);
            console.log('Modal initialized:', modal.id);
        } catch(e) {
            console.log('Error initializing modal:', e);
        }
    });
    
    // Phone input validation
    var phoneInput = document.getElementById('phone');
    if(phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
        });
    }
});
</script>

<script>
$(document).ready(function() {
    // Update displayed amount when input changes
    $('#amount').on('input', function() {
        let amount = $(this).val();
        
        // Validate amount
        let maxAmount = <?php echo e($invoice->balance); ?>;
        
        if(amount > maxAmount) {
            amount = maxAmount;
            $(this).val(maxAmount);
        }
        
        if(amount < 1) {
            amount = 1;
            $(this).val(1);
        }
        
        // Format with commas for display
        let formattedAmount = new Intl.NumberFormat().format(amount);
        
        // Update display elements
        $('#displayAmount').text('Ksh ' + formattedAmount);
        $('#submitAmount').text(formattedAmount);
    });
    
    // Phone number validation
    $('#phone').on('input', function() {
        $(this).val($(this).val().replace(/\D/g, ''));
    });
    
    // Form submission handling
    $('form').on('submit', function() {
        $('#submitBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing...').prop('disabled', true);
    });
    
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('header_scripts'); ?>
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap-datetimepicker.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php echo $__env->make('tenant.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ecyberco/domains/lipakodi.ecyber.co.ke/public_html/rms/resources/views/tenant/invoice_show.blade.php ENDPATH**/ ?>