@extends('layouts.app')
@section('nav-game','active')
@section('content')
<!-- Content Wrapper. Contains breadcrum -->
@php $post_id = 0; @endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1><a style="font-size: 24px; color: #555555; display: inline-block; margin-right: 15px;" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> Edit Game</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="/content/game">Game</a></li>
                <li class="breadcrumb-item active"><strong>Edit game</strong></li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form class="form-coltrol" method="post" action="/content/game/save" enctype="multipart/form-data">@csrf
            <div class="card">
                <div class="card-body">
                @if (is_null($game) || empty($game))
                    <div style="text-align: center;">Item not found!</div>
                @else
                    @php
                    $post_id        = $game->id;
                    $pkgs           = json_decode($game->package_id, true);
                    $android_pkg    = App\Utils::get_array_item_value('android', $pkgs, '');
                    $iphone_pkg     = App\Utils::get_array_item_value('iphone', $pkgs, '');
                    $title          = App\Utils::get_array_item_value($selected_lang, json_decode($game->title, true), '');
                    $short_desc     = App\Utils::get_array_item_value($selected_lang, json_decode($game->short_desc, true), '');
                    $content        = App\Utils::get_array_item_value($selected_lang, json_decode($game->content, true), '');
                    $images         = json_decode($game->images, true);
                    $icon_image     = App\Utils::get_array_item_value('icon', $images, '');
                    $feature_image  = App\Utils::get_array_item_value('feature', $images, '');
                    $post_seo = $game->post_seo;
                    $seo_title = $seo_keyword = $seo_description = '';
                    $is_hot = $game->is_hot;
                    $is_feature = $game->is_feature;

                    if (!is_null($post_seo)) {
                        $seo_title = App\Utils::get_array_item_value($selected_lang, json_decode($post_seo->seo_title, true), '');
                        $seo_keyword = App\Utils::get_array_item_value($selected_lang, json_decode($post_seo->seo_keyword, true), '');
                        $seo_description = App\Utils::get_array_item_value($selected_lang, json_decode($post_seo->seo_description, true), '');
                    }

                    @endphp
                    <input type="hidden" name="post_id" value="{{ $post_id }}" />
                    <input type="hidden" name="downloads" id="downloads" value="" />
                    <input type="hidden" name="rating" id="rating" value="" />
                    <input type="hidden" name="reviews" id="reviews" value="" />
                    <div class="row">
                        <div class="col-sm-9 col-12">
                            <div class="text-danger mb-3">{{ $errors->first('unknown_exception') }}</div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend"><span class="input-group-text">Language &nbsp; </span></div>
                                {!! Form::select('language', $languages, $selected_lang, ['id'=>'language', 'class' => 'form-control']) !!}
                            </div>
                            <div class="text-danger">{{ $errors->first('package-android') }}</div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend"><span class="input-group-text">Android package</span></div>
                                <input required type="text" class="form-control" id="package-android" name="package-android" placeholder="Android Package Name" value="{{ old('package-android', $android_pkg) }}" />
                                <span class="input-group-append">
                                    <button type="button" id="btn-check" style="width: 80px; text-align: center;" class="btn btn-info">Check</button>
                                </span>
                            </div>
                            <div class="text-danger">{{ $errors->first('package-iphone') }}</div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend"><span class="input-group-text">Apple store URL &nbsp; </span></div>
                                <input required type="text" class="form-control" name="package-iphone" placeholder="iPhone Package Name" value="{{ old('package-iphone', $iphone_pkg) }}"/>
                            </div>
                            <div class="text-danger">{{ $errors->first('title') }}</div>
                            <div class="input-group mb-3">
                                <input required type="text" class="form-control" id="title" name="title" placeholder="Game title" value="{{ old('title', $title) }}" />
                            </div>
                            <div class="text-danger">{{ $errors->first('short-desc') }}</div>
                            <div class="input-group mb-3">
                                <textarea required class="form-control" id="short-desc" name="short-desc" rows="3" placeholder="Summary">{!! old('short-desc', $short_desc) !!}</textarea>
                            </div>
                            <div class="text-danger">{{ $errors->first('content') }}</div>
                            <div class="input-group mb-3">
                                <textarea required class="form-control" id="content" name="content" rows="15" placeholder="Description">{!! old('content', $content) !!}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-3 col-12">
                            <div class="input-group mb-3">
                                <div style="text-align: center;width: 100%">Game icon</div>
                                <input required type="hidden" id="icon-image" name="icon-image" value="{{ old('icon-image', $icon_image) }}"/>
                                <div style="text-align: center; width: 100%">
                                    <div id="div-icon" style="position: relative; cursor:pointer; width: 96px; height: 96px; border: 1px solid #dddddd; border-radius: 5px; margin: auto; display: table;">
                                        <img src="{{ $icon_image }}" style="width: 96px; height: 96px;" />
                                    </div>
                                    <div class="text-danger">{{ $errors->first('icon-image') }}</div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div style="width: 100%">Feature image</div>
                                <input required type="hidden" id="feature-image" name="feature-image" value="{{ old('feature-image', $feature_image) }}"/>
                                <div id="div-feature" style="cursor:pointer; width: 100%; position: relative; padding-top: 56.25%; border: 1px solid #dddddd; border-radius: 5px;">
                                    <img src="{{ $feature_image }}" style="position: absolute; top: 0; left: 0; width: 100%;" />
                                </div>
                                <div class="text-danger">{{ $errors->first('feature-image') }}</div>
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
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1"
                                    name="game-feature" id="game-feature" {{$is_feature == 1 ? "checked" : ""}}>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Game Feature
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="game-hot"  value="1"
                                    id="game-hot" {{$is_hot == 1 ? "checked" : ""}}>
                                <label class="form-check-label" for="game-hot">
                                    Game Hot
                                </label>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>@if (!empty($game))
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
                location.href = '/content/game/edit?id={{ $post_id }}&language=' + $('#language').val();
            });

            $('#btn-reset').on('click', function() {
                location.href = '/content/game';
            });

            var btn_check = $('#btn-check');
            btn_check.on('click', function() {
                getGameInfo($('#package-android').val());
            });
            function getGameInfo(package) {
                if (!package) {
                    alert('Android Package Name empty!');
                    return;
                }
                btn_check.html('<span class="loader"></span>');
                btn_check.prop('disabled', true);
                $.get("/game/get-play-info?pkg=" + package, function(jsonData, status){
                    const gameInfo = JSON.parse(jsonData.content);
                        $("#title").val(gameInfo.product_info.title);
                        CKEDITOR.instances['content'].setData(gameInfo.about_this_game.snippet);
                        $("#div-icon").html(`<img src=${gameInfo.product_info.thumbnail} style="width: 96px; height: 96px;"/>`)
                        $("#icon-image").val(gameInfo.product_info.thumbnail)
                        $("#div-feature").html(`<img src=${gameInfo.media.images[0]} style="position: absolute; top: 0; left: 0; width: 100%;"/>`)
                        $("#feature-image").val(gameInfo.media.images[0]);
                        $("#downloads").val(gameInfo.product_info.downloads);
                        $("#rating").val(gameInfo.product_info.rating);
                        $("#reviews").val(gameInfo.product_info.reviews);

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

            $('#div-icon').on('click', function() {
                target = '#icon-image';
                preview = '#div-icon';
                openBrowser();
            });

            $('#div-feature').on('click', function() {
                target = '#feature-image';
                preview = '#div-feature';
                openBrowser();
            });
        });

        function SetUrl( urls ) {
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

</div>

@endsection
