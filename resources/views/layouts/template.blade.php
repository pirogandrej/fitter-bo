<!DOCTYPE HTML>

<html lang="ru">

<head>

    @include('layouts.head')

</head>

<body >

    <header>

        @include('layouts.header')

    </header>

    @yield('content')

    <footer>

        @include('layouts.footer')

    </footer>

    <!-- SCIPTS -->

    @include('layouts.scripts')

</body>

</html>
