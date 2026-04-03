@extends('layouts.master')

@push('header_scripts')
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css')}}">

@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4 d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Bills</h3>
            </div>
            <div class="col-auto float-right ml-auto">
                
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <div class="row myinvoice">
        <div class="col-md-12">
            <div class="card px-5">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6 m-b-20">
                            <img src="assets/img/lesa.png" class="inv-logo" alt="">
                           
                            <div class="row mt-3">
                                <div class="col-sm-4">
                                    
                                </div> <!-- end col -->

                               <!-- end col -->
                            </div>
                        </div>
                        <div class="col-sm-6 m-b-20">
                            <div class="invoice-details">
                                <h3 class="text-uppercase text-blue">Bill #-{{ $payowners->id}}</h3>
                                <ul class="list-unstyled">
                                    <li>Date: <span>{{$payowners->created_at }}</span></li>
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-lg-7 col-xl-8 m-b-20">
                            <h5>Bill from:</h5>
                            <ul class="list-unstyled">
                                <li>
                                    <h5><strong>
                                    @if ($payowners->apartment_id > 0 && $payowners->type == 'Rent Collection')
                                    {{ $payowners->apartment->landlord->full_name}}
                                    @else
                                    Lesa International Agencies
                                    @endif
                                    </strong></h5>
                                </li>
                                <li>
                                    @if ($payowners->apartment_id > 0 && $payowners->type == 'Rent Collection')
                                   {{ $payowners->apartment->landlord->phone_no}}
                                    @else
                                    
                                    @endif
                                    </li>
                                <li class="text-blue">
                                    @if ($payowners->apartment_id > 0 && $payowners->type == 'Rent Collection')
                                   {{ $payowners->apartment->landlord->email}}
                                    @else
                                    business@lesaagecies.co.ke
                                    @endif
                                    </li>
                                
                            </ul> 
                        </div>
                        <div class="col-sm-6 col-lg-5 col-xl-4 m-b-20">
                            <span class="text-muted">Billing Details:</span>
                            <ul class="list-unstyled invoice-payment-details">
                                <li>
                                    <h5>Total Balance: <span class="text-right font-weight-bold">Ksh
                                            {{ number_format($payowners->balance)  }}</span>
                                    </h5>
                                </li>
                                
                                <li>Property: <span>@if ($payowners->apartment_id > 0)
                                   {{ $payowners->apartment->name }}
                                    @else
                                    Lesa Agencies
                                    @endif</span></li>
                               
                                <li>Status:
                                    @if ($payowners->pay_status===1)
                                    <span class="text-success font-weight-bold"> PAID </span>
                                    @else
                                    <span class="text-danger font-weight-bold"> UNPAID </span>
                                    @endif



                            </ul>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="d-none d-sm-table-cell">DESCRIPTION</th>
                                    <th class="text-right">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr>
                                    <td>1</td>
                                    @if($payowners->type == 'Rent Collection')
                                    <td class="d-none d-sm-table-cell"> Rent Collection </td>
                                    
                                    @elseif($payowners->type == '--select--')
                                    <td class="d-none d-sm-table-cell"> {{$payowners->new_type}}</td>
                                    
                                    @elseif($payowners->type != 'Rent Collection' && $payowners->type != '--select--')
                                    <td class="d-none d-sm-table-cell"> {{$payowners->type}} </td>
                                    
                                    @endif
                                    <td class="text-right">Ksh {{ number_format($payowners->total_owned)}}</td>
                                </tr>
                               

                                
                            </tbody>
                        </table>
                    </div>
                    @if($payowners->proof)
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{asset('rms/storage/app/agency_files/'.$payowners->proof)}}" target="_blank" class="btn btn-primary btn-sm">View Doc</a>
                        </div>
                    </div>
                    @endif
                    <div>
                        <div class="row invoice-payment">
                            <div class="col-sm-7">
                            </div>
                            <div class="col-sm-5">
                                <div class="m-b-20">
                                    <div class="table-responsive no-border">
                                        <table class="table mb-0">
                                            <tbody>
                                                <tr>
                                                    <th>Subtotal:</th>
                                                    <td class="text-right">Ksh.
                                                        {{ number_format($payowners->total_owned)  }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Total Paid:</th>
                                                    <td class="text-right text-info text-bold">
                                                        Ksh.
                                                            {{ number_format($payowners->paid_in)}}
                                                        
                                                    </td>
                                                </tr>
                                             <tr>
                                                    <th>Balance: <span class="text-regular"></span></th>
                                                    <td class="text-right text-info text-bold">Ksh {{number_format($payowners->balance) }}</td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
@endsection
