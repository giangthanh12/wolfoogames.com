<!DOCTYPE html>
<html lang="en-US">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="img/cropped-favicon-192x192.png" />
    <title>Wolfoogames</title>
    {{-- SEO --}}
    <meta name="description" content=" ">
    <meta name="keywords" content=""/>
    <meta name="robots" content="INDEX,FOLLOW"/>
    <link  rel="canonical" href="" />   {{-- link hiện tại --}}
    <meta name="author" content="">
    <link rel="icon" href="{{asset("client/img/cropped-favicon-32x32.png")}}" sizes="32x32" />
    <link rel="icon" href="{{asset("client/img/cropped-favicon-192x192.png")}}" sizes="192x192" />
    {{-- END SEO --}}

    <link rel='stylesheet' href='{{asset("client/css/font-awesome.css")}}' type='text/css' media='all' />
    <link rel='stylesheet' href='{{asset("client/css/jquery.fancybox.css")}}' type='text/css' media='all' />
    <link rel='stylesheet' href='{{asset("client/css/select2.css")}}' type='text/css' media='all' />
    <link rel='stylesheet' href='{{asset("client/css/animate.css")}}' type='text/css' media='all' />
    <link rel='stylesheet' href='{{asset("client/css/main.css")}}' type='text/css' media='all' />
    <link rel='stylesheet' href='{{asset("client/css/shop.css")}}' type='text/css' media='all' />
    <link rel="stylesheet" href="{{asset("plugins/toastr/toastr.min.css")}}"/>

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script type='text/javascript' src='{{asset("client/js/jquery.js")}}'></script>

    <script type='text/javascript' src='{{asset("client/js/jquery-ui.min.js")}}'></script>
    <script type='text/javascript' src='{{asset("client/js/jquery-migrate.min.js")}}'></script>
    {{-- <link rel='stylesheet' href='tuner/style.css' type='text/css' media='all' /> --}}

    <link rel="apple-touch-icon-precomposed" href="img/cropped-favicon-180x180.png">
    <meta name="msapplication-TileImage" content="img/cropped-favicon-270x270.png">
</head>
@php
     $languages = App\Models\Config::get_languages();
        $languagesSelect = [App\Constants::DEFAULT_LANGUAGE => App\Constants::DEFAULT_LANG_NAME];
        if (!is_null($languages) && count($languages) > 0) {
            foreach($languages as $lang_code) {
                $languagesSelect[$lang_code] = App\Constants::LANGUAGES[$lang_code];
            }
        }

@endphp
<body class="archive post-type-archive post-type-archive-product woocommerce woocommerce-page wide wave-style">
    <div class="page">
        <!-- top panel -->
        <div class='site_top_panel wave slider'>
            <!-- canvas -->
            <div class='top_half_sin_wrapper'>
                <canvas class='top_half_sin' data-bg-color='#ffffff' data-line-color='#ffffff'></canvas>
            </div>
            <!-- / canvas -->
            <!-- top panekl content -->
            <div class='container' >
                <div class='row_text_search'>
                </div>
                <div id='top_panel_links'>

                    <div class="lang_bar">
                        <div>
                            <ul>
                                <li>
                                    <a href="#" class="lang_sel_sel icl-en">
                                        {{session()->has("selected_lang") ? $languagesSelect[session()->get("selected_lang")] : "English"}}
                                    </a>
                                    <ul>
                                        @foreach ($languagesSelect as $key=>$languageSelect)
                                            <li class="icl-fr">
                                                <a href="{{route("home.change-language", $key)}}">{{$languageSelect}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="site_top_panel_toggle"></div>
            </div>
            <!-- / top panel content -->
        </div>
        <!-- / top panel -->
        <!-- header container -->
        <div class='header_cont'>
            <div class='header_mask'>
                <div class='header_pattern'></div>
                <div class='header_img'></div>
            </div>
            @include("body.header")
            <!-- #masthead -->
        </div>
        <!-- / heder container -->
        <!-- bredcrumbs -->
        @yield("breadcrumb")
        <!-- / breadrumbs -->
        <!-- main container -->
        <div id="main" class="site-main">
            @yield("content")
        </div>
        <!-- #main -->
        <!-- footer -->
       @include("body.footer")
    </div>
    <!-- #page -->
    <div class='scroll_top animated'></div>
    <script type='text/javascript' src='{{asset("client/js/retina_1.3.0.js")}}'></script>
    <script type='text/javascript' src='{{asset("client/js/modernizr.js")}}'></script>
    <script type='text/javascript' src='{{asset("client/js/owl.carousel.js")}}'></script>
    <script type='text/javascript' src='{{asset("client/js/TweenMax.min.js")}}'></script>
    <script type='text/javascript' src='{{asset("client/js/jquery.isotope.min.js")}}'></script>
    <script type='text/javascript' src='{{asset("client/js/jquery.fancybox.js")}}'></script>
    <script type='text/javascript' src='{{asset("client/js/select2.min.js")}}'></script>
    <script type='text/javascript' src='{{asset("client/js/wow.min.js")}}'></script>
    <script type='text/javascript' src='{{asset("client/js/jquery.validate.min.js")}}'></script>
    <script type='text/javascript' src="{{asset("client/js/jquery.form.min.js")}}"></script>
    <script type='text/javascript' src='{{asset("client/js/scripts.js")}}'></script>
    <script type='text/javascript' src="{{asset("client/js/jquery.tweet.js")}}"></script>
</body>

@stack("script")

</html>
