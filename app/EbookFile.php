<?php

namespace App;

use Illuminate\Support\Facades\DB;

class EbookFile
{
    public static function getEbookFile($ebookFileId)
    {
        return DB::table('ebook_files')
                    ->select('id', 'name')
                    ->where('id' , $ebookFileId)
                    ->first();
    }
}
