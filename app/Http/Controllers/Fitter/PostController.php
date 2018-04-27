<?php

namespace App\Http\Controllers\Fitter;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

use Auth;
use Config;
use File;
use Image;


class PostController extends ContainerController
{

    public function index()
    {

        $this->data['content_information'] = [
            'page_title' => 'Ваши публикации',
            'breadcrumb' => [
                ['url' => route('fit_posts'), 'status' => 'active', 'name' => 'Список публикаций']
            ],
            'buttons' => [
                ['class' => 'btn-default', 'url' => url()->previous(), 'name' => 'Назад'],
                ['class' => 'btn-success', 'url' => route('fit_new_post'), 'name' => 'Добавить'],
            ]
        ];

        $posts = Post::getAllPostsByUser(Auth::user()->id);

        $this->data['posts'] = (count($posts) > 0) ? self::addPostImageUrl($posts) : $posts;

        return view('fitter.posts', $this->data);

    }

    public function profile()
    {

        $this->data['content_information'] = [
            'page_title' => 'Мой профиль',
            'breadcrumb' => [
                ['url' => route('fit_profile'), 'status' => 'active', 'name' => 'Мой профиль']
            ],
            'buttons' => [
                ['class' => 'btn-default', 'url' => url()->previous(), 'name' => 'Назад'],
                ['class' => 'btn-success change_profile', 'name' => 'Сохранить'],
            ]
        ];

        $posts = User::getUser(Auth::user()->id);

        $this->data['posts'] = $this->user_constructor($posts);

        return view('fitter.profile', $this->data);

    }

    public function profile_update(Request $request)
    {
        $post = $request->input();
        $currentUser = User::getUser($post['id']);

        $oldAvatarName = User::getAvatarUser($post['id']);

        $images = self::saveAvatarImage($request);

        if($post['password'] == $currentUser['password']) {
            $password = $post['password'];
        }
        else {
            $password = bcrypt($post['password']);
        }

        $data = [
            'id'         => $post['id'],
            'avatar'     => $images['avatar'],
            'name'       => $post['name'],
            'email'      => $post['email'],
            'password'   => $password,
        ];

        if($oldAvatarName != $images['avatar']) {

            self::deleteOldAvatarId($post['id']);

        }

        User::updateMyProfile($data);

        return redirect()->route('fit_posts');
    }

    public function new_post()
    {

        $this->data['content_information'] = [
            'page_title' => 'Добавить новую публикацию',
            'breadcrumb' => [
                ['url' => route('fit_new_post'), 'status' => 'active', 'name' => 'Добавить публикацию']
            ],
            'buttons' => [
                ['class' => 'btn-default', 'url' => url()->previous(), 'name' => 'Назад'],
//                ['class' => 'btn-success', 'url' => '#', 'js' => 'event.preventDefault();document.getElementById("new_post").submit();', 'name' => 'Сохранить'],
                ['class' => 'btn-success', 'url' => '#', 'js' => '$("#new_post").submit();', 'name' => 'Сохранить'],
            ]
        ];

        $this->data['categories'] = Category::getAllCategories();

        return view('fitter.new_post', $this->data);

    }

    public function insert_post(Request $request)
    {

        $data = $request->input();

        $images = self::savePostImage($request);

        $data = [
            'author_id'     => Auth::user()->id,
            'category_id'   => $data['category_id'],
            'title'         => $data['title'],
            'text'          => $data['text'],
            'small_image'   => $images['small_image'],
            'large_image'   => $images['large_image'],
            'hash_tags'     => $data['hash_tags'],
            'active'        => $data['active'],
            'view'          => '0',
            'approved'      => '0',
        ];

        Post::addPost($data);

        return redirect()->route('fit_posts');

    }

    public function edit_post($id)
    {

        $this->data['content_information'] = [
            'page_title' => 'Изменить публикацию',
            'breadcrumb' => [
                ['url' => route('fit_new_post'), 'status' => 'active', 'name' => 'Изменить публикацию']
            ],
            'buttons' => [
                ['class' => 'btn-default', 'url' => url()->previous(), 'name' => 'Назад'],
                ['class' => 'btn-success', 'url' => '#', 'js' => '$("#change_post").submit();', 'name' => 'Сохранить'],
            ]
        ];

        $post = Post::getPost($id);

        $this->data['post'] = self::addPostImageUrl($post);

        $this->data['categories'] = Category::getAllCategories();

        return view('fitter.edit_post', $this->data);

    }

