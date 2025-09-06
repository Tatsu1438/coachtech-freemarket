<?php

namespace App\Http\Controllers\Auth;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponseController implements LoginResponseContract
{
    public function toResponse($request)
    {
        return redirect()->route('items.top_mylist');
    }
}
