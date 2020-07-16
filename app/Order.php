<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

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
        return true;
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
        $createdAt = Carbon::now();
        $dt = $createdAt->copy()->addHours(24);
        $dt->second = 0;
        $faker = Faker::create('id_ID');
        $backCode = $faker->swiftBicNumber;
        $orderId = Order::getNewOrderId();
        $midtransOrderId = $orderId."-".$backCode;
        $arrBookId = Cart::getUserCartBookId();
        $paymentCode = Order::getPaymentCode($paymentMethod, $orderId);
        $totalPrice = Book::getTotalPrice($arrBookId);
        Cart::emptyUserCart();
        if ($paymentMethod == "1") {
            Order::postTransactionToMidtransWithBNIVAPayment($midtransOrderId);
        }
        else if ($paymentMethod == "2") {
            Order::postTransactionToMidtransWithIndomaretPayment($midtransOrderId);
        }
        Order::postTransaction($orderId, $totalPrice, $paymentMethod, $paymentCode);
        Order::store($orderId, $backCode, $paymentMethod, $paymentCode, $dt, $createdAt);
        BookSnapshot::storeBookSnaphshotsByArrBookIdAndOrderId($arrBookId, $orderId);
        return $orderId;
    }

    private static function store($id, $backCode , $paymentId, $paymentCode, $expiredTime, $createdAt)
    {
        $userId = session('id');
        DB::table('orders')->insert([
            "id" => $id,
            "paymentId" => $paymentId,
            "userId" => $userId,
            "backIdCode" => $backCode,
            "paymentCode" => $paymentCode,
            "expiredTime" => $expiredTime,
            "created_at" => $createdAt,
            "updated_at" => $createdAt,
        ]);
    }

    public static function postTransactionToMidtransWithBNIVAPayment($midtransOrderId)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/charge",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\n    \"payment_type\": \"bank_transfer\",\n    \"transaction_details\": {\n        \"gross_amount\": 44000,\n        \"order_id\": \"$midtransOrderId\"\n    },\n    \"customer_details\": {\n        \"email\": \"noreply@example.com\",\n        \"first_name\": \"budi\",\n        \"last_name\": \"utomo\",\n        \"phone\": \"+6281 1234 1234\"\n    },\n    \"item_details\": [\n    {\n       \"id\": \"item01\",\n       \"price\": 21000,\n       \"quantity\": 1,\n       \"name\": \"Ayam Zozozo\"\n    },\n    {\n       \"id\": \"item02\",\n       \"price\": 23000,\n       \"quantity\": 1,\n       \"name\": \"Ayam Xoxoxo\"\n    }\n   ],\n   \"bank_transfer\":{\n     \"bank\": \"bni\",\n     \"va_number\": \"12345678\"\n  }\n}",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: Basic U0ItTWlkLXNlcnZlci1RMkhTRE5pX1pfcUxGNjRQdEplLUo3RWw6"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public static function postTransactionToMidtransWithIndomaretPayment($midtransOrderId)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/charge",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\n    \"payment_type\": \"cstore\",\n    \"transaction_details\": {\n        \"gross_amount\": 44000,\n        \"order_id\": \"$midtransOrderId\"\n    },\n    \"customer_details\": {\n        \"email\": \"noreply@example.com\",\n        \"first_name\": \"budi\",\n        \"last_name\": \"utomo\",\n        \"phone\": \"+6281 1234 1234\"\n    },\n    \"item_details\": [\n    {\n       \"id\": \"item01\",\n       \"price\": 21000,\n       \"quantity\": 1,\n       \"name\": \"Ayam Zozozo\"\n    },\n    {\n       \"id\": \"item02\",\n       \"price\": 23000,\n       \"quantity\": 1,\n       \"name\": \"Ayam Xoxoxo\"\n    }\n   ],\n  \"cstore\": {\n    \"store\": \"Indomaret\",\n    \"message\": \"Message to display\"\n  }\n}",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: Basic U0ItTWlkLXNlcnZlci1RMkhTRE5pX1pfcUxGNjRQdEplLUo3RWw6"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
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

    private static function getPaymentCode($paymentId, $orderId)
    {
        if ($paymentId == 1) {
            return "21".$orderId;
        }
        else if ($paymentId == 2) {
            return "22".$orderId;
        }
        else {
            return "23".$orderId;
        }
    }

    public static function whetherTheTransactionIsPendingOrSuccess($bookId)
    {
        $userId = session('id');
        if (Order::whetherTheBuyerHasAlreadyPurchasedBook($userId, $bookId)) {
            return "success";
        }
        return "pending";
    }

    public static function getRealStatus($orderId)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://localhost:8000/transaction/$orderId",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS =>"{\r\n    \"paymentId\" : 1,\r\n    \"paymentCode\" : 213\r\n}",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response, true)["status"];
    }

    public static function updateStatus()
    {
        $orders = DB::table('orders')->where('status', 'pending')->where('userId', session('id'))->get();
        foreach ($orders as $order) {
            if (Order::getRealStatus($order->id) != "pending") {
                DB::table('orders')->where('id', $order->id)->update([
                    "status" => Order::getRealStatus($order->id)
                ]);
                if (Order::getRealStatus($order->id) == "success") {
                    $arrBookId = DB::table('orders')
                                        ->join('book_snapshots', 'orders.id', '=', 'book_snapshots.orderId')
                                        ->where('orders.id', $order->id)
                                        ->pluck('book_snapshots.bookId');
                    foreach ($arrBookId as $bookId) {
                        $publisherId = Book::getPublisherIdByBookId($bookId);
                        $price = BookSnapshot::getPrice($bookId, $order->id);
                        Publisher::addBalance($publisherId, $price);
                        Have::store(session('id'), $bookId);
                    }
                }
            }
        }
    }

    public static function getUserOrders($userId)
    {
        $orders = DB::table('orders')
                        ->select('id', 'created_at', 'status')
                        ->where('userId', $userId)
                        ->orderBy('created_at', 'desc')
                        ->get(); // berupa array of object
        foreach ($orders as $order) {
            $order->created_at = Carbon::parse($order->created_at)->toDateString();
            $order->totalPrice = Order::getTotalPrice($order->id);
        }
        return $orders;
    }

    public static function getTotalPrice($orderId)
    {
        return BookSnapshot::getTotalOrderPrice($orderId);
    }

    public static function getBooksByOrderId($orderId)
    {
        $arrBookId = BookSnapshot::getArrBookIdByOrderId($orderId);
        return Book::getBooksByArrBookId($arrBookId);
    }

    public static function getOrderForOrderInfoPage($orderId)
    {
        $order = DB::table('orders')
                    ->where('id', $orderId)
                    ->select('id', 'created_at', 'status', 'paymentId', 'paymentCode')
                    ->first();
        $order->created_at = Carbon::parse($order->created_at)->toDateString();
        $order->totalPrice = BookSnapshot::getTotalOrderPrice($order->id);
        $order->totalPrice = Order::convertPriceToCurrencyFormat($order->totalPrice);
        $order->codeName = Payment::getCodeName($order->paymentId);
        $order->paymentMethod = Payment::getName($order->paymentId);
        return $order;
    }

    public static function getPaymentId($orderId)
    {
        return DB::table('orders')->where('id', $orderId)->pluck('paymentId')[0];
    }

    public static function cancelAllOrderByUserId($userId)
    {
        DB::table('orders')->where('userId', $userId)->update([
            "status" => "failed",
            "updated_at" => Carbon::now(),
        ]);
    }

    public static function getTransactionStatusFromMidtrans($midtransOrderId)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/$midtransOrderId/status",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: Basic U0ItTWlkLXNlcnZlci1RMkhTRE5pX1pfcUxGNjRQdEplLUo3RWw6"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return Order::getTransacrtionStatusFromResponseMidtrans($response);
    }

    private static function getTransacrtionStatusFromResponseMidtrans($response)
    {
        $start = strpos($response, "transaction_status") + 21;
        $temp = "";
        for ($i=$start; $i < strlen($response) - 1; $i++) { 
            $temp = $temp.$response[$i];
        }
        $response = $temp;
        $temp = "";
        $end = strpos($response, ",") - 1;
        for ($i=0; $i < $end; $i++) { 
            $temp = $temp.$response[$i];
        }
        return $temp;
    }
}
