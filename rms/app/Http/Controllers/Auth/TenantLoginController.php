<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class TenantLoginController extends Controller
{

    /*

    |--------------------------------------------------------------------------

    | Tenant Login Controller

    |--------------------------------------------------------------------------

    |

    | This controller handles authenticating users for the application and

    | redirecting them to your home screen. The controller uses a trait

    | to conveniently provide its functionality to your applications.

    |

     */

    use AuthenticatesUsers;

    protected $guard = 'tenant';

    /**

     * Where to redirect users after login.

     *

     * @var string

     */

    protected $redirectTo = '/tenant-home';

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()
    {

        $this->middleware('guest:tenant')->except('logout');

    }

    public function showLoginForm()
    {

        return view('auth.tenantLogin');

    }

    public function login(Request $request)
    {

        if (auth()->guard('tenant')->attempt(['email' => $request->email, 'password' => $request->password])) {

            //dd(auth()->guard('tenant')->user());
            return redirect()->intended('/tenant');

        }

        //return back()->withErrors(['email' => 'Email or password are wrong.']);
        return back()->withInput($request->only('email'))
            ->withErrors(['email' => 'Email or password are wrong.']);

    }

    public function logout()
    {
        Auth::guard('tenant')->logout();
        return redirect()
            ->route('tenant.login');
    }

}
