<div class='benefits_area wave'>
    <!-- canvas -->
    <div class='cloud_wrapper'>
        <canvas class='cloud' data-bg-color='#f9e8b2' data-line-color='#ffffff'
            data-pattern-src='{{ asset('client/img/dots-pattern.png') }}'></canvas>
    </div>
    <div class='grid_row clearfix' style='padding-top: 0px; position: relative; z-index:100'>
        <div class='grid_col grid_col_12'>
            <!-- about us -->
            <div class='ce clearfix'>
                <div>
                    <h3 class="ce_title" style="text-align: center;">Game Hots</h3>
                </div>
            </div>
            <!-- / about us -->
        </div>
    </div>
    <!-- / canvas -->
    <div class='container'>
        <!-- benefits container -->
        <div class='benefits_container'>
            <!-- benefits item -->
            @forelse ($hot_games as $hot_game)
            @php
                $title = json_decode($hot_game->title, true);
                $images_hot_game = json_decode($hot_game->images);
                $icon_game = asset($images_hot_game->icon);
                $short_desc_game = json_decode($hot_game->short_desc, true);
            @endphp
                <div class="cws-widget">
                    <div class="widget-title">
                        <div class='widget_title_box'>
                            <div class='widget_title_icon_section' style="display:block;">
                                <img style="width: 85px;
                                            height: 85px;
                                            border-radius: 27%;"
                                    src='{{ $icon_game }}'
                                    alt />
                            </div>
                            <a href='{{route("games.detail", $hot_game->slug_url)}}'>
                                <div class='widget_title_text_section'
                                style="font-size: 26px;
                                    padding: 9px 0;"
                                > {{ App\Utils::get_value_language($title) }}
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class='cws_textwidget_content' style="margin-top: 0px;">
                        <div class='text' style="font-size: 18px;">{{ App\Utils::get_value_language($short_desc_game) }}</div>
                            <div class='link'>
                                <a href='{{route("games.install", $hot_game->id)}}' style="display: inline-block;
                                font-size: 1.3em;
                                line-height: 1;
                                padding: 8px 20px;
                                border-radius: 7px;
                                border: none;
                                color: #fff;
                                background: #26b4d7;
                                font-size:20px;
                                margin-top:10px;
                                " class="cf-form-control cf-submit"><i style="padding-right:10px" class='fa fa-download'></i>Install</a>
                                    <div class='link-item-bounce'></div>
                            </div>
                    </div>
                </div>
            @empty
            @endforelse

            <!-- / benefits item -->

        </div>
        <!-- / benefits container -->
    </div>
</div>
