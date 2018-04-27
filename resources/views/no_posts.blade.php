@extends('layouts.template')
@section('content')

    @include('components.slider')

    <div class="container">

        <div class="row">
            <div style="
                background-color: white;
                height: 100px;
                width: 100%;
                margin: 40px;
                text-align: center;
                padding-top: 20px;
                ">
                <h3>Cтатей не найдено.</h3>
            </div>
        </div>
    </div>
@endsection

@section('styles')

    <link href="{{ asset('css/main/styles.css') }}" rel="stylesheet">

    <link href="{{ asset('css/main/responsive.css') }}" rel="stylesheet">

@endsection