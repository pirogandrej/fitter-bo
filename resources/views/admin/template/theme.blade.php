<!DOCTYPE html>
<!--
   This is a starter template page. Use this page to start your new project from
   scratch. This page gets rid of all links and provides the needed markup only.
   -->
<html lang="ru">

<head>

    @include('admin.template.head')

</head>

<body class="fix-sidebar">

<div class="preloader">

    <div class="cssload-speeding-wheel"></div>

</div>

<div id="wrapper">

    @include('admin.template.navbar')

    @include('admin.template.sidebar')

    <div id="page-wrapper">

        <div class="container-fluid">

            <div class="row bg-title">

                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">

                    @include('admin.template.page_title')

                </div>

                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                    @include('admin.template.breadcrumb')

                </div>

                <div class="col-sm-12">

                    @include('admin.template.breadcrumb_buttons')

                </div>

            </div>

            <div class="row">

                @yield('content')

            </div>

            @include('admin.template.rigt_sidebar')

        </div>

    </div>

</div>

@include('admin.components.logout_form')

</body>

<!-- jQuery -->
<script src="{{ asset('admin/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('admin/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Sidebar menu plugin JavaScript -->
<script src="{{ asset('admin/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
<!--Slimscroll JavaScript For custom scroll-->
<script src="{{ asset('admin/js/jquery.slimscroll.js') }}"></script>
<!--Wave Effects -->
<script src="{{ asset('admin/js/waves.js') }}"></script>
<!-- Custom Theme JavaScript -->
<script src="{{ asset('admin/js/custom.min.js') }}"></script>

<script src="{{ asset('js/custom.js') }}"></script>

@yield('scripts')

</html>
