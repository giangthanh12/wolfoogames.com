@extends("layouts.layout-web-default")


@section("breadcrumb")
<section class='page_title wave'>
    <div class='container'>
        <div class='title'>
            <h1>List Videos</h1></div>
        <nav class="bread-crumbs"><a href="{{route("home.index")}}" >Home</a><i class="delimiter fa fa-chevron-right"></i><span class="current">Videos</span></nav>
        <!-- .breadcrumbs -->
    </div>
    <canvas class='breadcrumbs' data-bg-color='#f8f2dc' data-line-color='#f9e8b2'></canvas>
</section>
@endsection
@section('content')
<div class="page_content single_sidebar">
    <!-- pattern container / -->



       <!-- section -->
<div class='grid_row clearfix' style='padding-top: 0px;'>
    <div class='grid_col grid_col_12'>
        <div class='ce clearfix'>
            <div>
                <h3 class="ce_title" style="text-align: center;">List Videos</h3>
            </div>
        </div>
    </div>
</div>
<!-- / section -->
<!-- section gallery -->

<!-- / gallery section -->

    <div class="container" style="display: block;">
        <div class='grid_row clearfix' id="list-products">
            @forelse ($videos as $video)
            @php
                $title = json_decode($video->title, true);
             @endphp
             <div class='grid_col grid_col_4 video-item-col'>
                <div class='ce clearfix'>
                    <div>
                            <!-- gallery item -->
                            <div class='video-item'>
                                <div class='gallery-icon landscape' style="padding:0px;">
                                    <iframe width="560" style="aspect-ratio: 2/1;width: 100%; border-radius:6px;" src="https://www.youtube.com/embed/{{$video->video_url}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                                <div style=" display: block;
                                text-align: center;"
                                 class="cws_fa_tbl_cell" >
                                <a href="{{route("videos.detail", $video->slug_url)}}"><h2 style="height: 3em;
                                    line-height: 1.5em;
                                    overflow: hidden;
                                    font-size: 20px;
                                ">{{ App\Utils::get_value_language($title) }}</h2></a>
                                </div>
                            </div>
                            <!-- / galery item -->
                            <br style="clear: both" />
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


            .video-item-col:nth-child(3n+1) {
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
    var last_page = {{ $last_page }};
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
                    url: ENDPOINT + "/videos?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function () {
                        jQuery('#loadding').show();
                    }
                })
                .done(function (response) {
                    jQuery('#loadding').hide();
                    if (response.length == 0) {
                        jQuery('#auto-load').html("We don't have more data to display :(");
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
