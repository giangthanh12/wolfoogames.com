@extends("layouts.layout-web-default")


<!-- bredcrumbs -->
@section("breadcrumb")
<section class='page_title wave'>
    <div class='container'>
        <div class='title'>
            <h1>Tips</h1></div>
        <nav class="bread-crumbs"><a href="{{route("home.index")}}" >Home</a><i class="delimiter fa fa-chevron-right"></i><span class="current">Tips</span></nav>
        <!-- .breadcrumbs -->
    </div>
    <canvas class='breadcrumbs' data-bg-color='#f8f2dc' data-line-color='#f9e8b2'></canvas>
</section>
@endsection
<!-- bredcrumbs -->
@section('content')
<div class="page_content">
    <!-- pattern container / -->
    <div class='left-pattern pattern pattern-2'></div>
    <!-- main -->
    <main>
        <div class="grid_row">
            <!-- blog items -->
            <section class="news news-medium">
                <div class="cws_wrapper">
                    <div class="grid">
                        @forelse ($tips as $tip)
                        @php
                            $title = json_decode($tip->title, true);
                            $short_desc_tip = json_decode($tip->short_desc, true);
                        @endphp
                        <!-- blog item -->
                        <article class='item medium'>
                            <div class='post_header_def_post'>
                                <div class="date">
                                    <div class='date-cont'><span class='day'>{{$tip->updated_at->format("d")}}</span><span class='month' title='July'><span>{{$tip->updated_at->format("M")}}</span></span><span class='year'>{{$tip->updated_at->format("Y")}}</span><i class='springs'></i></div>
                                </div>
                                <div class="post_info_header">
                                    <h3 class="ce_title"><a href="{{route("tips.detail", $tip->slug_url)}}">{{ App\Utils::get_value_language($title) }}</a></h3> </div>
                            </div>
                            <div class='media_info_wrapper'>
                                <div class="media_part">
                                    <div class='pic'>
                                        <img src='{{asset($tip->images)}}' data-at2x='{{asset($tip->images)}}' alt />
                                    </div>
                                </div>
                            </div>
                            <div class='post_content_wrap'>
                                <div class='post_content'>
                                   <p>{{ App\Utils::get_value_language($short_desc_tip) }}</p>
                                </div>
                                <div class='meta_cont_wrapper'>
                                    <div class='meta_cont'>

                                        <div class='button_cont'><a href='{{route("tips.detail", $tip->slug_url)}}' class='cws_button small'>Read More</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class='separator-box'>
                                <canvas class='separator' width='1170' data-line-color='#f9e8b2'></canvas>
                            </div>
                        </article>
                        <!-- / blog item -->
                        @empty

                        @endforelse




                        <div class='pagination'>
                            <div class='page_links'>
                                {{$tips->links()}}
                            </div>
                        </div>
                    <!-- / pagination -->

            </section>
            <!-- / blog items -->
        </div>
    </main>

    <style>
        .pagination ul {
            display: flex;
            justify-content: center;
        }
        .pagination ul li {
            padding: 20px;
        }
        .pagination .page_links nav {
            background: none;
            width: 100%;
        }

        .pagination .page_links {
            display: block;
        }

    </style>
    <!-- patern container / -->
    <div class='right-pattern pattern pattern-2'></div>
    <!-- footer image / -->
    <div class="footer_image"></div>
</div>
<!-- svg filter -->
<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="0" style='display:none;'>
    <defs>
        <filter id="goo">
            <feGaussianBlur in="SourceGraphic" stdDeviation="6" result="blur" />
            <feColorMatrix in="blur" type="matrix" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 19 -9" result="goo" />
            <feComposite in="SourceGraphic" in2="goo" operator="atop" />
        </filter>
    </defs>
</svg>
<!-- / svg filter -->
@endsection
