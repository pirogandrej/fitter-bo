@extends('layouts.template')

@section('content')

    @include('components.slider')

    @include('components.blog-area')

@endsection

@section('styles')

    <link href="{{ asset('css/main/styles.css') }}" rel="stylesheet">

    <link href="{{ asset('css/main/responsive.css') }}" rel="stylesheet">

@endsection