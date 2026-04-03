@extends('layouts.master')

@section('content')

<!-- Page Content -->
<div class="content container-fluid">

    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="row align-items-center">
            <div class="col-9">
                {{-- <h3 class="page-title">Users</h3> --}}
                {{-- <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ul> --}}
            </div>
            <!--<div>-->
            <!--    <a href="{{ route('admin.create')}}" class="btn btn-success">-->
            <!--        Add User</a>-->
            <!--</div>-->
        </div>
    </div>
    <!-- /Page Header -->


<div class="card">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">

                @include('includes.messages')
                <table class="table table-striped custom-table mb-0">
                    <thead>
                        <tr>
                            <th style="width:40%">Notification</th>
                            <th style="width:40%">Type</th>
                            <th style="width:20%">Date</th>
                            
                           
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($service as $user)
                        <tr>
                            <td >
                                {{ $user->notification}}
                            </td>
                            <td >
                                 <a class="btn btn-sm btn-info"
            href="{{route('servicerequests.show', $user->id)}}">
                                Service Request Number {{ $user->id}}</a>
                            </td>
                            <td>{{ $user->updated_at }}</td>
                            
                        </tr>
                        @empty

                        @endforelse
                        @forelse ($bill as $user)
                        <tr>
                            <td >
                                {{ $user->notification}}
                            </td>
                            <td >
                                 <a class="btn btn-sm btn-info"
            href="{{route('payowner.show', $user->id)}}">
                                Bill Number {{ $user->id}}</a>
                            </td>
                            <td>{{ $user->updated_at }}</td>
                            
                        </tr>
                        @empty

                        @endforelse
                        @forelse ($managerpayment as $user)
                        <tr>
                            <td >
                                @if ($user->status == 0)
                               The payment is awaiting approval
                               @elseif($user->status == 1)
                               The payment has been approved
                               @else
                               The payment has been rejected, should be deleted
                               @endif
                            </td>
                            <td >
                                @if($user->status == 0)
                                 <a class="btn btn-sm btn-info"
            href="{{route('managerpayment.edit', $user->id)}}">
                                Pending Payment - Edit Payment</a>
                                @elseif($user->status == 1)
                                <a class="btn btn-sm btn-success"
            href="#">
                                Authorized Payment - Approved</a>
                                @else
                                <a class="btn btn-sm btn-danger"
            href="{{route('managerpayment.delete', $user->id)}}">
                                Rejected Payment - Delete</a>
                                @endif
                            </td>
                            <td>{{ $user->updated_at }}</td>
                            
                        </tr>
                        @empty

                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div></div>
<!-- /Page Content -->

@endsection

@push('footer_scripts')
<script>
   $(document).on('submit','.delete-form',function(event){
           return confirm(" Are you sure you want to delete this admin ? ");
   });

</script>
@endpush