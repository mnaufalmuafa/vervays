<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class HaveController extends Controller
{
    public function mybook()
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
        ];
        return view('pages.buyer.mybook', $data);
    }
}
