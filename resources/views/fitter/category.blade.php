@extends('fitter.template.theme')

@section('styles')

@endsection

@section('scripts')

@endsection

@section('content')

    <div class="col-md-12">

        <div class="white-box">

            <table class="table table-bordered table-striped">

                <thead>

                <tr>
                    <th>#</th>
                    <th>Заголовок</th>
                </tr>

                </thead>

                <tbody>

                    @foreach( $posts as $key => $post )

                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $post['title'] }}</td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

@endsection
