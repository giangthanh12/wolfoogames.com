@extends("layouts.layout-web-default")


@section("breadcrumb")
<section class='page_title wave'>
    <div class='container'>
        <div class='title'>
            <h1>404 Page</h1></div>
    </div>
    <canvas class='breadcrumbs' data-bg-color='#f8f2dc' data-line-color='#f9e8b2'></canvas>
</section>
@endsection
@section('content')
<div class="page_content">
    <div class='left-pattern pattern pattern-2'></div>
    <main>
        <div class="grid_row clearfix">
            <div class="grid_col grid_col_12">
                <div class="ce">
                    <div class="not_found">
                        <div class="banner_404">
                            4<span>0</span>4
                        </div>
                        <div class="desc_404">
                            <div class="msg_404">
                                <span>Sorry</span>
                                <br />page not found </div>
                            <div class="link">
                                Please, proceed to our <a href='{{route("home.index")}}'>Home page</a> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- pattern container / -->
    <div class='right-pattern pattern pattern-2'></div>
    <!-- footer image container -->
    <div class="footer_image"></div>
</div>
<!-- / 404 container -->
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

