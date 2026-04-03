<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Lesa Property Agency - {{$report_title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    {{-- <link href=" {{ asset('assets/css/invoice_bootstrap.min.css') }} " rel="stylesheet" type="text/css" /> --}}
    <link href=" {{ asset('assets/css/invoice_style.css') }} " rel="stylesheet" type="text/css" />
    
    <style>
.table-hover th, .table-hover td {
    padding: 0;
}
.table-info{
    background-color: #86cfda;
}
</style>
</head>

<body>
    <!-- Begin page -->
    <div id="wrapper">
        <div class="row">
            <div class="col-12">
                <div class="title text-center">
                    <h2>{{$report_title}}</h2>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="content">
                <!-- Start Content-->
                <div class="container-fluid">
                     <div class="row">
                        <div class="col-xs-6  float-right" style="float:right;text-align:right;">
                            <div class="mt-3 float-right">
                                <img src="{{URL::asset('assets/images/les.png')}}" alt="" height="100">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-hover">
                            <thead>
                              <tr>
                                 @foreach($columns as $column)
                                 <th>{{$column['label']}}</th>
                                @endforeach
                              </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $dt)
                              <tr>
                                @foreach($columns as $column)
                                 <td>{{$dt[$column['id']]}}</td>
                                @endforeach
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                    </div>

                </div> <!-- container -->

            </div> <!-- content -->
        </div>
    </div>
    <!-- END wrapper -->
</body>

</html>