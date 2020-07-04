<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Order;

class OrderController extends Controller
{
    public function index()
    {
        $data = [
            "firstName" => User::getFirstName(session('id'))
        ];
        return view('pages.buyer.cart', $data);
    }

    public function getUserCart(Request $request)
    {
        // $userId = session('id');
        return Order::getUserCart($request->userId);
    }

    public function create(Request $request)
    {
        return Order::createOrder($request->paymentMethod);
    }

    public function whetherTheTransactionIsPendingOrSuccess(Request $request)
    {
        return Order::whetherTheTransactionIsPendingOrSuccess($request->bookId);
    }

    public function showList()
    {
        $data = [
            "firstName" => User::getFirstName(session('id'))
        ];
        return view('pages.buyer.orders', $data);
    }
}
