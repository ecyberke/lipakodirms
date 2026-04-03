<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserpassRequest;
use App\Rules\MatchOldPassword;
use App\Traits\UtilTrait;
use App\User;
use App\ServiceRequests;
use App\PayOwners;
use App\ManagerPayment;
use Auth;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use UtilTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $users = User::where('is_super', false)->get();
        return view('authorization.listadmins', compact('users'));
    }
     public function notification()
    {
        $service = ServiceRequests::where('manager', Auth::user()->name)->get();
        $bill = PayOwners::where('agency_user', Auth::user()->name)->get();
        $managerpayment = ManagerPayment::where('Manager', Auth::user()->name)->get();
        // $service = ServiceRequests::where('manager', 'Auth::user()->name')->get();
        return view('authorization.notification', compact('service','bill', 'managerpayment'));
    }

    public function create()
    {
        return view('authorization.creat');
    }

    public function store(CreateUserRequest $request)
    {
        $user = new User();
         
        $user->name = $request->name;
       
        
        $user->user_id = $request->user_id;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->is_admin = $request->is_admin;
        $user->password = Hash::make($request->password);
        if($user->is_admin == 2){
        
        }

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'User Created',
            'more_info' => 'Username: ' . $request->username ,
            'user_id' => $user->user_id,
            'tenant_id' => '0',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
         
            
        ]);
        $user->save();
        
        $user1 = User::where('username',$user->username)->first();
         if(auth()->user()->id != null){
            $user1->org_id = auth()->user()->id; 
            
        }else{
          $user1->org_id = $user->id; 
        }
          $user1->save();
        return redirect()->route('admin.index')->with('success', 'New user has been created');

    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->user_id = $request->user_id;
        $user->username = $request->username;
        $user->email = $request->email;
        
       
       
        $user->is_admin = $request->is_admin;
        $user->password = Hash::make($request->password);

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'User Details Updated',
            'more_info' => 'Username: ' . $request->username,
            'user_id' => $user->user_id,
            'tenant_id' => '0',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
        ]);
        $user->save();

        return redirect()->route('admin.index')->with('success', $user->name . '  has been updated');

    }
    public function updatepass(UpdateUserpassRequest $request, $id)
    {
        $user = User::findOrFail($id);

     
        $user->password = Hash::make($request->password);

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'User Password Updated',
            'more_info' => 'Username: ' . $user->username,
            'user_id' => $user->user_id,
            'tenant_id' => '0',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
        ]);
        $user->save();

        return redirect()->route('admin.index')->with('success', $user->name . '  Password has been updated');

    }

    public function destroy($id)
    {

        $user = User::findOrFail($id);

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'User Deleted Partially',
            'more_info' => 'Username: ' . $user->username,
            'user_id' => $user->user_id,
            'tenant_id' => '0',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
        ]);

        $user->delete();

        return back()->with('success', $user->name . ' has been deleted');
    }

    public function changeRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->is_admin = !$user->is_admin;

        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'User Role Changed',
            'more_info' => 'Username: ' . $user->username,
            'user_id' => $user->user_id,
            'tenant_id' => '0',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
        ]);

        $user->save();

        return redirect()->back()->with('success', 'User Level has been updated');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('authorization.edit', compact('user'));
    }
    public function editpassword($id)
    {
        $user = User::findOrFail($id);

        return view('authorization.editpassword', compact('user'));
    }

    public function changePassword()
    {
        return view('authorization.changepass');

    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
        $this->createLog([
            'username' => auth()->user()->username,
            'operation' => 'Logged In User Password Updated',
            'more_info' => 'Password changed',
            'user_id' => auth()->user()->id,
            'tenant_id' => '0',
            'servicerequest_id' => '0',
            'house_id' => '0',
            'apartment_id' => '0',
            'landlord_id' => '0',
            'bill_id' => '0',
            'invoice_id' => '0',
            'sms_id' => '0',
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password has been changed successfully');

    }

}
