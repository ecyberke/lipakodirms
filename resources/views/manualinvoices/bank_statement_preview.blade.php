@extends('layouts.master')

@section('css')
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<style>
    .matched-row { background-color: rgba(40, 167, 69, 0.06); }
    .unmatched-row { background-color: rgba(255, 193, 7, 0.08); }
    .preview-amount { font-weight: 600; color: #28a745; }
    .tenant-select { min-width: 180px; }
</style>
@endsection

@section('page-header')
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">Bank Statement Preview</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="d-flex">
                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/>
                    </svg>
                    <span class="breadcrumb-icon">Home</span>
                </a>
            </li>
            <li class="breadcrumb-item"><a href="{{ route('manualinvoice.paymentlist') }}">Payments</a></li>
            <li class="breadcrumb-item active">Import Preview</li>
        </ol>
    </div>
</div>
@endsection

@section('content')

@include('includes.messages')

<div class="row mb-3">
    <div class="col-md-3">
        <div class="card card-body py-3 text-center">
            <div class="h5 mb-0">{{ count($importData['rows']) }}</div>
            <small class="text-muted">Total Credit Rows</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-body py-3 text-center">
            <div class="h5 mb-0 text-success">{{ $matched }}</div>
            <small class="text-muted">Auto-Matched</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-body py-3 text-center">
            <div class="h5 mb-0 text-warning">{{ $unmatched }}</div>
            <small class="text-muted">Needs Assignment</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-body py-3 text-center">
            <div class="h5 mb-0">{{ number_format(collect($importData['rows'])->sum('credit'), 2) }}</div>
            <small class="text-muted">Total Credits (KES)</small>
        </div>
    </div>
</div>

<div class="alert alert-info alert-dismissible mb-3">
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    <strong><i class="fe fe-info mr-1"></i> {{ $bankLabel }} Statement</strong> &mdash;
    File: <em>{{ $importData['filename'] }}</em>.
    Rows in <span class="text-success font-weight-bold">green</span> were matched automatically.
    Rows in <span class="text-warning font-weight-bold">yellow</span> need a tenant assigned or should be skipped.
</div>

<form action="{{ route('bank-statement.confirm') }}" method="POST" id="confirmForm">
    @csrf
    <input type="hidden" name="session_key" value="{{ $sessionKey }}">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fe fe-list mr-1"></i> Credit Transactions</h3>
            <div class="card-options">
                <button type="submit" class="btn btn-success btn-sm waves-effect waves-light">
                    <i class="fe fe-check mr-1"></i> Confirm &amp; Import
                </button>
                <a href="{{ route('manualinvoice.paymentlist') }}" class="btn btn-secondary btn-sm ml-2">
                    <i class="fe fe-x mr-1"></i> Cancel
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped custom-table mb-0">
                    <thead>
                        <tr>
                            <th style="width:3%">#</th>
                            <th style="width:10%">Date</th>
                            <th style="width:28%">Description</th>
                            <th style="width:12%">Reference</th>
                            <th style="width:8%">Type</th>
                            <th style="width:10%">Amount (KES)</th>
                            <th style="width:22%">Assign Tenant</th>
                            <th style="width:7%">Skip</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($importData['rows'] as $i => $row)
                        <tr class="{{ $row['matched'] ? 'matched-row' : 'unmatched-row' }}" id="row-{{ $i }}">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $row['date'] ?? '—' }}</td>
                            <td><small>{{ Str::limit($row['description'], 65) }}</small></td>
                            <td><small class="text-muted">{{ $row['reference'] ?: '—' }}</small></td>
                            <td>
                                <span class="badge badge-secondary" style="font-size:0.71rem;">
                                    {{ $row['type_label'] }}
                                </span>
                            </td>
                            <td class="preview-amount">{{ number_format($row['credit'], 2) }}</td>
                            <td>
                                @if($row['matched'])
                                    <span class="text-success">
                                        <i class="fe fe-check-circle mr-1"></i>
                                        {{ $row['tenant_name'] }}
                                        <small class="text-muted d-block">{{ $row['tenant_account'] }}</small>
                                    </span>
                                    <input type="hidden" name="tenant_id[{{ $i }}]" value="{{ $row['tenant_id'] }}">
                                @else
                                    <select name="tenant_id[{{ $i }}]"
                                            class="form-control form-control-sm select2 tenant-select"
                                            data-row="{{ $i }}">
                                        <option value="">— Select Tenant —</option>
                                        @foreach($tenants as $tenant)
                                            <option value="{{ $tenant->id }}">
                                                {{ $tenant->firstname }} {{ $tenant->lastname }}
                                                ({{ $tenant->account_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox"
                                           class="custom-control-input skip-check"
                                           id="skip-{{ $i }}"
                                           name="skip[{{ $i }}]"
                                           value="1"
                                           data-row="{{ $i }}">
                                    <label class="custom-control-label" for="skip-{{ $i }}"></label>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-weight-bold">
                            <td colspan="5" class="text-right">Total Selected:</td>
                            <td class="text-success" id="totalAmount">
                                {{ number_format(collect($importData['rows'])->sum('credit'), 2) }}
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success waves-effect waves-light">
                <i class="fe fe-check mr-1"></i> Confirm &amp; Import
            </button>
            <a href="{{ route('manualinvoice.paymentlist') }}" class="btn btn-secondary ml-2">
                <i class="fe fe-x mr-1"></i> Cancel
            </a>
            <small class="text-muted ml-3">
                Unassigned rows are not imported. Use Reroute from the payments list to assign them later.
            </small>
        </div>
    </div>
</form>

@endsection

@section('js')
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script>
$(function() {
    $('.tenant-select').select2({ placeholder: '— Select Tenant —', allowClear: true, width: '100%' });

    $('.skip-check').on('change', function() {
        var idx = $(this).data('row');
        var row = $('#row-' + idx);
        if ($(this).is(':checked')) {
            row.css('opacity', '0.4');
            row.find('select').prop('disabled', true).trigger('change');
        } else {
            row.css('opacity', '1');
            row.find('select').prop('disabled', false);
        }
    });

    $('#confirmForm').on('submit', function(e) {
        var unassigned = 0;
        @foreach($importData['rows'] as $i => $row)
        @if(!$row['matched'])
        if (!$('#skip-{{ $i }}').is(':checked') && !$('select[name="tenant_id[{{ $i }}]"]').val()) {
            unassigned++;
        }
        @endif
        @endforeach
        if (unassigned > 0) {
            if (!confirm(unassigned + ' row(s) have no tenant assigned and will NOT be imported. Continue?')) {
                e.preventDefault();
            }
        }
    });
});
</script>
@endsection
