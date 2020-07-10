<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use App\User;

class ReviewController extends Controller
{
    public function giveRating()
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
        ];
        return view('pages.buyer.give_review', $data);
    }
}
