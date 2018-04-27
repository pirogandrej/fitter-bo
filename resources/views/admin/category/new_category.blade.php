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

    <form id="admin_change_category_form" class="form-horizontal" data-toggle="validator" novalidate="true" method="post" action="{{ route('admin_new_category_form')}}" enctype="multipart/form-data">

        {{ csrf_field() }}

        <input name="id" type="hidden" value="">

        <div class="col-sm-4">

            <div class="white-box">

                <div class="form-group">

                    <label for="input-file-max-fs">Загрузка изображения. Максимальный размер - 2 Мб.</label>

                    <div class="col-md-12">

                        <input type="file" name="image" class="dropify" data-max-file-size="2M" data-height="300" data-default-file="" value=""/>

                        <input type="hidden" name="latest_image" value="" />

                    </div>

                </div>

            </div>

        </div>

        <div class="col-sm-4">

            <div class="white-box">

                <div class="form-group">

                    <label class="col-md-12">Название категории :</label>

                    <div class="col-md-12">

                        <input type="text" name="title" required class="form-control" value="" placeholder="Название категории" />

                    </div>

                </div>

            </div>

        </div>

        <div class="col-sm-12">

            <div class="white-box">

                <div class="form-group">

                    <label class="col-md-12">Описание :</label>

                    <div class="col-md-12">

                        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
                        <textarea name="description" required class="form-control my-editor">{!! '<p>Описание ...</p>' !!}</textarea>
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