<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect()->route('dashboard');
});

Route::prefix('/get')->group(function() {
    Route::get('/get_book_s_publisher_name/{bookId}', 'buyer\BookController@getPublisherName');
    Route::get('/get_ebook_cover_by_book_id/{bookId}', 'api\EbookCoverController@getEbookCoverByBookId');
    Route::get('/have_user_given_book_rating/{bookId}', 'api\ReviewController@haveUserGivenBookRating');
});

Route::middleware(['LoginAndSignUpMiddleware'])->group(function() {
    Route::get('/login', 'LoginController@index')
        ->name('login');

    Route::post('/login', 'LoginController@checkLogin');

    Route::get('/signup', 'SignUpController@index')
        ->name('signup');

    Route::post('/signup', 'SignUpController@signUp');

    Route::prefix('/account')->group(function() {
        Route::get('/begin_reset_password', 'LoginController@beginResetPassword');
        Route::post('/begin_reset_password', 'LoginController@resetPassword');
        Route::get('/reset/password/from/email', 'LoginController@changePassword');
        Route::get('/reset/password/sent', 'LoginController@resetPasswordSent')->name('reset-password-sent');
        Route::post('/reset/password/from/email', 'LoginController@updatePassword');
    });
});

Route::post('/logout', 'LogoutController@index');

Route::get('/account/verificate', 'SignUpController@verificateEmail');

Route::get('/search/book', 'buyer\SearchController@search');

Route::middleware(['IsLogin'])->group(function() {
    Route::get('/email/verification', 'SignUpController@emailVerification')
        ->middleware('IsTheEmailNotVerified')
        ->name('email-verification');

    Route::middleware(['HasTheEmailBeenVerified', 'CheckOrderStatus'])->group(function(){
        // UNTUK BUYER
        Route::get('/dashboard', 'buyer\DashboardController@index')
            ->name('dashboard');

        Route::get('/search', 'buyer\SearchController@index')
            ->name('search');

        Route::post('/bepublisher', 'publisher\DashboardController@bePublisher');

        Route::get('/book/detail/{id}/{slug}', 'buyer\BookController@index');

        Route::get('/mybook', 'buyer\BookController@mybook')->name('mybook');

        Route::get('/wishes', 'buyer\WishesController@index')->name('wishlist');
        Route::get('/cart', 'buyer\OrderController@index')->name('cart');
        Route::get('/orders', 'buyer\OrderController@showList')->name('orders');
        Route::get('/read/sample/{bookId}', 'buyer\ReadController@readSample');
        Route::get('/read/book/{bookId}', 'buyer\ReadController@readBook');
        Route::get('/give_rating/{bookId}', 'buyer\BookController@giveRating');

        Route::prefix('/get')->group(function() {
            Route::get('/user_wishlist', 'buyer\WishesController@getUserWishlist');
            Route::get('/get_user_role_for_ebook_info_page/{bookId}', 'buyer\BookController@getUserRoleForEbookInfoPage');
            Route::get('/get_user_cart', 'buyer\OrderController@getUserCart');
            Route::get('/whether_the_transaction_is_pending_or_success/{bookId}', 'buyer\OrderController@whetherTheTransactionIsPendingOrSuccess');
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            Route::get('/get_people_gave_stars_count_all_rating/{id}', 'buyer\BookController@getPeopleGaveStarsCountAllRating');
            Route::get('/get_people_gave_stars_count_by_rating/{id}/{rating}', 'buyer\BookController@getPeopleGaveStarsCountByRating');
            Route::get('/get_reviews_by_book_id/{bookId}', 'buyer\BookController@getReviewsByBookId');
            Route::get('/whether_the_user_has_added_book_to_cart/{bookId}', 'buyer\BookController@whetherTheUserHasAddedBookToCart');
            Route::get('/whether_the_user_has_added_book_to_wish_list/{bookId}', 'buyer\BookController@whetherTheUserHasAddedBookToWishList');
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            Route::get('/get_user_orders_for_orders_page', 'buyer\OrderController@getUserOrdersForOrdersPage');
            Route::get('/get_books_by_order_id/{orderId}', 'buyer\OrderController@getBooksByOrderId');
            Route::get('/update_last_read/{bookId}/{lastRead}', 'api\HaveController@updateLastRead');
            Route::get('/get_last_read/{bookId}', 'api\HaveController@getLastRead');
            Route::get('/get_user_books', 'api\BookController@getUserBooks');
        });

        Route::prefix('/post')->group(function() {
            Route::post('/add_book_to_cart/{bookId}', 'buyer\BookController@addBookToCart');
            Route::post('/remove_book_from_cart/{bookId}', 'buyer\BookController@removeBookFromCart');
            Route::post('/add_book_to_wish_list/{bookId}', 'buyer\BookController@addBookToWishList');
            Route::post('/remove_book_from_wish_list/{bookId}', 'buyer\BookController@removeBookFromWishList');
            Route::post('/create_order', 'buyer\OrderController@create');
        });

        // UNTUK PUBLISHER
        Route::prefix('/publisher')->middleware('DoesPublishers')->group(function() {

            Route::get('/dashboard', 'publisher\DashboardController@index')
                ->name('dashboard-publisher');

            Route::get('/edit', 'publisher\DashboardController@editDataPublisher')
                ->name('edit-data-publisher');
            
            Route::post('/edit', 'publisher\DashboardController@updateDataPublisher')
                ->name('edit-data-publisher-POST');
            
            Route::get('/input/book', 'publisher\BookController@create')
                ->name('input-book');

            Route::post('/input/book', 'publisher\BookController@store')
                ->name('input-book-POST');

            Route::get('/cashout', 'publisher\BalanceController@cashout');

            Route::prefix('/post')->group(function (){
                Route::post('/cashout', 'publisher\BalanceController@withdrawBalance');
            });

            Route::middleware(['DoesPublisherHaveThatBook'])->group(function() {
                Route::get('/edit/book', 'publisher\BookController@edit')
                    ->name('edit-book');

                Route::post('/edit/book', 'publisher\BookController@update')
                    ->name('edit-book-POST');

                Route::post('/delete/book', 'publisher\BookController@destroy')
                    ->name('delete-book');
            });

        });
    });

        
});

