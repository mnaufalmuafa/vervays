<?php

namespace App;

use Illuminate\Support\Facades\DB;

class BookSnapshot
{
    public static function getPrice($bookId, $orderId)
    {
        return DB::table('book_snapshots')
                    ->where('bookId', $bookId)
                    ->where('orderId', $orderId)
                    ->pluck('price')[0];
    }

    public static function getTotalOrderPrice($orderId)
    {
        return DB::table('book_snapshots')
                    ->where('orderId', $orderId)
                    ->select(DB::raw('SUM(`price`) as totalPrice'))
                    ->get()[0]->totalPrice;
    }

    public static function getArrBookIdByOrderId($orderId)
    {
        return DB::table('book_snapshots')->where('orderId', $orderId)->pluck('bookId');
    }
}
