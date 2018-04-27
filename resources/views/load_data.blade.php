<section class="blog-area section">

    <div class="container">

        <div class="row" id="load-data">
        @foreach($posts as $post)
                @if(($post['active'] == 1) && ($post['approved'] == 1))

                    @if($post['largePosition'] == 0)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100">
                                <div class="single-post post-style-1">

                                    <a href="/posts/{{ $post['id'] }}">
                                        <div class="blog-image"><img src="{{ $post['small_image_url'] }}" alt="Blog Image"></div>
                                    </a>
                                    <a class="avatar" href="{{ route('posts_author', $post['author_id']) }}"><img src="{{ $post['avatar'] }}" alt="Profile Image"></a>

                                    <div class="blog-info">

                                        <h4 class="title"><a href="/posts/{{ $post['id'] }}"><b>{{ $post['title'] }}</b></a></h4>

                                        <ul class="post-footer">
                                            <li><p id="heart"
                                                   class="{{ ($post['has_like']) ? 'has-like' : ''}}"
                                                   data-url="{{ route('change_like', $post['id']) }}"
                                                   onclick="like_ajax(this)">
                                                    <i class="ion-heart"></i>
                                                    <span>{{ $post['likes_num'] }}</span>
                                                </p>
                                            </li>
                                            <li><p href="#"><i class="ion-chatbubble p-eye"></i>{{ $post['comments_num'] }}</p></li>
                                            <li><p href="#"><i class="ion-eye p-eye"></i>{{ $post['view'] }}</p></li>
                                        </ul>

                                    </div><!-- blog-info -->
                                </div><!-- single-post -->
                            </div><!-- card -->
                        </div><!-- col-lg-4 col-md-6 -->
                    @else
                        <div class="col-lg-8 col-md-12">
                            <div class="card h-100">
                                <div class="single-post post-style-2">

                                    <div class="blog-image"
                                         onclick="location.href='/posts/{{ $post['id'] }}';"
                                         style="background: url('{{ $post['small_image_url'] }}') no-repeat;
                                                 background-size: cover;
                                                 cursor:pointer;
                                                 ">
                                    </div>

                                    <div class="blog-info">

                                        <h4 class="title"><a href="/posts/{{ $post['id'] }}"><b>{{ $post['title'] }}</b></a></h4>

                                        {{ $post['shortText'] }}

                                        <div class="avatar-area">
                                            <a class="avatar" href="{{ route('posts_author', $post['author_id']) }}"><img src="{{ $post['avatar'] }}" alt="Profile Image"></a>
                                            <div class="right-area">
                                                <a class="name" href="{{ route('posts_author', $post['author_id']) }}"><b>{{ $post['user_name'] }}</b></a>
                                                <h6 class="date" href="#">{{ $post['updated_at'] }}</h6>
                                            </div>
                                        </div>

                                        <ul class="post-footer">
                                            <li><p id="heart"
                                                   class="{{ ($post['has_like']) ? 'has-like' : ''}}"
                                                   data-url="{{ route('change_like', $post['id']) }}"
                                                   onclick="like_ajax(this)">
                                                    <i class="ion-heart"></i>
                                                    <span>{{ $post['likes_num'] }}</span>
                                                </p>
                                            </li>
                                            <li><p><i class="ion-chatbubble p-eye"></i>{{ $post['comments_num'] }}</p></li>
                                            <li><p><i class="ion-eye p-eye"></i>{{ $post['view'] }}</p></li>
                                        </ul>

                                    </div><!-- blog-right -->

                                </div><!-- single-post extra-blog -->

                            </div><!-- card -->
                        </div><!-- col-lg-8 col-md-12 -->
                    @endif

                @endif
            @endforeach


            @if($sumpostsout > 0)
                <div id="remove-row" style="width: 100%;">
                    <button id="btn-more" data-sumpostsout="{{ $sumpostsout }}" data-url="/loaddatapost" class="load-more-btn" style="text-align: center;"> Load More </button>
                </div>
            @else
                <div id="remove-row" style="width: 100%;">
                    <h4>Статьи все загружены.</h4>
                </div>
            @endif


        </div>


    </div>

</section>

