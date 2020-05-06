<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AdminAccessMiddleware
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
        if (!Gate::check('admin-permission', [ Auth::user() ])) {
            throw new AuthorizationException('You don\'t have administrator\'s permissions.');
        }

        return $next($request);
    }
}
