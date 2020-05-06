<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        if (!hash_equals((string)$request->route('id'), (string)$request->user()->getKey())) {
            throw new AuthorizationException;
        }

        if (!hash_equals((string)$request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            if ($request->wantsJson()) {
                return new Response('', 204);
            } else {
                $dashboardPath = '/';

                switch ($request->user()->role_id) {
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

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        if ($response = $this->verified($request)) {
            return $response;
        }

        if ($request->wantsJson()) {
            return new Response('', 204);
        } else {
            $dashboardPath = '/';

            switch ($request->user()->role_id) {
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

            return redirect()->intended($dashboardPath)->with('verified', true);
        }
    }
}
