<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Have
{
    public static function store($userId, $bookId)
    {
        DB::table('have')->insert([
            "id" => Have::getNewId(),
            "userId" => $userId,
            "bookId" => $bookId,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
    }

    private static function getNewId()
    {
        return DB::table('have')->get()->count() + 1;
    }
}
