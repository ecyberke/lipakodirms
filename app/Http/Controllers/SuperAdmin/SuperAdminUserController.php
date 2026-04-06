<?php
namespace App\Http\Controllers\SuperAdmin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminUserController extends SuperAdminController
{
    public function index()
    {
        $users = User::where('is_super', 1)->latest()->get();
        return view('super_admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('super_admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'username' => 'required|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_super' => 1,
            'is_admin' => 2,
            'org_id'   => 0,
        ]);

        return redirect()->route('super.users.index')
            ->with('success', 'Super admin user created successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
