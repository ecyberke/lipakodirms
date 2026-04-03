<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>LIA Invoices</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    {{-- <link href=" {{ asset('assets/css/invoice_bootstrap.min.css') }} " rel="stylesheet" type="text/css" /> --}}
    <link href=" {{ asset('assets/css/invoice_style.css') }} " rel="stylesheet" type="text/css" />
</head>

<body>
    <!-- Begin page -->
    <div id="wrapper">
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-box">
                                <!-- Logo & title -->
                                <div class="clearfix">
                                    <div class="float-left">
                                         <img src="{{URL::asset('assets/images/les.png')}}" alt="Lesa Logo" height="100">
                                    </div>
                                    <div class="float-right">
                                        {{-- <h3 class="m-0 d-print-none">Invoice</h3> --}}
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                      

                                    </div><!-- end col -->
                                    <div class="col-xs-4 offset-xs-2 float-right" style="float:right;text-align:right;">
                                        <div class="mt-3 float-right">
                                            <p class="m-b-10"><strong>Generated On : </strong> <span
                                                    class="float-right">
                                                    {{$invoice->created_at }}</span></p>
                                            <!--<p class="m-b-10"><strong>Invoice Due Date : </strong> <span-->
                                            <!--        class="float-right" style="color: red;">-->
                                                   <!--5th {{ \Carbon\Carbon::createFromFormat('M-Y',$invoice->rent_month)->format('M-Y') }}</span></p>-->
                                            <p class="m-b-10"><strong>Payment Status : </strong>
                                                <span
                                                class="float-right">
                                                    @if ($invoice->is_paid===1)
                                                    <span style="color: seagreen;">Paid</span>
                                                    @elseif ($invoice->is_paid===0 && $invoice->paid_in > 0 )
                                                    <span style="color: orange;">Partial Payment</span>
                                                    @else
                                                    <span style="color: red;">Unpaid</span>
                                                    @endif
                                                    
                                   



                                                </span></p>
                                            <p class="m-b-10"><strong>Invoice No. : </strong> <span
                                                    class="float-right" style="color: royalblue;">#{{ $invoice->id}} </span></p>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                              <div class="row mt-3">
                                    <div class="col-xs-4">
                                        <p><b>Tenant Details</b> </p>
                                        <address>
                                            Name: @if($invoice->tenant_id > 0)
                                              {{ $invoice->tenant->full_name}}
                                              @else
                                              {{ $invoice->tenant_name}}
                                              @endif <br>
                                             
                                      
                                       
                                        Phone Number: @if($invoice->tenant_id > 0)
                                              +{{ $invoice->tenant->phone}}
                                              @elseif ($invoice->tenant_phone > 0)
                                              +{{ $invoice->tenant_phone}}
                                              @else
                                              <span class="text-danger "> NO PHONE </span>
                                              @endif<br>
                                               Account Number: @if($invoice->tenant_id > 0)
                                              {{ $invoice->tenant->account_number}}
                                              @else
                                             <span class="text-danger "> NO ACCOUNT NUMBER </span>
                                              @endif<br>
                                          
                                        </address>
                                    </div> <!-- end col -->

                                    <div class="col-xs-6">
                                        <p><b>House Details</b> </p>
                                        <address>
                                           
                                           <li>House:  @if($invoice->house_id > 0)
                                            <span class="text-success "> {{$invoice->house->house_no}} </span>
                                            
                                            @else
                                            <span class="text-success "> NO HOUSE </span>
                                            
                                            @endif
                                </li>
                                <li>Property: 
                                            @if($invoice->apartment_id > 0)
                                            <span class="text-success"> {{$invoice->house->apartment->name}} </span>
                                            
                                            @else
                                            <span class="text-success "> NO APARTMENT </span>
                                            
                                            @endif
                                </li>
                                <li>Property Type: 
                                            @if($invoice->house_id > 0)
                                            <span class="text-success "> {{$invoice->house->house_type}} </span>
                                            
                                            @else
                                            <span class="text-success"> NO TYPE INDICATED </span>
                                            
                                            @endif </li>
                             
                                                                       
                                        </address>
                                    </div> <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table mt-4 table-centered">
                                                <thead>
                                                    <tr>
                                                      
                                                        <th>Bill Description</th>
                                                        <th style="width: 30%" class="text-right">Total</th>
                                                    </tr>
                                                </thead>
                                                 <tbody>
                                  @if($invoice->type == 'Monthly Rent' || $invoice->type == 'rent and deposit' )
                                @if($invoice->rent > 0)
                                <tr>
                              
                                    <td class="d-none d-sm-table-cell"> House Rent </td>
                                    <td class="text-right">Ksh {{ number_format($invoice->rent)}}</td>
                                </tr>
                                @endif
                                @if($invoice->deposit_paid > 0)
                                <tr>
                                
                                   
                                    <td class="d-none d-sm-table-cell"> Deposit </td>
                                    <td class="text-right">Ksh {{ number_format($invoice->deposit_paid)}}</td>
                                </tr>
                                @endif
                                @if($invoice->carryforward > 0)
                                <tr>
                                
                                   
                                    <td class="d-none d-sm-table-cell"> Arrears </td>
                                    <td class="text-right">Ksh {{ number_format($invoice->carryforward)}}</td>
                                </tr>
                                @endif
                                @if($invoice->electricity_bill > 0)
                                <tr>
                                
                                   
                                    <td class="d-none d-sm-table-cell"> Electricity Bill </td>
                                    <td class="text-right">Ksh {{ number_format($invoice->electricity_bill)}}</td>
                                </tr>
                                @endif
                                @if($invoice->water_bill > 0)
                                <tr>
                                
                                   
                                    <td class="d-none d-sm-table-cell"> Water Bill </td>
                                    <td class="text-right">Ksh {{ number_format($invoice->water_bill)}}</td>
                                </tr>
                                @endif
                                @if($invoice->litter_bill > 0)
                                <tr>
                                
                                   
                                    <td class="d-none d-sm-table-cell"> Litter Bill </td>
                                    <td class="text-right">Ksh {{ number_format($invoice->litter_bill)}}</td>
                                </tr>
                                @endif
                                @if($invoice->compound_bill > 0)
                                <tr>
                                
                                   
                                    <td class="d-none d-sm-table-cell"> Compound Maintenance Bill </td>
                                    <td class="text-right">Ksh {{ number_format($invoice->compound_bill)}}</td>
                                </tr>
                                @endif
                                @if($invoice->security > 0)
                                <tr>
                                
                                   
                                    <td class="d-none d-sm-table-cell"> Security Bill </td>
                                    <td class="text-right">Ksh {{ number_format($invoice->security)}}</td>
                                </tr>
                                @endif
                                @if($invoice->other_bill > 0)
                                <tr>
                                
                                   
                                    <td class="d-none d-sm-table-cell"> Other Bills </td>
                                    <td class="text-right">Ksh {{ number_format($invoice->other_bill)}}</td>
                                </tr>
                                @endif
                                
                                
                                
                               
                                 
                            
                                
                                    
                                   
                               
                          
                                
                               
                                
                                @else
                                <tr>
                                   
                                     @if($invoice->type === 'placement')
                                    <td class="d-none d-sm-table-cell">Placement Fee</td>
                                    @elseif($invoice->type === 'management')
                                    <td class="d-none d-sm-table-cell">Management Fee</td>
                                    @elseif($invoice->type === 'viewing')
                                     <td class="d-none d-sm-table-cell">Viewing Fee</td>
                                     @else
                                     <td class="d-none d-sm-table-cell">Others - {{$invoice->description}}</td>
                                      @endif
                                    <td class="text-right">Ksh {{ number_format($invoice->total_payable)}}</td>
                                </tr>
                                 @endif
                                

                                @php
                                $count=3;
                                @endphp
                            </tbody>
                        </table>
                                            </table>
                                        </div> <!-- end table-responsive -->
                                    </div> <!-- end col -->
                                </div>
                                <br/>
                   
                    
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-xs-9">
                                        <div class="clearfix pt-5">
                                            <h6 class="text-muted">Notes:</h6>

                                            <small class="text-muted">
                                                To be paid by  MPesa Paybill Number <b>743994</b>.<br>
                                                The invoiced tenant has a balance of <strong>Ksh {{number_format($invoice->balance)}}<</strong> <br />
                                            
                                            </small>
                                        </div>
                                        
                                    </div> <!-- end col -->
                                    <div class="col-xs-3  float-right" style="float:right;text-align:right;">
                                        <div class="mt-3 float-right">
                                            <p class="m-b-10"><b>Sub-total:</b> <span class="float-right">Ksh
                                                        {{ number_format($invoice->total_payable)  }}</span></p>
                                            <!--<p class="m-b-10"><b>Tax:</b> <span class="float-right"> Ksh 0.00</span></p> <hr>-->
                                            
                                            <p class="m-b-10"><b>Total Paid:</b> <span class="float-right"> Ksh {{number_format($invoice->paid_in)}} </span></p>
                                            <p class="m-b-10"><b>Balance:</b> <span class="float-right"> Ksh {{number_format($invoice->balance)}} </span></p>
                                        </div>
                                    </div>
                                    {{-- <div  class="col-xs-3 offset-xs-2">
                                        <div class="mt-3 float-right">
                                        <div class="float-right">
                                            
                                        </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div> <!-- end col --> --}}
                                </div>
                                <!-- end row -->
                            </div> <!-- end card-box -->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->
        </div>
    </div>
    <!-- END wrapper -->
</body>

</html>