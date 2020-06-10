<?php

namespace App\Http\Controllers\publisher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "publisher" => User::getPublisherData(session('id')),
        ];
        return view('pages.publisher.dashboard', $data);
    }

    public function bePublisher()
    {
        $id = session('id');
        User::bePublisher($id);
        return true;
    }

    public function editDataPublisher()
    {
        return "Edit Data";
    }

    public function updateDataPublisher($id)
    {
        // TODO
    }
}
