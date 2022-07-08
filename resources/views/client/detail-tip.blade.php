@extends("layouts.layout-web-default")

@php
$title = json_decode($tip->title, true);
$short_desc_tip = json_decode($tip->short_desc, true);
$content_tip = json_decode($tip->content, true);
@endphp
@section("breadcrumb")
<section class='page_title wave'>
    <div class='container'>
        <div class='title'>
            <h1>{{ App\Utils::get_value_language($title) }}</h1>
        </div>
        <nav class="bread-crumbs"><a href="{{route("home.index")}}" >Home</a><i class="delimiter fa fa-chevron-right"></i><span class="current">{{ App\Utils::get_value_language($title) }}</span></nav>
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
                <div class="widget-title">Related Tips</div>
                @forelse ($tips_related as $tip_related)
                @php
                    $title_tip_related = json_decode($tip_related->title, true);
                    $short_desc_tip_related = json_decode($tip_related->short_desc, true);
                @endphp
                    <!-- post item -->
                    <div class='post_item'>
                        <div class='post_preview clearfix'>
                            <a href='{{route("tips.detail", $tip_related->slug_url)}}' class='post_thumb_wrapp pic'>
                                <img class='post_thumb' src='{{asset($tip_related->images)}}' data-at2x='{{asset($tip_related->images)}}' alt />
                            </a>
                            <div class='post_title'><a href='{{route("tips.detail", $tip_related->slug_url)}}'>
                                {{ App\Utils::get_value_language($title_tip_related) }}
                            </a></div>
                            <div class='post_content'>
                                {{ App\Utils::get_value_language($short_desc_tip_related) }}
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
            <div class="grid_row clearfix">
                <!-- page content -->
                <section class="news single">
                    <div class="cws_wrapper">
                        <div class="grid">
                            <!-- blog item -->
                            <article class="item clearfix">
                                <div class='media_info_wrapper'>
                                    <div class="media_part" style="width: 100%;">
                                        <div class='pic'><img src='{{$tip->images}}' data-at2x='{{$tip->images}}' alt />
                                            <div class='hover-effect'></div>
                                            <div class='links_popup'>
                                                <div class='link_cont'>
                                                    <div class='link'>
                                                        <a class='fancy' href='{{$tip->images}}'><i class='fa fa-camera'></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='post_content_wrap'>
                                    <div class='post_content'>
                                        {!! App\Utils::get_value_language($content_tip) !!}
                                    </div>
                                    <div class='meta_cont_wrapper'>
                                        <div class='meta_cont'>
                                            <div class="post_info">
                                                <div class='date_default'><i class='fa fa-calendar'></i> {{\Carbon\Carbon::parse($tip->updated_at)->format('M d Y');}}</div>
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
