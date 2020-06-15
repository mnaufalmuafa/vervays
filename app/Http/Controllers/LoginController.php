<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function checkLogin(Request $request)
    {
        $errorMsg = [
            "email.required" => "Masukkan alamat email anda",
            "email.email" => "Masukkan format email yang tepat",
            "password.required" => "Masukkan password",
            "password.min" => "Password harus lebih dari 7 karakter",
        ];
        $request->validate([
            "email" => "required|email",
            "password" => "required|min:8"
        ], $errorMsg);

        $id = User::checkLogin($request->email, $request->password);
        if ($id == 0) {
            return view('pages.login', ["InvalidInputErrorMessage" => "Email atau password salah"]);
        }
        else {
            return redirect()->route('dashboard');
        }
    }
}
