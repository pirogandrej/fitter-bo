<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;

class Like extends Model
{

    protected $guarded = [];

    public static function hasLike($post_id) {

        $like = self::where('post_id', $post_id)->where('author_id', Auth::user()->id)->get();

        if( !empty($like[0]) ) {

            return true;

        } else {

            return false;

        }

    }

    public static function changeLike($post_id) {

        $like = self::where('post_id', $post_id)->where('author_id', Auth::user()->id)->get();

        if( !empty($like[0]) ) {

            self::where('post_id', $post_id)->where('author_id', Auth::user()->id)->delete();

        } else {

            self::insert([
                'post_id'   => $post_id,
                'author_id' => Auth::user()->id,
                'created_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s')
                ]);

        }

    }

    public static function getPostId($id) {

        return self::where('id', '=', $id)->value('post_id');

    }

    public static function deleteAllLikesPost($id)
    {
        return self::where('post_id','=', $id)->delete();
    }

    public static function numberLike($id)
    {
        return count (self::where('post_id', '=', $id)->get());
    }

}

