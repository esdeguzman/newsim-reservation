<?php

namespace App\Http\Controllers;

use App\Notifications\ResetPassword;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function requestPasswordReset(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->notify(new ResetPassword($user));
            $user->requested_password_reset = 1;
            $user->save();

            $request->session()->flash('info', ['text' => 'Link for resetting your password has been sent to your email.']);
        } else {
            $request->session()->flash('info', ['text' => 'Provided email does not exists. Perhaps your are not registered yet?']);
        }

        return back();
    }

    public function resetPassword(User $user, Request $request)
    {
        return view('pages.reset-password', ['user_id' => $user->id]);
    }

    public function saveNewPassword(User $user, Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
            'email' => 'required',
        ]);

        if ($user->email == $request->email and $user->requested_password_reset == 1) {
            $password = bcrypt($request->password);

            $user->password = $password;
            $user->requested_password_reset = 0;
            $user->save();
        } else {
            $request->session()->flash('info', ['email' => $request->email]);
        }

        return back()->withInput();
    }
}
