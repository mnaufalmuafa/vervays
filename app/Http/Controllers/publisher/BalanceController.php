<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use App\Publisher;
use Illuminate\Http\Request;
use App\User;

class BalanceController extends Controller
{
    public function cashout()
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
        ];
        return view('pages.publisher.cashout', $data);
    }

    public function withdrawBalance(Request $request)
    {
        $publisherId = Publisher::getPublisherIdWithUserId(session('id'));
        Publisher::withdrawBalance($publisherId, $request->amount);
    }
}
