<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;

use Config;
use Auth;
use Image;
use File;
use Crypt;


class AdminPostController extends AdminContainerController
{

    public function index() {

        $this->data['content_information'] = [
            'page_title' => 'Админ: список публикаций',
            'breadcrumb' => [
                ['url' => route('admin_all_posts'), 'status' => 'active', 'name' => 'Админ: список публикаций']
            ],
            'buttons' => [
                ['class' => 'btn-default', 'url' => url()->previous(), 'name' => 'Назад'],
            ]
        ];

        $posts = Post::getAllPostsWithUser();

        $this->data['posts'] = [];
        if(count($posts) > 0)
        {
            $this->data['posts'] = self::postsConstructor($posts);
        }

        return view('admin.post.all_posts', $this->data);
    }

    public function admin_edit_post($id)
    {

        $this->data['content_information'] = [
            'page_title' => 'Админ: изменить публикацию',
            'breadcrumb' => [
                ['url' => route('admin_edit_post', $id), 'status' => 'active', 'name' => 'Админ: изменить публикацию']
            ],
            'buttons' => [
                ['class' => 'btn-default', 'url' => url()->previous(), 'name' => 'Назад'],
                ['class' => 'btn-success admin_change_post', 'name' => 'Сохранить'],
            ]
        ];

        $post = Post::getPost($id);

        $this->data['post'] = self::postsConstructor($post);

        $this->data['categories'] = Category::getAllCategories();

        return view('admin.post.edit_post', $this->data);

    }

    public function admin_update_post_form(Request $request)
    {

        $post = $request->input();

        $images = self::savePostImage($request);

        $data = [
            'id'            => $post['id'],
            'author_id'     => $post['author_id'],
            'category_id'   => $post['category_id'],
            'title'         => $post['title'],
            'text'          => $post['text'],
            'small_image'   => $images['small_image'],
            'large_image'   => $images['large_image'],
            'hash_tags'     => $post['hash_tags'],
            'active'        => $post['active'],
            'approved'      => $post['approved'],
        ];

        if($images['small_image'] != Post::getSmallImgPost($post['id']))
        {
            $this->deleteOldSmallImage($post['id']);
        }

        if($images['large_image'] != Post::getLargeImgPost($post['id']))
        {
            $this->deleteOldLargeImage($post['id']);
        }

        Post::addPost($data);

        return redirect()->route('admin_all_posts');
    }

    public function admin_approved_post(Request $request)
    {
        $id_approved = $request->input('postid');

        Post::changeApprovedPost($id_approved);

        return redirect()->route('admin_all_posts');
    }

    public function admin_delete_post(Request $request)
    {
        $id_del = $request->input('postid');
        $pathDelSmallImage = Config::get('custom.path_posts_imgSmall') . '/' . $id_del;
        $pathDelLargeImage = Config::get('custom.path_posts_imgLarge') . '/' . $id_del;
        File::deleteDirectory(public_path($pathDelSmallImage));
        File::deleteDirectory(public_path($pathDelLargeImage));
        Post::deletePost($id_del);
        return redirect()->route('admin_all_posts');
    }

    public function admin_posts_check_category(Request $request){

        $id = $request->input('postid');

        $posts = Post::getPostsByCategoryId($id);

        (!empty($posts[0])) ? $flag = 1 : $flag = 0;

        return $flag;
    }

    public function admin_posts_check_user(Request $request){

        $id = $request->input('postid');

        $posts = Post::getAllPostsByUser($id);

        (!empty($posts[0])) ? $flag = 1 : $flag = 0;

        return $flag;
    }

    public static function postsConstructor($data) {

        if ( !empty($data[0]) ) {

            foreach ($data as $key => $post) {

                $data[$key]['author_name'] = User::getNameUser($post['author_id']);

                $data[$key]['author_avatar'] = !empty(User::getAvatarUser($post['author_id'])) ? asset(Config::get('custom.avatars_folder') . User::getAvatarUser($post['author_id'])) : asset('default.jpg');

                $data[$key]['category_name'] = Category::getCategoryName($post['category_id']);

                $data[$key]['small_image_url'] = !empty($post['small_image']) ? asset(Config::get('custom.path_posts_imgSmall') . $post['id'] . '/' . $post['small_image']) : Config::get('custom.default_small_image_url');

                $data[$key]['large_image_url'] = !empty($post['large_image']) ? asset(Config::get('custom.path_posts_imgLarge') . $post['id'] . '/' . $post['large_image']) : Config::get('custom.default_large_image_url');

            }

        } else {

            $data['author_name'] = User::getNameUser($data['author_id']);

            $data['author_avatar'] = !empty(User::getAvatarUser($data['author_id'])) ? asset(Config::get('custom.avatars_folder') . User::getAvatarUser($data['author_id'])) : asset(Config::get('custom.avatars_folder') . 'default.jpg');

            $data['category_name'] = Category::getCategoryName($data['category_id']);

            $data['small_image_url'] = !empty($data['small_image']) ? asset(Config::get('custom.path_posts_imgSmall') . $data['id'] . '/' . $data['small_image']) : Config::get('custom.default_small_image_url');

            $data['large_image_url'] = !empty($data['large_image']) ? asset(Config::get('custom.path_posts_imgLarge') . $data['id'] . '/' . $data['large_image']) : Config::get('custom.default_large_image_url');

        }

        return $data;

    }

    public static function savePostImage($data) {

        $id = Auth::user()->id;

        $new_post_id = !empty($data['id']) ? $data['id'] : Post::getMaxPostId() + 1;

        $result = [];

        if ( !empty($data->file('small_image')) ) {

            $file_small = $data->file('small_image');

            $result['small_image'] = md5( 'small' . $id . date('Hms')) . '.' . $file_small->getClientOriginalExtension();

            $configSmall = Config::get('custom.path_posts_imgSmall');

            $path_small = public_path($configSmall);

            $path_small = $path_small . $new_post_id . '/';

            $file_small->move($path_small, $result['small_image']);

            $img = Image::make($path_small . $result['small_image'])->fit(500);

            $img->save($path_small . $result['small_image'], 90);

        } else {

            $result['small_image'] = !empty($data->input('latest_small_image')) ? $data->input('latest_small_image') : '';

        }

        if ( !empty($data->file('large_image')) ) {

            $file_large = $data->file('large_image');

            $result['large_image'] = md5('large' . $id . date('Hms')) . '.' . $file_large->getClientOriginalExtension();

            $configLarge = Config::get('custom.path_posts_imgLarge');

            $path_large = public_path($configLarge);

            $path_large = $path_large . $new_post_id . '/';

            $file_large->move($path_large, $result['large_image']);

            $img = Image::make($path_large . $result['large_image'])->fit(1000);

            $img->save($path_large . $result['large_image'], 90);

        } else {

            $result['large_image'] = !empty($data->input('latest_large_image')) ? $data->input('latest_large_image') : '';

        }

        return $result;

    }

    public function deleteOldSmallImage($id) {

        $pathDelSmallImage = Config::get('custom.path_posts_imgSmall') . $id;
        $imageSmallName = Post::getSmallImgPost($id);
        $smallImagePathname = public_path($pathDelSmallImage . '/' . $imageSmallName);
        File::delete($smallImagePathname);

    }

    public function deleteOldLargeImage($id) {

        $pathDelLargeImage = Config::get('custom.path_posts_imgLarge') . $id;
        $imageLargeName = Post::getLargeImgPost($id);
        $largeImagePathname = public_path($pathDelLargeImage . '/' . $imageLargeName);
        File::delete($largeImagePathname);

    }

}
