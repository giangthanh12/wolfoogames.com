@extends("layouts.layout-web-default")

@php
$title = json_decode($game->title, true);
$short_desc_game = json_decode($game->short_desc, true);
$content_game = json_decode($game->content, true);
$images_game = json_decode($game->images);
$icon_game = asset($images_game->icon);
$feature_game = $images_game->feature;
$info_game = json_decode($game->info_game);

@endphp
@section("breadcrumb")
<section class='page_title wave'>
    <div class='container'>
        <div class='title'>
            <h1> {{ App\Utils::get_value_language($title) }}</h1>
        </div>
        <nav class="bread-crumbs"><a href="{{route("home.index")}}">Home</a><i
                class="delimiter fa fa-chevron-right"></i><span
                class="current">
                {{ App\Utils::get_value_language($title) }}
            </span></nav>
        <!-- .breadcrumbs -->
    </div>
    <canvas class='breadcrumbs' data-bg-color='#f8f2dc' data-line-color='#f9e8b2'></canvas>
</section>
@endsection
@section('content')
<div class="page_content single_sidebar">
    <!-- pattern container / -->
    <div class="left-pattern pattern pattern-2"></div>
    <!-- container -->
    <!-- content -->
    <div class='container'>
        <!-- sidebar -->
        <!-- sidebar -->
        <aside class='sb_right'>
            <!-- widget search -->

            <!-- / widget search -->
            <!-- widget post -->
            <div class="cws-widget">
                <div class="widget-title">Relate Games</div>
                @forelse ($games_related as $game_related)
                    @php
                        $title_game_related = json_decode($game_related->title, true);
                        $short_desc_game_related = json_decode($game_related->short_desc, true);
                        $images_game = json_decode($game_related->images, true);

                    @endphp
                    <!-- post item -->
                    <div class='post_item'>
                        <div class='post_preview clearfix'>
                            <a href='{{ route('games.detail', $game_related->slug_url) }}'
                                class='post_thumb_wrapp pic'><img class='post_thumb' style="margin:0px"
                                    src='{{ asset($images_game['icon']) }}'
                                    data-at2x='{{ asset($images_game['icon']) }}' alt />

                            </a>
                            <div class='post_title'><a
                                    href='{{ route("games.detail", $game_related->slug_url) }}'>
                                    {{ App\Utils::get_value_language($title_game_related) }}
                                </a>
                            </div>
                            <div class='post_content'>
                                {{ App\Utils::get_value_language($short_desc_game_related) }}
                            </div>
                        </div>
                    </div>
                    <!-- / post item -->
                @empty
                @endforelse

            </div>
            <!-- / widget post -->

        </aside>
        <style>
            .post_item .post_content {
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                display: -webkit-box;
            }
        </style>
        <!-- / side bar -->
        <!-- main -->
        <main>
            <div class="grid_row clearfix" style="padding-bottom:0px;">

                <div class="grid_col grid_col_12">
                    <div class='media_info_wrapper'>
                        <div class="media_part" style="border-radius:0px;border-width:0px; margin-bottom:0px;">
                            <div class='pic'><img style="width: 100%;aspect-ratio:2/1"
                                    src='{{$feature_game}}' data-at2x='{{ $icon_game }}' alt />
                            </div>
                            <div class="background"></div>
                            <div class="wrapper-info-game">
                                <div class="title"><h3>{{ array_key_exists('en', $title) ? $title['en'] : '' }}</h3></div>
                                <div class="info-game" style="max-width:500px">
                                    <div class="left">
                                        <img style="width:48px; height:48px; border-radius:8px;"  src="{{$icon_game}}" alt="">
                                    </div>
                                    <div class="right" style="font-size: 15px;">
                                        <div class="review" style="padding-right: 5px;border-right: 1px solid white; color:#e8eaed;"><span>{{$info_game->reviews/1000}}K reviews</span></div>

                                        <div class="views" style="padding-right: 5px;border-right: 1px solid white; color:#e8eaed;"><span>{{$info_game->downloads}} Downloads</span></div>
                                        <div class="rate" style="color:#e8eaed;"><span>Rate for {{$info_game->rating}}</span></div>
                                    </div>
                                </div>
                                <div class='link'>
                                    <a href='{{route("games.install", $game->id)}}'
                                        style="display: inline-block;
                                            font-size: 1.3em;
                                            line-height: 1;
                                            border-radius: 7px;
                                            border: none;
                                            color: #fff;
                                            font-size:15px;
                                            background: #26b4d7;
                                            padding: 8px 18px;
                                            "
                                        class="cf-form-control cf-submit"><i
                                        style="padding-right: 3px;"
                                            class='fa fa-download'></i>Install</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- / page content -->
            </div>
            <!-- / reply form -->

            <div class="grid_row clearfix item" style="padding-top:0px; margin-top: 10px;">
                <div class='post_header_def_post'>
                    <div class="date">
                        <div class='date-cont'><span class='day'>{{$game->updated_at->format("d")}}</span><span class='month' title='July'><span>{{$game->updated_at->format("M")}}</span></span><span class='year'>{{$game->updated_at->format("Y")}}</span><i class='springs'></i></div>
                    </div>
                    <div class="post_info_header">
                        <h3 class="ce_title">About this game</h3>
                    </div>

                </div>
                <div class='post_content_wrap'>
                    <div class='post_content'>
                        <p>
                            {!! App\Utils::get_value_language($content_game) !!}
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- pattern container -->
    <div class="right-pattern pattern pattern-2"></div>
    <!-- footer  image / -->
    <div class="footer_image"></div>
</div>
<style>
    .media_part .background {
        position: absolute;
        width: 100%;
        height: 100%;
        background: #000;
        border-radius: 13px;
        top: 0;
        left: 0;
        z-index: 10;
        opacity: 0.5;
    }
    .wrapper-info-game {
        position: absolute;
        bottom: 0;
        z-index: 11;
        padding: 20px;
        box-sizing: border-box;
    }
    .wrapper-info-game .title h3{
        font-size: 40px;
        padding: 10px 0;
        color: #fff;
        max-width: 310px;
        font-family: Patrick Hand !important;
    }
    .wrapper-info-game .info-game {
        max-width: 500px;
        display: flex;
        gap: 10px;
    }
    .wrapper-info-game .info-game .right {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .wrapper-info-game .info-game span{
        color: #fff;
        font: 15px;
    }
</style>
<!-- svg filter -->
<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="0" style='display:none;'>
    <defs>
        <filter id="goo">
            <feGaussianBlur in="SourceGraphic" stdDeviation="6" result="blur" />
            <feColorMatrix in="blur" type="matrix"
                values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
            <feComposite in="SourceGraphic" in2="goo" operator="atop" />
        </filter>
    </defs>
</svg>
<!-- / svg filter -->
@endsection
