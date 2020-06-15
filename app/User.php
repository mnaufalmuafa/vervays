<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class User
{
    public static function checkLogin($email, $password)
    {
        $user = DB::table('users')
            ->where('email', $email)
            ->where('password', $password)
            ->where('isDeleted', '0')
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
            ->where('isDeleted', '0')
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
            ->join('users', 'users.id', '=', 'publishers.userId')
            ->where('userId', $id)
            ->where('users.isDeleted', 0)
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
            ->where('id', $publisher->profilePhotoId)
            ->first();
        $balance = number_format($publisher->balance,2,',','.');
        $photoURL = '/image/profile_photos/'.$publisher->profilePhotoId;
        $photoURL = $photoURL.'/'.$photo->name;
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

    public static function doesUserAmongThePublishers($userId)
    {
        $value = DB::table('publishers')
            ->join('users', 'users.id', '=', 'publishers.userId')
            ->where('userId', $userId)
            ->where('users.isDeleted', 0)
            ->get()
            ->count();
        if ($value == 1) {
            return true;
        }
        return false;
    }

    public static function IsTheEmailNotVerified()
    {
        $id = session('id');
        $value = DB::table('users')
            ->select('email_verified_at')
            ->where('id', $id)
            ->first()
            ->email_verified_at;
        if ($value == null) {
            return true;
        }
        return false;
    }

    public static function createEmailVerificationToken() {
        $faker = Faker::create('id_ID');
        $id = session('id');
        $token = $faker->md5;
        DB::table('email_verification_tokens')->insert([
            "userId" => $id,
            "token" => $token,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        return $token;
    }

    public static function isEmailVerificationExist($userId, $token)
    {
        $value = DB::table('email_verification_tokens')
            ->where('userId', $userId)
            ->where('token', $token)
            ->first();
        return $value != null;
    }

    public static function verificateEmail($userId)
    {
        DB::table('email_verification_tokens')
            ->where('userId', $userId)
            ->delete();
        DB::table('users')
            ->where('id', $userId)
            ->update([
                "email_verified_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);
    }

    public static function getCurrentUserEmail()
    {
        $id = session('id');
        return DB::table('users')
            ->where('id', $id)
            ->first()
            ->email;
    }

    public static function createResetPasswordToken($email)
    {
        $faker = Faker::create('id_ID');
        $token = $faker->md5;
        $id = User::getIdByEmail($email);
        if ($id == 0) { //Jika email tidak terdaftar
            $token = 0;
        }
        else { // Jika email terdaftar
            DB::table('password_reset_tokens') //Menghapus token reset password jika ada
                ->where('userId', User::getIdByEmail($email))
                ->delete();
            DB::table('password_reset_tokens')->insert([ //Membuat token reset
                    "userId" => User::getIdByEmail($email),
                    "token" => $token,
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);
        }
        return $token;
    }

    public static function getFirstNameByEmail($email)
    {
        $result = DB::table('users')
            ->where('email', $email)
            ->select('firstName')
            ->get();
        return $result[0]->firstName;
    }

    public static function getIdByEmail($email) {
        $result = DB::table('users')
            ->where('email', $email)
            ->where('isDeleted', '0')
            ->select('id')
            ->get();
        return $result[0]->id ?? 0;
    }

    public static function isPasswordResetRequestExist($userId, $token)
    {
        $value = DB::table('password_reset_tokens')
            ->where('userId', $userId)
            ->where('token', $token)
            ->first();
        return $value != null;
    }

    public static function updatePassword($userId, $newPassword)
    {
        $value = DB::table('users')
                    ->where('id', $userId)
                    ->where('isDeleted', '0')
                    ->first();
        if ($value != null) {
            DB::table('users')
                ->where('id', $userId)
                ->where('isDeleted', '0')
                ->update([
                    "password" => $newPassword,
                    "updated_at" => Carbon::now(),
                ]);
            DB::table('password_reset_tokens')
                ->where('userId', $userId)
                ->delete();
            return true; // Tanda jika berhasil update password
        }
        return false; // Tanda jika gagal update password
    }
}
