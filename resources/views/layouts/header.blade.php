<!-- Main Header -->
<header class="main-header header-style-one">

    <!-- Header Upper -->
    <div class="header-upper">
        <div class="inner-container clearfix">
            <!--Logo-->
            <div class="logo-box">
                <div class="logo">
                    <a href="{{route('index')}}" title="{{lang_name('Home_page')}}"><img
                            src="{{setting()->avatar()}}" id="thm-logo" alt="{{setting()->name()}}"
                            title="{{setting()->name()}}">
                    </a>
                </div>
            </div>
            <div class="nav-outer clearfix">
                <!--Mobile Navigation Toggler-->
                <div class="mobile-nav-toggler"><span class="icon flaticon-menu-2"></span><span
                        class="txt">{{lang_name('Menu')}}</span></div>

                <!-- Main Menu -->
                <nav class="main-menu navbar-expand-md navbar-light">
                    <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                        <ul class="navigation clearfix">
                            <li class="{{current_route("index") == "active" ? "current" : ""}}"><a href="{{route('index')}}">{{lang_name('Home_Page')}}</a></li>
                            <li class="{{current_route("about") == "active" ? "current" : ""}}"><a href="{{route('about')}}">{{lang_name('About')}}</a></li>
                            <li class="dropdown {{current_route("services") == "active" ? "current" : ""}}"><a href="{{route('services')}}">{{lang_name('Services')}}</a>
                                <ul>
                                    <li><a href="{{route('services')}}">{{lang_name('All_Services')}}</a></li>
                                    @if(category()->count() != 0)
                                        @foreach(category() as $r)
                                            <li><a href="{{$r->route()}}">{{$r->name()}}</a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                            <li class="{{current_route("portfolio") == "active" ? "current" : ""}}"><a href="{{route('portfolio')}}">{{lang_name('Portfolio')}}</a></li>
                            <li class="{{current_route("blog") == "active" ? "current" : ""}}"><a href="{{route('blog')}}">{{lang_name('Blog')}}</a></li>
                            <li class="{{current_route("contact") == "active" ? "current" : ""}}"><a href="{{route('contact')}}">{{lang_name('Contact')}}</a></li>
                            <li class="dropdown">
                                <a href="#">
                                    {{$select_lan->name}}
                                </a>
                                <ul>
                                    @if($langauges->count() > 0)
                                        @foreach($langauges as $lang222)
                                            <li><a href="{{route('change_language',['lang'=>$lang222->dir])}}">{{$lang222->name}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#">
                                    {{$curenc_cooki->code}}
                                </a>
                                <ul>
                                    @if($currs->count() > 0)
                                        @foreach($currs as $item)
                                            <li><a href="{{route('currency_change',['lang'=>$item->id])}}">{{$item->name}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="other-links clearfix">
                <!--Search Btn-->
                <div class="search-btn">
                    <button type="button" class="theme-btn search-toggler"><span
                            class="flaticon-loupe"></span></button>
                </div>
                <div class="link-box">
                    <div class="call-us">
                        <a class="link" href="tel:{{hp_contact()->phone}}">
                            <span class="icon"></span>
                            <span class="sub-text">{{lang_name('Call_Us_Now')}}</span>
                            <span class="number">{{hp_contact()->phone}}</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--End Header Upper-->

</header>
<!-- End Main Header -->

<!--Mobile Menu-->
<div class="side-menu__block">


    <div class="side-menu__block-overlay custom-cursor__overlay">
        <div class="cursor"></div>
        <div class="cursor-follower"></div>
    </div><!-- /.side-menu__block-overlay -->
    <div class="side-menu__block-inner ">
        <div class="side-menu__top justify-content-end">

            <a href="{{route('index')}}" class="side-menu__toggler side-menu__close-btn"><img src="{{setting()->avatar()}}"
                                                                             alt="{{setting()->name()}}"></a>
        </div><!-- /.side-menu__top -->


        <nav class="mobile-nav__container">
            <!-- content is loading via js -->
        </nav>
        <div class="side-menu__sep"></div><!-- /.side-menu__sep -->
        <div class="side-menu__content">
            <p>{{hp_contact()->address}}</p>
            <p>
                <a href="mailto:{{hp_contact()->email}}">{{hp_contact()->email}}</a>
                <br>
                <a href="tel:{{hp_contact()->phone}}">{{hp_contact()->phone}}
                </a>
            </p>
            <div class="side-menu__social">
                @if(hp_contact()->facebook != null)
                    <a href="{{hp_contact()->facebook}}"><span
                            class="fab fa-facebook-square"></span></a>
                @endif
                @if(hp_contact()->twitter != null)
                    <a href="{{hp_contact()->twitter}}"><span class="fab fa-twitter"></span></a>
                @endif
                @if(hp_contact()->instagram != null)
                    <a href="{{hp_contact()->instagram}}"><span class="fab fa-instagram"></span></a>
                @endif
                @if(hp_contact()->pinterest != null)
                    <a href="{{hp_contact()->pinterest}}"><span
                            class="fab fa-youtube"></span></a>
                @endif
            </div>
        </div><!-- /.side-menu__content -->
    </div><!-- /.side-menu__block-inner -->
</div><!-- /.side-menu__block -->
