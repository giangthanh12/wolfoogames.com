@extends("layouts.layout-web-default")
@php
$title = json_decode($video->title, true);
$short_desc_video = json_decode($video->short_desc, true);
$content_video = json_decode($video->content, true);

@endphp

@section("breadcrumb")
<section class='page_title wave'>
    <div class='container'>
        <div class='title'>
            {{-- {{ array_key_exists('en', $title) ? $title['en'] : '' }} --}}
            <h1></h1></div>
        <nav class="bread-crumbs"><a href="{{route("home.index")}}" >Home</a><i class="delimiter fa fa-chevron-right"></i><span class="current">{{ array_key_exists('en', $title) ? $title['en'] : '' }}</span></nav>
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
        <aside class='sb_right' style="margin-left:0px; width:100%; width:400px">
            <!-- widget search -->

            <!-- / widget search -->
            <!-- widget post -->
            <div class="cws-widget">
                <div class="widget-title">Related Videos</div>
                    <div id="list-videos-related">
                        @forelse ($videos_related as $video_related)
                        @php
                            $title_video_related = json_decode($video_related->title, true);
                            $content_video_related = json_decode($video_related->content, true);
                        @endphp
                            <!-- post item -->
                            <div class='post_item' >
                                <div class='post_preview clearfix'
                                    style="display: flex;
                                          flex-direction: row;
                                          gap: 10px;">
                                   <div class="pic-item" style="width: 168px;height: 94px; flex:none">
                                        <img style="height: 100%;
                                                    width: 100%;
                                                    object-fit: cover;" src="{{$video_related->images}}" alt="">
                                   </div>
                                    <div class='post_title'><a
                                        style="font-size: 18px;
                                        font-weight: 600;
                                        -webkit-line-clamp: 2;
                                        -webkit-box-orient: vertical;
                                        overflow: hidden;
                                        display: -webkit-box;"
                                        href='{{route("videos.detail", $video_related->slug_url)}}'>
                                        {{ App\Utils::get_value_language($title_video_related) }}
                                    </a>
                                        <p class="title-channel" style="font-size: 14px; margin-bottom:0px;">Channel: {{$video_related->get_channel()}}</p>
                                        <a href="{{route("videos.detail", $video_related->slug_url)}}" style="font-size: 14px;"><i class="delimiter fa fa-chevron-right" style="font-size: 11px;"></i> Watch now</a>
                                    </div>
                                </div>
                            </div>
                            <!-- / post item -->
                        @empty

                        @endforelse
                    </div>
                    <div id="loadding" style="text-align:center; display:none;">
                        <img style="width: 35px;" src="{{asset("client/img/loadding.svg")}}" alt="">
                    </div>
                    <div class="btn-loadmore" style="text-align:right"><a href="" id="load-more">Load more...</a></div>
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
        <main style="width:718px">
            <div class="grid_row clearfix">
                <!-- page content -->
                <section class="news single">
                    <div class="cws_wrapper">
                        <div class="grid" style="margin-right:0px;">
                            <!-- blog item -->
                            <article class="item clearfix" style="width:100%">
                                <div class='media_info_wrapper'>
                                    <div class="media_part" style="width: 100%; border-style:none;border-radius: 0px;">
                                        <div class='pic'>
                                            <iframe style="aspect-ratio: 2/1;width: 100%;" src="https://www.youtube.com/embed/{{$video->video_url}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                    </div>
                                </div>
                                <div class='title'>
                                    <h3 style="font-weight: 700; font-size:30px; color: #030303;">
                                        {{ App\Utils::get_value_language($title) }}
                                    </h3>
                                </div>
                                <div class='post_header_def_post'>

                                    <div class="post_info_header">
                                        <h3 style="font-size:25px;" class="ce_title">About this video</h3>
                                    </div>
                                </div>
                                <div class='post_content_wrap'>
                                    <div class='post_content'>
                                        {!! App\Utils::get_value_language($content_video) !!}
                                    </div>
                                    <div class='meta_cont_wrapper'>
                                        <div class='meta_cont'>
                                            <div class="post_info">
                                                <div class='date_default'><i class='fa fa-calendar'></i> {{\Carbon\Carbon::parse($video->updated_at)->format('M d Y');}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <!-- / blog item -->
                        </div>
                    </div>
                </section>
                <!-- / page content -->
            </div>

        </main>
    </div>
    <!-- pattern container -->
    <div class="right-pattern pattern pattern-2"></div>
    <!-- footer  image / -->
    <div class="footer_image"></div>
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
    var last_page = {{ $last_page }}

    var ENDPOINT = "{{ url('/') }}";
    var page = 2;
    if(last_page < page) {
        jQuery("#load-more").hide();
    }
    jQuery("#load-more").click(function(e) {
        e.preventDefault();
        loadMoreVideosRelated(page);
        if(page == last_page) {
            jQuery("#load-more").hide();
        }
        else {
            page++;
        }

    })
    function loadMoreVideosRelated(page) {
        jQuery.ajax({
                    url: ENDPOINT + "/videos/{{ $video->slug_url }}?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function () {
                        jQuery('#loadding').show();
                    }
                })
                .done(function (response) {
                    console.log(response);
                    jQuery('#loadding').hide();
                    if (response.length == 0) {
                        return;
                        jQuery("#load-more")
                    }
                    jQuery("#list-videos-related").append(response);
                })
                .fail(function (jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                    jQuery('#loadding').hide();
                });
        }
</script>
@endpush
