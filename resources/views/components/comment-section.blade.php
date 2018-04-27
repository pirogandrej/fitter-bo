<section class="comment-section center-text">
    <div class="container">
        <div class="row">

            <div class="col-lg-2 col-md-0">

            </div>

            <div class="col-lg-8 col-md-12">

                @if( Auth::check() )
                    <h4><b>ОСТАВИТЬ КОММЕНТАРИЙ</b></h4>

                    <div class="comment-form">
                        <form id="change_comment" method="post" action="{{ route('fit_comment_post') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">

                                <input type="hidden" name="user_id" value="{{ $post['user_id'] }}" />
                                <input type="hidden" name="post_id" value="{{ $post['id'] }}" />

                                <div class="col-sm-12">
                                        <textarea name="contact-form-message" rows="2" class="text-area-messge form-control"
                                                  placeholder="Текст комментария" aria-required="true" aria-invalid="false" required></textarea >
                                </div><!-- col-sm-12 -->
                                <div class="col-sm-12">
                                    <button class="submit-btn" type="submit" id="form-submit"><b>ОСТАВИТЬ КОММЕНТАРИЙ</b></button>
                                </div><!-- col-sm-12 -->

                            </div><!-- row -->
                        </form>
                    </div><!-- comment-form -->

                @endif

                @if(count($post['comments']) > 0)

                    <h4><b>КОММЕНТАРИИ ({{ count($post['comments']) }})</b></h4>

                    <div id="num1">
                        <div class="commnets-area text-left">

                            <div class="comment">

                                <div class="post-info">

                                    <div class="left-area">
                                        <a class="avatar" href="{{ route('posts_author', $post['comments'][count($post['comments'])-1]['author_id']) }}"><img src="{{ $post['comments'][count($post['comments'])-1]['comment_author_avatar'] }}" alt="Profile Image"></a>
                                    </div>

                                    <div class="middle-area">
                                        <a class="name" href="{{ route('posts_author', $post['comments'][count($post['comments'])-1]['author_id']) }}"><b>{{ $post['comments'][count($post['comments'])-1]['comment_author_name'] }}</b></a>
                                        <h6 class="date date_post">{{ $post['comments'][count($post['comments'])-1]['updated_at'] }}</h6>
                                    </div>

                                    {{--<div class="right-area">--}}
                                        {{--<h5 class="reply-btn" ><a href="#"><b>ОТВЕТИТЬ</b></a></h5>--}}
                                    {{--</div>--}}

                                </div><!-- post-info -->

                                <p>{{ $post['comments'][count($post['comments'])-1]['text'] }}</p>

                            </div>

                        </div><!-- commnets-area -->
                    </div>

                    <div id="block" style="display: none;">
                        @foreach($post['comments'] as $comment)
                            <div class="commnets-area text-left">

                                <div class="comment">

                                    <div class="post-info">

                                        <div class="left-area">
                                            <a class="avatar" href="{{ route('posts_author', $comment['author_id']) }}"><img src="{{ $comment['comment_author_avatar'] }}" alt="Profile Image"></a>
                                        </div>

                                        <div class="middle-area">
                                            <a class="name" href="{{ route('posts_author', $comment['author_id']) }}"><b>{{ $comment['comment_author_name'] }}</b></a>
                                            <h6 class="date">{{ $comment['updated_at'] }}</h6>
                                        </div>

                                        {{--<div class="right-area">--}}
                                            {{--<h5 class="reply-btn" ><a href="#"><b>ОТВЕТИТЬ</b></a></h5>--}}
                                        {{--</div>--}}

                                    </div><!-- post-info -->

                                    <p>{{ $comment['text'] }}</p>

                                </div>

                            </div><!-- commnets-area -->
                        @endforeach

                    </div> <!-- block -->

                    @if(count($post['comments']) > 1)
                        <div id="div_button_comment" class="col-sm-12 comment-form" style="padding-top: 0px;padding-bottom: 0px;">

                            <button id="button_comment" class="comment-form submit-btn">СМОТРЕТЬ ВСЕ КОММЕНТАРИИ</button>

                        </div>
                    @endif

                @endif

            </div><!-- col-lg-8 col-md-12 -->

        </div><!-- row -->

    </div><!-- container -->
</section>

