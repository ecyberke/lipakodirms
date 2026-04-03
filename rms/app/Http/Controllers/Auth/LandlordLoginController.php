<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LandlordLoginController extends Controller
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

    protected $guard = 'landlord';

    /**

     * Where to redirect users after login.

     *

     * @var string

     */

    protected $redirectTo = '/landlord-home';

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()
    {

        $this->middleware('guest:landlord')->except('logout');

    }

    public function showLoginForm()
    {

        return view('auth.landlordLogin');

    }

    public function login(Request $request)
    {

        if (auth()->guard('landlord')->attempt(['email' => $request->email, 'password' => $request->password])) {

            return redirect()->intended('/landlord');
        }

        //return back()->withErrors(['email' => 'Email or password are wrong.']);
        return back()->withInput($request->only('email'))
            ->withErrors(['email' => 'Email or password are wrong.']);

    }

    public function logout()
    {
        Auth::guard('landlord')->logout();
        return redirect()->route('landlord.login');
    }

}
