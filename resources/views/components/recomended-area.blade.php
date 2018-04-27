<section class="recomended-area section">
    <div class="container">
        <div class="row">

            @if (count($post['recomended']) > 2)

                @foreach($post['recomended'] as $item)

                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img src="{{ $item['small_image_url'] }}" alt="Blog Image"></div>

                                <a class="avatar" href="{{ route('posts_author', $post['author_id']) }}"><img src="{{ $item['avatar'] }}" alt="Profile Image"></a>

                                <div class="blog-info">

                                    <h4 class="title"><a href="/posts/{{ $item['id'] }}"><b>{{ $item['title'] }}</b></a></h4>

                                    <ul class="post-footer">
                                        <li><p><i class="ion-heart p-eye"></i>{{ $item['likes_num'] }}</p></li>
                                        <li><p><i class="ion-chatbubble p-eye"></i>{{ $item['comments_num'] }}</p></li>
                                        <li><p><i class="ion-eye p-eye"></i>{{ $item['views_num'] }}</p></li>
                                    </ul>

                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-md-6 col-sm-12 -->

                @endforeach

            @endif

        </div><!-- row -->
    </div><!-- container -->
</section>