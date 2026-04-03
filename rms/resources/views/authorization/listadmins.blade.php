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
            <div>
                <a href="{{ route('admin.create')}}" class="btn btn-success">
                    Add User</a>
            </div>
        </div>
    </div>
    <!-- /Page Header -->


<div class="card" style="padding-top:25px; padding-bottom:25px; padding-left:25px; padding-right:25px;">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">

                @include('includes.messages')
                <table class="table table-striped " >
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>User-Name</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            
                            <th style="width: 10%;">Password</th>
                            <th style="width: 10%;">Action</th>
                           
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($users as $user)
                        <tr>
                            <td>
                                {{ $user->name}}
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->user_id }}</td>
                            <td>
                                @if ($user->is_admin===1)
                                <span class="badge bg-inverse-primary">Office Manager</span>
                                @elseif ($user->is_admin===2)
                                <span class="badge bg-inverse-danger">Administrator</span>
                                @else
                                <span class="badge bg-inverse-success">Agent</span>
                                @endif
                            </td>
                            <!--<td>-->

                            <!--    <form action="{{ route('admin.toggleRole',$user->id) }}" method="post">-->
                            <!--        @csrf-->
                            <!--        @if ($user->is_admin===1)-->
                            <!--        <input type="submit" class="btn btn-success btn-sm " value="Make Agent">-->
                            <!--        @elseif($user->is_super===1 && $user->is_admin===1 )-->
                            <!--        <input type="submit" class="btn btn-secondary btn-sm" value="Make Office Manager">-->
                            <!--        @else-->
                            <!--        <input type="submit" class="btn btn-danger btn-sm" value="Make Administrator">-->
                            <!--        @endif-->
                            <!--    </form>-->



                            <!--</td>-->
                            <td>

                                 <div class="dropdown-item ">
                                                <a class="btn btn-sm btn-success btn-block" href="{{route('admin.editpassword', $user->id)}}"> Edit</a>
                                            </div>



                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-item ">
                                                <a class="btn btn-sm btn-info btn-block" href="{{route('admin.edit', $user->id)}}"> Edit</a>
                                            </div>
                                            
                                            <div class="dropdown-item ">
                                                <form action="{{ route('admin.delete',$user->id) }}" method="post" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                
                                                    <input type="submit" class="btn btn-danger btn-sm btn-block" value="Delete">
                                                </form>
                                                {{-- <a class="btn btn-sm btn-danger btn-block" href="{{route('admin.delete', $user->id)}}"> Delete</a> --}}
                                            </div>
        
                                           
                                        </div>
                                    </div>
                                </div>
                            </td>
                            {{-- <td><a href="{{ route('admin.edit',$user->id )}}" class="btn btn-info btn-sm btn-block">Edit</a></td>
                            <td>
                                <form action="{{ route('admin.delete',$user->id) }}" method="post" class="delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <input type="submit" class="btn btn-danger btn-sm btn-block" value="Delete">
                                </form>
                            </td> --}}
                        </tr>
                        @empty

                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</div>
<!-- /Page Content -->

@endsection

@push('footer_scripts')
<script>
   $(document).on('submit','.delete-form',function(event){
           return confirm(" Are you sure you want to delete this admin ? ");
   });

</script>
@endpush