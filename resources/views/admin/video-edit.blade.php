@extends('layouts.app')
@section('nav-video','active')
@section('content')
<!-- Content Wrapper. Contains breadcrum -->

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1><a style="font-size: 24px; color: #555555; display: inline-block; margin-right: 15px;" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> Add new video</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/content/video">Video</a></li>
                <li class="breadcrumb-item active"><strong>Add new video</strong></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form class="form-coltrol" method="post" action="/content/video/save" enctype="multipart/form-data">@csrf
            <div class="card">
                <div class="card-body">
                @if (is_null($video) || empty($video))
                    <div style="text-align: center;">Item not found!</div>
                @else
                    @php
                    $post_id        = $video->id;

                    $title          = App\Utils::get_array_item_value($selected_lang, json_decode($video->title, true), '');
                    $content        = App\Utils::get_array_item_value($selected_lang, json_decode($video->content, true), '');

                    $post_seo = $video->post_seo;
                    $seo_title = $seo_keyword = $seo_description = '';
                    if (!is_null($post_seo)) {
                        $seo_title = App\Utils::get_array_item_value($selected_lang, json_decode($post_seo->seo_title, true), '');
                        $seo_keyword = App\Utils::get_array_item_value($selected_lang, json_decode($post_seo->seo_keyword, true), '');
                        $seo_description = App\Utils::get_array_item_value($selected_lang, json_decode($post_seo->seo_description, true), '');
                    }

                    @endphp
                    <input type="hidden" name="post_id" value="{{ $post_id }}" />
                    <div class="row">
                        <div class="col-sm-9 col-12">
                            <div class="text-danger mb-3">{{ $errors->first('unknown_exception') }}</div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend"><span class="input-group-text">Language &nbsp; </span></div>
                                {!! Form::select('language', $languages, $selected_lang, ['id'=>'language', 'class' => 'form-control']) !!}
                            </div>
                            <div class="text-danger">{{ $errors->first('video-url') }}</div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend"><span class="input-group-text">Youtube video url</span></div>
                                <input required type="text" class="form-control" id="video-url" name="video-url" placeholder="https://www.youtube.com/watch?v=..." value="{{ old('video-url', $video->video_url) }}" />
                                <span class="input-group-append">
                                    <button type="button" id="btn-check" style="width: 80px; text-align: center;" class="btn btn-info">Get info</button>
                                </span>
                            </div>
                            <div class="text-danger">{{ $errors->first('channel') }}</div>
                            <div class="input-group mb-3">
                                <input required type="text" class="form-control" id="channel" name="channel" placeholder="Channel title" value="{{old('channel',$video->get_channel())}}" />
                            </div>
                            <div class="text-danger">{{ $errors->first('title') }}</div>
                            <div class="input-group mb-3">
                                <input required type="text" class="form-control" id="title" name="title" placeholder="Video title" value="{{ old('title', $title) }}" />
                            </div>
                            <div class="text-danger">{{ $errors->first('content') }}</div>
                            <div class="input-group mb-3">
                                <textarea required class="form-control" id="content" name="content" rows="15" placeholder="Description">{!! old('content', $content) !!}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-3 col-12">
                        <div class="input-group mb-3">
                                <div style="width: 100%">Thumbnail image</div>
                                <input required type="hidden" id="thumbnail-image" name="thumbnail-image" value="{{ old('thumbnail-image', $video->images) }}"/>
                                <div id="div-thumbnail" style="cursor:pointer; width: 100%; position: relative; padding-top: 56.25%; border: 1px solid #dddddd; border-radius: 5px;">
                                    <img src="{{ $video->images }}" id="thumbnail-img" style="position: absolute; top: 0; left: 0; width: 100%;" />
                                </div>
                                <div class="text-danger" id="thumbnail-error">{{ $errors->first('thumbnail-image') }}</div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend"><span class="input-group-text">Duration</span></div>
                                <input type="text" class="form-control" id="duration" name="duration" placeholder="00:00" value="{{ old('duration', $video->get_duration()) }}" />
                            </div>
                            <div class="mb-3">
                                <div>SEO Title (<span id="title-length">0</span> / 65)</div>
                                <input type="text" class="form-control" name="seo-title" id="seo-title"
                                    onkeyup="countChar(this, '#title-length', 65)" value="{{ old('seo-title', $seo_title) }}"/>
                            </div>
                            <div class="mb-3">
                                <div>SEO Keyword</div>
                                <input type="text" class="form-control" name="seo-keyword" id="seo-keyword" value="{{ old('seo-keyword', $seo_keyword) }}" />
                            </div>
                            <div class="mb-3">
                                <div>SEO Description (<span id="description-length">0</span> / 120)</div>
                                <textarea rows="3" class="form-control" style="width: 100%" id="seo-description"
                                    name="seo-description" onkeyup="countChar(this, '#description-length', 120)">{{ old('seo-description', $seo_description) }}</textarea>
                            </div>
                        </div>
                    </div>
                @endif
                </div>
            </div>@if (!empty($video))
            <div class="mb-3">
                <button id="btn-reset" type="reset" class="btn btn-default mr-2" style="width: 120px;"><i class="fas fa-reply"></i> Cancel</button>
                <button type="submit" class="btn btn-primary" style="width: 120px;"><i class="fas fa-save"></i> Save</button>
            </div>@endif
            </form>
        </div>
    </div>

    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
        var target = '';
        var preview = '';
        left = ($(window).width() - 1000) / 2;
        wtop = ($(window).height() - 600) / 2;

        $(document).ready(function(){

            $('#language').on('change', function () {
                location.href = '/content/video/edit?id={{ $post_id }}&language=' + $('#language').val();
            });

            $('#btn-reset').on('click', function() {
                location.href = '/content/video';
            });

            var btn_check = $('#btn-check');
            btn_check.on('click', function() {
                get_video_info($('#video-url').val());
            });
            function get_video_info(video_url) {
                if (!video_url) {
                    return;
                }
                btn_check.html('<span class="loader"></span>');
                btn_check.prop('disabled', true);
                $.get("/content/video/get-video-info?url=" + video_url, function(jsonData, status){
                    if (jsonData.status === 'success') {
                        $('#title').val(jsonData.title);
                        $('#seo-title').val(jsonData.title);
                        CKEDITOR.instances['content'].setData( jsonData.description );
                        $('#duration').val(jsonData.duration);
                        $('#thumbnail-image').val(jsonData.thumbnail);
                        $('#channel').val(jsonData.channel);
                        $('#thumbnail-img').attr('src', jsonData.thumbnail);
                    }
                    setBtnCheckToDefault();
                });
            }

            function setBtnCheckToDefault() {
                btn_check.prop('disabled', false);
                btn_check.html('Check');
            }

            /* for CKEditor */
            function openBrowser() {
                window.open('/laravel-filemanager?type=Images&langCode=en',
                    'Image Browser', 'width=1000,height=600,directories=no,titlebar=no,toolbar=no,location=0,status=no,menubar=no,addressbar=no,top=' + wtop + ',left=' + left);
            }

            var options = {
                width: "100%", height: "640px",
                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                //filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                //filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
            };

            CKEDITOR.replace('content', options);

            $('#div-thumbnail').on('click', function() {
                target = '#thumbnail-image';
                preview = '#div-thumbnail';
                openBrowser();
            });

        });

        function SetUrl( urls ) {

            if (target == '#thumbnail-image') {
                $('#thumbnail-error').html('');
            }

            var url = urls[0].url;
            $(target).val(url);
            var img = '<img src="' + url + '" style="position: absolute; width: 100%; height: 100%; top:0; left:0" />';
            $(preview).html(img);
            target = '';
            preview = '';
        }

        function countChar(input, container, max_length) {
            var len = input.value.length;
            if (len >= max_length) {
                input.value = input.value.substring(0, max_length);
                len = input.value.length;
            }
            $(container).text(len);
        };
        countChar(document.getElementById('seo-title'), '#title-length', 65);
        countChar(document.getElementById('seo-description'), '#description-length', 120);
    </script>

    @if(Session::has('msg'))
    <script>
        @if (Session::get('status') === 'success')
        toastr.success('{!!Session::get('msg')!!}');
        @else
        toastr.error('{!!Session::get('msg')!!}');
        @endif
    </script>
    @endif
</div>

@endsection
