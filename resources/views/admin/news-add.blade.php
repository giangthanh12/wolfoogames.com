@extends('layouts.app')
@section('nav-news','active')
@section('content')
<!-- Content Wrapper. Contains breadcrum -->

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1><a style="font-size: 24px; color: #555555; display: inline-block; margin-right: 15px;" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> Add new post</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/content/news">News</a></li>
                <li class="breadcrumb-item active"><strong>Add new post</strong></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form class="form-coltrol" method="post" action="/content/news/save" enctype="multipart/form-data">@csrf
                <input type="hidden" name="post_id" value="0" />
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-9 col-12">
                            <div class="text-danger mb-3">{{ $errors->first('unknown_exception') }}</div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend"><span class="input-group-text">Language &nbsp; </span></div>
                                {!! Form::select('language', $languages, $selected_lang, ['id'=>'language', 'class' => 'form-control']) !!}
                            </div>
                            <div class="text-danger">{{ $errors->first('title') }}</div>
                            <div class="input-group mb-3">
                                <input required type="text" class="form-control" id="title" name="title" placeholder="Post title" value="{{old('title')}}" />
                            </div>
                            <div class="text-danger">{{ $errors->first('short-desc') }}</div>
                            <div class="input-group mb-3">
                                <textarea required class="form-control" id="short-desc" name="short-desc" rows="3" placeholder="Summary">{!! old('short-desc') !!}</textarea>
                            </div>
                            <div class="text-danger">{{ $errors->first('content') }}</div>
                            <div class="input-group mb-3">
                                <textarea required class="form-control" id="content" name="content" rows="15" placeholder="Description">{!! old('content')!!}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-3 col-12">
                        <div class="input-group mb-3">
                                <div style="width: 100%">Feature image</div>
                                <input required type="hidden" id="feature-image" name="feature-image" value="{{old('feature-image')}}"/>
                                <div id="div-feature" style="cursor:pointer; width: 100%; position: relative; padding-top: 56.25%; border: 1px solid #dddddd; border-radius: 5px;">
                                    <span style="font-size: 24px; color: #aaaaaa; position: absolute; top: calc(50% - 15px); top: -webkit-calc(50% - 15px); top: -moz-calc(50% - 15px); text-align: center; left: 0; right: 0;"><i class="far fa-image"></i></span>
                                </div>
                                <div class="text-danger" id="feature-error">{{ $errors->first('feature-image') }}</div>
                            </div>
                            <div class="mb-3">
                                <div>SEO Title (<span id="title-length">0</span> / 65)</div>
                                <input type="text" class="form-control" name="seo-title" id="seo-title"
                                    onkeyup="countChar(this, '#title-length', 65)"/>
                            </div>
                            <div class="mb-3">
                                <div>SEO Keyword</div>
                                <input type="text" class="form-control" name="seo-keyword" id="seo-keyword" />
                            </div>
                            <div class="mb-3">
                                <div>SEO Description (<span id="description-length">0</span> / 120)</div>
                                <textarea rows="3" class="form-control" style="width: 100%" id="seo-description"
                                    name="seo-description" onkeyup="countChar(this, '#description-length', 120)"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <button id="btn-reset" type="reset" class="btn btn-default mr-2" style="width: 120px;"><i class="fas fa-reply"></i> Cancel</button>
                <button type="submit" class="btn btn-primary" style="width: 120px;"><i class="fas fa-save"></i> Save</button>
            </div>
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


            $('#btn-reset').on('click', function() {
                location.href = '/content/video';
            });

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

            $('#div-feature').on('click', function() {
                target = '#feature-image';
                preview = '#div-feature';
                openBrowser();
            });

        });

        function SetUrl( urls ) {

            if (target == '#feature-image') {
                $('#feature-error').html('');
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
