@extends('super_admin.layouts.master')
@section('title', 'Super Admin Users')
@section('page-title', 'Super Admin Users')

@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="content container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Super Admin Users</h3>
                    <div class="card-options">
                        <a href="{{ route('super.users.create') }}" class="btn btn-sm btn-primary">
                            <i class="fe fe-plus"></i> Add User
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @include('includes.messages')
                    <table id="users-table" class="table table-striped custom-table mb-0 dt-responsive nowrap" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="width:3%">#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Created</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i = 1; @endphp
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-right">
                                @if($user->id !== auth()->id())
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <div class="dropdown-item">
                                            <form method="POST" action="{{ route('super.users.destroy', $user->id) }}"
                                                onsubmit="return confirm('Delete this user?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger btn-block">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <span class="badge badge-info">You</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">No users found</td></tr>
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
$(function() { $('#users-table').DataTable({ responsive: true, pageLength: 25, order: [[0, 'desc']] }); });
</script>
@endsection
