<?php

namespace App\Http\Controllers\Auth;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponseController implements RegisterResponseContract
{
    public function toResponse($request)
    {
        if (!$request->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }
        return redirect()->route('mypage_first');
    }
}