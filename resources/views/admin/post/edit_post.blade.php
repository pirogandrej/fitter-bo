@extends('admin.template.theme')

@section('styles')

    <link rel="stylesheet" type="text/css" href="{{ asset('fitter/plugins/bower_components/dropify/dist/css/dropify.min.css') }}">

@endsection

@section('scripts')

    <script src="{{ asset('fitter/plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>
    <script src="{{ asset('fitter/plugins/bower_components/moment/moment.js') }}"></script>
    <script src="{{ asset('fitter/js/custom/new_post.js') }}"></script>
    <script src="{{ asset('admin/js/validator.js') }}"></script>

@endsection

@section('content')

    <form id="admin_change_post_form" class="form-horizontal" data-toggle="validator" novalidate="true" method="post" action="{{ route('admin_update_post_form')}}" enctype="multipart/form-data">

        {{ csrf_field() }}

        <input name="id" type="hidden" value="{{ $post['id'] }}">
        <input name="author_id" type="hidden" value="{{ $post['author_id'] }}">
        <input name="approved" type="hidden" value="{{ $post['approved'] }}">

        <div class="col-sm-4">

            <div class="white-box">

                <div class="form-group">

                    <label for="input-file-max-fs">Загрузка изображения. Максимальный размер - 2 Мб.</label>

                    <div class="col-md-12">

                        <input type="file" name="small_image" class="dropify" data-max-file-size="2M" data-height="300" data-default-file="{{ $post['small_image_url'] }}" value="{{ $post['small_image'] }}"/>

                        <input type="hidden" name="latest_small_image" value="{{ $post['small_image'] }}" />

                    </div>

                </div>

            </div>

        </div>

        <div class="col-sm-4">

            <div class="white-box">

                <div class="form-group">

                    <label for="input-file-max-fs">Загрузка изображения. Максимальный размер - 2 Мб.</label>

                    <div class="col-md-12">

                        <input type="file" name="large_image" class="dropify" data-max-file-size="2M" data-height="300" data-default-file="{{ $post['large_image_url'] }}" value="{{ $post['large_image'] }}"/>

                        <input type="hidden" name="latest_large_image" value="{{ $post['large_image'] }}" />

                    </div>

                </div>

            </div>

        </div>

        <div class="col-sm-4">

            <div class="white-box">

                <div class="form-group">

                    <label class="col-md-12">Тема:</label>

                    <div class="col-md-12">

                        <input type="text" name="title" required class="form-control" value="{{ $post['title'] }}" placeholder="Название публикации" />

                    </div>

                </div>

                <div class="form-group">

                    <label class="col-md-12">Хэш-теги:</label>

                    <div class="col-md-12">

                        <input type="text" name="hash_tags" required class="form-control" value="{{ $post['hash_tags'] }}" data-role="tagsinput" />

                    </div>

                </div>

                <div class="form-group">

                    <label class="col-md-12">Категория :</label>

                    <div class="col-md-12">

                        <select class="form-control" name="category_id" required>
                            @if (!empty($categories))
                                @foreach($categories as $key => $category)
                                    <option value="{{ $category['id'] }}" {{ $post['category_id'] == $category['id'] ? 'selected="selected"' : '' }}>{{ $category['title'] }}</option>
                                @endforeach
                            @endif
                        </select>

                    </div>

                </div>

                <div class="form-group">

                    <label class="col-md-12">Видимость :</label>

                    <div class="col-md-12">

                        <select class="form-control" name="active" required>
                            <option value="1" {{ $post['active'] == '1' ? 'selected="selected"' : '' }}>Включено</option>
                            <option value="0" {{ $post['active'] == '0' ? 'selected="selected"' : '' }}>Отключено</option>
                        </select>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-sm-12">

            <div class="white-box">

                <div class="form-group">

                    <label class="col-md-12">Содержимое:</label>

                    <div class="col-md-12">

                        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
                        <textarea name="text" class="form-control my-editor">{!! $post['text'] !!}</textarea>
                        <script>
                            var editor_config = {
                                path_absolute : "/",
                                selector: "textarea.my-editor",
                                plugins: [
                                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                                    "insertdatetime media nonbreaking save table contextmenu directionality",
                                    "emoticons template paste textcolor colorpicker textpattern"
                                ],
                                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                                relative_urls: false,
                                file_browser_callback : function(field_name, url, type, win) {
                                    var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                                    var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                                    var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                                    if (type == 'image') {
                                        cmsURL = cmsURL + "&type=Images";
                                    } else {
                                        cmsURL = cmsURL + "&type=Files";
                                    }

                                    tinyMCE.activeEditor.windowManager.open({
                                        file : cmsURL,
                                        title : 'Filemanager',
                                        width : x * 0.8,
                                        height : y * 0.8,
                                        resizable : "yes",
                                        close_previous : "no"
                                    });
                                }
                            };

                            tinymce.init(editor_config);
                        </script>

                    </div>

                </div>

            </div>

        </div>

    </form>

@endsection