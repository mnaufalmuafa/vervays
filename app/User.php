<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    public static function signUp($firstName, $lastName, $email, $password)
    {
        $user = DB::table('users')
            ->where('email', $email)
            ->first();
        if ($user == null) {
            $id = DB::table('users')->get()->count()+1;
            $lastName = $lastName == null ? "" : $lastName;
            DB::table('users')->insert([
                "id" => $id,
                "firstName" => $firstName,
                "lastName" => $lastName,
                "isDeleted" => 0,
                "email" => $email,
                "password" => $password,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            session(['id' => $id]);
            return 1;
        }
        else {
            return 0;
        }
    }

    public static function getFirstName($id)
    {
        $result = DB::table('users')
            ->where('id', $id)
            ->select('firstName')
            ->get();
        return $result[0]->firstName;
    }
}
