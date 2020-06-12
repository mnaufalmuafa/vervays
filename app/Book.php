<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\Publisher;

class Book
{
    public static function store($ebookData, $ebookFilesData, $sampleEbookFilesData, $ebookCoverData)
    {
        DB::table('ebook_files')->insert($ebookFilesData);
        DB::table('sample_ebook_files')->insert($sampleEbookFilesData);
        DB::table('ebook_covers')->insert($ebookCoverData);
        DB::table('books')->insert($ebookData);
    }

    public static function getCategories()
    {
        return DB::table('categories')
            ->select('id', 'name')
            ->orderBy('name')
            ->get()
            ->all();
    }

    public static function getLanguages()
    {
        return DB::table('languages')
            ->select('id', 'name')
            ->get()
            ->all();
    }

    public static function getNewEbookFilesId()
    {
        return DB::table('ebook_files')->get()->count() + 1;
    }

    public static function getNewSampleEbookFilesId()
    {
        return DB::table('sample_ebook_files')->get()->count() + 1;
    }

    public static function getNewEbookCoverId()
    {
        return DB::table('ebook_covers')->get()->count() + 1;
    }

    public static function getNewBookId()
    {
        return DB::table('books')->get()->count() + 1;
    }

    public static function getBookDataForDashboardPublisher()
    {
        $userId = session('id');
        $publisherId = Publisher::getPublisherIdWithUserId($userId);
        $books = DB::table('books')
            ->where('publisherId', $publisherId)
            ->where('isDeleted', '0')
            ->get();
        $data = [];
        foreach ($books as $book) {
            array_push($data,[
                "id" => $book->id,
                "title" => $book->title,
                "author" => $book->author,
                "imageURL" => Book::getEbookCoverURL($book->ebookCoverId),
                "synopsis" => $book->synopsis,
                "rating" => Book::getBookRating($book->id),
                "ratingCount" => Book::getBookRatingCount($book->id),
                "soldCount" => Book::getBookSoldCount($book->id),
                "price" => Book::convertPriceToCurrencyFormat($book->price),
            ]);
        }
        return $data;
    }

    private static function getEbookCoverURL($ebookCoverId)
    {
        $fileName = DB::table('ebook_covers')
            ->where('id', $ebookCoverId)
            ->first()
            ->name;
        return url("ebook/ebook_cover/".$ebookCoverId."/".$fileName);
    }

    private static function getBookRating($id)
    {
        $rating = DB::table('reviews')
            ->join('have', 'reviews.haveId', '=', 'have.id')
            ->where('bookId', $id)
            ->avg('rating');
        return $rating ?? 0;
    }

    private static function getBookRatingCount($id)
    {
        $ratingCount = DB::table('reviews')
            ->join('have', 'reviews.haveId', '=', 'have.id')
            ->where('bookId', $id)
            ->count();
        return $ratingCount ?? 0;
    }

    private static function getBookSoldCount($id)
    {
        $soldCount = DB::table('book_snapshots')
            ->join('orders', 'book_snapshots.orderId', '=', 'orders.id')
            ->where('book_snapshots.bookId', $id)
            ->where('orders.status', 'success')
            ->count();
        return $soldCount ?? 0;
    }

    private static function convertPriceToCurrencyFormat($price)
    {
        return number_format($price,0,',','.');
    }

    public static function getBook($bookId)
    {
        return DB::table('books')
            ->where('id', $bookId)
            ->first();
    }
}
