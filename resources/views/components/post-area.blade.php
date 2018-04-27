{{--{{ dd($post) }}--}}
<section class="post-area" data-url="{{ route('change_view', $post['id']) }}">
    <div class="container">

        <div class="row">

            <div class="col-lg-1 col-md-0"></div>
            <div class="col-lg-10 col-md-12">

                <div class="main-post">

                    <div class="post-top-area">

                        <h3 class="title"><a href="#"><b>{{ $post['title']  }}</b></a></h3>

                        <div class="post-info">

                            <div class="left-area">
                                <a class="avatar" href="{{ route('posts_author', $post['author_id']) }}"><img src="{{ $post['avatar'] }}" alt="Profile Image"></a>
                            </div>
                            <div class="middle-area">
                                <a class="name" href="{{ route('posts_author', $post['author_id']) }}"><b>{{ $post['user_name'] }}</b></a>
                                <br>
                                <h6 class="date">{{ $post['updated_at'] }}</h6>
                            </div>

                        </div><!-- post-info -->

                        <div class="blog-large-image" style="
                            height: 400px;
                            border: 2px solid #a9a9a9;
                            background: url({{  $post['small_image_url']  }}) 100% 100% no-repeat;
                            background-position:center -180px;
                            background-size:cover;
                            ">
                        </div>

                        <br>

                        {!! $post->text !!}

                    </div>

                    <div class="post-bottom-area">

                        <ul class="tags">
                            <li><a href="/search_tag/труба">Труба</a></li>
                            <li><a href="/search_tag/фиттинг">Фиттинг</a></li>
                            <li><a href="/search_tag/лайфхак">Лайфхак</a></li>
                            <li><a href="/search_tag/пайка">Пайка</a></li>
                        </ul>

                        <div class="post-icons-area">
                            <ul class="post-icons">

                                <li><p id="heart"
                                       class="{{ ($post['has_like']) ? 'has-like' : ''}}"
                                       data-url="{{ route('change_like', $post['id']) }}"
                                       onclick="like_ajax(this)">
                                        <i class="ion-heart"></i>
                                        <span>{{ $post['likes_num'] }}</span>
                                    </p>
                                </li>
                                <li><p><i class="ion-chatbubble p-eye-post"></i>{{ $post['comments_num'] }}</p></li>
                                <li><p><i class="ion-eye p-eye-post"></i>{{ $post['views_num'] }}</p></li>
                            </ul>

                            <ul class="icons">
                                <li>Поделиться : </li>
                                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#"><i class="ion-social-pinterest"></i></a></li>
                            </ul>
                        </div>

                        <div class="post-footer post-info">

                            <div class="left-area">
                                <a class="avatar" href="{{ route('posts_author', $post['author_id']) }}"><img src="{{ $post['avatar'] }}" alt="Profile Image"></a>
                            </div>

                            <div class="middle-area">
                                <a class="name" href="{{ route('posts_author', $post['author_id']) }}"><b>{{ $post['user_name'] }}</b></a>
                                <h6 class="date">{{ $post['updated_at'] }}</h6>
                            </div>

                        </div><!-- post-info -->

                    </div><!-- post-bottom-area -->

                </div><!-- main-post -->

            </div><!-- col-lg-8 col-md-12 -->
        </div><!-- row -->
    </div><!-- container -->
</section><!-- post-area -->

<script>

        setTimeout(function () {

            var url = $('.post-area').data('url'),
                csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: url,
                type: "GET",
                data: {
                    _token: csrfToken
                },
                dataType: "html",
                success: function () {
                    console.log('Ok');
                },
                error: function () {
                    console.log("Ошибка!");
                }
            });

            isFirst30 = false;

        }, 30 * 1000);

</script>