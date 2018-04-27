<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comment extends Model
{

    protected $guarded = [];

    public static function getAllComments() {

        return self::get();

    }

    public static function saveComment($user_id, $post_id, $text) {

        self::insert([
            'author_id' => $user_id,
            'post_id' => $post_id,
            'text' => $text,
            'approved' => 0,
            'created_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s')
        ]);

    }

    public static function getCommentsPostIdApproved($post_id) {

        return self::where('post_id', '=', $post_id)->where('approved', '=', '1')->get()->reverse();

    }

    public static function getCommentsPostIdAll($post_id) {

        return self::where('post_id', '=', $post_id)->get()->reverse();

    }

    public static function deleteComment($id)
    {
        return self::where('id','=', $id)->delete();
    }

    public static function deleteAllCommentsPost($id)
    {
        return self::where('post_id','=', $id)->delete();
    }

    public static function getApprovedComment($id)
    {
        return self::where('id','=', $id)->value('approved');
    }

    public static function numberComment($id)
    {
        return count (self::where('post_id', '=', $id)->where('approved', '=','1')->get());
    }

    public static function setApprovedComment($id, $val)
    {
        return self::where('id','=', $id)
            ->update([
                'approved' => $val,
                'updated_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s')
            ]);
    }

    public static function changeApprovedComment($id)
    {
        $val = self::where('id','=', $id)->value('approved');
        if($val == 0){
            return self::where('id','=', $id)
                ->update([
                    'approved' => '1',
                    'updated_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s')
                    ]);
        }
        else{
            return self::where('id','=', $id)
                ->update([
                    'approved' => '0',
                    'updated_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s')
                    ]);
        }

    }

}

