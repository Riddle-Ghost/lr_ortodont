<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|Response|mixed
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        if ($request->wantsJson()) {
            return new Response('', 204);
        } else {
            $dashboardPath = '/';

            switch ($this->guard()->user()->role_id) {
                case Role::ADMIN_ID:
                    $dashboardPath = '/dashboard';
                    break;
                case Role::DOCTOR_ID:
                    $dashboardPath = '/office';
                    break;
                case Role::CLINIC_ID:
                    $dashboardPath = '/cabinet';
                    break;
            }

            return redirect()->intended($dashboardPath);
        }
    }
}
