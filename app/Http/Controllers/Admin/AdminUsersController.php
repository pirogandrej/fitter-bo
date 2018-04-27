<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\User;
use Config;
use Auth;
use Image;
use File;
use Crypt;
use Hash;


class AdminUsersController extends AdminContainerController
{

    public function index() {

        $this->data['content_information'] = [
            'page_title' => 'Админ: список пользователей',
            'breadcrumb' => [
                ['url' => route('admin_users'), 'status' => 'active', 'name' => 'Админ: список пользователей']
            ],
            'buttons' => [
                ['class' => 'btn-default', 'url' => url()->previous(), 'name' => 'Назад'],
                ['class' => 'btn-success', 'url' => route('admin_user_new'), 'name' => 'Добавить'],
            ]
        ];

        $posts = User::getAllUsers();

        $this->data['posts'] = self::user_constructor($posts);

        return view('admin.all_users', $this->data);

    }

    public function profile()
    {

        $this->data['content_information'] = [
            'page_title' => 'Мой профиль',
            'breadcrumb' => [
                ['url' => route('admin_profile'), 'status' => 'active', 'name' => 'Мой профиль']
            ],
            'buttons' => [
                ['class' => 'btn-default', 'url' => url()->previous(), 'name' => 'Назад'],
                ['class' => 'btn-success change_user_profile', 'name' => 'Сохранить'],
            ]
        ];

        $post = User::getUser(Auth::user()->id);

        $this->data['post'] = self::user_constructor($post);

        return view('admin.admin_profile', $this->data);

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

        return redirect()->route('admin_users');
    }

    public function admin_user_new()
    {

        $this->data['content_information'] = [
            'page_title' => 'Добавить нового пользователя',
            'breadcrumb' => [
                ['url' => route('admin_user_new'), 'status' => 'active', 'name' => 'Добавить нового пользователя']
            ],
            'buttons' => [
                ['class' => 'btn-default', 'url' => url()->previous(), 'name' => 'Назад'],
                ['class' => 'btn-success new_user', 'name' => 'Сохранить'],
            ]
        ];

        return view('admin.admin_user_new', $this->data);

    }

    public function admin_user_new_form(Request $request)
    {

        $post = $request->input();

        $images = self::saveAvatarImage($request);

        $data = [
            'avatar'        => $images['avatar'],
            'name'          => $post['name'],
            'email'         => $post['email'],
            'password'      => $post['password'],
            'access'        => $post['access'],
            'admin_role'    => $post['admin_role'],
        ];

        User::insertMyUser($data);

        return redirect()->route('admin_users');

    }

    public function admin_user_edit($id)
    {

        $this->data['content_information'] = [
            'page_title' => 'Изменить данные пользователя',
            'breadcrumb' => [
                ['url' => route('admin_user_edit', $id), 'status' => 'active', 'name' => 'Изменить данные пользователя']
            ],
            'buttons' => [
                ['class' => 'btn-default', 'url' => url()->previous(), 'name' => 'Назад'],
                ['class' => 'btn-success change_user', 'name' => 'Сохранить'],
            ]
        ];

        $post = User::getUser($id);

        $this->data['post'] = self::user_constructor($post);

        return view('admin.admin_user_edit', $this->data);

    }

    public function admin_user_update_form(Request $request)
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
            'access'     => $post['access'],
            'admin_role' => $post['admin_role']
        ];

        if($oldAvatarName != $images['avatar']) {

            self::deleteOldAvatarId($post['id']);

        }

        User::updateMyUser($data);

        return redirect()->route('admin_users');
    }

    public function admin_user_delete(Request $request)
    {

        $id = $request->input('postid');

        self::deleteOldAvatarId($id);

        User::deleteUser($id);

        return redirect()->route('admin_users');
    }

    public static function user_constructor($data) {

        if ( !empty($data[0]) ) {

            foreach ($data as $key => $post) {

                $data[$key]['avatar_url'] = !empty($post['avatar']) ? asset(Config::get('custom.avatars_folder') . $post['avatar']) : asset(Config::get('custom.avatars_folder') . 'default.jpg');

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

}
