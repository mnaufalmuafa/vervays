<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Book;
use Carbon\Carbon;

class BookController extends Controller
{
    public function create()
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "publisher" => User::getPublisherData(session('id')),
            "categories" => Book::getCategories(),
            "languages" => Book::getLanguages(),
        ];
        return view('pages.publisher.input_book', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "title" => "required|string",
            "author" => "required|string",
            "languageId" => "required|integer",
            "numberOfPage" => "required|integer",
            "categoryId" => "required|integer",
            "synopsis" => "required|string",
            "price" => "required|integer",
            "ebookFile" => "required|file|mimes:pdf",
            "sampleEbookFile" => "required|file|mimes:pdf",
            "photo" => "required|file|mimes:jpeg,jpg,png",
        ]);
        
        // Upload Ebook
        $ebookFileId = Book::getNewEbookFilesId();
        $ebook = $request->file('ebookFile');
        $nama_file = $ebook->getClientOriginalName();
        $tujuan_upload = 'ebook/ebook_files/'.$ebookFileId;
        $ebook->move($tujuan_upload,$nama_file);

        //Upload Sample Ebook
        $sampleEbookId = Book::getNewSampleEbookFilesId();
        $SampleEbook = $request->file('sampleEbookFile');
        $nama_file = $SampleEbook->getClientOriginalName();
        $tujuan_upload = 'ebook/sample_ebook_files/'.$sampleEbookId;
        $SampleEbook->move($tujuan_upload,$nama_file);

        //Upload Cover Ebook
        $photoId = Book::getNewEbookCoverId();
        $photo = $request->file('photo');
        $nama_file = $photo->getClientOriginalName();
        $tujuan_upload = 'ebook/ebook_cover/'.$photoId;
        $photo->move($tujuan_upload,$nama_file);

        // Simpan ebook dan datanya ke database
        $ebookData = [
            "id" => Book::getNewBookId(),
            "title" => $request->title,
            "author" => $request->author,
            "languageId" => $request->languageId,
            "numberOfPage" => $request->numberOfPage,
            "price" => $request->price,
            "synopsis" => $request->synopsis,
            "ebookFileId" => $ebookFileId,
            "sampleEbookFileId" => $sampleEbookId,
            "ebookCoverId" => $photoId,
            "categoryId" => $request->categoryId,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ];
        $ebookFilesData = [
            "id" => $ebookFileId,
            "name" => $ebook->getClientOriginalName(),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ];
        $sampleEbookFilesData = [
            "id" => $sampleEbookId,
            "name" => $SampleEbook->getClientOriginalName(),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ];
        $ebookCoverData = [
            "id" => $photoId,
            "name" => $photo->getClientOriginalName(),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ];
        Book::store($ebookData, $ebookFilesData, $sampleEbookFilesData, $ebookCoverData);
        return redirect()->route('dashboard-publisher');
    }
}
