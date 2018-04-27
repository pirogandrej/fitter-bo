<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{

    protected $guarded = [];

    public static function getPost($id) {

        return self::where('id', '=', $id)->first();

    }

    public static function getMaxPostId() {

        return self::max('id');

    }

    public static function getAllPostsByUser($id) {

        return self::where('author_id', '=', $id)->orderBy('updated_at', 'DESK')->get();

    }

    public static function getAllPostsWithUser()
    {
        return self::with('user')->orderBy('approved')->orderBy('updated_at', 'DESK')->get();
    }

    public static function addPost($data) {

        return self::updateOrCreate(
            ['id' => !empty($data['id']) ? $data['id'] : self::max('id') + 1],
            [
                'author_id' => $data['author_id'],
                'category_id' => $data['category_id'],
                'title' => $data['title'],
                'text' => $data['text'],
                'small_image' => $data['small_image'],
                'large_image' => $data['large_image'],
                'hash_tags' => $data['hash_tags'],
                'active' => $data['active'],
                'approved' => $data['approved'],
                'created_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s')
            ]
        );
    }

    public static function updatePost($data) {

        return self::where('id', '=', $data['id'])
            ->update([
                'author_id' => $data['author_id'],
                'category_id' => $data['category_id'],
                'title' => $data['title'],
                'text' => $data['text'],
                'small_image' => $data['small_image'],
                'large_image' => $data['large_image'],
                'hash_tags' => $data['hash_tags'],
                'active' => $data['active'],
                'approved' => $data['approved'],
                'updated_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s')
            ]);
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'author_id');
    }

    public static function changeView($post_id)
    {
        self::where('id','=', $post_id)->increment('view');
        self::where('id','=', $post_id)
            ->update([
                'updated_at' => Carbon::now()->addHours(3)->format('Y-m-d H:i:s')
            ]);
        return;

    }

    public static function getPostsRecomended($user_id, $post_id)
    {
        return self::where('author_id','=', $user_id)->where('id','!=', $post_id)->where('active','=', 1)->latest()->limit(3)->get()->reverse();
    }

    public static function deletePost($id)
    {
        return self::where('id','=', $id)->delete();
    }

    public static function getTitlePost($id){
        return self::where('id','=', $id)->value('title');
    }

    public static function getSmallImgPost($id)
    {
        return self::where('id','=', $id)->value('small_image');
    }

    public static function getLargeImgPost($id)
    {
        return self::where('id','=', $id)->value('large_image');
    }

    public static function changeApprovedPost($id)
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

    public static function getPostsByCategoryId($id) {

        return self::where('category_id', '=', $id)->get();

    }

    public static function getCreatedAtPostId($id) {

        return self::where('id', '=', $id)->value('created_at');

    }

    public static function getSearchQuery($array)
    {

        $posts = self::Where(function ($query) use($array) {
                for ($i = 0; $i < count($array); $i++){
                    $query->where(strtolower('title'), 'like',  '%' . $array[$i] .'%');
                }
            })->get();

        return $posts;
    }

}

