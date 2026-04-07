<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\UtilTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    use UtilTrait;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
   

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function username()
    {
        return 'username';
    }

    /**
     * Validate login credentials and enforce org-based access.
     */
    protected function attemptLogin(\Illuminate\Http\Request $request)
    {
        $attempted = $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );

        if (!$attempted) {
            return false;
        }

        $user   = $this->guard()->user();
        $org_id = config('app.org_id');

        // If on a subdomain (org_id > 0), enforce org membership
        if ($org_id && $org_id > 0) {
            // Super admins can't log in via company subdomain
            if ($user->is_super) {
                $this->guard()->logout();
                return false;
            }
            // User must belong to this org
            if ((int)$user->org_id !== (int)$org_id) {
                $this->guard()->logout();
                return false;
            }
        }

        return true;
    }

    /**
     * Custom failed login message.
     */
    protected function sendFailedLoginResponse(\Illuminate\Http\Request $request)
    {
        $org_id = config('app.org_id');

        if ($org_id && $org_id > 0) {
            $org = config('app.organization');
            $message = 'These credentials do not belong to ' . ($org->name ?? 'this organization') . '.';
        } else {
            $message = trans('auth.failed');
        }

        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => [$message],
        ]);
    }
}
