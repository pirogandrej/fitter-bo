@extends('admin.template.theme')

@section('styles')

@endsection

@section('scripts')

@endsection

@section('content')

    @if(count($posts) > 0)

        <div class="col-md-12">

            <div class="white-box">

                <table class="table table-bordered table-striped">

                    <thead>

                    <tr>
                        <th>#</th>
                        <th>Автор публикации</th>
                        <th>Изображение публикации</th>
                        <th>Заголовок публикации</th>
                        <th>Текст комментария</th>
                        <th>Создан</th>
                        <th>Изменен</th>
                        <th>Комментарий одобрен</th>
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

                            <td><img src="{{ $post['comment_image'] }}" class="" alt="" style="width: 100px;"></td>

                            <td>{{ $post['title_post'] }}</td>

                            <td>{{ $post['text'] }}</td>

                            <td>{{ $post['created_at'] }}</td>

                            <td>{{ $post['updated_at'] }}</td>

                            <td>
                                <select
                                        class="form-control select_comment_approved"
                                        data-url="{{ route('admin_approved_comment') }}"
                                        data-post-id="{{ $post['id'] }}"
                                        style="margin-top: 20px;width: 125px;color: {{ $post['approved'] == 1 ? 'lightgreen' : '#FFA9AE' }};">

                                    @if($post['approved'] == 1)

                                        <option value="1" selected="selected" style="color:white;">Одобрен</option>
                                        <option value="0" style="color:white;">Не одобрен</option>

                                    @elseif($post['approved'] == 0)

                                        <option value="1" style="color:white;">Одобрен</option>
                                        <option value="0" selected="selected" style="color:white;">Не одобрен</option>

                                    @endif

                                </select>
                            </td>

                            <td>
                                <button class="btn btn-block btn-outline btn-danger delete-direction"
                                        data-url="{{ route('admin_delete_comment') }}"
                                        data-name=""
                                        data-post-id="{{ $post['id'] }}"
                                        onclick="deleteConfirm(this)"
                                        id="btn_del"
                                        style="margin-top: 20px;">
                                    Удалить
                                </button>
                            </td>
                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>
    @else

        <h4>Комментарии по статьям отсутствуют</h4>

    @endif


@endsection