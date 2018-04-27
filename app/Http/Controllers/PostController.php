<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Category;
use Auth;
use Image;
use Config;
use Helper;

class PostController extends Controller
{
    public function __construct()
    {
    }


    public function posts_posts()
    {

        $datas = Post::getAllPostsWithUser();

        $data['datas'] = $datas;
        $sumOut = 0;

        if (count($datas) <= 8)
        {
            $posts = $datas;
            $data['sumpostsout'] = '-1';
        }
        else
        {
            $num = 0;
            foreach ($datas as $key => $data ){
                $posts[$key] = $data;
                $num++;
                $sumOut++;
                if($num >= 8)
                {
                    break;
                }
            }
        }
        $data['sumpostsout'] = $sumOut;
        $data['posts'] = [];

        if(count($posts) > 0)
        {
            $data['posts'] = self::post_constructor($posts);
        }

        $data['large_image'] = 'https://experiencinginformation.files.wordpress.com/2016/03/blueprint.jpg';

        $data['categories'] = Category::getAllCategories();

        return view('load_more_main', $data);

    }

    public function loadDataAjax(Request $request)
    {
        $output = '';
        $sumpostsout = $request->input('sumpostsout');
        $datas = Post::getAllPostsWithUser();

        if($sumpostsout != count($datas))
        {

            $posts = [];
            $j=0;
            for($i = $sumpostsout;($i<($sumpostsout+8)) && ($i<count($datas));$i++){
                $posts[$j] = $datas[$i];
                $j++;
            }
            $sumpostsout = $sumpostsout + $j;

            $data['posts'] = [];

            if(count($posts) > 0)
            {
                $data['posts'] = self::post_constructor($posts);
            }

            if(count($posts) > 0)
            {
                foreach($posts as $post)
                {

                    if(($post['active'] == 1) && ($post['approved'] == 1)) {

                        if ($post['largePosition'] == 0) {
                            $resultLike = ($post["has_like"]) ? "has-like" : "";
                            $output .= '
                                <div class="col-lg-4 col-md-6" >
                                    <div class="card h-100" >
                                        <div class="single-post post-style-1" >
        
                                            <a href = "/posts/' . $post['id'] . '" >
                                                <div class="blog-image" ><img src = "' . $post['small_image_url'] . '" alt = "Blog Image" ></div >
                                            </a >
                                            <a class="avatar" href = "' . route('posts_author', $post['author_id']) . '" ><img src = "' . $post['avatar'] . '" alt = "Profile Image" ></a >
        
                                            <div class="blog-info" >
        
                                                <h4 class="title" ><a href = "/posts/' . $post['id'] .'" ><b >' . $post['title'] . '</b ></a ></h4 >
        
                                                <ul class="post-footer">
                                                    <li><p id="heart"
                                                           class="' . $resultLike . '"
                                                           data-url="'. route("change_like", $post["id"]) .'"
                                                           onclick="like_ajax(this)">
                                                            <i class="ion-heart"></i>
                                                            <span>'. $post["likes_num"].' </span>
                                                        </p>
                                                    </li>
                                                    <li ><p href = "#" ><i class="ion-chatbubble p-eye" ></i >' . $post['comments_num'] . '</p ></li >
                                                    <li ><p href = "#" ><i class="ion-eye p-eye" ></i >' . $post['view'] . '</p ></li >
                                                </ul >
        
                                            </div >
                                        </div >
                                    </div >
                                </div >';
                        }
                        else {
                            $resultLike = ($post["has_like"]) ? "has-like" : "";
                            $output .= '
                                <div class="col-lg-8 col-md-12" >
                                    <div class="card h-100" >
                                        <div class="single-post post-style-2" >
        
                                            <div class="blog-image"
                                                 onclick = "location.href=\'/posts/' . $post['id'] . '\';"
                                                 style = "background: url(\'' . $post['small_image_url'] . '\') no-repeat;
                                                         background-size: cover;
                                                         cursor:pointer;
                                                         ">
                                            </div >
        
                                            <div class="blog-info" >
        
                                                <h4 class="title" ><a href = "/posts/' . $post['id'] . '" ><b >' . $post['title'] . '</b ></a ></h4 >' . $post['shortText'] . '
        
                                                <div class="avatar-area" >
                                                    <a class="avatar" href = "' . route('posts_author', $post['author_id']) . '" ><img src = "' . $post['avatar'] . '" alt = "Profile Image" ></a >
                                                    <div class="right-area" >
                                                        <a class="name" href = "' . route('posts_author', $post['author_id']) . '" ><b >' . $post['user_name'] . '</b ></a >
                                                        <h6 class="date" href = "#" >' . $post['updated_at'] . '</h6 >
                                                    </div >
                                                </div >
        
                                                <ul class="post-footer" >
                                                    <li><p id="heart"
                                                           class="' . $resultLike . '"
                                                           data-url="'. route("change_like", $post["id"]) .'"
                                                           onclick="like_ajax(this)">
                                                            <i class="ion-heart"></i>
                                                            <span>'. $post["likes_num"].' </span>
                                                        </p>
                                                    </li>
                                                    <li ><p ><i class="ion-chatbubble p-eye" ></i >' . $post['comments_num'] . '</p ></li >
                                                    <li ><p ><i class="ion-eye p-eye" ></i >' . $post['view'] . '</p ></li >
                                                </ul >
        
                                            </div >
        
                                        </div >
        
                                    </div >
                                </div >';
                        }

                    }

                }

            }
            if ($sumpostsout != count($datas))
            {
                $output .= '<div id="remove-row" style="width: 100%;">
                            <button id="btn-more" data-url="/loaddatapost" data-sumpostsout="' . $sumpostsout . '" class="load-more-btn"> Load More </button>
                        </div>';
            }
            else
            {
                $output .= '<div id="remove-row" style="width: 100%;">
                            <h4>Статьи все загружены.</h4>
                        </div>';
            }
        }

        echo $output;
    }

