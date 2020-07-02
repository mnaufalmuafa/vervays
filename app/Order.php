<?php

namespace App;

use Carbon\Carbon;
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

    private static function getNewOrderId()
    {
        return DB::table('orders')->count() + 1;
    }

    public static function createOrder($paymentMethod)
    {
        $orderId = Order::getNewOrderId();
        $arrBookId = Order::getUserCartBookId();
        $paymentCode = Order::getPaymentCode($paymentMethod);
        $totalPrice = Book::getTotalPrice($arrBookId);
        Order::emptyUserCart();
        Order::postTransaction($orderId, $totalPrice, $paymentMethod, $paymentCode);
        Order::store($orderId, $paymentMethod, $paymentCode);
        Order::storeBookSnaphshots($arrBookId, $orderId);
        return $orderId;
    }

    private static function storeBookSnaphshots($arrBookId, $orderId)
    {
        foreach ($arrBookId as $book) {
            $now = Carbon::now();
            DB::table('book_snapshots')->insert([
                "bookId" => $book->bookId,
                "orderId" => $orderId,
                "price" => Book::getPrice($book->bookId),
                "created_at" => $now,
                "updated_at" => $now,
            ]);
        }
    }

    private static function store($id, $paymentId, $paymentCode)
    {
        $now = Carbon::now();
        $userId = session('id');
        DB::table('orders')->insert([
            "id" => $id,
            "paymentId" => $paymentId,
            "userId" => $userId,
            "paymentCode" => $paymentCode,
            "created_at" => $now,
            "updated_at" => $now,
        ]);
    }

    private static function emptyUserCart()
    {
        $userId = session('id');
        DB::table('carts')->where('userId', $userId)->delete();
    }

    private static function postTransaction($id, $totalPrice, $paymentId, $paymentCode)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://localhost:8000/transaction",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\n\t\"id\" : $id,\n\t\"totalPrice\" : $totalPrice,\n\t\"paymentCode\": \"$paymentCode\",\n\t\"paymentId\" : $paymentId\n}",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        unset($response);
    }

    private static function getPaymentCode($paymentId)
    {
        $userId = session('id');
        if ($paymentId == 1) {
            return "21".$userId;
        }
        else if ($paymentId == 2) {
            return "22".$userId;
        }
        else {
            return "23".$userId;
        }
    }

    private static function getUserCartBookId()
    {
        $userId = session('id');
        return DB::table('carts')
                        ->where('carts.userId', $userId)
                        ->select('carts.bookId')
                        ->get();
    }
}
