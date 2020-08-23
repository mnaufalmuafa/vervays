<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\FlashMessages;
use Illuminate\Http\Request;

class FlashMessageController extends Controller
{
    public function getFlashMessages(Request $request)
    {
        $flashMessages = FlashMessages::where('userId', session('id'))->get();
        FlashMessages::where('userId', session('id'))->delete();
        return response()->json($flashMessages);
    }
}
