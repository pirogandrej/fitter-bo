@extends('layouts.template')

@section('content')

    @include('components.slider')

    @include('components.post-area')

    @include('components.recomended-area')

    @include('components.comment-section')

@endsection

@section('styles')

    <link href="{{ asset('css/show_post/styles.css') }}" rel="stylesheet">

    <link href="{{ asset('css/show_post/responsive.css') }}" rel="stylesheet">

@endsection