<div class="container-fluid position-relative no-side-padding">

    <a href="{{ route('posts_posts') }}" class="logo"><img src="{{ asset('images\logo.png') }}" alt="Logo Image"></a>

    <div class="menu-nav-icon" data-nav-menu="#main-menu"><i class="ion-navicon"></i></div>

    <ul class="main-menu visible-on-click" id="main-menu">
        <li><a href="{{ route('posts_posts') }}">Главная</a></li>
        <li><a href="{{ route('posts_category') }}">Рубрики</a></li>
        <li><a href="{{ route('posts_fresh') }}">Свежачек</a></li>
        <li><a href="{{ route('posts_top') }}">TOP-10</a></li>
        @if( Auth::check() )
        <li>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                ВЫХОД
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>

        </li>
        @else
        <li><a href="/login">ВХОД</a></li>
            @endif
    </ul><!-- main-menu -->

    <div class="src-area">

        <form data-toggle="validator" novalidate="true" method="post" action="{{ route('search')}}" enctype="multipart/form-data">

            {{ csrf_field() }}

            <button class="src-btn" type="submit"><i class="ion-ios-search-strong"></i></button>
            <input class="src-input" type="text" placeholder="Поиск" name="search" required>
        </form>

    </div>

</div><!-- conatiner -->