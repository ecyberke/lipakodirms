@extends('super_admin.layouts.master')
@section('title', 'Edit Invoice')
@section('page-title', 'Edit Invoice')

@section('content')
<div class="content container-fluid">
    <form action="{{ route('super.invoices.update', $invoice->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row">
            <div class="col-md-12">
                @include('includes.messages')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Invoice {{ $invoice->invoice_number }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label>Organization</label>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $organizations->where('id', $invoice->organization_id)->first()?->name ?? 'N/A' }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Invoice Type</label>
                                        <input type="text" class="form-control" readonly
                                            value="{{ $invoice->type === 'sms_credits' ? 'SMS Credits' : 'Subscription' }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <label>Amount (KES) <span class="text-danger">*</span></label>
                                        <input type="number" name="amount" class="form-control"
                                            value="{{ old('amount', $invoice->amount) }}" min="1" step="0.01" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Due Date <span class="text-danger">*</span></label>
                                        <input type="date" name="due_date" class="form-control"
                                            value="{{ old('due_date', \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d')) }}" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select name="status" class="form-control" required>
                                            <option value="unpaid" {{ $invoice->status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                            <option value="paid" {{ $invoice->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="partial" {{ $invoice->status === 'partial' ? 'selected' : '' }}>Partial</option>
                                            <option value="cancelled" {{ $invoice->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <label>Description</label>
                                        <input type="text" name="description" class="form-control"
                                            value="{{ old('description', $invoice->description) }}">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-8">
                                        <button type="submit" class="btn btn-success waves-effect waves-light">
                                            Update Invoice
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
