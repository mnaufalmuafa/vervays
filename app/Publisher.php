<?php

namespace App;

use Illuminate\Support\Facades\DB;

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
}
