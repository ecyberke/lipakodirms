@extends('layouts.master')
<style>
    
.section-title {
    font-family: Rubik, Helvetica, Arial, serif;
    letter-spacing: 1px;
    margin: 1.2rem 0 .5rem;
    color: #BAC0C7;
    font-size: 1.8rem;
    font-weight: 500;
}

</style>
<link href="{{ asset('assets/fontawesom-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
@section('content')
<div class="content container-fluid">
    <div class="row">
        
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-header">Deleted Houses</p>
                </div>
                
                <div class="card-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">House Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Description</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($houses as $key=>$house)
                      <tr>
                        <th scope="row">{{$key+=1}}</th>
                      <td>{{$house->house_no}}</td>
                      <td>{{$house->house_type}}</td>
                      <td>{{$house->description}}</td>
                      <td>{{$house->deleted_at}}</td>
                        <td class="text-center">
                            <form method="POST" action="{{ url('softdeletes/restore/'.$house->id.'/House') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                            <form method="POST" action="{{ url('softdeletes/delete/'.$house->id.'/House') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                            </form>
                            
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            
            
                </div>
            
                </div>
            
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-header">Deleted Invoices</p>
                </div>
                
                <div class="card-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Invoice Number</th>
                        <th scope="col">Tenant</th>
                        <th scope="col">Type</th>
                        <th scope="col">Amount Payable</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $key=>$house)
                      <tr>
                        <th scope="row">{{$key+=1}}</th>
                      <td>INV00{{$house->id}}</td>
                      <td>{{$house->tenant_name}}</td>
                      <td>{{$house->type}}</td>
                      <td>{{$house->total_payable}}</td>
                      <td>{{$house->deleted_at}}</td>
                        <td class="text-center">
                            <form method="POST" action="{{ url('softdeletes/restore/'.$house->id.'/Invoice') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                            <form method="POST" action="{{ url('softdeletes/delete/'.$house->id.'/Invoice') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                            </form>
                            
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            
            
                </div>
            
                </div>
            
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-header">Deleted Landlords</p>
                </div>
                
                <div class="card-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">telephone</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($landlords as $key=>$house)
                      <tr>
                        <th scope="row">{{$key+=1}}</th>
                      <td>{{$house->full_name}}</td>
                      <td>{{$house->id}}</td>
                      <td>{{$house->deleted_at}}</td>
                        <td class="text-center">
                            <form method="POST" action="{{ url('softdeletes/restore/'.$house->id.'/Landlord') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                            <form method="POST" action="{{ url('softdeletes/delete/'.$house->id.'/Landlord') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                            </form>
                            
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            
            
                </div>
            
                </div>
            
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-header">Deleted Apartments</p>
                </div>
                
                <div class="card-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Location</th>
                        <th scope="col">Landlord Phone</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($apartments as $key=>$house)
                      <tr>
                        <th scope="row">{{$key+=1}}</th>
                      <td>{{$house->name}}</td>
                      <td>{{$house->type}}</td>
                      <td>{{$house->location}}</td>
                      <td>{{$house->landlord_id}}</td>
                      <td>{{$house->deleted_at}}</td>
                        <td class="text-center">
                            <form method="POST" action="{{ url('softdeletes/restore/'.$house->id.'/Apartment') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                            <form method="POST" action="{{ url('softdeletes/delete/'.$house->id.'/Apartment') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                            </form>
                            
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            
            
                </div>
            
                </div>
            
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-header">Deleted Tenants</p>
                </div>
                
                <div class="card-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Telephone</th>
                        <th scope="col">Account Number</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($tenants as $key=>$house)
                      <tr>
                        <th scope="row">{{$key+=1}}</th>
                      <td>{{$house->full_name}}</td>
                      <td>{{$house->id}}</td>
                      <td>{{$house->account_number}}</td>
                      <td>{{$house->deleted_at}}</td>
                        <td class="text-center">
                            <form method="POST" action="{{ url('softdeletes/restore/'.$house->id.'/Tenant') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                            <form method="POST" action="{{ url('softdeletes/delete/'.$house->id.'/Tenant') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                            </form>
                            
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            
            
                </div>
            
                </div>
            
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-header">Deleted Users</p>
                </div>
                
                <div class="card-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $key=>$house)
                      <tr>
                        <th scope="row">{{$key+=1}}</th>
                      <td>{{$house->name}}</td>
                      <td>{{$house->email}}</td>
                      <td>{{$house->deleted_at}}</td>
                        <td class="text-center">
                            <form method="POST" action="{{ url('softdeletes/restore/'.$house->id.'/User') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                            <form method="POST" action="{{ url('softdeletes/delete/'.$house->id.'/User') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                            </form>
                            
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            
            
                </div>
            
                </div>
            
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-12">
            <div class="card p-2">
                <div class="card-header">Deleted Bills</p>
                </div>
                
                <div class="card-body">
              
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Type</th>
                        <th scope="col">Description</th>
                        <th scope="col">Total Owned</th>
                        <th scope="col">Deleted At</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($bills as $key=>$house)
                      <tr>
                        <th scope="row">{{$key+=1}}</th>
                      <td>{{$house->type}}</td>
                      <td>{{$house->description}}</td>
                      <td>{{$house->total_owned}}</td>
                      <td>{{$house->deleted_at}}</td>
                        <td class="text-center">
                            <form method="POST" action="{{ url('softdeletes/restore/'.$house->id.'/PayOwners') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Restore</button>
                            </form>
                            <form method="POST" action="{{ url('softdeletes/delete/'.$house->id.'/PayOwners') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Delete Permanently</button>
                            </form>
                            
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
            
            
                </div>
            
                </div>
            
        </div>
    </div>
	

</div>
@endsection