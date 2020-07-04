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
}
