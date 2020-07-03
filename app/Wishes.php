<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Wishes
{
    public static function getUsersWishlist()
    {
        // return "354";
        $data = DB::table('wishes')
                        ->join('books', 'wishes.bookId', '=', 'books.id')
                        ->join('publishers', 'books.publisherId', '=', 'publishers.id')
                        ->join('ebook_covers', 'books.ebookCoverId', '=', 'ebook_covers.id')
                        ->where('wishes.userId', session('id'))
                        ->select(
                            'books.id',
                            'books.author', 
                            'books.title', 
                            'books.synopsis', 
                            'books.price',
                            'books.ebookCoverId'
                        )
                        ->addSelect(DB::raw("`ebook_covers`.`name` as ebookCoverName"))
                        ->get();
        foreach ($data as $book) {
            $book->rating = Book::getBookRating($book->id);
            // $book->rating = 3.45;
            $book->ratingCount = Book::getBookRatingCount($book->id);
            $book->soldCount = Book::getBookSoldCount($book->id);
        }
        return response()->json($data);
    }
}
