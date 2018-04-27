<?php

namespace App\Http\Controllers\Fitter;

use Auth;
use App\Models\Like;

class LikeController extends ContainerController
{

    public function change_like($post_id) {

        Like::changeLike($post_id);

    }

    public function has_like($post_id) {

        return Like::hasLikeLike($post_id);

    }

}


