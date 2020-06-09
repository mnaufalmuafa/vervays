<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            "firstName" => User::getFirstName(session('id'))
        ];
        return view('pages.buyer.dashboard', $data);
    }
}
