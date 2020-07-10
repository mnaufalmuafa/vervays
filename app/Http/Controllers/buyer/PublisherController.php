<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class PublisherController extends Controller
{
    public function index()
    {
        $data = [
            "firstName" => User::getFirstName(session('id'))
        ];
        return view('pages.buyer.info_publisher', $data);
    }
}
