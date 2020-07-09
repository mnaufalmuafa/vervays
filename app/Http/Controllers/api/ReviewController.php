<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Reviews;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function haveUserGivenBookRating(Request $request)
    {
        return response()->json(Reviews::didTheUserGiveAReview($request->bookId));
    }
}
