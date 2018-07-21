<?php

namespace App\Http\Controllers\Auth;

use function App\Helper\trainee;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
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
     * Override username function to use "username"
     * instead of email address
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        $previous = url()->previous();

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $request['previous'] = $previous;
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function authenticated(Request $request, $user)
    {
        if (optional(auth()->user()->administrator)->exists() && str_contains($request->previous,'admin')) {
            // do nothing
        } elseif (optional(auth()->user()->trainee)->exists() && str_contains($request->previous,'trainee')) {
            if (trainee()->status == 'inactive') {
                $request->session()->flash('info', [
                    'inactive' => 'Your account has been deactivated by the administrators. If you think this is' .
                                    ' incorrect, please call 888-2764 or email your concern at it@newsim.ph'
                ]);

                auth()->logout();

                return redirect(url('/trainee/login'));
            }
        } else {
            return redirect('page-not-found');
        }
    }

    public function redirectTo()
    {
        if (optional(auth()->user()->administrator)->exists()) {
            return 'admin/home';
        } elseif (optional(auth()->user()->trainee)->exists()) {
            return 'trainee/home';
        }
    }

    public function logout(Request $request)
    {
        $path = '';

        if (optional(auth()->user()->administrator)->exists()) {
            $path = '/admin/login';
        } elseif (optional(auth()->user()->trainee)->exists()) {
            $path = '/trainee/login';
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect($path);
    }
}
