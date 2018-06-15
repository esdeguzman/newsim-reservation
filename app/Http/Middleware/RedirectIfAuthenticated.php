<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (optional(auth()->user()->administrator)->exists()) {
                return redirect('admin/home');
            } elseif (auth()->user()->trainee->exists()) {
                return redirect('trainee/home');
            }
        }

        return $next($request);
    }
}
