<section class="blog-area section">
{{--{{ dd($posts['2']['title']) }}--}}
    <div class="container">

        <div>
            <h3>Рубрики :</h3><br><br>
        </div>

        <div class="row">

            @foreach($posts as $post)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="single-post post-style-1">
                        <div class="blog-image">
                            <a href="/posts/category/{{ $post['id'] }}"><img class="category_image" src="{{ $post['category_image_url'] }}" alt="Blog Image"></a>
                        </div>

                        <div class="blog-info">

                            <h4 class="title"><a href="/posts/category/{{ $post['id'] }}"><b>{{ $post['title'] }}</b></a></h4>

                        </div><!-- blog-info -->
                    </div><!-- single-post -->
                </div><!-- card -->
            </div><!-- col-lg-4 col-md-6 -->
            @endforeach

        </div><!-- row -->

    </div><!-- container -->
</section>

