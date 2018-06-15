<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $prefix = str_replace('/', '', $request->route()->getPrefix());
        if (optional(auth()->user()->administrator)->exists() && $prefix == 'admin') {
        // do nothing
        } elseif (optional(auth()->user()->trainee)->exists() && $prefix == 'trainee') {
            // do nothing
        } else {
            return redirect('page-not-found');
        }

        return $next($request);
    }
}