    public function posts_index($id)
    {

        $post = Post::find($id);

        $data['post'] = self::post_constructor($post);

        $data_recomended = Post::getPostsRecomended($data['post']['author_id'], $id);

        if(count($data_recomended) > 0){
            $data['post']['recomended'] = self::post_constructor($data_recomended);
        }

        $data['post']['comments'] = self::comments_constructor($id);

        $data['categories'] = Category::getAllCategories();

        return view('post.show_post', $data);

    }

    public function posts_top()
    {

        $posts = Post::getAllPostsWithUser();

        $numberPosts = count($posts);

        $data['posts'] = self::post_constructor($posts);

        foreach ($data['posts'] as $key => $post){
            $results[$key]['like_num'] = $post['likes_num'];
            $results[$key]['views_num'] = $post['views_num'];
            $results[$key]['like_post_id'] = $post['like_post_id'];
            $results[$key]['days_post'] = $this->getDaysPostId($post['like_post_id']);
            if ($results[$key]['views_num'] == 0) $results[$key]['views_num'] = 1;
            if ($results[$key]['days_post'] == 0) $results[$key]['days_post'] = 1;
            $results[$key]['post_index'] = ($results[$key]['like_num'] / ($results[$key]['views_num'])) / ($results[$key]['days_post']);
        }

        usort($results, function ($a, $b) {
            if($a['post_index']==$b['post_index']) return 0;
            return ($a['post_index'] < $b['post_index']) ? 1 : -1;
        });

        $numArr = 0;
        $arrTopPosts = [];
        foreach($results as $key => $result){
            if (((($result['post_index'] > 0) && ($numArr < 10)) && ($numberPosts > 10) ) || ($numberPosts <= 10)) {
                $arrTopPosts[$numArr] = Post::getPost($result['like_post_id']);
                $numArr++;
            }
        }

        $data['posts'] = [];

        if(count($arrTopPosts) > 0)
        {
            $data['posts'] = self::post_constructor($arrTopPosts);
        }

        $data['large_image'] = 'https://experiencinginformation.files.wordpress.com/2016/03/blueprint.jpg';

        $data['categories'] = Category::getAllCategories();

        return view('main', $data);

    }

