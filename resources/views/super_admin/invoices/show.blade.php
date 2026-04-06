@extends('super_admin.layouts.master')
@section('title', 'Invoice')
@section('page-title', 'Invoice')

@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card overflow-hidden">
                <div class="card-status bg-primary"></div>
                <div class="card-body">
                    <h2 class="text-muted font-weight-bold">INVOICE</h2>
                    @include('includes.messages')

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <img src="{{URL::asset('assets/images/lipakodi_main_logo.png')}}" alt="Lipakodi" style="height:60px;">
                            <p class="mt-2 mb-0"><strong>Lipakodi RMS</strong></p>
                            <p class="text-muted small">Rental Management System</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <h4 class="font-weight-bold">{{ $invoice->invoice_number }}</h4>
                            <p class="mb-1">
                                <strong>Status:</strong>
                                @if($invoice->status === 'paid')
                                    <span class="badge badge-success">PAID</span>
                                @elseif($invoice->status === 'partial')
                                    <span class="badge badge-warning">PARTIAL</span>
                                @elseif($invoice->status === 'overpayment')
                                    <span class="badge" style="background-color:#6f42c1;color:#fff;">OVERPAYMENT</span>
                                @elseif($invoice->status === 'cancelled')
                                    <span class="badge badge-secondary">CANCELLED</span>
                                @else
                                    <span class="badge badge-danger">UNPAID</span>
                                @endif
                            </p>
                            <p class="mb-1"><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->created_at)->format('d M Y') }}</p>
                            <p class="mb-1"><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Bill To:</h6>
                            <p class="mb-0"><strong>{{ $invoice->org_name }}</strong></p>
                            <p class="mb-0 text-muted">{{ $invoice->org_slug }}.lipakodi.co.ke</p>
                            <p class="mb-0 text-muted">{{ $invoice->org_phone }}</p>
                            <p class="mb-0 text-muted">{{ $invoice->org_email }}</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <h6 class="font-weight-bold">Invoice Type:</h6>
                            @if($invoice->type === 'sms_credits')
                                <span class="badge badge-info">SMS Credits</span>
                            @else
                                <span class="badge badge-primary">Subscription</span>
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Description</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $invoice->description ?? ($invoice->type === 'sms_credits' ? 'SMS Credits Purchase' : 'Subscription Invoice') }}</td>
                                    <td class="text-right">KES {{ number_format($invoice->amount) }}</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="text-right">Total</th>
                                    <th class="text-right">KES {{ number_format($invoice->amount) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    @if($invoice->status === 'paid')
                    <div class="alert alert-success">
                        <i class="fe fe-check-circle mr-2"></i>
                        <strong>Payment Received</strong> via {{ ucfirst($invoice->payment_method) }}
                        — Ref: {{ $invoice->payment_reference }}
                        on {{ \Carbon\Carbon::parse($invoice->paid_at)->format('d M Y') }}
                    </div>
                    @elseif($invoice->status === 'unpaid')
                    <div class="alert alert-danger">
                        <i class="fe fe-alert-triangle mr-2"></i>
                        <strong>Payment Pending</strong> — Due by {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}
                    </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <a href="{{ route('super.invoices.list') }}" class="btn btn-secondary">
                                <i class="fe fe-arrow-left mr-1"></i> Back
                            </a>
                            <a href="{{ route('super.invoices.edit', $invoice->id) }}" class="btn btn-success ml-2">
                                <i class="fe fe-edit mr-1"></i> Edit
                            </a>
                            @if($invoice->status === 'unpaid')
                            <a href="{{ route('super.invoices.pay') }}?invoice_id={{ $invoice->id }}" class="btn btn-primary ml-2">
                                <i class="fe fe-credit-card mr-1"></i> Record Payment
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
