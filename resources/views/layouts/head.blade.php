<title>Blue Ocean</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Font -->

<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">


<!-- Stylesheets -->

<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">

<link href="{{ asset('css/ionicons.min.css') }}" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="{{ asset('/css/custom.css') }}">

@yield('styles')