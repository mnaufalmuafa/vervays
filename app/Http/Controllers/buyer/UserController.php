<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function setting()
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
        ];
        return view('pages.buyer.account_setting', $data);
    }
}
