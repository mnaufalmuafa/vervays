<?php

namespace App\Http\Controllers\buyer;

use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Order;

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
        return Book::getPeopleGaveStarsCountAllRating($request->id);
    }

    public function getPeopleGaveStarsCountByRating(Request $request)
    {
        return Book::getPeopleGaveStarsCountByRating($request->id, $request->rating);
    }

    public function getReviewsByBookId(Request $request)
    {
        return Book::getReviewsByBookId($request->bookId);
    }

    public function getUserRoleForEbookInfoPage(Request $request)
    {
        return Order::getUserRoleForEbookInfoPage($request->bookId);
    }

    public function whetherTheUserHasAddedBookToCart(Request $request)
    {
        return Book::whetherTheUserHasAddedBookToCart($request->bookId);
    }

    public function addBookToCart(Request $request)
    {
        Book::addBookToCart($request->bookId);
    }

    public function removeBookFromCart(Request $request)
    {
        Book::removeBookFromCart($request->bookId);
    }
}
