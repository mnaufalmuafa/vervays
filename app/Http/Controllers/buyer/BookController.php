<?php

namespace App\Http\Controllers\buyer;

use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "book" => Book::getBookForInfoPage($request->id),
        ];
        // dd($data["book"]);
        return view('pages.buyer.ebook_info', $data);
    }

    public function getPeopleGaveStarsCountAllRating(Request $request) // untuk semua rating (dari 1.0 sampai 5.0)
    {
        return Book::getPeopleGaveStarsCountAllRating($request->get('id'));
    }

    public function getPeopleGaveStarsCountByRating(Request $request)
    {
        return Book::getPeopleGaveFiveStarsCountByRating($request->get('id'), $request->get('rating'));
    }
}
