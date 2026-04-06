@extends('super_admin.layouts.master')
@section('title', 'Connections')
@section('page-title', 'Connections')

@section('content')
<div class="content container-fluid">
    <form method="POST" action="{{ route('super.connections.update') }}">
        @csrf
        <div class="row">
            {{-- Bulk SMS --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <svg class="side-menu__icon mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            Bulk SMS
                        </h4>
                        <div class="card-options">
                            @if($settings?->sms_api_token)
                                <span class="badge badge-success"><i class="fe fe-check"></i> Active</span>
                            @else
                                <span class="badge badge-secondary">Not Configured</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @include('includes.messages')
                        <div class="form-group">
                            <label>Sender ID <span class="text-danger">*</span></label>
                            <input type="text" name="sms_sender_id" class="form-control"
                                placeholder="e.g. SaliSystems" value="{{ $settings?->sms_sender_id }}">
                        </div>
                        <div class="form-group">
                            <label>Admin Phone <span class="text-danger">*</span></label>
                            <input type="text" name="sms_admin_phone" class="form-control"
                                placeholder="e.g. 254700000000" value="{{ $settings?->sms_admin_phone }}">
                        </div>
                        <div class="form-group">
                            <label>API Key <span class="text-danger">*</span></label>
                            <input type="text" name="sms_api_token" class="form-control"
                                placeholder="Bearer Token" value="{{ $settings?->sms_api_token }}">
                            <small class="text-muted">Used for subscription expiry, payment confirmation and renewal reminders</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- M-Pesa --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <svg class="side-menu__icon mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                            M-Pesa Paybill
                        </h4>
                        <div class="card-options">
                            @if($settings?->mpesa_consumer_key && $settings?->mpesa_shortcode)
                                <span class="badge badge-success"><i class="fe fe-check"></i> Active</span>
                            @else
                                <span class="badge badge-secondary">Not Configured</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Shortcode <span class="text-danger">*</span></label>
                            <input type="text" name="mpesa_shortcode" class="form-control"
                                placeholder="Paybill/Till Number" value="{{ $settings?->mpesa_shortcode }}">
                        </div>
                        <div class="form-group">
                            <label>Consumer Key <span class="text-danger">*</span></label>
                            <input type="text" name="mpesa_consumer_key" class="form-control"
                                placeholder="Consumer Key" value="{{ $settings?->mpesa_consumer_key }}">
                        </div>
                        <div class="form-group">
                            <label>Consumer Secret <span class="text-danger">*</span></label>
                            <input type="text" name="mpesa_consumer_secret" class="form-control"
                                placeholder="Consumer Secret" value="{{ $settings?->mpesa_consumer_secret }}">
                        </div>
                        <div class="form-group">
                            <label>Pass Key <span class="text-danger">*</span></label>
                            <input type="text" name="mpesa_passkey" class="form-control"
                                placeholder="Pass Key" value="{{ $settings?->mpesa_passkey }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-sm-8">
                <button type="submit" class="btn btn-success waves-effect waves-light">
                    <i class="fe fe-save"></i> Save Connections
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
