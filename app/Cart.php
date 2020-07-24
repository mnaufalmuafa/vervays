<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Cart
{
    public static function emptyUserCart()
    {
        $userId = session('id');
        DB::table('carts')->where('userId', $userId)->delete();
    }

    public static function getUserCartBookId()
    {
        $userId = session('id');
        return DB::table('carts')
                        ->where('carts.userId', $userId)
                        ->select('carts.bookId')
                        ->get();
    }

    public static function whetherTheUserHasAddedBookToCart($bookId)
    {
        $userId = session('id');
        $count = DB::table('carts')
                        ->where('userId', $userId)
                        ->where('bookId', $bookId)
                        ->count();
        if ($count == 1) {
            return json_encode(true);
        }
        return json_encode(false);
    }

    public static function whetherTheUserHasAddedBookToCartForModel($bookId)
    {
        $userId = session('id');
        $count = DB::table('carts')
                        ->where('userId', $userId)
                        ->where('bookId', $bookId)
                        ->count();
        if ($count == 1) {
            return true;
        }
        return false;
    }

    public static function addBookToCart($bookId)
    {
        if (!Cart::whetherTheUserHasAddedBookToCartForModel($bookId)) {
            $userId = session('id');
            DB::table('carts')->insert([
                'bookId' => $bookId,
                'userId' => $userId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public static  function removeBookFromCart($bookId)
    {
        if (Cart::whetherTheUserHasAddedBookToCartForModel($bookId)) {
            $userId = session('id');
            DB::table('carts')
                ->where('bookId', $bookId)
                ->where('userId', $userId)
                ->delete();
        }
    }
}
