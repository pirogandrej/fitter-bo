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
                    <th>Аватар</th>
                    <th>Пользователь</th>
                    <th>Email</th>
                    <th>Доступ</th>
                    <th>Админ-доступ</th>
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

                        <td><img src="{{ $post['avatar_url'] }}" class="" alt="" style="width: 100px;"></td>

                        <td>{{ $post['name'] }}</td>

                        <td>{{ $post['email'] }}</td>

                        @if($post['access'])
                            <td style="color:#99d683;">Включен</td>
                        @else
                            <td>Отключен</td>
                        @endif

                        @if($post['admin_role'])
                            <td style="color:#99d683;">Включен</td>
                        @else
                            <td>Отключен</td>
                        @endif

                        <td>{{ $post['created_at'] }}</td>

                        <td>{{ $post['updated_at'] }}</td>

                        <td>
                            <a href="{{ route('admin_user_edit', $post['id']) }}" class="btn btn-block btn-outline btn-warning">Изменить</a>
                        </td>

                        <td>
                            <button class="btn btn-block btn-outline btn-danger delete-direction"
                                    {{--data-url="{{ route('admin_user_delete') }}"--}}
                                    data-url-check="{{ route('admin_posts_check_user') }}"
                                    data-url-change="{{ route('admin_user_delete') }}"
                                    data-name=""
                                    data-post-id="{{ $post['id'] }}"
                                    onclick="deleteConfirmUser(this)"
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
