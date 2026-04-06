@extends('super_admin.layouts.master')
@section('title', 'Add Invoice')
@section('page-title', 'Add Invoice')

@section('css')
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/date-picker/date-picker.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="content container-fluid">
    <form action="{{ route('super.invoices.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                @include('includes.messages')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">New Invoice</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label>Organization <span class="text-danger">*</span></label>
                                        <select name="organization_id" class="form-control select2-show-search" required>
                                            <option value="">--- Select Organization ---</option>
                                            @foreach($organizations as $org)
                                            <option value="{{ $org->id }}" {{ old('organization_id') == $org->id ? 'selected' : '' }}>
                                                {{ $org->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Invoice Type <span class="text-danger">*</span></label>
                                        <select name="type" class="form-control select2-show-search" required>
                                            <option value="">--- Select Type ---</option>
                                            <option value="subscription">Subscription</option>
                                            <option value="sms_credits">SMS Credits</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label>Amount (KES) <span class="text-danger">*</span></label>
                                        <input type="number" name="amount" class="form-control"
                                            value="{{ old('amount') }}" min="1" step="0.01" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Due Date <span class="text-danger">*</span></label>
                                        <input type="date" name="due_date" class="form-control"
                                            value="{{ old('due_date', now()->addDays(7)->format('Y-m-d')) }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label>Description</label>
                                        <input type="text" name="description" class="form-control"
                                            value="{{ old('description') }}" placeholder="e.g. Monthly subscription - April 2026">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-success waves-effect waves-light">
                                            Create Invoice
                                        </button>
                                        <a href="{{ route('super.invoices.list') }}" class="btn btn-secondary ml-2">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
@endsection
