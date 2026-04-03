<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
<script type="text/javascript">
    $(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
  });
</script>
@extends('layouts.home')
@push('header_scripts')
<!-- Datetimepicker CSS -->
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css')}}">

@endpush

@section('content')

<div class="content container-fluid">

    {{-- <div class="row ">
        <div class="col-sm-6">
            <h4 class="page-title">Add New Apartment</h4>
        </div>
    </div> --}}

    <!-- end row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    {{-- <h4 class="mt-0 header-title">Property Information </h4> --}}
                    {{-- <p class="text-muted m-b-30 font-14">After adding new property, proceed to define houses where tenents will live.
                    
                    </p> --}}
                    <div class="col-12">
                        @include('includes.messages')
                    </div>
                    <div class="p-20">
                        <form action="{{route('incomes.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Income Source <span class="text-danger">*</span></label>
                                        <div>
                                            <input class="form-control" type="text" id="example-text-input" name="source"
                                            value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Amount <span class="text-danger">*</span></label>
                                        <div>
                                            <input class="form-control" type="text" id="example-text-input" name="amount"
                                        placeholder="" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Income Description <span class="text-danger">*</span></label>
                                        <div>
                                            <input class="form-control" type="text" id="example-text-input" name="description"
                                        value="{{old('description')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Income Date <span class="text-danger">*</span></label>
                                        <div>
                                            <div class="form-group">
                                                <div class="cal-icon">
                                                    <input class="form-control datetimepicker" type="text" name="income_date"
                                            value="">
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 ">
                                    <button type="submit" class="btn btn-success mr-3">Add Income
                                    </button>

                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>
@endsection

@push('footer_scripts')
<script>
    

    $(function () {
        $('#datetimepicker10').datetimepicker({
            viewMode: 'years',
            format: 'MM/YYYY'
        });
    });

    

</script>
@endpush
