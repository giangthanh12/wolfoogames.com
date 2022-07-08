<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="img/cropped-favicon-192x192.png" />
    <title>{{$meta_title}}</title>
    {{-- SEO --}}
    <meta name="description" content="{{$meta_desc}}">
    <meta name="keywords" content="{{$meta_keywords}}"/>
    <meta name="robots" content="INDEX,FOLLOW"/>
    <link  rel="canonical" href="{{$url_canonical}}" />
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

    <script type='text/javascript' src='{{asset("client/js/jquery.js")}}'></script>
    {{-- <script src="{{asset("client/js/jquery3.6.0.js")}}"></script> --}}

		<!-- CSS STYLE-->
		<link rel="stylesheet" type="text/css" href="{{asset("client/css/slider/style.css")}}" />
        {{-- <link rel="stylesheet" href="https://zulijani.com/slider-revolution/sources/css/style.css"> --}}
		<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
	    <script type="text/javascript" src="{{asset("client/js/slider/jquery.themepunch.plugins.min.js")}}"></script>
		<script type="text/javascript" src="{{asset("client/js/slider/jquery.themepunch.revolution.min.js")}}"></script>

		<!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
        <link rel="stylesheet" href="{{asset("client/css/slider/settings.css")}}"  />


    <link rel="apple-touch-icon-precomposed" href="{{asset("client/img/cropped-favicon-180x180.png")}}">
    <meta name="msapplication-TileImage" content="{{asset("client/img/cropped-favicon-270x270.png")}}">
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
<style>
ul li:before {
    content:none;
}
</style>
<body class="home page wide wave-style">
    <div class="page">
        <!-- top panel -->
        <div class='site_top_panel wave slider'>
            <!-- canvas -->
            <div class='top_half_sin_wrapper'>
                <canvas class='top_half_sin' data-bg-color='#ffffff' data-line-color='#ffffff'></canvas>
            </div>
            <!-- / canvas -->
            <div class='container'>

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
        </div>
        <!-- / top panel -->
        <!-- slider and menu container -->
        <div class='slider_vs_menu'>
            <div class='header_cont'>
                <div class='header_mask'>
                    <div class='header_pattern'></div>
                </div>
                 <!-- header -->
                    @include("body.header")
                <!-- header -->
            </div>
            <!-- SLIDER -->
            @section('slider')

            @show
            <!-- END SLIDER -->
        </div>
        <!-- / slider and menu container -->
        <!-- / game hot -->
        @section("game_hot")
        @show
         <!-- / end game hot -->
        <!-- canvas -->
        <div class="cloud_wrapper">
            <canvas class="white_cloud"></canvas>
        </div>
        <!-- / canvas -->
        <!-- main container -->
        <div id="main" class="site-main">
            @yield("content")
        </div>
        <!-- #main -->
        <!-- footer -->
            @include("body.footer")
         <!-- end footer -->
    </div>
    <!-- #page -->
    <div class='scroll_top animated'></div>
    {{-- <div id="lang_sel_footer">
        <ul>
            <li>
                <a href="index-2.html" class="lang_sel_sel"><img src="img/en.png" alt="English" class="iclflag" title="English" />&nbsp;English</a>
            </li>
            <li>
                <a href="#"><img src="img/fr.png" alt="Français" class="iclflag" title="Français" />&nbsp;Français</a>
            </li>
            <li>
                <a href="#"><img src="img/de.png" alt="Deutsch" class="iclflag" title="Deutsch" />&nbsp;Deutsch</a>
            </li>
        </ul>
    </div> --}}
    {{-- <script type='text/javascript' src='tuner/tuner/js/colorpicker.js'></script>
    <script type='text/javascript' src='tuner/tuner/js/scripts.js'></script> --}}
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


    {{-- alert boostrap --}}

</body>


</html>

