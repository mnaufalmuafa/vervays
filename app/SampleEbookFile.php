<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\Book;

class SampleEbookFile
{
    public static function getSampleEbookFile($sampleEbookFileId)
    {
        return DB::table('sample_ebook_files')
                    ->select('id', 'name')
                    ->where('id' , $sampleEbookFileId)
                    ->first();
    }

    public static function getSampleBookFileURL($bookId)
    {
        $sampleEbookFileId = Book::getSampleEbookFileId($bookId);
        $sampleEbookFile = SampleEbookFile::getSampleEbookFile($sampleEbookFileId);
        return "/ebook/sample_ebook_files/".$sampleEbookFile->id."/".$sampleEbookFile->name;
    }
}
