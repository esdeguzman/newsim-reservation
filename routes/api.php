<?php

use Illuminate\Http\Request;

Route::post('/trainee/authenticate', function (Request $request) {
    $credentials = $request->only(['username', 'password']);

    if (Auth::attempt($credentials)) {
        $token = str_random(24);
        auth()->user()->trainee->login_token = $token;
        auth()->user()->trainee->save();
        return $token;
    }

    return ['error' => 'Invalid Credentials!'];
});

Route::post('/trainee/secret', function (Request $request) {
    $user = User::with(['trainee' => function ($query) use ($request) {
        $query->where('login_token', $request->login_token);
    }])->where('id', $request->user_id)->first();

    if (is_null($user)) {
       return  ['error' => 'Unauthenticated Trainee!'];
    } else {
        $user->trainee->secret = $request->secret;
        $user->trainee->save();

        return ['success' => 'Secret Successfully Saved!'];
    }
});

Route::middleware('auth.trainee')->post('/trainee/logout', function (Request $request) {
    $user = User::find($request->user_id);
    $user->trainee->login_token = null;
    $user->trainee->secret = null;
    $user->trainee->save();

    return ['success' => 'Trainee Has Been Logged Out'];
});
