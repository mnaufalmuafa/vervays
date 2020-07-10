<?php

namespace App;

use Illuminate\Support\Facades\DB;

class EbookCover
{
    public static function getEbookCoverByBookId($bookId)
    {
        $ebookCoverId = Book::getEbookCoverId($bookId);
        return DB::table('ebook_covers')
                    ->select('id', 'name')
                    ->where('id', $ebookCoverId)
                    ->get()[0];
    }

    public static function getEbookCoverURL($ebookCoverId)
    {
        $fileName = DB::table('ebook_covers')
                        ->where('id', $ebookCoverId)
                        ->first()
                        ->name;
        return url("ebook/ebook_cover/".$ebookCoverId."/".$fileName);
    }
}
