<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Lesa Property Agency - All Tenants</title>
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
                    <h2>Tenant Account Numbers</h2>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="col-12">
                        <div class="title text-center">
                                <div class="mt-3 float-right">
                                    <img src="{{URL::asset('assets/images/les.png')}}" alt="" height="100">
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>Account Number</th>
                                <th>Name</th>
                                <th>telephone</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($tenants as $tenant)
                                <tr>
                                <th>{{$tenant->account_number}}</th>
                                    <th>{{$tenant->full_name}}</th>
                                    <th>{{$tenant->id}}</th>
                                </tr>
                                @endforeach
                            </tbody>
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