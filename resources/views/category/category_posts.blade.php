{{--{{ dd($categories) }}--}}
@extends('layouts.template')

@section('content')

    @include('category.category_slider')

    @include('category.category_post_area')

@endsection

@section('styles')

    <link href="{{ asset('css/main/styles.css') }}" rel="stylesheet">

    <link href="{{ asset('css/main/responsive.css') }}" rel="stylesheet">

@endsection