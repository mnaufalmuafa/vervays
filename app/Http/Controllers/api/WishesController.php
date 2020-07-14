<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Wishes;

class WishesController extends Controller
{
    public function getUserWishlist()
    {
        return Wishes::getUsersWishlist();
    }
}
