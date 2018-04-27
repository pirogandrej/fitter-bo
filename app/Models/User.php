<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class User extends Model
{

    protected $guarded = [];

    public static function getUserData($id) {

        return self::where('id', '=', $id)->firstOrFail();

    }

    public static function getUser($id) {

        return self::where('id', '=', $id)->firstOrFail();

    }

    public static function getAllUsers() {

        return self::all();

    }

    public static function insertMyUser($data) {

        return self::insert([
            'name' => $data['name'],
            'avatar' => $data['avatar'],
            'email' => $data['email'],
            'access' => $data['access'],
            'admin_role' => $data['admin_role'],
            'password' => bcrypt($data['password']),
            'created_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s')
        ]);
    }

    public static function updateMyUser($data) {

        return self::where('id', $data['id'])->update([
            'name' => $data['name'],
            'avatar' => $data['avatar'],
            'email' => $data['email'],
            'access' => $data['access'],
            'admin_role' => $data['admin_role'],
            'password' => $data['password'],
            'updated_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s')
        ]);
    }

    public static function updateMyProfile($data) {

        return self::where('id', $data['id'])->update([
            'name' => $data['name'],
            'avatar' => $data['avatar'],
            'email' => $data['email'],
            'password' => $data['password'],
            'updated_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s')
        ]);
    }

    public static function deleteUser($id) {

        return self::where('id', '=', $id)->delete();

    }

    public static function getNameUser($id){

        return self::where('id', '=', $id)->value('name');
    }

    public static function getAvatarUser($id){

        return self::where('id', '=', $id)->value('avatar');
    }

}

