<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    public function getUserCart(Request $request)
    {
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

    public function getUserOrdersForOrdersPage()
    {
        return Order::getUserOrders(session('id'));
    }

    public function getBooksByOrderId(Request $request)
    {
        return Order::getBooksByOrderId($request->orderId);
    }

    public function getPaymentCodeFromMidtrans(Request $request)
    {
        return Order::getPaymentCodeFromMidtrans($request->get('orderId'), $request->get('paymentMethod'));
    }
}
