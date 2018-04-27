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
                    <th>Автор</th>
                    <th>Изображение</th>
                    <th>Заголовок</th>
                    <th>Категория</th>
                    <th>Видимость</th>
                    <th>Создан</th>
                    <th>Изменен</th>
                    <th>Статья одобрена</th>
                    <th></th>
                    <th></th>
                </tr>

                </thead>

                <tbody>

                    @foreach( $posts as $key => $post )

                        <tr>

                            <td>{{ $key }}</td>

                            <td>
                                <img src="{{ $post['author_avatar'] }}" class="" alt="" style="width: 60px;border-radius: 100px;border: 3px solid green;box-shadow: 0 0 7px #666;margin-left: 15px">
                                <br><br>
                                {{ $post['author_name'] }}
                            </td>

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
                                <select
                                        class="form-control select_post_approved"
                                        data-url="{{ route('admin_approved_post') }}"
                                        data-post-id="{{ $post['id'] }}"
                                        style="margin-top: 0px;width: 135px;color: {{ $post['approved'] == 1 ? 'lightgreen' : '#FFA9AE' }};">

                                    @if($post['approved'] == 1)

                                        <option value="1" selected="selected" style="color:white;">Одобрена</option>
                                        <option value="0" style="color:white;">Не одобрена</option>

                                    @elseif($post['approved'] == 0)

                                        <option value="1" style="color:white;">Одобрена</option>
                                        <option value="0" selected="selected" style="color:white;">Не одобрена</option>

                                    @endif

                                </select>
                            </td>

                            <td>
                                <a href="{{ route('admin_edit_post', $post['id']) }}" class="btn btn-block btn-outline btn-warning">Изменить</a>
                            </td>

                            <td>
                                <button class="btn btn-block btn-outline btn-danger delete-direction"
                                        data-url="{{ route('admin_delete_post') }}"
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