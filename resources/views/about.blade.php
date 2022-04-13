@extends('layouts.app')

@section('title')
    {{$lang->About}}
@endsection

@section('content')

    @includeIf("layouts.breadcrumb")


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

    <section class="testimonials-section">
        <div class="auto-container">
            <div class="sec-title">
                <h2>Customer feedbacks <span class="dot">.</span></h2>
            </div>
            <div class="carousel-box">
                <div class="testimonials-carousel owl-theme owl-carousel">

                    @if($Testimonials->count() != 0)
                        @foreach($Testimonials as $r)
                            <div class="testi-block">
                                <div class="inner">
                                    <div class="icon"><span>“</span></div>
                                    <div class="info">
                                        <div class="image">
                                            <img src="{{$r->img()}}"
                                                 alt="{{$r->name()}}">
                                        </div>
                                        <div class="name">{{$r->name()}}</div>
                                        <div class="designation">{{$r->bio()}}</div>
                                    </div>
                                    <div class="text">{{$r->summary()}}
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

@endsection
