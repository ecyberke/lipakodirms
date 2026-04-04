<?php
namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\TenantUser;
use App\Tenant;
use App\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TenantAuthController extends Controller
{
    public function showLogin()
    {
        $org = config('app.organization');
        return view('tenant.auth.login', compact('org'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'account_number' => 'required|string',
            'password' => 'required|string',
        ]);

        $orgId = config('app.org_id', 1);

        $tenantUser = TenantUser::where('account_number', strtoupper($request->account_number))
            ->where('org_id', $orgId)
            ->first();

        if (!$tenantUser || !Hash::check($request->password, $tenantUser->password)) {
            return redirect()->route('tenant.login')
                ->withInput($request->only('account_number'))
                ->withErrors(['account_number' => 'Invalid account number or password']);
        }

        // MFA check
        if ($tenantUser->mfa_enabled) {
            session(['mfa_tenant_id' => $tenantUser->id]);
            $this->sendMfaCode($tenantUser);
            return redirect()->route('tenant.mfa');
        }

        Auth::guard('tenant')->login($tenantUser, $request->remember);
        return redirect()->route('tenant.dashboard');
    }

    public function logout()
    {
        Auth::guard('tenant')->logout();
        return redirect()->route('tenant.login');
    }

    private function sendMfaCode($tenantUser)
    {
        $code = rand(100000, 999999);
        $tenantUser->update([
            'mfa_code' => $code,
            'mfa_expires_at' => now()->addMinutes(10),
        ]);
        // SMS sending would go here
    }
}
