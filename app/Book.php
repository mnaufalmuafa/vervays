<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\Publisher;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Book extends Model
{
    protected $table = "books";

    protected $fillable = [
        'id', 'title', 'author', 'languageId', 'numberOfPage',
        'price', 'synopsis', 'isDeleted', 'ebookFileId',
        'sampleEbookFileId', 'ebookCoverId', 'publisherId', 'categoryId',
    ];
    
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

    public static function getBookDataForDashboardPublisher()
    {
        $userId = session('id');
        $publisherId = Publisher::getPublisherIdWithUserId($userId);
        $books = DB::table('books')
            ->where('publisherId', $publisherId)
            ->where('isDeleted', '0')
            ->get();
        $data = [];
        foreach ($books as $book) {
            array_push($data,[
                "id" => $book->id,
                "title" => $book->title,
                "author" => $book->author,
                "imageURL" => Book::getEbookCoverURL($book->ebookCoverId),
                "synopsis" => $book->synopsis,
                "rating" => Book::getBookRating($book->id),
                "ratingCount" => Book::getBookRatingCount($book->id),
                "soldCount" => Book::getBookSoldCount($book->id),
                "price" => Book::convertPriceToCurrencyFormat($book->price),
            ]);
        }
        return $data;
    }

    private static function getEbookCoverURL($ebookCoverId)
    {
        $fileName = DB::table('ebook_covers')
            ->where('id', $ebookCoverId)
            ->first()
            ->name;
        return url("ebook/ebook_cover/".$ebookCoverId."/".$fileName);
    }

    public static function getBookRating($id)
    {
        $rating = DB::table('reviews')
            ->join('have', 'reviews.haveId', '=', 'have.id')
            ->where('bookId', $id)
            ->avg('rating');
        return $rating ?? 0;
    }

    public static function getBookRatingCount($id)
    {
        $ratingCount = DB::table('reviews')
            ->join('have', 'reviews.haveId', '=', 'have.id')
            ->where('bookId', $id)
            ->count();
        return $ratingCount ?? 0;
    }

    public static function getBookSoldCount($id)
    {
        $soldCount = DB::table('book_snapshots')
            ->join('orders', 'book_snapshots.orderId', '=', 'orders.id')
            ->where('book_snapshots.bookId', $id)
            ->where('orders.status', 'success')
            ->count();
        return $soldCount ?? 0;
    }

    private static function convertPriceToCurrencyFormat($price)
    {
        return number_format($price,0,',','.');
    }

    public static function getBook($bookId)
    {
        return DB::table('books')
            ->where('id', $bookId)
            ->first();
    }

    public static function updateBook($book) {
        $data = [];
        if ($book["title"] != null) {
            $data = array_merge($data, array('title' => $book["title"]));
        }
        if ($book["author"] != null) {
            $data = array_merge($data, array('author' => $book["author"]));
        }
        if ($book["languageId"] != null) {
            $data = array_merge($data, array('languageId' => $book["languageId"]));
        }
        if ($book["numberOfPage"] != null) {
            $data = array_merge($data, array('numberOfPage' => $book["numberOfPage"]));
        }
        if ($book["price"] != null) {
            $data = array_merge($data, array('price' => $book["price"]));
        }
        if ($book["synopsis"] != null) {
            $data = array_merge($data, array('synopsis' => $book["synopsis"]));
        }
        if ($book["categoryId"] != null) {
            $data = array_merge($data, array('categoryId' => $book["categoryId"]));
        }
        if ($book["release_at"] != null) {
            $data = array_merge($data, array('release_at' => $book["release_at"]));
        }
        $data = array_merge($data, array("updated_at" => Carbon::now()));
        Book::where('id', $book["id"])->update($data);
    }

    public static function uploadCoverPhoto($file, $bookId)
    {
        $photoId = Book::getNewEbookCoverId();
        $photo = $file;
        $nama_file = $photo->getClientOriginalName();
        $tujuan_upload = 'ebook/ebook_cover/'.$photoId;
        $photo->move($tujuan_upload,$nama_file);
        DB::table('ebook_covers')->insert([
            "id" => $photoId,
            "name" => $photo->getClientOriginalName(),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('books')
            ->join('ebook_covers', 'books.ebookCoverId', '=', 'ebook_covers.id')
            ->where('books.id',$bookId)
            ->update([
                "ebookCoverId" => $photoId,
                "books.updated_at" => Carbon::now(),
            ]);
    }

    public static function uploadSampleEbook($file, $bookId)
    {
        $sampleEbookId = Book::getNewSampleEbookFilesId();
        $SampleEbook = $file;
        $nama_file = $SampleEbook->getClientOriginalName();
        $tujuan_upload = 'ebook/sample_ebook_files/'.$sampleEbookId;
        $SampleEbook->move($tujuan_upload,$nama_file);
        DB::table('sample_ebook_files')->insert([
            "id" => $sampleEbookId,
            "name" => $SampleEbook->getClientOriginalName(),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('books')
            ->join('sample_ebook_files', 'books.sampleEbookFileId', '=', 'sample_ebook_files.id')
            ->where('books.id',$bookId)
            ->update([
                "sampleEbookFileId" => $sampleEbookId,
                "books.updated_at" => Carbon::now(),
            ]);
    }

    public static function deleteBook($id) {
        $book = Book::find($id);
        $book->isDeleted = 1;
        $book->save();
        DB::table('carts')->where("bookId", $id)->delete();
        DB::table('wishes')->where("bookId", $id)->delete();
    }

    public static function getSixNewestBookForBuyerDashboard()
    {
        $books = DB::table('books')
            ->select('id', 'title', 'author', 'price', 'ebookCoverId')
            ->where('isDeleted', '0')
            ->orderBy('release_at','desc')
            ->take(6)
            ->get();
        foreach ($books as $book) {
            $book->price = Book::convertPriceToCurrencyFormat($book->price);
        }
        $bookArray = json_decode(json_encode($books), true); //mengubah objek menjadi array
        for ($i=0; $i < count($books); $i++) { 
            $rating = Book::getBookRating($bookArray[$i]["id"]);
            $rating = number_format((float) $rating, 1, '.', '');
            $bookArray[$i] = array_merge($bookArray[$i], array("rating" => $rating));
            $imageURL = Book::getEbookCoverURL($bookArray[$i]["ebookCoverId"]);
            $bookArray[$i] = array_merge($bookArray[$i], array("imageURL" => $imageURL));
        }
        return $bookArray;
    }

    public static function getSixEditorChoiceBookForBuyerDashboard()
    {
        $books = DB::table('books')
            ->select('id', 'title', 'author', 'price',  'ebookCoverId')
            ->where('isDeleted', '0')
            ->where('isEditorChoice', '1')
            ->take(6)
            ->get();
        foreach ($books as $book) {
            $book->price = Book::convertPriceToCurrencyFormat($book->price);
        }
        $bookArray = json_decode(json_encode($books), true); //mengubah objek menjadi array
        for ($i=0; $i < count($books); $i++) { 
            $rating = Book::getBookRating($bookArray[$i]["id"]);
            $rating = number_format((float) $rating, 1, '.', '');
            $bookArray[$i] = array_merge($bookArray[$i], array("rating" => $rating));
            $imageURL = Book::getEbookCoverURL($bookArray[$i]["ebookCoverId"]);
            $bookArray[$i] = array_merge($bookArray[$i], array("imageURL" => $imageURL));
        }
        return $bookArray;
    }

    public static function getSixBestsellerBookForBuyerDashboard()
    {
        $booksId = DB::select("SELECT `books`.`id` FROM `books`
                                JOIN `book_snapshots` ON `books`.`id` = `book_snapshots`.`bookId`
                                JOIN `orders` ON `book_snapshots`.`orderId` = `orders`.`id`
                                WHERE `orders`.`status` = 'success'
                                AND `books`.`isDeleted` = 0
                                GROUP BY `books`.`id`
                                ORDER BY COUNT(`books`.`id`) DESC
                                LIMIT 6"); //berupa array of object (array biasa)
        if (count($booksId) == 0) { // Jika tidak ada buku yang terjual
            return null;
        }
        $arrBooksId = [];
        array_splice($arrBooksId,0,1,$booksId);
        $pureArrBooksId = [];
        for ($i=0; $i < count($arrBooksId); $i++) { 
            if ($i == 0) {
                $pureArrBooksId[0] = $arrBooksId[0]->id;
            }
            else {
                array_push($pureArrBooksId, $arrBooksId[$i]->id);
            }
        }
        //
        $books = DB::table('books')
            ->select('id', 'title', 'author', 'price',  'ebookCoverId')
            ->where('isDeleted', '0')
            ->whereIn('id', $pureArrBooksId)
            ->take(6)
            ->get();
        foreach ($books as $book) {
            $book->price = Book::convertPriceToCurrencyFormat($book->price);
        }
        $bookArray = json_decode(json_encode($books), true); //mengubah objek menjadi array
        for ($i=0; $i < count($books); $i++) { 
            $rating = Book::getBookRating($bookArray[$i]["id"]);
            $rating = number_format((float) $rating, 1, '.', '');
            $bookArray[$i] = array_merge($bookArray[$i], array("rating" => $rating));
            $imageURL = Book::getEbookCoverURL($bookArray[$i]["ebookCoverId"]);
            $bookArray[$i] = array_merge($bookArray[$i], array("imageURL" => $imageURL));
        }
        return $bookArray;
    }

    public static function getBookForSearch($keyword)
    {
        $keywords = explode(" ",$keyword);
        $addOnQuery = " ";
        foreach ($keywords as $katakunci) {
            $addOnQuery = $addOnQuery."AND `title` LIKE '%".$katakunci."%' ";
        }
        $query = "SELECT
                    `books`.`id`, `title`, `author`, `languageId`, `price`, `release_at`, `synopsis`,
                    `ebookCoverId`, `categoryId`,
                    `languages`.`name` as 'Language' ,
                    `ebook_covers`.`name` as 'ebookCoverName',
                    `categories`.`name` as 'Category'
                    FROM `books` 
                    JOIN `ebook_covers` ON `books`.`ebookCoverId` = `ebook_covers`.`id`
                    JOIN `languages` ON `books`.`languageId` = `languages`.`id`
                    JOIN `categories` ON `books`.`categoryId` = `categories`.`id`
                    WHERE `isDeleted` = 0";
        $query = $query.$addOnQuery;
        $books = DB::select($query, [1]);
        foreach ($books as $book) {
            $book->rating = Book::getBookRating($book->id);
            // $book->rating = 5.0;
            $book->ratingCount = Book::getBookRatingCount($book->id);
            $book->soldCount = Book::getBookSoldCount($book->id);
            $book->priceForHuman = Book::convertPriceToCurrencyFormat($book->price);
        }
        // dd($books[0]);
        return response()->json($books);
    }

    private static function getLanguageName($languageId)
    {
        return DB::table('languages')
                    ->where('id', $languageId)
                    ->pluck('name')[0];
    }

    private static function getCategoryName($categoryId) {
        return DB::table('categories')
                    ->where('id', $categoryId)
                    ->pluck('name')[0];
    }

    public static function getBookForInfoPage($id)
    {
        $book = DB::table('books')
                    ->where('id', $id)
                    ->where('isDeleted', '0')
                    ->first();
        $book->priceForHuman = Book::convertPriceToCurrencyFormat($book->price);
        $book->language = Book::getLanguageName($book->languageId);
        $book->category = Book::getCategoryName($book->categoryId);
        $book->publisher = Publisher::getPublisherName($book->publisherId);
        $rating = Book::getBookRating($book->id);
        $rating = number_format((float) $rating, 1, '.', '');
        $book->rating = $rating;
        $book->ratingCount = Book::getBookRatingCount($book->id);
        $book->soldCount = Book::getBookSoldCount($book->id);
        $book->imageURL = Book::getEbookCoverURL($book->ebookCoverId);
        unset($book->ebookCoverId);
        unset($book->created_at);
        unset($book->updated_at);
        unset($book->price);
        unset($book->isDeleted);
        unset($book->isEditorChoice);
        return json_decode(json_encode($book), true);
    }

    public static function getPeopleGaveStarsCountAllRating($bookId)
    {
        return DB::table('reviews')
                    ->join('have', 'reviews.haveId', '=', 'have.id')
                    ->where('have.bookId', $bookId)
                    ->count();
    }

    public static function getPeopleGaveStarsCountByRating($bookId, $rating)
    {
        return DB::table('reviews')
                    ->join('have', 'reviews.haveId', '=', 'have.id')
                    ->where('have.bookId', $bookId)
                    ->where('rating', $rating)
                    ->count();
    }

    public static function getReviewsByBookId($bookId)
    {
        $reviews = DB::table('reviews')
                        ->select('reviews.id', 'rating', 'review', 'isAnonymous', 'firstName', 'lastName', 'isDeleted', 'reviews.created_at')
                        ->join('have', 'reviews.haveId', '=', 'have.id')
                        ->join('users', 'have.userId', '=', 'users.id')
                        ->where('have.bookId', $bookId)
                        ->orderBy('reviews.id', 'asc')
                        ->get();
        foreach ($reviews as $review) {
            $created_at = Carbon::parse($review->created_at)->toDateString();
            $review->created_at = $created_at;
        }
        return $reviews;
    }

    public static function getPublisherIdByBookId($bookId)
    {
        return DB::table('books')
                    ->where('id', $bookId)
                    ->get()[0]->publisherId;
    }

    public static function whetherTheUserHasAddedBookToCart($bookId)
    {
        $userId = session('id');
        $count = DB::table('carts')
                        ->where('userId', $userId)
                        ->where('bookId', $bookId)
                        ->count();
        if ($count == 1) {
            return json_encode(true);
        }
        return json_encode(false);
    }

    public static function whetherTheUserHasAddedBookToCartForModel($bookId)
    {
        $userId = session('id');
        $count = DB::table('carts')
                        ->where('userId', $userId)
                        ->where('bookId', $bookId)
                        ->count();
        if ($count == 1) {
            return true;
        }
        return false;
    }

    public static function addBookToCart($bookId)
    {
        if (!Book::whetherTheUserHasAddedBookToCartForModel($bookId)) {
            $userId = session('id');
            DB::table('carts')->insert([
                'bookId' => $bookId,
                'userId' => $userId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public static  function removeBookFromCart($bookId)
    {
        if (Book::whetherTheUserHasAddedBookToCartForModel($bookId)) {
            $userId = session('id');
            DB::table('carts')
                ->where('bookId', $bookId)
                ->where('userId', $userId)
                ->delete();
        }
    }

    public static function whetherTheUserHasAddedBookToWishList($bookId)
    {
        $userId = session('id');
        $count = DB::table('wishes')
                        ->where('userId', $userId)
                        ->where('bookId', $bookId)
                        ->count();
        if ($count == 1) {
            return json_encode(true);
        }
        return json_encode(false);
    }

    public static function whetherTheUserHasAddedBookToWishListForModel($bookId)
    {
        $userId = session('id');
        $count = DB::table('wishes')
                        ->where('userId', $userId)
                        ->where('bookId', $bookId)
                        ->count();
        if ($count == 1) {
            return true;
        }
        return false;
    }

    public static function addBookToWishList($bookId)
    {
        if (!Book::whetherTheUserHasAddedBookToWishListForModel($bookId)) {
            $userId = session('id');
            DB::table('wishes')->insert([
                'bookId' => $bookId,
                'userId' => $userId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    public static  function removeBookFromWishList($bookId)
    {
        if (Book::whetherTheUserHasAddedBookToWishListForModel($bookId)) {
            $userId = session('id');
            DB::table('wishes')
                ->where('bookId', $bookId)
                ->where('userId', $userId)
                ->delete();
        }
    }

    public static function getTotalPrice($arrBookId)
    {
        $totalPrice = 0;
        foreach ($arrBookId as $book) {
            $totalPrice = $totalPrice + DB::table('books')->where('id', $book->bookId)->pluck('price')[0];
        }
        return $totalPrice;
    }

    public static function getPrice($bookId)
    {
        return DB::table('books')->where('id', $bookId)->pluck('price')[0];
    }

    public static function getBooksByArrBookId($arrBookId)
    {
        return DB::table('books')->whereIn('id', $arrBookId)->get();
    }

    public static function getPublisherName($bookId)
    {
        $publisherId = DB::table('books')->where('id', $bookId)->pluck('publisherId')[0];
        return Publisher::getPublisherName($publisherId);
    }

    public static function getEbookCoverId($bookId)
    {
        return DB::table('books')->where('id', $bookId)->pluck('ebookCoverId')[0];
    }

    private static function getSampleEbookFileId($bookId)
    {
        return DB::table('books')->where('id', $bookId)->pluck('sampleEbookFileId')[0];
    }

    public static function getSampleBookFileURL($bookId)
    {
        $sampleEbookFileId = Book::getSampleEbookFileId($bookId);
        $sampleEbookFile = SampleEbookFile::getSampleEbookFile($sampleEbookFileId);
        return "/ebook/sample_ebook_files/".$sampleEbookFile->id."/".$sampleEbookFile->name;
    }
}
