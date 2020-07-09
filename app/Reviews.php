<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Reviews
{
    public static function didTheUserGiveAReview($bookId)
    {
        $count = DB::table('reviews')
                        ->join('have', 'reviews.haveId', '=', 'have.id')
                        ->where('have.userId', session('id'))
                        ->where('have.bookId', $bookId)
                        ->get()
                        ->count();
        return $count == 1;
    }
}
