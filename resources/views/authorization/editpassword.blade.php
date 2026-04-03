@extends('layouts.master')

@section('content')<br><br>
<div class="content container-fluid">
    <form action="{{ route('admin.updatepass',$user->id ) }}" method="post">
        @csrf
        @method('PUT')
              
                               
            <div class="row">
    
    
                <div class="col-10">
                    <div class="card">
                        <div class="card-body">
                            <!--<h4 class="mt-0 header-title mb-4">Update User Details</h4>-->
    
                            <!--<hr class="mt-2 mb-4">-->
                            @include('includes.messages')
    
                          
                            
                            <div class="row">
                                <div class="col-sm-6">
                                <label >New Password</label>
                                
                                    <div class="form-group">
                                        <div>
                                            <input type="password" class="form-control" name="password" value="">
                                           
                                        </div>
                                    </div>
    
                                </div>
                                 <div class="col-sm-6">
                                <label >Confirm Password</label>
                               
                                    <div class="form-group">
                                        <div>
                                            <input type="password" class="form-control" name="repeat-password" value="">
                                           
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                            
                            
    
                            <div class="row mb-4">
                                <div class="col-sm-8 ">
                                    <button type="submit" class="btn btn-success waves-effect waves-light">Update Password</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            </div>
        </form>
        
    </div>
</div>
</form>

       
        

</div>
<!-- /Page Content -->
@endsection