    public function posts_fresh()
    {

        $posts = Post::getAllPostsWithUser();

        $data['posts'] = self::post_constructor($posts);

        foreach ($data['posts'] as $key => $post){
            $results[$key]['days_post'] = $this->getDaysPostId($post['post_id']);
            $results[$key]['post_id'] = $post['post_id'];
        }

        usort($results, function ($a, $b) {
            if($a['days_post']==$b['days_post']) return 0;
            return ($a['days_post'] > $b['days_post']) ? 1 : -1;
        });

        $numArr = 0;
        foreach($results as $key => $result){
            if ($numArr < 10) {
                $arrFreshPosts[$numArr] = Post::getPost($result['post_id']);
                $numArr++;
            }
        }

        $data['posts'] = self::post_constructor($arrFreshPosts);

        $data['large_image'] = 'https://experiencinginformation.files.wordpress.com/2016/03/blueprint.jpg';

        $data['categories'] = Category::getAllCategories();

        return view('main', $data);

    }

    public function posts_category()
    {

        $categories = Category::getAllCategories();

        $data['posts'] = self::categories_constructor($categories);

        $data['large_image'] = 'https://experiencinginformation.files.wordpress.com/2016/03/blueprint.jpg';

        $data['categories'] = Category::getAllCategories();

        return view('all_categories', $data);

    }

    public function posts_category_description($id)
    {

        $posts = Post::getPostsByCategoryId($id);

        $data['posts'] = [];

        if(count($posts) > 0)
        {
            $data['posts'] = self::post_constructor($posts);
        }

        $category = Category::find($id);

        $data['categories'] = Category::getAllCategories();

        $data['category_full'] = self::categories_constructor($category);

        $data['large_image'] = $data['category_full']['category_image_url'];

        return view('category.category_posts', $data);

    }

    public function change_view($post_id) {

        Post::changeView($post_id);

    }

    public function search(Request $request)
    {

        $data = $request->input();

        $text = $data['search'];

        $posts = [];

        if($text != null)
        {
            $posts = $this->getSearchPosts($text);
        }

        if(($text == null) || (count($posts) == 0))
        {
            $data['categories'] = Category::getAllCategories();
            $data['large_image'] = 'https://experiencinginformation.files.wordpress.com/2016/03/blueprint.jpg';
            return view('no_posts', $data);
        }

        $data['posts'] = self::post_constructor($posts);

        $data['large_image'] = 'https://experiencinginformation.files.wordpress.com/2016/03/blueprint.jpg';

        $data['categories'] = Category::getAllCategories();

        return view('main', $data);

    }

    public function search_tag($text)
    {

        $posts = [];

        if($text != null)
        {
            $posts = $this->getSearchPosts($text);
        }

        if(($text == null) || (count($posts) == 0))
        {
            $data['categories'] = Category::getAllCategories();
            $data['large_image'] = 'https://experiencinginformation.files.wordpress.com/2016/03/blueprint.jpg';
            return view('no_posts', $data);
        }

        $data['posts'] = self::post_constructor($posts);

        $data['large_image'] = 'https://experiencinginformation.files.wordpress.com/2016/03/blueprint.jpg';

        $data['categories'] = Category::getAllCategories();

        return view('main', $data);

    }

    public function posts_author($author_id)
    {

        $posts = Post::getAllPostsByUser($author_id);

        $data['posts'] = self::post_constructor($posts);

        $data['large_image'] = 'https://experiencinginformation.files.wordpress.com/2016/03/blueprint.jpg';

        $data['categories'] = Category::getAllCategories();

        return view('main', $data);

    }


