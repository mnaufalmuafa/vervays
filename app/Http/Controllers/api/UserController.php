<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        User::updateProfile(
            $request->post('firstName'),
            $request->post('lastName'),
            $request->post('birthDay'),
            $request->post('phoneNum'),
            $request->post('gender')
        );
    }
}
