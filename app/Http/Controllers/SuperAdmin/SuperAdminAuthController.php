<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->is_super) {
            return redirect()->route('super.dashboard');
        }
        return view('super_admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->remember)) {
            if (!Auth::user()->is_super) {
                Auth::logout();
                return back()->withErrors(['username' => 'You do not have super admin access.']);
            }
            $request->session()->regenerate();
            return redirect()->route('super.dashboard');
        }

        return back()->withErrors(['username' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('super.login');
    }
}