    public static function post_constructor($data) {

        if ( !empty($data[0]) ) {

            $sum = 1;
            foreach ($data as $key => $post) {

                $data[$key]['post_id'] = $post['id'];

                $post_user = User::getUser($post['author_id']);

                $data[$key]['small_image_url'] = !empty($post['small_image']) ? asset(Config::get('custom.path_posts_imgSmall') . $post['id'] . '/' . $post['small_image']) : Config::get('custom.default_small_image_url');

                $data[$key]['large_image_url'] = !empty($post['large_image']) ? asset(Config::get('custom.path_posts_imgLarge') . $post['id'] . '/' . $post['large_image']) : Config::get('custom.default_large_image_url');

                $data[$key]['user_name'] = $post_user['name'];

                $data[$key]['user_id'] = $post_user['id'];

                $data[$key]['avatar'] = asset(Config::get('custom.avatars_folder') . $post_user['avatar']);

                $data[$key]['likes_num'] = Like::numberLike($post['id']);

                $data[$key]['like_post_id'] = $post['id'];

                $data[$key]['comments_num'] = Comment::numberComment($post['id']);

                $post = Post::find($post['id']);
                $data[$key]['views_num'] = $post->where('id','=',$post['id'])->value('view');

                $data[$key]['has_like'] = (Auth::check()) ? Like::hasLike($post['id']) : false;

                $data[$key]['largePosition'] = 0;

                if (($data[$key]['active'] == 1) && ($data[$key]['approved'] == 1)){
                    if (($sum == 1) || ($sum == 4)){
                        $data[$key]['largePosition'] = 1;
                    }
                    $sum = ($sum<4) ? $sum+1: 1;
                }

                $data[$key]['shortText'] =  mb_substr(strip_tags(trim(preg_replace('/[^\S\r\n]+/', ' ', $post['text']), "\x00..\x22")),0,140);

            }

        } else {

            $data['post_id'] = $data['id'];

            $post_user = User::getUser($data['author_id']);

            $data['small_image_url'] = !empty($data['small_image']) ? asset(Config::get('custom.path_posts_imgSmall') . $data['id'] . '/' . $data['small_image']) : Config::get('custom.default_small_image_url');

            $data['large_image_url'] = !empty($data['large_image']) ? asset(Config::get('custom.path_posts_imgLarge') . $data['id'] . '/' . $data['large_image']) : Config::get('custom.default_large_image_url');

            $data['user_name'] = $post_user['name'];

            $data['user_id'] = $post_user['id'];

            $data['avatar'] = asset(Config::get('custom.avatars_folder') . $post_user['avatar']);

            $data['likes_num'] = Like::numberLike($data['id']);
            $data['like_post_id'] = $data['id'];

            $data['comments_num'] = Comment::numberComment($data['id']);

            $post = Post::find($data['id']);
            $data['views_num'] = $post->where('id','=',$data['id'])->value('view');

            $data['has_like'] = (Auth::check()) ? Like::hasLike($data['id']) : false;

            $data['largePosition'] = 1;

            $data['shortText'] =  mb_substr(strip_tags(trim(preg_replace('/[^\S\r\n]+/', ' ', $data['text']), "\x00..\x22")),0,140);

        }

        return $data;

    }

    public static function comments_constructor($post_id) {

        $data = Comment::getCommentsPostIdApproved($post_id);

            foreach ($data as $key => $post) {

                $post_user = User::getUser($post['author_id']);
                $data[$key]['comment_author_name'] = $post_user['name'];
                $data[$key]['comment_author_avatar'] = asset(Config::get('custom.avatars_folder') . $post_user['avatar']);
            }

        return $data;

    }

    public static function categories_constructor($data) {

        if ( !empty($data[0]) ) {

            foreach ($data as $key => $post) {

                $data[$key]['category_id'] = $post['id'];

                $data[$key]['category_image_url'] = !empty($post['image']) ? asset(Config::get('custom.category_image_folder') . $post['image']) : asset(Config::get('custom.category_image_folder') . 'default.jpg');

            }

        } else {

            $data['category_id'] = $data['id'];

            $data['category_image_url'] = !empty($data['image']) ? asset(Config::get('custom.category_image_folder') . $data['image']) : asset(Config::get('custom.category_image_folder') . 'default.jpg');

        }

        return $data;

    }

    public function getDaysPostId($id) {

        $your_date = strtotime(Post::getCreatedAtPostId($id));
        $now = time() + 10800;
        $datediff = $now - $your_date;
        $intDateDiff = (int)floor($datediff / (60 * 60 * 24));
        return $intDateDiff;

    }

    public function getSearchPosts($text)
    {

        $array = $this->getTextArray($text);

        return Post::getSearchQuery($array);

    }

    public function getTextArray($text)
    {

        $array = preg_split("/[\s,]+/", $text);

        $array = array_map('mb_strtolower', $array);

        return $array;

    }

}

