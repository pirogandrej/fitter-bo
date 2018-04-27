<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

use Config;
use Auth;
use Image;
use File;
use Crypt;


class AdminCommentController extends AdminContainerController
{

    public function index() {


        $this->data['content_information'] = [
            'page_title' => 'Админ: список комментариев',
            'breadcrumb' => [
                ['url' => route('admin_all_comments'), 'status' => 'active', 'name' => 'Админ: список комментариев']
            ],
            'buttons' => [
                ['class' => 'btn-default', 'url' => url()->previous(), 'name' => 'Назад'],
            ]
        ];

        $comments = self::getAllCommentsWithPosts();

        $this->data['posts'] = [];

        if(count($comments) > 0)
        {
            $this->data['posts'] = self::comments_constructor($comments);
        }

        return view('admin.all_comments', $this->data);

    }


    public function admin_approved_comment(Request $request)
    {
        $id_approved = $request->input('postid');

        Comment::changeApprovedComment($id_approved);

        return redirect()->route('admin_all_comments');
    }


    public function admin_delete_comment(Request $request)
    {
        $id_del = $request->input('postid');

        Comment::deleteComment($id_del);

        return redirect()->route('admin_all_comments');
    }


    public static function getAllCommentsWithPosts() {
        $commentNum = 0;
        $result = [];

        $posts = Post::getAllPostsWithUser();

        foreach ($posts as $key => $post){
            $commentsPost = Comment::getCommentsPostIdAll($post['id']);
            foreach ($commentsPost as $item => $comment){
                $result[$commentNum] = $comment;
                $commentNum++;
            }
        }
        return $result;

    }


    public static function comments_constructor($data) {

        if ( !empty($data[0]) ) {

            foreach ($data as $key => $post) {


                $data[$key]['comment_image'] = !empty(Post::getSmallImgPost($post['post_id'])) ? asset(Config::get('custom.path_posts_imgSmall') . $post['post_id'] . '/' . Post::getSmallImgPost($post['post_id'])) : Config::get('custom.default_small_image_url');

                $data[$key]['author_name'] = User::getNameUser($post['author_id']);

                $data[$key]['author_avatar'] = !empty(User::getAvatarUser($post['author_id'])) ? asset(Config::get('custom.avatars_folder') . User::getAvatarUser($post['author_id'])) : asset('default.jpg');

                $data[$key]['small_image_url'] = !empty($post['small_image']) ? asset(Config::get('custom.path_posts_imgSmall') . $post['id'] . '/' . $post['small_image']) : Config::get('custom.default_small_image_url');

                $data[$key]['large_image_url'] = !empty($post['large_image']) ? asset(Config::get('custom.path_posts_imgLarge') . $post['id'] . '/' . $post['large_image']) : Config::get('custom.default_large_image_url');

                $data[$key]['title_post'] = Post::getTitlePost($post['post_id']);

            }

        } else {

            $data['author_name'] = User::getNameUser($data['author_id']);

            $data['author_avatar'] = !empty(User::getAvatarUser($data['author_id'])) ? asset(Config::get('custom.avatars_folder') . User::getAvatarUser($data['author_id'])) : asset(Config::get('custom.avatars_folder') . 'default.jpg');

            $data['small_image_url'] = !empty($data['small_image']) ? asset(Config::get('custom.path_posts_imgSmall') . $data['id'] . '/' . $data['small_image']) : Config::get('custom.default_small_image_url');

            $data['large_image_url'] = !empty($data['large_image']) ? asset(Config::get('custom.path_posts_imgLarge') . $data['id'] . '/' . $data['large_image']) : Config::get('custom.default_large_image_url');

            $data['title_post'] = Post::getTitlePost($data['post_id']);
        }

        return $data;

    }

}
