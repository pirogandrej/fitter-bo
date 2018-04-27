<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Category extends Model
{

    protected $guarded = [];

    public static function getAllCategories() {

        return self::get();

    }

    public static function createNewCategory($data) {

        return self::insert([
            'image' => $data['image'],
            'title' => $data['title'],
            'description' => $data['description'],
            'created_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s')
        ]);

    }

    public static function getCategory($id) {

        return self::where('id', '=', $id)->first();

    }

    public static function updateCategory($data) {

        return self::where('id','=', $data['id'])
            ->update([
                'id' => $data['id'],
                'image' => $data['image'],
                'title' => $data['title'],
                'description' => $data['description'],
                'updated_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s')
            ]);

    }

    public static function deleteCategory($id)

    {
        return self::where('id','=', $id)->delete();
    }

    public static function getCategoryName($id){
        return self::where('id','=', $id)->value('title');
    }

    public static function getImageNameId($id) {

        return self::where('id','=', $id)->value('image');
    }

}

