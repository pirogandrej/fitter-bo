<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Config;
use Image;
use File;


class AdminCategoryController extends AdminContainerController
{

    public function index()
    {
        $this->data['content_information'] = [
            'page_title' => 'Админ: список категорий',
            'breadcrumb' => [
                ['url' => route('admin_all_categories'), 'status' => 'active', 'name' => 'Админ: список категорий']
            ],
            'buttons' => [
                ['class' => 'btn-default', 'url' => url()->previous(), 'name' => 'Назад'],
                ['class' => 'btn-success', 'url' => route('admin_new_category'), 'name' => 'Добавить'],
            ]
        ];

        $posts = Category::getAllCategories();
        $this->data['posts'] = [];
        if(count($posts) > 0)
        {
            $this->data['posts'] = self::categoriesConstructor($posts);
        }

        return view('admin.category.all_categories', $this->data);

    }

    public function admin_new_category()
    {
        $this->data['content_information'] = [
            'page_title' => 'Админ: добавить новую категорию',
            'breadcrumb' => [
                ['url' => route('admin_new_category'), 'status' => 'active', 'name' => 'Админ: добавить новую категорию']
            ],
            'buttons' => [
                ['class' => 'btn-default', 'url' => url()->previous(), 'name' => 'Назад'],
                ['class' => 'btn-success admin_new_category', 'name' => 'Сохранить'],
            ]
        ];

        $posts = Category::getAllCategories();
        $this->data['posts'] = $posts;

        return view('admin.category.new_category', $this->data);

    }

    public function admin_new_category_form(Request $request)
    {
        $post = $request->input();

        $images = self::saveImage($request);

        $data = [
            'image' => $images['image'],
            'title' => $post['title'],
            'description' => $post['description']
        ];

        Category::createNewCategory($data);

        return redirect()->route('admin_all_categories');

    }

    public function admin_edit_category($id)
    {

        $this->data['content_information'] = [
            'page_title' => 'Админ: изменить категорию',
            'breadcrumb' => [
                ['url' => route('admin_edit_category', $id), 'status' => 'active', 'name' => 'Админ: изменить категорию']
            ],
            'buttons' => [
                ['class' => 'btn-default', 'url' => url()->previous(), 'name' => 'Назад'],
                ['class' => 'btn-success admin_change_category', 'name' => 'Сохранить'],
            ]
        ];

        $post = Category::getCategory($id);

        $this->data['post'] = self::categoriesConstructor($post);

        return view('admin.category.edit_category', $this->data);

    }

    public function admin_edit_category_form(Request $request)
    {
        $post = $request->input();

        $images = self::saveImage($request);

        $oldNameImage = Category::getImageNameId($post['id']);

        if($oldNameImage != $images['image']) {

            self::deleteOldImageId($post['id']);

        }

        $data = [
            'id' => $post['id'],
            'image' => $images['image'],
            'title' => $post['title'],
            'description' => $post['description']
        ];

        Category::updateCategory($data);

        return redirect()->route('admin_all_categories');
    }

    public function admin_delete_category(Request $request)
    {
        $id = $request->input('postid');

        self::deleteOldImageId($id);

        Category::deleteCategory($id);

        return redirect()->route('admin_all_categories');
    }


    public static function categoriesConstructor($data) {

        if ( !empty($data[0]) ) {

            foreach ($data as $key => $post) {

                $data[$key]['category_image_url'] = !empty($post['image']) ? asset(Config::get('custom.category_image_folder') . $post['image']) : asset(Config::get('custom.category_image_folder') . 'default.jpg');

            }

        } else {

            $data['category_image_url'] = !empty($data['image']) ? asset(Config::get('custom.category_image_folder') . $data['image']) : asset(Config::get('custom.category_image_folder') . 'default.jpg');

        }

        return $data;

    }

    public static function saveImage($data) {

        $result = [];

        if ( !empty($data->file('image')) ) {

            $file = $data->file('image');

            $result['image'] = md5( date('Hms')) . '.' . $file->getClientOriginalExtension();

            $configImagePath = Config::get('custom.category_image_folder');

            $path = public_path($configImagePath);

            $file->move($path, $result['image']);

            $img = Image::make($path . $result['image'])->fit(500);

            $img->save($path . $result['image'], 90);

        } else {

            $result['image'] = !empty($data->input('latest_image')) ? $data->input('latest_image') : '';

        }

        return $result;

    }

    public static function deleteOldImageId($id) {

        $path = Config::get('custom.category_image_folder');

        $imageName = Category::getImageNameId($id);

        File::delete(public_path($path . $imageName));

    }

}




