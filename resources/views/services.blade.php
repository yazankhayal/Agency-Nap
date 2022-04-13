@extends('layouts.app')

@section('title')
    {{lang_name('Services')}}
@endsection

@section('content')

    @includeIf("layouts.breadcrumb")

    <!-- advance search -->
    <div class="advance-search">
        <div class="container">
            <div class="default-form comment-form">
                <form method="get" action="{{route('services')}}">
                    <div class="row clearfix">
                        <div class="col-md-3 col-6 form-group">
                            <input type="text" placeholder="{{lang_name('type')}}" name="type">
                        </div>
                        <div class="col-md-3 col-6 form-group">
                            <input type="text" placeholder="{{lang_name('bed_rooms')}}" name="bed_rooms">
                        </div>
                        <div class="col-md-3 col-6 form-group">
                            <input type="text" placeholder="{{lang_name('bath_rooms')}}" name="bath_rooms">
                        </div>
                        <div class="col-md-3 col-6 form-group">
                            <input type="text" placeholder="{{lang_name('car')}}" name="car">
                        </div>
                        <div class="col-md-3 col-6 form-group">
                            <input type="text" placeholder="{{lang_name('sq')}}" name="sq">
                        </div>
                        <div class="col-md-3 col-6 form-group">
                            <input type="text" placeholder="{{lang_name('address')}}" name="address">
                        </div>
                        <div class="col-md-3 col-6 form-group">
                            <input type="text" placeholder="{{lang_name('country')}}" name="country">
                        </div>
                        <div class="col-md-3 col-6 form-group">
                            <input type="text" placeholder="{{lang_name('city')}}" name="city">
                        </div>
                        <div class="col-md-12 col-sm-12 form-group">
                            <input type="hidden" name="price_min" id="price_min">
                            <div class="range-slider" data-range_min="0" data-range_max="999999"
                                 data-cur_min="300" data-cur_max="999999">
                                <div class="bar"></div>
                                <span class="range-slider-leftgrip"></span>
                                <span class="range-slider-rightgrip"></span>
                            </div>
                            <div class="single-range-price">
                                <b>{{lang_name('Price')}}: </b> {{$curenc_cooki->code}}<span
                                    class="range-slider-leftlabel"></span> - {{$curenc_cooki->code}}<span
                                    class="range-slider-rightlabel"></span>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12">
                            <div class="accordion-box">
                                <div class="accordion">
                                    <div class="acc-btn"><i
                                            class="far fa-plus-square"></i>{{lang_name('Other_Advantages')}}</div>
                                    <div class="acc-content" style="display: none;">
                                        <div class="row">
                                            @if(count($tags) != 0)
                                                @foreach(array_unique($tags) as $key => $value)
                                                    <div class="col-md-3 col-4">
                                                        <label>
                                                            <input type="checkbox" name="features[]" value="{{$value}}">
                                                            &nbsp; {{$value}}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 form-group">
                            <button type="submit" class="theme-btn btn-style-one">
                                <i class="btn-curve"></i>
                                <span class="btn-title">{{lang_name('Search_now')}}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- News Section -->
    <section class="news-section estate-section">
        <div class="auto-container">
            @include("data.products")
        </div>
    </section>

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="auto-container">
            <!--Widgets Section-->
            <div class="widgets-section">
                <div class="row clearfix">

                    <!--Column-->
                    <div class="column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                        <div class="footer-widget logo-widget">
                            <div class="widget-content">
                                <div class="logo">
                                    <a href="index-2.html"><img id="fLogo" src="images/footer-logo.png" alt=""/></a>
                                </div>
                                <div class="text">Welcome to our web design agency. Lorem ipsum simply free text
                                    dolor sited amet cons cing elit.
                                </div>
                                <ul class="social-links clearfix">
                                    <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                    <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!--Column-->
                    <div class="column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                        <div class="footer-widget links-widget">
                            <div class="widget-content">
                                <h6>Explore</h6>
                                <div class="row clearfix">
                                    <div class="col-md-6 col-sm-12">
                                        <ul>
                                            <li><a href="about.html">About</a></li>
                                            <li><a href="portfolio.html">Our Portfolio</a></li>
                                            <li><a href="blog-grid.html">Latest News</a></li>
                                            <li><a href="contact.html">Contact</a></li>
                                            <li><a href="testimonials.html">Testimonials</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <ul>
                                            <li><a href="faqs.html">Faq</a></li>
                                            <li><a href="#">Privacy Policy</a></li>
                                            <li><a href="#">Terms of Use</a></li>
                                            <li><a href="#">Help</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Column-->
                    <div class="column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                        <div class="footer-widget info-widget">
                            <div class="widget-content">
                                <h6>Contact</h6>
                                <ul class="contact-info">
                                    <li class="address"><span class="icon flaticon-pin-1"></span> 66 Broklyn Street,
                                        New York <br>United States of America
                                    </li>
                                    <li><span class="icon flaticon-call"></span><a href="tel:666888000">666 888
                                            000</a></li>
                                    <li><span class="icon flaticon-email-2"></span><a
                                            href="mailto:info@Khalid.com">info@Khalid.com</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!--Column-->
                    <div class="column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                        <div class="footer-widget newsletter-widget">
                            <div class="widget-content">
                                <h6>Newsletter</h6>
                                <div class="newsletter-form">
                                    <form method="post" action="">
                                        <div class="form-group clearfix">
                                            <input type="email" name="email" value="" placeholder="Email Address"
                                                   required="">
                                            <button type="submit" class="theme-btn"><span
                                                    class="fa fa-envelope"></span></button>
                                        </div>
                                    </form>
                                </div>
                                <div class="text">Sign up for our latest news & articles. We won’t give you spam
                                    mails.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="auto-container">
                <div class="inner clearfix">
                    <div class="copyright">&copy; copyright 2020 by Test</div>
                </div>
            </div>
        </div>

    </footer>

@endsection

@section('js')
    <script type="text/javascript">
        var page = 1;
        $(document).ready(function () {

            //type=&bed_rooms=&bath_rooms=&car=&sq=&address=&country=&city=&price_min=300-999999
            var type = getUrlParameter('type');
            var bed_rooms = getUrlParameter('bed_rooms');
            var bath_rooms = getUrlParameter('bath_rooms');
            var car = getUrlParameter('car');
            var sq = getUrlParameter('sq');
            var address = getUrlParameter('address');
            var country = getUrlParameter('country');
            var city = getUrlParameter('city');
            var price_min = getUrlParameter('price_min');
            var category_id = getUrlParameter('category_id');
            if(type == undefined){
                type = "";
            }
            if(bed_rooms == undefined){
                bed_rooms = "";
            }
            if(bath_rooms == undefined){
                bath_rooms = "";
            }
            if(car == undefined){
                car = "";
            }
            if(sq == undefined){
                sq = "";
            }
            if(address == undefined){
                address = "";
            }
            if(country == undefined){
                country = "";
            }
            if(city == undefined){
                city = "";
            }
            if(price_min == undefined){
                price_min = "";
            }
            if(category_id == undefined){
                category_id = "";
            }


            $(document).on('click', '.btn_Load_more', function (event) {
                event.preventDefault();
                page++;
                window.location.href = "services?page=" + page + "&type="+type
                    + "&bed_rooms="+bed_rooms+ "&bath_rooms="+bath_rooms
                    + "&car="+car+ "&sq="+sq+ "&address="+address
                    + "&country="+country+ "&country="+country
                    + "&city="+city+ "&price_min="+price_min
                    + "&category_id="+category_id;
            });

        });
    </script>
@endsection
