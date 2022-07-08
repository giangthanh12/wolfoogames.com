@extends("layouts.layout-web-default")


@section("breadcrumb")
@php
    $content_about = (array) json_decode($content_about);
@endphp
<section class='page_title wave'>
    <div class='container'>
        <div class='title'>
            <h1>About</h1></div>
        <nav class="bread-crumbs"><a href="{{route("home.index")}}" >Home</a><i class="delimiter fa fa-chevron-right"></i><span class="current">about</span></nav>
        <!-- .breadcrumbs -->
    </div>
    <canvas class='breadcrumbs' data-bg-color='#f8f2dc' data-line-color='#f9e8b2'></canvas>
</section>
@endsection
@section('content')
<div class="page_content single_sidebar">
    <div class="container" style="display: block; margin-bottom:75px;">
        {!! App\Utils::get_value_language($content_about) !!}
    </div>
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

