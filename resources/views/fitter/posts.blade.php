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
                    <th>Изображение</th>
                    <th>Заголовок</th>
                    <th>Категория</th>
                    <th>Видимость</th>
                    <th>Создан</th>
                    <th>Изменен</th>
                    <th></th>
                    <th></th>
                </tr>

                </thead>

                <tbody>

                    @foreach( $posts as $key => $post )

                        <tr>

                            <td>{{ $key }}</td>

                            <td><img src="{{ $post['small_image_url'] }}" class="" alt="" style="width: 100px;"></td>

                            <td>{{ $post['title'] }}</td>

                            <td>{{ $post['category_name'] }}</td>

                            @if($post['active'])
                                <td style="color:#99d683;">Включено</td>
                            @else
                                <td>Отключено</td>
                            @endif

                            <td>{{ $post['created_at'] }}</td>

                            <td>{{ $post['updated_at'] }}</td>

                            <td>
                                <a href="{{ route('fit_edit_post', $post['id']) }}" class="btn btn-block btn-outline btn-warning">Изменить</a>
                            </td>

                            <td>
                                <button class="btn btn-block btn-outline btn-danger delete-direction"
                                        data-url="{{ route('fit_delete_post') }}"
                                        data-name=""
                                        data-post-id="{{ $post['id'] }}"
                                        onclick="deleteConfirm(this)"
                                        id="btn_del">
                                    Удалить
                                </button>
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

@endsection