<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
    public function getUserBooks()
    {
        return Book::getBookDataForMyBookPage();
    }
}
