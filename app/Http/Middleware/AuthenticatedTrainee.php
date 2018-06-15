<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AuthenticatedTrainee
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
        $user = User::with(['trainee' => function ($query) use ($request) {
            $query
                ->where('login_token', $request->login_token)
                ->where('secret', $request->secret);
        }])->where('id', $request->user_id)->first();

        if (is_null($user->trainee)) {
            return  response()->json([
                'error' => 'Unauthenticated Trainee!'
            ]);
        }

        return $next($request);
    }
}
