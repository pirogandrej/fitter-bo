<div class="container">
    <div class="row">

        <div class="col-lg-4 col-md-6">
            <div class="footer-section">

                <a class="logo" href="{{ route('posts_posts') }}"><img src="{{ asset('images\logo.png') }}" alt="Logo Image"></a>
                <p class="copyright">Blue Ocean 2018. All rights reserved.</p>
                {{--<p class="copyright">Developed by <a href="https://blue-ocean.com.ua" target="_blank">Kartsev Denis</a></p>--}}
                <ul class="icons">
                    <li><a href="#"><i class="ion-social-facebook-outline"></i></a></li>
                    <li><a href="#"><i class="ion-social-twitter-outline"></i></a></li>
                    <li><a href="#"><i class="ion-social-instagram-outline"></i></a></li>
                    <li><a href="#"><i class="ion-social-vimeo-outline"></i></a></li>
                    <li><a href="#"><i class="ion-social-pinterest-outline"></i></a></li>
                </ul>

            </div><!-- footer-section -->
        </div><!-- col-lg-4 col-md-6 -->

        <div class="col-lg-4 col-md-6">
            <div class="footer-section">
                <h4 class="title"><b>Рубрики</b></h4>
                <ul>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('posts_category_description', $category['id']) }}">
                                {{ $category['title'] }}
                            </a>
                        </li>
                        <br>
                    @endforeach
                </ul>
            </div><!-- footer-section -->
        </div><!-- col-lg-4 col-md-6 -->

        <div class="col-lg-4 col-md-6">
            <div class="footer-section">

                <h4 class="title"><b>ПОДПИСАТЬСЯ</b></h4>
                <div class="input-area">
                    <form>
                        <input class="email-input" type="text" placeholder="Ваш email">
                        <button class="submit-btn" type="submit"><i class="icon ion-ios-email-outline"></i></button>
                    </form>
                </div>

            </div><!-- footer-section -->
        </div><!-- col-lg-4 col-md-6 -->

    </div><!-- row -->
</div><!-- container -->