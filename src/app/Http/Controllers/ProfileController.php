<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function sellList()
    {
        return view('profile.mypage_sold');
    }

    public function buyList()
    {
        return view('profile.mypage_bought');
    }

    public function edit()
    {
        return view('profile.mypage_edit');
    }
}
