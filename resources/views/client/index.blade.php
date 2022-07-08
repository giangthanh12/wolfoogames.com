@extends('layouts.web')

@section('slider')
    @parent
    @include('body.slider')
@endsection
@section('game_hot')
    @parent
    @include('body.game_hot')
@endsection


@section('content')
    <div class="page_content">
        <!-- pattern conatainer / -->
        <div class='left-pattern pattern pattern-2'></div>
        <main>
            <!-- section -->

                    <!-- heading section -->
                    <div class='grid_row clearfix'>
                        <div class='grid_col grid_col_12'>
                            <div class='ce clearfix'>
                                <div>
                                    <h3 class="ce_title" style="text-align: center;">Game Features</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / heading section -->
                    <!-- section -->
                    <div class='grid_row clearfix '>
                        @forelse ($feature_games as $feature_game)
                        @php
                            $title = json_decode($feature_game->title, true);
                            $images_feature_game = json_decode($feature_game->images);
                            $icon_game = asset($images_feature_game->icon);
                        @endphp



                        <div class='grid_col grid_col_4 new-game-item clearfix'>
                            <div class='ce clearfix'>
                                <div>
                                    <div class='cws_fa_tbl'>
                                        <div class='cws_fa_tbl_row'>
                                            <div class='cws_fa_tbl_cell size_1x' style="width: calc(2em + 130px);">
                                                <div class='cws_fa_wrapper round' style="transform: translateY(-8px);">
                                                    <img src="{{$icon_game}}" alt="" style="border-radius: 15px;">
                                                </div>
                                            </div>
                                            <div class='cws_fa_tbl_cell'>
                                                <a href='{{route("games.detail", $feature_game->slug_url)}}'> <h2 style="height: 3em;
                                                line-height: 1.5em;
                                                overflow: hidden;
                                                transform: translateY(-18px);
                                                font-family: Patrick Hand !important;
                                                ">  {{ App\Utils::get_value_language($title) }}</h2> </a>
                                                <div class='link'>
                                                    <a href='{{route("games.install",$feature_game->id)}}' style="display: inline-block;
                                                    font-size: 1.3em;
                                                    line-height: 1;
                                                    padding: 8px 20px;
                                                    border-radius: 7px;
                                                    border: none;
                                                    color: #fff;
                                                    background: #26b4d7;
                                                    font-size:20px;
                                                    /* margin-top:10px; */

                                                    " class="cf-form-control cf-submit"><i style="font-size: 17px;" style="padding-right:10px" class='fa fa-download'></i>Install</a>
                                                </div>

                                            </div>
                                        </div>
                                        <div class='cws_fa_tbl_row'>
                                            <div class='cws_fa_tbl_cell'></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty

                        @endforelse
                    </div>
                    <div class='grid_row clearfix button-load-game'>
                        <a href='{{route("games.index")}}' class='cws_button'>More game</a>
                    </div>
                    <!-- / section -->
                    <!-- divider -->
                    <div class='grid_row clearfix' style='padding-bottom: 50px;'>
                        <div class='grid_col grid_col_12'>
                            <div class='ce clearfix'>
                                <div>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>


            <style>
                .game_feature .cws-widget:before {
                    content: '';
                    width: 70%;
                    height: calc(100% + 60px);
                    border-radius: 100%;
                    position: absolute;
                    top: -30px;
                    left: 15%;
                    z-index: -1;
                    background: #c6f0fa;
                }
                .cws_textwidget_content .text {
                    -webkit-line-clamp: 3;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    display: -webkit-box;
                }
                .widget_title_text_section {
                    -webkit-line-clamp: 1;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    display: -webkit-box;
                }
                .game_feature .cws-widget {
                    border-radius: 25% 25% 25% 25%/60% 60% 40% 40%;
                    position: relative;
                    z-index: 1;
                    background: #c6f0fa;
                    margin-top: 0;
                }

                .game-feature {
                    margin-top: 85px;
                }

                .game-feature:nth-child(3n+1) {
                    margin-left: 0;
                }

                .cws-widget .widget-title:after {
                    content: none;
                    display: block;
                    width: 100%;
                    height: 6px;
                    border-radius: 3px;
                    margin-top: 8px;
                }

                .button-load-game {
                    text-align: center;
                    margin-top: 20px;
                }
            </style>

                    <!-- heading section -->
                    <div class='grid_row clearfix'>
                        <div class='grid_col grid_col_12'>
                            <div class='ce clearfix'>
                                <div>
                                    <h3 class="ce_title" style="text-align: center;">New games</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / heading section -->
                    <!-- section -->
                    <div class='grid_row clearfix '>
                        @forelse ($new_games as $new_game)
                        @php
                            $title = json_decode($new_game->title, true);
                            $images_new_game = json_decode($new_game->images);
                            $icon_game = asset($images_new_game->icon);
                            // $short_desc_game = json_decode($new_game->short_desc, true);
                        @endphp
                         <div class='grid_col grid_col_4 new-game-item clearfix'>
                            <div class='ce clearfix'>
                                <div>
                                    <div class='cws_fa_tbl'>
                                        <div class='cws_fa_tbl_row'>
                                            <div class='cws_fa_tbl_cell size_1x' style="width: calc(2em + 130px);">
                                                <div class='cws_fa_wrapper round' style="transform: translateY(-8px);">
                                                    <img src="{{$icon_game}}" alt="" style="border-radius: 15px;">
                                                </div>
                                            </div>
                                            <div class='cws_fa_tbl_cell'>
                                                <a href='{{route("games.detail", $new_game->slug_url)}}'> <h2 style="height: 3em;
                                                line-height: 1.5em;
                                                overflow: hidden;
                                                transform: translateY(-18px);
                                                font-family: Patrick Hand !important;
                                                ">{{ App\Utils::get_value_language($title) }}</h2> </a>
                                                <div class='link'>
                                                    <a href='{{route("games.install",$new_game->id)}}' style="display: inline-block;
                                                    font-size: 1.3em;
                                                    line-height: 1;
                                                    padding: 8px 20px;
                                                    border-radius: 7px;
                                                    border: none;
                                                    color: #fff;
                                                    background: #26b4d7;
                                                    font-size:20px;
                                                    /* margin-top:10px; */

                                                    " class="cf-form-control cf-submit"><i style="font-size: 17px;" style="padding-right:10px" class='fa fa-download'></i>Install</a>
                                                </div>

                                            </div>
                                        </div>
                                        <div class='cws_fa_tbl_row'>
                                            <div class='cws_fa_tbl_cell'></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </div>
                    <div class='grid_row clearfix button-load-game'>
                        <a href='{{route("games.index")}}' class='cws_button'>More game</a>
                    </div>
                    <!-- / section -->
                    <!-- divider -->


            <div class='grid_row clearfix' style='padding-bottom: 50px;'>
                <div class='grid_col grid_col_12'>
                    <div class='ce clearfix'>
                        <div>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .new-game-item {
                    margin-bottom: 50px;
                    /* height: 125px; */
                }
                .new-game-item:nth-child(3n+1) {
                    margin-left: 0px;
                }
            </style>
            <!-- / divider -->
            <!-- section -->
            <div class='grid_row clearfix' style='padding-top: 0px;'>
                <div class='grid_col grid_col_12'>
                    <div class='ce clearfix'>
                        <div>
                            <h3 class="ce_title" style="text-align: center;">New Videos</h3>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / section -->
            <!-- section gallery -->
            <div class='grid_row clearfix'>
                @forelse ($new_videos as $new_video)
                @php

                $title = json_decode($new_video->title, true);

                @endphp
                <div class='grid_col grid_col_4 video-item-col'>
                    <div class='ce clearfix'>
                        <div>
                                <!-- gallery item -->

                                    <div class='video-item'>
                                        <div class='gallery-icon landscape' style="padding:0;">
                                            <iframe width="560" style="aspect-ratio: 2/1;width: 100%; border-radius:6px;" src="https://www.youtube.com/embed/{{$new_video->video_url}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                        <div style=" display: block;
                                                     text-align: center;"
                                        class="cws_fa_tbl_cell" >
                                            <a href="{{route("videos.detail", $new_video->slug_url)}}"><h2 style="height: 3em;
                                                line-height: 1.5em;
                                                overflow: hidden;
                                                font-size: 20px;
                                            ">{{ App\Utils::get_value_language($title) }}</h2></a></div>
                                    </div>
                                <!-- / galery item -->

                                <br style="clear: both" />
                        </div>
                    </div>
                </div>

                @empty
                @endforelse
            </div>
            <!-- / gallery section -->
            <style>
                .video-item-col:nth-child(3n+1) {
                    margin-left: 0px;
                }
            </style>
        </main>
        <!-- pettaren container / -->
        <div class='right-pattern pattern pattern-2'></div>
        <!-- footer image container / -->
        <div class="footer_image"></div>
    </div>
    <!-- svg filter -->
    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="0" style='display:none;'>
        <defs>
            <filter id="goo">
                <feGaussianBlur in="SourceGraphic" stdDeviation="6" result="blur" />
                <feColorMatrix in="blur" type="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9"
                    result="goo" />
                <feComposite in="SourceGraphic" in2="goo" operator="atop" />
            </filter>
        </defs>
    </svg>
    <!-- / svg filter -->
@endsection
