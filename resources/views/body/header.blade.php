   <header class='site_header logo-in-menu' data-menu-after="3">
                    <div class="header_box">
                        <div class="container">
                            <!-- logo -->
                            <div class="header_logo_part with_border" role="banner">
                                <a class="logo" href="index-2.html"><img src='{{asset("client/img/logo1-304vqrnv7ccxz47xp4tw5m.png")}}' data-at2x='https://kiddy.cwsthemes.com/wp-content/uploads/bfi_thumb/logo1-3dc8xteh2cjwhur3tdcjre@2x.png' alt /></a>
                            </div>
                            <!-- / logo -->
                            <!-- menu -->
                            <div class="header_nav_part">
                                <nav class="main-nav-container a-center">
                                    <div class="mobile_menu_header">
                                        <i class="mobile_menu_switcher"><span></span><span></span><span></span></i>
                                    </div>
                                    <ul id="menu-main-menu" class="main-menu menu-bees">
                                        <!-- menu item -->
                                        <li class="menu-item page_item  current-menu-parent current_page_parent  menu-item-has-children bees-start">
                                            <a href="{{route("home.index")}}">
                                                <div class="bees bees-start"><span></span>
                                                    <div class="line-one"></div>
                                                    <div class="line-two"></div>
                                                </div>Home
                                                <div class="canvas_wrapper">
                                                    <canvas class="menu_dashed"></canvas>
                                                </div>
                                            </a>
                                        </li>
                                        {{-- current-menu-item current_page_item current-menu-ancestor --}}
                                        <!-- / menu item -->
                                        <!-- menu item -->
                                        <li class="menu-item menu-item-has-children"><a href="{{route("games.index")}}">Games<div class="canvas_wrapper"><canvas class="menu_dashed"></canvas></div></a>
                                            {{-- <span class='button_open'></span> --}}

                                        </li>
                                        <!-- / menu item -->
                                        <!-- menu item -->
                                        <li class="menu-item menu-item-has-children" ><a href="{{route("character.index")}}">Character<div class="canvas_wrapper"><canvas class="menu_dashed"></canvas></div></a>
                                            {{-- <span class='button_open'></span> --}}
                                        </li>
                                        <!-- / menu item -->
                                        <!-- menu item -->
                                        <li class="menu-item menu-item-has-children right"><a href="{{route("videos.index")}}">Video<div class="canvas_wrapper"><canvas class="menu_dashed"></canvas></div></a>
                                            {{-- <span class='button_open'></span> --}}
                                        </li>
                                        <!-- / menu item -->
                                        <!-- menu item -->
                                        <li class="menu-item menu-item-has-children right" ><a href="{{route("tips.index")}}">Tips<div class="canvas_wrapper"><canvas class="menu_dashed"></canvas></div></a>
                                            {{-- <span class='button_open'></span> --}}
                                        </li>
                                        <!-- / menu item -->
                                        <!-- menu item -->
                                        <li class="menu-item right bees-end">
                                            <a href="{{route("about.index")}}">
                                                <div class="bees bees-end"><span></span>
                                                    <div class="line-one"></div>
                                                    <div class="line-two"></div>
                                                </div>About
                                                <div class="canvas_wrapper">
                                                    <canvas class="menu_dashed"></canvas>
                                                </div>
                                            </a>
                                        </li>
                                        <!-- / menu item -->
                                    </ul>
                                </nav>
                            </div>
                            <!-- / menu -->
                        </div>
                    </div>
                </header>
