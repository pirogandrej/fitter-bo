<?php

namespace App\Http\Controllers\Fitter;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;


class CommentController extends ContainerController
{

    public function comment_post(Request $request) {

        $user_id = Auth::user()->id;
        $post_id = $request->input('post_id');
        $text = $request->input('contact-form-message');
        Comment::saveComment($user_id, $post_id, $text);
        return redirect()->route('posts_post', $post_id);

    }

}
