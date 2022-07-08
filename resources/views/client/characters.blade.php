@extends('layouts.layout-web-default')


@section('breadcrumb')
    <section class='page_title wave'>
        <div class='container'>
            <div class='title'>
                <h1>List Characters</h1>
            </div>
            <nav class="bread-crumbs"><a href="{{route("home.index")}}">Home</a><i class="delimiter fa fa-chevron-right"></i><span
                    class="current">Characters</span></nav>
            <!-- .breadcrumbs -->
        </div>
        <canvas class='breadcrumbs' data-bg-color='#f8f2dc' data-line-color='#f9e8b2'></canvas>
    </section>
@endsection
@section('content')
    <div class="page_content single_sidebar" style="">
        <!-- pattern container / -->

        <div class="container" style="display: block; margin-bottom: 150px; position:relative;">
            <div class='grid_row clearfix' id="list-products">
                @forelse ($characters as $character)
                @php
                    $title = json_decode($character->title, true);
                    $images_character = json_decode($character->images);
                    $icon_character = asset($images_character->icon);
                    $content = json_decode($character->content, true);
                @endphp
                <div class="js-charac-thumb charac-thumb p-3">
                    <div class="js-head _img text-center" style="text-align: center;">
                        <img style="aspect-ratio: 1/1;
                                    width: 200px;
                                    border-radius: 10px;
                                    object-fit: cover;
                                    cursor: pointer;" src="{{$icon_character}}" alt="#" />
                    </div>
                    <h3 class="_text color-tim text-center" style="text-align: center; cursor: pointer;color: #26b4d7;margin-top: 5px; ">{{ App\Utils::get_value_language($title) }}</h3>
                    <div data-charac-detail class="charac-detail" style="">
                        <img class="_img" style="aspect-ratio: 1/1;
                                                width: 200px;
                                                border-radius: 10px;
                                                object-fit: cover;" src="{{$icon_character}}" alt="#" />
                        <div class="_text">
                            <div class="_title fw-bold text-center">{{ App\Utils::get_value_language($title) }}</div>
                            <div class="_des">
                                <p>
                                    {!! App\Utils::get_value_language($content) !!}
                                </p>
                            </div>
                            <img class="_bg" src="{{ asset('client/img/charactor/item-bg.png') }}" alt="#" />
                        </div>
                    </div>
                </div>
                @empty

                @endforelse

            </div>


            <!-- pagination -->

            <!-- / pagination -->

            <style>
                #list-products {
                    display: flex;
                    flex-wrap: wrap;
                }
                #list-products .charac-thumb {
                    width: 25%;
                }
                .charac-detail {
                    display: flex!important;
                    align-items: center;
                    color: #fff;
                    position: absolute;

                    left: 5%;
                    right: 5%;
                    opacity: 0;
                    pointer-events: none;
                    transform: translateY(-22px);
                }
                .charac-detail.is-active {
                    opacity: 1;
                    pointer-events: all;
                    transform: translateY(0px);
                    transition: all .3s ease;
                }

                .charac-detail ._img {
                    width: 250px;
                    display: block;
                    margin-right: -107px;
                    position: relative;
                    z-index: 1;
                }

                .charac-detail ._text {
                    position: relative;
                    padding: 15% 18%;
                    width: 80%;
                    color: #fff;
                }

                .charac-detail ._title {
                    position: relative;
                    z-index: 1;
                    font-size: 50px;
                    text-align: center;
                    margin-bottom: 38px;
                }

                .charac-detail ._des {
                    font-size: 23px;
                    line-height: 40px;
                    color: #fff;
                    position: relative;
                    z-index: 100000;
                }

                .charac-detail ._bg {
                    position: absolute;
                    left: 50%;
                    top: 50%;
                    transform: translate(-50%, -50%);
                    width: 90%;
                    height: 90%;
                    overflow: visible;
                    stroke: transparent;
                    stroke-width: 8px;
                    transition: all .3s ease;
                    z-index: 0;
                }

                .footer_wrapper_copyright {
                    z-index: 0;
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
                <feColorMatrix in="blur" type="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9"
                    result="goo" />
                <feComposite in="SourceGraphic" in2="goo" operator="atop" />
            </filter>
        </defs>
    </svg>
    <!-- / svg filter -->
@endsection
@push('script')
    <script>
        var ENDPOINT = "{{ url('/') }}";
        var page = 2;
        jQuery("#load-more").click(function(e) {
            e.preventDefault();
            loadMoreGames(page);
            page++;
        })

        function loadMoreGames(page) {
            jQuery.ajax({
                    url: ENDPOINT + "/character?page=" + page,
                    datatype: "html",
                    type: "get",
                    beforeSend: function() {
                        jQuery('#loadding').show();
                    }
                })
                .done(function(response) {
                    jQuery('#loadding').hide();
                    if (response.length == 0) {
                        jQuery('#auto-load').html("We don't have more data to display :(");
                        return;
                    }
                    jQuery("#list-products").append(response);
                })
                .fail(function(jqXHR, ajaxOptions, thrownError) {
                    console.log('Server error occured');
                    jQuery('#loadding').hide();
                });
        }
        jQuery(".js-charac-thumb").each(function () {
            let _this = jQuery(this);
            _this.find(".js-head").click(function (event) {
              event.preventDefault();
              let _parent = jQuery(this).parent();
              let _content = _parent.find("[data-charac-detail]");

              jQuery(".js-charac-thumb").css({
                "margin-bottom": 0,
              });
              jQuery(".js-charac-thumb").removeClass("is-active");
              jQuery("[data-charac-detail]").removeClass("is-active");

              _parent.css("margin-bottom", _content.outerHeight());
              _content.addClass("is-active");
              _parent.addClass("is-active");
            });
          });
    </script>
@endpush
