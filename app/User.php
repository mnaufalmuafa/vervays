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
            $id = User::getUsersCount()+1;
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

    private static function getLastName($id)
    {
        $result = DB::table('users')
            ->where('id', $id)
            ->select('lastName')
            ->get();
        return $result[0]->lastName;
    }

    private static function getUsersCount() {
        return DB::table('users')->get()->count();
    }

    private static function getPublishersCount() {
        return DB::table('publishers')->get()->count();
    }

    public static function bePublisher($id) {
        $user = DB::table('publishers')
            ->where('userId', $id)
            ->first();
        if ($user == null) { //Belum menjadi publisher
            $name = User::getFirstName($id) . ' '
                . User::getLastName($id);
            $now = Carbon::now();
            DB::table('publishers')->insert([
                "id" => User::getPublishersCount()+1,
                "userId" => $id,
                "profilePhotoId" => 1,
                "name" => $name,
                "description" => "-",
                "balance" => 0,
                "month" => $now->month,
                "year" => $now->year,
                "created_at" => $now,
                "updated_at" => $now,
            ]);
        }
    }

    public static function getPublisherData($userId)
    {
        $publisher = DB::table('publishers')
            ->select('id', 'profilePhotoId', 'publishers.name', 'description', 'balance', 'month', 'year')
            ->where('userId', $userId)
            ->first();
        $photo = DB::table('profile_photos')
            ->select('name')
            ->where('id', $publisher->id)
            ->first();
        $balance = number_format($publisher->balance,2,',','.');
        $photoURL = '/image/profile_photos/'.$publisher->profilePhotoId;
        $photoURL = $photoURL.'/'.$photo->name.'.jpg';
        $photoURL = url($photoURL);
        return [
            "photoURL" => $photoURL,
            "name" => $publisher->name,
            "description" => $publisher->description,
            "balance" => $balance,
            "month" => User::convert_month_int_to_string_word($publisher->month),
            "year" => $publisher->year,
        ];
    }

    private static function convert_month_int_to_string_word($month) {
        if ($month == 1) {
            return "Januari";
        }
        if ($month == 2) {
            return "Februari";
        }
        if ($month == 3) {
            return "Maret";
        }
        if ($month == 4) {
            return "April";
        }
        if ($month == 5) {
            return "Mei";
        }
        if ($month == 6) {
            return "Juni";
        }
        if ($month == 7) {
            return "Juli";
        }
        if ($month == 8) {
            return "Agustus";
        }
        if ($month == 9) {
            return "September";
        }
        if ($month == 10) {
            return "Oktober";
        }
        if ($month == 11) {
            return "November";
        }
        return "Desember";
    }
}
