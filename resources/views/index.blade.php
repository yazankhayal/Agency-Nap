@extends('layouts.app')

@section('title')
    {{$lang->Home_Page}}
@endsection

@section('content')

    <!-- Banner Section -->
    <section class="banner-section banner-one banner-one-page" id="home">

        <div class="banner-carousel owl-theme owl-carousel">


            @if($slider->count() != 0)
                @foreach($slider as $i)
                    <div class="slide-item">
                        <div class="image-layer" style="background-image: url('{{$i->img1()}}');"></div>

                        <div class="auto-container">
                            <div class="content-box">
                                <div class="content">
                                    <div class="inner text-center">
                                        <div class="sub-title">{{$i->name()}}</div>
                                        <h1>{{$i->sub_name()}} <br> <span>{!! $i->summary() !!}</span></h1>
                                        <div class="link-box">
                                            @if($i->link)
                                                <a class="theme-btn btn-style-one" href="{{$i->link}}">
                                                    <i class="btn-curve"></i>
                                                    <span class="btn-title">{{lang_name('Read_More')}}</span>
                                                </a>
                                            @endif
                                            @if($i->video)
                                                <div class="vid-link">
                                                    <a href="{{$i->video}}"
                                                       class="lightbox-image">
                                                        <div class="icon"><span class="flaticon-play-button-1"></span><i
                                                                class="ripple"></i></div>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </section>
    <!--End Banner Section -->

    <!--Services Section-->
    <section class="services-section">
        <div class="auto-container">
            <div class="row clearfix">
                <!--Title Block-->
                <div class="title-block col-xl-6 col-lg-12 col-md-12 col-sm-12">
                    <div class="inner">
                        <div class="sec-title">
                            <h2>We Shape the Perfect <br>Solutions<span class="dot">.</span></h2>
                            <div class="lower-text">We are committed to providing our customers with exceptional
                                service while offering our employees the best training.
                            </div>
                        </div>
                    </div>
                </div>

                @if(category()->count() != 0)
                    @foreach(category() as $r)
                        <div class="service-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInLeft"
                             data-wow-delay="0ms"
                             data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="bottom-curve"></div>
                                <div class="icon-box"><img src="{{$r->avatar()}}"></div>
                                <h6><a href="{{$r->route()}}">{{$r->name()}}</a></h6>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>

    @if($about != null)
        <!--About Section-->
        <section class="about-section">
            <div class="auto-container">
                <div class="row clearfix">
                    <!--Image Column-->
                    <div class="image-column col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="image-block wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms"><img
                                    src="{{$about->img1()}}" alt=""></div>
                            <div class="image-block wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms"><img
                                    src="{{$about->img2()}}" alt=""></div>
                        </div>
                    </div>
                    <!--Text Column-->
                    <div class="text-column col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        {!! $about->summary() !!}
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($how_work)
        <!--Live Section-->
        <section class="live-section">
            <div class="auto-container">
                <div class="sec-title centered">
                    <h2>{{$how_work->name()}} <span class="dot">.</span></h2>
                </div>
                <div class="main-image-box">
                    <div class="image-layer" style="background-image: url('{{$how_work->img1()}}');"></div>
                    <div class="inner clearfix">
                        <div class="round-box wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1500ms">
                            <div class="round-inner">
                                <div class="vid-link">
                                    @if($how_work->video)
                                        <a href="{{$how_work->video}}" class="lightbox-image">
                                            <div class="icon"><span class="flaticon-play-button-1"></span><i
                                                    class="ripple"></i></div>
                                        </a>
                                    @endif
                                </div>
                                <div class="title">
                                    {!! $how_work->summary() !!}
                                </div>
                                @if($how_work->link)
                                    <div class="more-link"><a href="{{$how_work->link}}">{{lang_name('Read_More')}}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if($fact)
        <!--We DO Section-->
        <section class="we-do-section">
            <div class="auto-container">
                <div class="row clearfix">
                    <!--Left Column-->
                    <div class="left-col col-lg-6 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="sec-title">
                                <h2>{{$fact->name()}}<br>{{$fact->sub_name()}} <span class="dot">.</span></h2>
                            </div>
                            <div class="featured-block clearfix">
                                <div class="image"><img src="{{$fact->img1()}}" alt=""></div>
                                <div class="text">
                                    {!! $fact->summary() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Right Column-->
                    <div class="right-col col-lg-6 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="faq-box">
                                <ul class="accordion-box clearfix">

                                    @if($fqa->count() != 0)
                                        @php $c = 1; @endphp
                                        @foreach($fqa as $r)
                                            <li class="accordion block {{$c == 1 ? "active-block" : ""}}">
                                                <div class="acc-btn {{$c == 1 ? "active" : ""}}"><span class="count">{{$c}}.</span>
                                                    {{$r->name()}}
                                                </div>
                                                <div class="acc-content  {{$c == 1 ? "current" : ""}}">
                                                    <div class="content">
                                                        <div class="text">{{$r->summary()}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @php $c = $c + 1; @endphp
                                        @endforeach
                                    @endif

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Gallery Section -->
    <section class="gallery-section">
        <div class="auto-container">
            <!--MixitUp Galery-->
            <div class="mixitup-gallery">
                <div class="upper-row clearfix">
                    <div class="sec-title">
                        <h2>work showcase <span class="dot">.</span></h2>
                    </div>
                    <!--Filter-->
                    <div class="filters clearfix">
                        <ul class="filter-tabs filter-btns clearfix">
                            <li class="active filter" data-role="button" data-filter="all">All<sup>[{{$featured->count()}}]</sup></li>
                            @if(CategoryPortfolio()->count() != 0)
                                @foreach(CategoryPortfolio() as $r)
                                    <li class="filter" data-role="button"
                                        data-filter=".fliter_cat_{{$r->id}}">{{$r->name()}}<sup>
                                            [{{$r->Portfolio->count()}}]</sup>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="filter-list row">

                    @if($featured->count() != 0)
                        @foreach($featured as $r)
                            <div
                                class="gallery-item mix all fliter_cat_{{$r->category_portfolio_id}} col-lg-4 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <figure class="image"><img src="{{$r->img()}}" alt=""></figure>
                                    <a href="{{$r->img()}}" class="lightbox-image overlay-box"
                                       data-fancybox="gallery"></a>
                                    <div class="cap-box">
                                        <div class="cap-inner">
                                            <div class="cat"><span>{{$r->CategoryPortfolio->name()}}</span></div>
                                            <div class="title">
                                                <h5><a href="{{$r->route()}}">{{$r->name()}}</a></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>

            </div>

        </div>
    </section>

    <!-- Funfacts Section -->
    <section class="facts-section">
        <div class="image-layer" style="background-image: url('{{setting()->fact()}}');"></div>
        <div class="auto-container">
            <div class="inner-container">

                @if($special)
                    <div class="fact-counter">
                        {!! $special->summary() !!}
                    </div>
                @endif

            </div>
        </div>
    </section>
    <!-- End Funfacts Section -->

    <!--Sponsors Section-->
    <section class="sponsors-section">
        <div class="sponsors-outer">
            <!--Sponsors-->
            <div class="auto-container">
                <!--Sponsors Carousel-->
                <div class="sponsors-carousel owl-theme owl-carousel">
                    @if($gallery->count() != 0)
                        @foreach($gallery as $r)
                            <div class="slide-item">
                                <figure class="image-box"><img src="{{$r->img()}}" alt=""></figure>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!--Agency Section-->
    @if($agency)
        <section class="agency-section">
            <div class="auto-container">
                <div class="row clearfix">
                    <!--Left Column-->
                    <div class="left-col col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="sec-title">
                                <h2>{{$agency->name()}}<br>{{$agency->sub_name()}} <span class="dot">.</span></h2>
                            </div>

                            <!--Default Tabs-->
                            <div class="default-tabs tabs-box">

                                <!--Tab Btns-->
                                <ul class="tab-btns tab-buttons clearfix">
                                    <li data-tab="#tab-1" class="tab-btn active-btn">
                                        <span>{{lang_name('Mission')}}</span></li>
                                    <li data-tab="#tab-2" class="tab-btn"><span>{{lang_name('Vision')}}</span></li>
                                    <li data-tab="#tab-3" class="tab-btn"><span>{{lang_name('History')}}</span></li>
                                </ul>

                                <!--Tabs Container-->
                                <div class="tabs-content">

                                    <!--Tab-->
                                    <div class="tab active-tab" id="tab-1">
                                        <div class="content">
                                            <div class="text">
                                                {!! $agency->sub_summary() !!}
                                            </div>
                                        </div>
                                    </div>

                                    <!--Tab-->
                                    <div class="tab" id="tab-2">
                                        <div class="content">
                                            <div class="text">
                                                {!! $agency->summary1() !!}
                                            </div>
                                        </div>
                                    </div>

                                    <!--Tab-->
                                    <div class="tab" id="tab-3">
                                        <div class="content">
                                            <div class="text">
                                                {!! $agency->sub_summary2() !!}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Right Column-->
                    <div class="right-col col-xl-6 col-lg-12 col-md-12 col-sm-12">
                        <div class="inner">
                            <div class="text">
                                {!! $agency->summary() !!}
                            </div>
                            <div class="featured-block-two clearfix">
                                <div class="image"><img src="{{$agency->img1()}}" alt=""></div>
                                <div class="text">
                                    {!! $agency->summary3() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- News Section -->
    <section class="news-section">
        <div class="auto-container">
            <div class="sec-title centered">
                <h2>{{lang_name('LATEST_BLOGS')}}<span class="dot">.</span></h2>
            </div>

            <div class="row clearfix">

                @if($blog->count() != 0)
                    @foreach($blog as $r)
                        <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="0ms"
                             data-wow-duration="1500ms">
                            <div class="inner-box">
                                <div class="image-box">
                                    <a href="{{$r->route()}}"><img src="{{$r->img()}}" alt="{{$r->name()}}"></a>
                                </div>
                                <div class="lower-box">
                                    <h5><a href="{{$r->route()}}">{{$r->name()}}</a></h5>
                                    <div class="text">{{$r->tags()}}
                                    </div>
                                    <div class="link-box"><a class="theme-btn" href="{{$r->route()}}"><span
                                                class="flaticon-next-1"></span></a></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>

    <!-- Call To Section -->
    <section class="call-to-section">
        <div class="auto-container">
            <div class="inner clearfix">
                <div class="shape-1 wow slideInRight" data-wow-delay="0ms" data-wow-duration="1500ms"></div>
                <div class="shape-2 wow fadeInDown" data-wow-delay="0ms" data-wow-duration="1500ms"></div>
                <h2>{{lang_name('LETS_GET_YOUR_PROJECT')}} <br>{{lang_name('Started')}}</h2>
                <div class="link-box">
                    <a class="theme-btn btn-style-two" href="{{route('contact')}}">
                        <i class="btn-curve"></i>
                        <span class="btn-title">{{lang_name('Contact')}}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
