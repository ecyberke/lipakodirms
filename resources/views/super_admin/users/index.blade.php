@extends('super_admin.layouts.master')
@section('title', 'Super Admin Users')
@section('page-title', 'Super Admin Users')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="content container-fluid">
    <div class="card" style="padding-top:25px;padding-bottom:25px;padding-left:25px;padding-right:25px;">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    @include('includes.messages')
                    <table class="table table-striped custom-table mb-0" id="users-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Created</th>
                                <th style="width:10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="text-center">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            @if($user->id !== auth()->id())
                                            <div class="dropdown-item">
                                                <form method="POST" action="{{ route('super.users.destroy', $user->id) }}"
                                                    class="delete-form">
                                                    @csrf @method('DELETE')
                                                    <input type="submit" class="btn btn-sm btn-danger btn-block" value="Delete">
                                                </form>
                                            </div>
                                            @else
                                            <div class="dropdown-item">
                                                <span class="badge badge-info btn-block text-center">Current User</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted">No users found</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script>
$(function() {
    $('#users-table').DataTable({ responsive: true, pageLength: 25 });
    $(document).on('submit', '.delete-form', function() {
        return confirm('Are you sure you want to delete this user?');
    });
});
</script>
@endsection
