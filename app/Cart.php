<?php

namespace App;

use Illuminate\Support\Facades\DB;

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
}
