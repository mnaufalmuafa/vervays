<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\Book;
use Carbon\Carbon;

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

    public static function whetherTheUserHasAddedBookToWishListForModel($bookId)
    {
        $userId = session('id');
        $count = DB::table('wishes')
                        ->where('userId', $userId)
                        ->where('bookId', $bookId)
                        ->count();
        if ($count == 1) {
            return true;
        }
        return false;
    }

    public static function addBookToWishList($bookId)
    {
        if (!Wishes::whetherTheUserHasAddedBookToWishListForModel($bookId)) {
            $userId = session('id');
            DB::table('wishes')->insert([
                'bookId' => $bookId,
                'userId' => $userId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public static  function removeBookFromWishList($userId, $bookId)
    {
        if (Wishes::whetherTheUserHasAddedBookToWishListForModel($bookId)) {
            DB::table('wishes')
                ->where('bookId', $bookId)
                ->where('userId', $userId)
                ->delete();
        }
    }

    public static function whetherTheUserHasAddedBookToWishList($bookId)
    {
        $userId = session('id');
        $count = DB::table('wishes')
                        ->where('userId', $userId)
                        ->where('bookId', $bookId)
                        ->count();
        if ($count == 1) {
            return json_encode(true);
        }
        return json_encode(false);
    }
}
