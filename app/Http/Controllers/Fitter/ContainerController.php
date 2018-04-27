<?php

namespace App\Http\Controllers\Fitter;

use App\Http\Controllers\Controller;

use App\Models\User;
use File;

class ContainerController extends Controller
{

    public $container = [];

    public function __construct()
    {

        $this->middleware(function ($request, $next) {

            $currentUserData = User::getUserData(auth()->user()->id);

            $currentUserData->avatar = self::user_avatar($currentUserData->avatar);

            $this->data['currentUserData'] = $currentUserData;

            $this->data['sidebar_items'] = self::getSidebarItems();

            return $next($request);

        });

    }

    public static function user_avatar($avatar_name) {

        $default = '/avatars/default.jpg';

        $avatar_local_path = '/avatars/' . $avatar_name;

        $avatar_full_path = public_path($avatar_local_path);

        $avatar_web_path = asset( $avatar_local_path );

        if (File::exists($avatar_full_path)) {

            return $avatar_web_path;

        } else {

            return asset( $default );

        }

    }

    public static function getSidebarItems() {

        $sidebar_items = [];

        $sidebar_items[] = array(
            'type' => 'fa fa-plus-book',
            'title' => 'Статьи',
            'icon' => 'fa fa-sign-out',
            'url' => route('fit_posts'),
        );


        $sidebar_items[] = array(
            'type' => '',
            'title' => 'Выход',
            'icon' => 'fa fa-sign-out',
            'url' => '#',
            'js' => "event.preventDefault(); document.getElementById('logout-form').submit()",
        );

        return $sidebar_items;

    }

}