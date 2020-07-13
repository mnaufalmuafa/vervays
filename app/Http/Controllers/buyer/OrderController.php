<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Order;
use App\Book;
use App\PaymentMethod;
use App\Step;

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

    public function getUserOrdersForOrdersPage()
    {
        return Order::getUserOrders(session('id'));
    }

    public function getBooksByOrderId(Request $request)
    {
        return Order::getBooksByOrderId($request->orderId);
    }

    public function showOrderDetail(Request $request)
    {
        $orderId = $request->orderId;
        $paymentId = Order::getPaymentId($orderId);
        $arrPaymentMethod = PaymentMethod::getArrPaymentMethodByPaymentIdForOrderInfoPage($paymentId);
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "order" => Order::getOrderForOrderInfoPage($orderId),
            "books" => Book::getBookDataForOrderInfoPage($orderId),
            "arrPaymentMethod" => $arrPaymentMethod,
            "arrStep" => Step::getPaymentMethodStepsForOrderInfoPage($arrPaymentMethod),
        ];
        // dd($data["paymentMethod"]);
        return view('pages.buyer.info_order', $data);
    }
}
