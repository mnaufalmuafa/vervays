<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;

class ReadController extends Controller
{
    public function readSample(Request $request)
    {
        $data = [
            "bookId" => $request->bookId,
            "ebookURL" => Book::getSampleBookFileURL($request->bookId),
        ];
        return view('pages.buyer.read', $data);
    }

    public function readBook(Request $request)
    {
        $data = [
            "bookId" => $request->bookId,
            "ebookURL" => Book::getBookFileURL($request->bookId),
        ];
        return view('pages.buyer.read', $data);
    }
}
