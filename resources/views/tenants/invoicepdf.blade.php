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
                                         <img src="https://rms.lesaagencies.co.ke/assets/images/lesa.png" alt="Lesa Logo" height="100">
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
                                            <p class="m-b-10"><strong>Payment Status : </strong>
                                                <span
                                                class="float-right">
                                                    @if ($invoice->status===1)
                                                    <span style="color: seagreen;">Paid</span>
                                                    @elseif ($invoice->status===0 && $invoice->paid_in > 0 )
                                                    <span style="color: orange;">Partial Payment</span>
                                                    @else
                                                    <span style="color: red;">Unpaid</span>
                                                    @endif
                                                    
                                   



                                                </span></p>
                                            <p class="m-b-10"><strong>Bill No. : </strong> <span
                                                    class="float-right" style="color: royalblue;">#{{ $invoice->id}} </span></p>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                                <!-- end row -->

                              <div class="row mt-3">
                                    <div class="col-xs-4">
                                        <p><b>Tenant Details</b> </p>
                                        <address>
                                    
                                             Name: {{ $invoice->tenant_name}}
                                              <br>
                                             
                                      
                                       
                                        Phone Number: +{{ $invoice->tenant->phone}}
                                             <br>
                                               Account Number:{{ $invoice->tenant->account_number}}
                                             <br>
                                          
                                        </address>
                                    </div> <!-- end col -->

                                    <div class="col-xs-6">
                                        <p><b>House Details</b> </p>
                                        <address>
                                           
                                           <li>House:
                                            <span class="text-success "> {{$invoice->house->house_no}} </span>
                                            
                                </li>
                                <li>Property:
                                            <span class="text-success"> {{$invoice->house->apartment->name}} </span>
                                          
                                </li>
                                <li>Property Type:
                                            <span class="text-success "> {{$invoice->house->house_type}} </span>
                                            </li>
                             
                                                                       
                                        </address>
                                    </div> <!-- end col -->
                                </div>
                                <!-- end row -->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover text-nowrap">
											    
												<tr>
                                   
                                    <th class="d-none d-sm-table-cell">DESCRIPTION</th>
                                    <th class="text-right">TOTAL</th>
                                </tr>
                                
                                <tr>
                              
                                    <td class="d-none d-sm-table-cell"> Deposit Amount </td>
                                    <td class="text-right">Ksh {{ number_format($invoice->deposit_amount )}} </td>
                                </tr>
                                @if($invoice->total_repair_amount > 0)
                                <tr>
                                
                                   
                                    <td class="d-none d-sm-table-cell"> Repairs </td>
                                    <td class="text-right">Ksh {{ number_format($invoice->total_repair_amount)}}</td>
                                </tr>
                                @endif
                               
                               
                                

                                @php
                                $count=3;
                                @endphp

                               
												
												
											
											
                                
                                                <tr>
                                                   	<td colspan="1" class="font-weight-bold text-uppercase text-right h5 mb-0">Sub Total</td>
                                                    <td class="text-right">Ksh
                                                        {{ number_format($invoice->deposit_amount - $invoice->total_repair_amount  )  }} 
                                                    </td>
                                                </tr>
                                                <tr>
                                                   	<td colspan="1" class="font-weight-bold text-uppercase text-right h5 mb-0">Total Paid</td>
                                                    @if($invoice->paid_in === null)
                                                    <td class="text-right text-danger text-bold">Ksh. 0
                                                    </td>
                                                    @else
                                                    <td class="text-right text-success text-bold">Ksh.{{ number_format($invoice->paid_in - $invoice->total_repair_amount  )  }}
                                                    </td>
                                                    @endif
                                                </tr>
                                                
                                             <tr>
													<td colspan="1" class="font-weight-bold text-uppercase text-right h5 mb-0">Total Due</td>
													@if($invoice->balance === null)
													<td class="text-right text-danger text-bold">Ksh {{number_format($invoice->deposit_amount - $invoice->total_repair_amount )}}</td>
													@else
													<td class="text-right text-danger text-bold">Ksh {{number_format($invoice->balance)}}</td>
													@endif
												</tr>
                                    			
												<tr>
												    
													<td colspan="5" class="text-right">
													</td>
												</tr>
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
                                           
                                        </div>
                                        
                                    </div> <!-- end col -->
                                   
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
