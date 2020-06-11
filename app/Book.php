<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Book
{
    public static function store($ebookData, $ebookFilesData, $sampleEbookFilesData, $ebookCoverData)
    {
        DB::table('ebook_files')->insert($ebookFilesData);
        DB::table('sample_ebook_files')->insert($sampleEbookFilesData);
        DB::table('ebook_covers')->insert($ebookCoverData);
        DB::table('books')->insert($ebookData);
    }

    public static function getCategories()
    {
        return DB::table('categories')
            ->select('id', 'name')
            ->orderBy('name')
            ->get()
            ->all();
    }

    public static function getLanguages()
    {
        return DB::table('languages')
            ->select('id', 'name')
            ->get()
            ->all();
    }

    public static function getNewEbookFilesId()
    {
        return DB::table('ebook_files')->get()->count() + 1;
    }

    public static function getNewSampleEbookFilesId()
    {
        return DB::table('sample_ebook_files')->get()->count() + 1;
    }

    public static function getNewEbookCoverId()
    {
        return DB::table('ebook_covers')->get()->count() + 1;
    }

    public static function getNewBookId()
    {
        return DB::table('books')->get()->count() + 1;
    }
}
