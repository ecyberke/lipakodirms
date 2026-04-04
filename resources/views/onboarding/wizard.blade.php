@extends('layouts.master')
@section('page-header')
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">Setup Wizard</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Setup Wizard</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<!-- Progress -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">Overall Progress</h5>
                    <span class="badge badge-primary">{{ $completedSteps }}/{{ $totalSteps }} Steps Complete</span>
                </div>
                <div class="progress mb-3" style="height: 10px; border-radius: 10px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progressPercent }}%; border-radius: 10px;">
                        {{ $progressPercent }}%
                    </div>
                </div>
                @if($nextStep)
                <div class="alert alert-info mb-0">
                    <i class="fe fe-arrow-right"></i> <strong>Next Step:</strong> {{ $nextStep['title'] }}
                    <a href="{{ route($nextStep['route']) }}" class="btn btn-sm btn-primary ml-3">Start Now</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Section 1: Onboard Property -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fe fe-briefcase text-primary"></i> Onboard Property
                </h4>
                <p class="text-muted mb-0">Set up your property and owner details</p>
            </div>
            <div class="card-body">
                @foreach($steps as $num => $step)
                @if($step['section'] === 'property')
                <div class="d-flex align-items-center p-3 mb-3 rounded" 
                    style="background: {{ $step['completed'] ? '#f0f4ff' : '#fffbf0' }}; border: 1px solid {{ $step['completed'] ? '#b8cef5' : '#ffeaa7' }};">
                    <div class="mr-3" style="width:45px;height:45px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:{{ $step['completed'] ? '#1A4FA8' : '#F47920' }};">
                        <i class="{{ $step['icon'] }} text-white" style="font-size:1.1rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Step {{ $num }}: {{ $step['title'] }}</strong><br>
                                <small class="text-muted">{{ $step['description'] }}</small>
                            </div>
                            <div class="ml-3">
                                @if($step['completed'])
                                    <span class="badge badge-primary">
                                        <i class="fe fe-check"></i> Done ({{ $step['count'] }})
                                    </span><br>
                                    <a href="{{ route($step['route']) }}" class="btn btn-sm btn-outline-primary mt-1">Add More</a>
                                @else
                                    <a href="{{ route($step['route']) }}" class="btn btn-sm btn-primary">Start</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- Section 2: Onboard Tenant -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fe fe-users text-success"></i> Onboard Tenant
                </h4>
                <p class="text-muted mb-0">Add tenants and assign them to units</p>
            </div>
            <div class="card-body">
                @foreach($steps as $num => $step)
                @if($step['section'] === 'tenant')
                <div class="d-flex align-items-center p-3 mb-3 rounded"
                    style="background: {{ $step['completed'] ? '#f0f4ff' : '#fffbf0' }}; border: 1px solid {{ $step['completed'] ? '#b8cef5' : '#ffeaa7' }};">
                    <div class="mr-3" style="width:45px;height:45px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:{{ $step['completed'] ? '#1A4FA8' : '#F47920' }};">
                        <i class="{{ $step['icon'] }} text-white" style="font-size:1.1rem;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Step {{ $num }}: {{ $step['title'] }}</strong><br>
                                <small class="text-muted">{{ $step['description'] }}</small>
                            </div>
                            <div class="ml-3">
                                @if($step['completed'])
                                    <span class="badge badge-primary">
                                        <i class="fe fe-check"></i> Done ({{ $step['count'] }})
                                    </span><br>
                                    <a href="{{ route($step['route']) }}" class="btn btn-sm btn-outline-primary mt-1">Add More</a>
                                @else
                                    <a href="{{ route($step['route']) }}" class="btn btn-sm btn-primary">Start</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
@if($completedSteps > 0)
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><i class="fe fe-bar-chart-2"></i> Quick Overview</h4>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    @foreach($steps as $step)
                    @if($step['completed'])
                    <div class="col-md-2 col-4 mb-3">
                        <h4 class="text-primary mb-1">{{ $step['count'] }}</h4>
                        <small class="text-muted">{{ $step['title'] }}</small>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
