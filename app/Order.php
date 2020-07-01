<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    public static function getUserRoleForEbookInfoPage($bookId)
    {
        // ROLE 1 : Sebagai publisher
        // ROLE 2 : Sebagai buyer yang blm membeli buku
        // ROLE 3 : Sebagai buyer yang sedang atau sudah membeli buku
        $userId = session('id');
        $publisherId = Book::getPublisherIdByBookId($bookId);
        $publisherUserId = Publisher::getUserIdByPublisherId($publisherId);
        if ($publisherUserId == $userId) {
            return 1;
        }
        else if (Order::whetherTheBuyerHasntPurchasedBook($userId, $bookId)) {
            return 2;
        }
        return 3;
    }
    
    private static function whetherTheBuyerHasntPurchasedBook($buyerId, $bookId)
    {
        if (Order::whetherTheBuyerHasAlreadyPurchasedBook($buyerId, $bookId) || Order::whetherTheBuyerIsBuyingBook($buyerId, $bookId)) {
            return false;
        }
        $count = DB::table('orders')
                        ->join('users', 'users.id', '=', 'orders.userId')
                        ->join('book_snapshots', 'book_snapshots.orderId', '=', 'orders.id')
                        ->where('users.id', $buyerId)
                        ->where('book_snapshots.bookId', $bookId)
                        ->where('status', 'failed')
                        ->count();
        if ($count != 0) {
            return true;
        }
        return false;
    }

    private static function whetherTheBuyerHasAlreadyPurchasedBook($buyerId, $bookId)
    {
        $count = DB::table('orders')
                        ->join('users', 'users.id', '=', 'orders.userId')
                        ->join('book_snapshots', 'book_snapshots.orderId', '=', 'orders.id')
                        ->where('users.id', $buyerId)
                        ->where('book_snapshots.bookId', $bookId)
                        ->where('status', 'success')
                        ->count();
        if ($count != 0) {
            return true;
        }
        return false;
    }

    private static function whetherTheBuyerIsBuyingBook($buyerId, $bookId)
    {
        $count = DB::table('orders')
                        ->join('users', 'users.id', '=', 'orders.userId')
                        ->join('book_snapshots', 'book_snapshots.orderId', '=', 'orders.id')
                        ->where('users.id', $buyerId)
                        ->where('book_snapshots.bookId', $bookId)
                        ->where('status', 'pending')
                        ->count();
        if ($count != 0) {
            return true;
        }
        return false;
    }

    private static function convertPriceToCurrencyFormat($price)
    {
        return number_format($price,0,',','.');
    }

    public static function getUserCart()
    {
        $userId = session('id');
        $cart = DB::table('carts')
                        ->join('books', 'carts.bookId', '=', 'books.id')
                        ->join('publishers', 'books.publisherId', '=', 'publishers.id')
                        ->join('ebook_covers', 'books.ebookCoverId', '=', 'ebook_covers.id')
                        ->where('carts.userId', $userId)
                        ->select('carts.bookId', 'books.title', 'books.author', 'books.price', 'ebookCoverId')
                        ->addSelect(DB::raw('`publishers`.`name` as publisherName'))
                        ->addSelect(DB::raw('`ebook_covers`.`name` as ebookCoverName'))
                        ->get();
        foreach ($cart as $book) {
            $book->priceForHuman = Order::convertPriceToCurrencyFormat($book->price);
        }
        // dd($cart);
        return response()->json($cart);
    }

    public static function removeBookFromCart($bookId)
    {
        $userId = session('id');
        DB::table('carts')
            ->where('bookId', $bookId)
            ->where('userId', $userId)
            ->delete();
    }
}
