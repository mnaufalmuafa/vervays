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

    public static function updateLastRead($bookId, $lastRead)
    {
        DB::table('have')
            ->where('userId', 1)
            ->where('bookId', $bookId)
            ->update([
                "lastRead" => $lastRead,
            ]);
    }

    public static function getLastRead($bookId)
    {
        return DB::table('have')
                    ->where('userId', session('id'))
                    ->where('bookId', $bookId)
                    ->pluck('lastRead')[0];
    }

    public static function getIdByUserIdAndBookId($userId, $bookId)
    {
        return DB::table('have')
                    ->where('userId', $userId)
                    ->where('bookId', $bookId)
                    ->pluck('id')[0];
    }
}
