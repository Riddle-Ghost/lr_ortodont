<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DoctorAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle($request, Closure $next)
    {
        if (!Gate::check('doctor-permission', [ Auth::user() ])) {
            throw new AuthorizationException('You don\'t have doctor\'s permissions.');
        }

        return $next($request);
    }
}
