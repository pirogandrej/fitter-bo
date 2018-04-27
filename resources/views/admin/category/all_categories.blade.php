@extends('admin.template.theme')

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
                    <th>Название</th>
                    {{--<th>Описание</th>--}}
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

                        <td><img src="{{ $post['category_image_url'] }}" class="" alt="" style="width: 100px;"></td>

                        <td>{{ $post['title'] }}</td>

                        {{--<td>{{ $post['description'] }}</td>--}}

                        <td>{{ $post['created_at'] }}</td>

                        <td>{{ $post['updated_at'] }}</td>

                        <td>
                            <a href="{{ route('admin_edit_category', $post['id']) }}" class="btn btn-block btn-outline btn-warning">Изменить</a>
                        </td>

                        <td>
                            <button class="btn btn-block btn-outline btn-danger delete-direction"
                                    data-url-check="{{ route('admin_posts_check_category') }}"
                                    data-url-change="{{ route('admin_delete_category') }}"
                                    data-name=""
                                    data-post-id="{{ $post['id'] }}"
                                    onclick="deleteCategory(this)"
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