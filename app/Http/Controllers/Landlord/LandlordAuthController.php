<?php
namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\LandlordUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LandlordAuthController extends Controller
{
    public function showLogin()
    {
        $org = config('app.organization');
        return view('landlord.auth.login', compact('org'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'account_number' => 'required|string',
            'password' => 'required|string',
        ]);

        $orgId = config('app.org_id', 1);
        $landlordUser = LandlordUser::where('account_number', strtoupper($request->account_number))
            ->where('org_id', $orgId)->first();

        if (!$landlordUser || !Hash::check($request->password, $landlordUser->password)) {
            return redirect()->route('landlord.login')
                ->withInput($request->only('account_number'))
                ->withErrors(['account_number' => 'Invalid account number or password']);
        }

        Auth::guard('landlord')->login($landlordUser, $request->remember);
        return redirect()->route('landlord.dashboard');
    }

    public function logout()
    {
        Auth::guard('landlord')->logout();
        return redirect()->route('landlord.login');
    }
}
