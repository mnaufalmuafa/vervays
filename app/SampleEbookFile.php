<?php

namespace App;

use Illuminate\Support\Facades\DB;

class SampleEbookFile
{
    public static function getSampleEbookFile($sampleEbookFileId)
    {
        return DB::table('sample_ebook_files')
                    ->select('id', 'name')
                    ->where('id' , $sampleEbookFileId)
                    ->first();
    }
}
