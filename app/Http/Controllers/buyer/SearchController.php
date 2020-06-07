<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->keyword) {
            return redirect()->route('dashboard');
        }
        else {
            $data = [
                "keyword" => $request->keyword,
            ];
            return view('pages.buyer.search', $data);
        }
    }
}
