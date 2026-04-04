<!-- START OF EXPENSE FORM -->
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
            <li class="breadcrumb-item active" aria-current="page">Create Expense</li>
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
                
                <!-- Hidden fields for backend compatibility -->
                <input type="hidden" name="bill_type" value="agency">
                <input type="hidden" name="bill_category" value="bills_list">
                
                <!-- Expense selection dropdown -->
                <div class="row" id="expenseOptionsWrapper">
                    <div class="col-md-12">
                        <label>Select Expense <span class="text-danger">*</span></label>
                        <select class="form-control select2-show-search" name="selected_bill" required>
                            <option value="" disabled selected>-- Select Expense Type --</option>
                            <option value="Agency Bill-Rent">Rent</option>
                            <option value="Agency Bill-Wages">Wages</option>
                            <option value="Agency Bill-Stationary">Stationary</option>
                            <option value="Agency Bill-Electricity">Electricity Bill</option>
                            <option value="Agency Bill-Water">Water Bill</option>
                            <option value="Agency Bill-Office Refreshments">Office Refreshments</option>
                            <option value="Agency Bill-Travels">Travels</option>
                            <option value="Agency Bill-Branding and Marketing">Branding and Marketing</option>
                            <option value="Agency Bill-Professional Fees">Professional Fees</option>
                            <option value="Agency Bill-Bank Charges">Bank Charges</option>
                            <option value="Agency Bill-Web Hosting">Web Hosting</option>
                            <option value="Agency Bill-Internet Charges">Internet Charges</option>
                            <option value="Agency Bill-Others">Others</option>
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
                        <label>Expense Description <span class="text-danger">*</span></label>
                        <textarea name="bill_description" class="form-control" rows="5" required></textarea>
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

                <input type="hidden" name="approval" value="{{ Auth::user()->is_admin == 2 ? 1 : 0 }}">

                <div class="row mb-4">
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-success waves-effect waves-light">Add Expense</button>
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
    
    // Auto-populate description based on selected expense
    $('select[name="selected_bill"]').change(function() {
        const expenseType = $(this).find('option:selected').text();
        
        if (expenseType && expenseType !== '-- Select Expense Type --') {
            const currentDesc = $('textarea[name="bill_description"]').val();
            if (!currentDesc) {
                // Remove the "Agency Bill-" prefix if present for cleaner description
                const cleanExpenseType = expenseType.replace('Agency Bill-', '');
                $('textarea[name="bill_description"]').val(cleanExpenseType + ' expense');
            }
        }
    });
    
    // Initialize select2
    $('.select2-show-search').select2({
        minimumResultsForSearch: Infinity
    });
    
});
</script>
@endsection