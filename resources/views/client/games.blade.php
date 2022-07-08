@extends("layouts.layout-web-default")


@section("breadcrumb")
<section class='page_title wave'>
    <div class='container'>
        <div class='title'>
            <h1>List Games</h1></div>
        <nav class="bread-crumbs"><a href="{{route("home.index")}}" >Home</a><i class="delimiter fa fa-chevron-right"></i><span class="current">Games</span></nav>
        <!-- .breadcrumbs -->
    </div>
    <canvas class='breadcrumbs' data-bg-color='#f8f2dc' data-line-color='#f9e8b2'></canvas>
</section>
@endsection
@section('content')
<div class="page_content single_sidebar">
    <!-- pattern container / -->

    <div class="container" style="display: block;">
        <div class='grid_row clearfix' id="list-products">
            @forelse ($games as $game)
            @php
            $title = json_decode($game->title, true);
            $images_game = json_decode($game->images);
            $icon_game = asset($images_game->icon);
            $short_desc_game = json_decode($game->short_desc, true);
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
                                    <a href='{{route("games.detail",$game->slug_url)}}'> <h2 style="height: 3em;
                                    line-height: 1.5em;
                                    overflow: hidden;
                                    transform: translateY(-18px);
                                    font-family: Patrick Hand !important;
                                    ">  {{ App\Utils::get_value_language($title) }}</h2> </a>
                                    <div class='link'>
                                        <a href='{{route("games.install", $game->id)}}' style="display: inline-block;
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

        <div id="loadding" style="text-align:center; display:none;">
            <img src="{{asset("client/img/Infinity-1s-200px.svg")}}" alt="">
        </div>
        <!-- pagination -->
        <div style="" class='grid_row clearfix button-load-game a-center'>
            <a href='' id="load-more" class='cws_button'>Load more</a>
        </div>
        <!-- / pagination -->
        <style>

            .new-game-item {
                margin-bottom: 110px;
                height: 125px;
            }
            .new-game-item:nth-child(3n+1) {
                margin-left: 0px;
            }

        </style>


    </div>
    <!-- footer image container  / -->
    <div class="footer_image"></div>
    <!-- pattern container / -->
    <div class='right-pattern pattern pattern-2'></div>
</div>
<!-- svg filter -->
<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="0" style='display:none;'>
    <defs>
        <filter id="goo">
            <feGaussianBlur in="SourceGraphic" stdDeviation="6" result="blur" />
            <feColorMatrix in="blur" type="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
            <feComposite in="SourceGraphic" in2="goo" operator="atop" />
        </filter>
    </defs>
</svg>
<!-- / svg filter -->
@endsection
@push("script")
<script>
    var ENDPOINT = "{{ url('/') }}";
    var page = 2;
    var last_page = {{$last_page}}
    if(last_page < page) {
        jQuery("#load-more").hide();
    }
    jQuery("#load-more").click(function(e) {
        e.preventDefault();
        loadMoreGames(page);
        if(page == last_page) {
            jQuery("#load-more").hide();
        }
        else {
            page++;
        }
    })
    function loadMoreGames(page) {
        jQuery.ajax({
                    url: ENDPOINT + "/games?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function () {
                        jQuery('#loadding').show();
                    }
                })
                .done(function (response) {
                    jQuery('#loadding').hide();
                    if (response.length == 0) {
                        return;
                    }
                    jQuery("#list-products").append(response);
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                    jQuery('#loadding').hide();
                });
        }
</script>
@endpush
