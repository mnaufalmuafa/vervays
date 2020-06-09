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

Route::get('/login', 'LoginController@index')
    ->middleware('LoginAndSignUpMiddleware')
    ->name('login');

Route::post('/login', 'LoginController@checkLogin')
    ->middleware('LoginAndSignUpMiddleware');

Route::post('/logout', 'LogoutController@index');

Route::get('/signup', 'SignUpController@index')
    ->middleware('LoginAndSignUpMiddleware')
    ->name('signup');

Route::post('/signup', 'SignUpController@signUp')
    ->middleware('LoginAndSignUpMiddleware');


// UNTUK BUYER
Route::get('/dashboard', 'buyer\DashboardController@index')
    ->middleware('IsLogin')
    ->name('dashboard');

Route::get('/search', 'buyer\SearchController@index')
    ->middleware('IsLogin')
    ->name('search');

Route::post('/bepublisher', 'publisher\DashboardController@bePublisher')
    ->middleware('IsLogin');

// UNTUK PUBLISHER
Route::prefix('/publisher')->group(function() {
    Route::get('/dashboard', 'publisher\DashboardController@index')
        ->middleware('IsLogin')
        ->name('dashboard-publisher');
});
