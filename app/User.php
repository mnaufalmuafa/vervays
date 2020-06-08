<?php

namespace App;

use Illuminate\Support\Facades\DB;

class User
{
    public static function checkLogin($email, $password)
    {
        $user = DB::table('users')
            ->where('email', $email)
            ->where('password', $password)
            ->select('id')
            ->first();
        if ($user == null) {
            return 0;
        }
        else {
            session(['id' => $user->id]);
            return $user->id;
        }
    }
}
