<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SampleEbookFiles extends Model
{
    protected $table = 'sample_ebook_files';

    protected $primaryKey = 'id';

    public static function getNewSampleEbookFilesId()
    {
        return SampleEbookFiles::get()->count() + 1;
    }
}
