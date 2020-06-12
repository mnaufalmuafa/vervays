<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Publisher
{
    public static function updateNama($nama, $idUser)
    {
        DB::table('publishers')->where('userId',$idUser)
            ->update([
                "name" => $nama,
            ]);
    }

    public static function updateDeskripsi($deskripsi, $idUser)
    {
        DB::table('publishers')->where('userId',$idUser)
            ->update([
                "description" => $deskripsi,
            ]);
    }

    public static function updateFoto($foto, $idUser, $idFoto) {
        DB::table('profile_photos')->insert([
            "id" => $idFoto,
            "name" => $foto,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('publishers')->where('userId', $idUser)
            ->update([
                "profilePhotoId" => $idFoto,
            ]);
    }

    public static function getNewProfilePhotoId()
    {
        return DB::table('profile_photos')->get()->count() + 1;
    }

    public static function getPublisherIdWithUserId($userId)
    {
        return DB::table('publishers')
            ->select('id')
            ->where('userId', $userId)
            ->first()
            ->id;
    }

    public static function doesThePublisherHaveThatBook($publisherId, $bookId)
    {
        $value = DB::table('books')
            ->join('publishers', 'publishers.id', '=', 'books.publisherId')
            ->where('publishers.id', $publisherId)
            ->where('books.id', $bookId)
            ->count();
        if ($value == 1) {
            return true;
        }
        return false;
    }
}
