<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class BookController extends Controller
{
    public function create()
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "publisher" => User::getPublisherData(session('id')),
        ];
        return view('pages.publisher.input_book', $data);
    }
}
