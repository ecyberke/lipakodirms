<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Lesa Property Agency - Preprinted Report</title>
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
        <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <img src="{{URL::asset('assets/images/les.png')}}" alt="" height="100">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <h2>Preprinted Agency Management Form | Property:{{$ten->apartment->name}} </h2>
                    <h5>Date: {{$date}}</h5>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="col-12">
                        <div class="title text-center">
                       
                            <h4></h4>
                           
                        </div>
                    </div> 
                    <div class="row">
                         <table class="table table-bordered">
                            <thead>
                              <tr class="text-center">
                                <th>#</th>
                                <th>Account Number</th>
                                <th>Phone Number</th>
                                <th>Tenant Name</th>
                                <th>Expected Monthly</th>
                                <th>Total Expected</th>
                                <th>Rent_Paid</th>
                                
                                <th>Bills_Paid</th>
                                <th>Deposit Paid</th>
                                <th>Prepaid</th>
                                <th>Outstanding Balance</th>
                              
                                {{-- <th>tenant Name</th> --}}
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($tenants as $key=>$tenant)
                                <tr>
                                <td>{{$key+=1}}</td>
                                <td>{{$tenant->tenant->account_number}}</td>
                                <td>+{{$tenant->tenant->phone}}</td>
                                <td>{{$tenant->tenant->full_name}}</td>
                                <td class="text-right">{{number_format($tenant->rent,2)}}</td>
                                <td class="text-right">{{number_format($tenant->balance,2)}}</td>
                              
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                               
                                <tr>
                                
                                <td colspan="4" >TOTALS</td>
                                <td class="text-right">{{number_format($all_rents,2)}}</td>
                                <td class="text-right">{{number_format($total_balance,2)}}</td>
                              
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                                </tr>
                                
                            </tfoot>
                          </table>
                    </div>
                    <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->
        </div>
    </div>
    <!-- END wrapper -->
</body>

</html>