    public function update_post(Request $request)
    {

        $post = $request->input();

        $images = self::savePostImage($request);

        $data = [
            'id'            => $post['id'],
            'author_id'     => Auth::user()->id,
            'category_id'   => $post['category_id'],
            'title'         => $post['title'],
            'text'          => $post['text'],
            'small_image'   => $images['small_image'],
            'large_image'   => $images['large_image'],
            'hash_tags'     => $post['hash_tags'],
            'active'        => $post['active'],
            'approved'      => '0',
        ];

        if($images['small_image'] != Post::getSmallImgPost($post['id']))
        {
            $this->deleteOldSmallImage($post['id']);
        }

        if($images['large_image'] != Post::getLargeImgPost($post['id']))
        {
            $this->deleteOldLargeImage($post['id']);
        }

        Post::updatePost($data);

        return redirect()->route('fit_posts');
    }

    public function delete_post(Request $request)
    {
        $id = $request->input('postid');

        $this->deleteImagesPostId($id);

        $this->deleteCommentsLikes($id);

        Post::deletePost($id);

        return redirect()->route('fit_posts');
    }


    public static function addPostImageUrl($data) {

        if ( !empty($data[0]) ) {

            foreach ($data as $key => $post) {

                $data[$key]['small_image_url'] = !empty($post['small_image']) ? asset(Config::get('custom.path_posts_imgSmall') . $post['id'] . '/' . $post['small_image']) : Config::get('custom.default_small_image_url');

                $data[$key]['large_image_url'] = !empty($post['large_image']) ? asset(Config::get('custom.path_posts_imgLarge') . $post['id'] . '/' . $post['large_image']) : Config::get('custom.default_large_image_url');

                $data[$key]['category_name'] = Category::getCategoryName($post['category_id']);

            }

        } else {

            $data['small_image_url'] = !empty($data['small_image']) ? asset(Config::get('custom.path_posts_imgSmall') . $data['id'] . '/' . $data['small_image']) : Config::get('custom.default_small_image_url');

            $data['large_image_url'] = !empty($data['large_image']) ? asset(Config::get('custom.path_posts_imgLarge') . $data['id'] . '/' . $data['large_image']) : Config::get('custom.default_large_image_url');

            $data['category_name'] = Category::getCategoryName($data['category_id']);

        }

        return $data;

    }

    public static function savePostImage($data) {

        $id = Auth::user()->id;

        $new_post_id = !empty($data['id']) ? $data['id'] : Post::getMaxPostId() + 1;

        $result = [];

        if ( !empty($data->file('small_image')) ) {

            $file_small = $data->file('small_image');

            $nameSmallImage = md5( 'small' . $id . date('Hms'));
            $extSmallImage = $file_small->getClientOriginalExtension();

            $result['small_image'] = $nameSmallImage . '.' . $extSmallImage;

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

            $nameLargeImage = md5( 'large' . $id . date('Hms'));
            $extLargeImage = $file_large->getClientOriginalExtension();

            $result['large_image'] = $nameLargeImage . '.' . $extLargeImage;

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

    public function deleteImagesPostId($id)
    {

        $pathDelSmallImage = Config::get('custom.path_posts_imgSmall') . '/' . $id;
        $pathDelLargeImage = Config::get('custom.path_posts_imgLarge') . '/' . $id;
        File::deleteDirectory(public_path($pathDelSmallImage));
        File::deleteDirectory(public_path($pathDelLargeImage));

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

    public function user_constructor($data) {

        if ( !empty($data[0]) ) {

            foreach ($data as $key => $post) {

                $data[$key]['avatar_url'] = !empty($post['avatar']) ? asset(Config::get('custom.avatars_folder') . $post['avatar']) : asset('default.jpg');

            }

        } else {

            $data['avatar_url'] = !empty($data['avatar']) ? asset(Config::get('custom.avatars_folder') . $data['avatar']) : asset(Config::get('custom.avatars_folder') . 'default.jpg');

        }

        return $data;

    }

    public static function saveAvatarImage($data) {

        $result = [];

        if ( !empty($data->file('avatar')) ) {

            $file = $data->file('avatar');

            $result['avatar'] = md5( 'avatar' . date('Hms')) . '.' . $file->getClientOriginalExtension();

            $configAvatar = Config::get('custom.avatars_folder');

            $path = public_path($configAvatar);

            $file->move($path, $result['avatar']);

            $img = Image::make($path . $result['avatar'])->fit(500);

            $img->save($path . $result['avatar'], 90);

        } else {

            $result['avatar'] = !empty($data->input('latest_avatar')) ? $data->input('latest_avatar') : '';

        }

        return $result;

    }

    public static function deleteOldAvatarId($id) {

        $path = Config::get('custom.avatars_folder');

        $avatarName = User::getAvatarUser($id);

        File::delete(public_path($path . $avatarName));

    }

    public function deleteCommentsLikes($id) {

        Comment::deleteAllCommentsPost($id);

        Like::deleteAllLikesPost($id);

    }

}




