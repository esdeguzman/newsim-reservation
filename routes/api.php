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
