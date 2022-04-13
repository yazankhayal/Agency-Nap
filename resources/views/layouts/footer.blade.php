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
                                <a href="{{route('index')}}"><img id="fLogo" src="{{setting()->avatar1()}}"
                                                                  alt="{{setting()->name()}}"/></a>
                            </div>
                            <div class="text">
                                {{setting()->summary()}}
                            </div>
                            <ul class="social-links clearfix">
                                @if(hp_contact()->facebook != null)
                                    <li><a href="{{hp_contact()->facebook}}"><span
                                                class="fab fa-facebook-square"></span></a></li>
                                @endif
                                @if(hp_contact()->twitter != null)
                                    <li><a href="{{hp_contact()->twitter}}"><span class="fab fa-twitter"></span></a>
                                @endif
                                @if(hp_contact()->instagram != null)
                                    <li><a href="{{hp_contact()->instagram}}"><span class="fab fa-instagram"></span></a>
                                    </li>
                                @endif
                                @if(hp_contact()->pinterest != null)
                                    <li><a href="{{hp_contact()->pinterest}}"><span
                                                class="fab fa-youtube"></span></a></li>
                                @endif
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
                                        <li><a href="{{route('index')}}">{{lang_name('Home_Page')}}</a></li>
                                        <li><a href="{{route('about')}}">{{lang_name('About')}}</a></li>
                                        <li><a href="{{route('portfolio')}}">{{lang_name('Portfolio')}}</a></li>
                                        <li><a href="{{route('blog')}}">{{lang_name('Blog')}}</a></li>
                                        <li><a href="{{route('contact')}}">{{lang_name('Contact')}}</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <ul>
                                        @if(pages_footer()->count() != 0)
                                            @foreach(pages_footer() as $r)
                                                <li><a href="{{$r->route()}}">{{$r->name()}}</a>
                                                </li>
                                            @endforeach
                                        @endif
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
                                <li class="address"><span class="icon flaticon-pin-1"></span>
                                    {{hp_contact()->address}}
                                </li>
                                <li><span class="icon flaticon-call"></span><a href="tel:{{hp_contact()->phone}}">{{hp_contact()->phone}}</a></li>
                                <li><span class="icon flaticon-email-2"></span><a
                                        href="mailto:{{hp_contact()->email}}">{{hp_contact()->email}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!--Column-->
                <div class="column col-xl-3 col-lg-6 col-md-6 col-sm-12">
                    <div class="footer-widget newsletter-widget">
                        <div class="widget-content">
                            <h6>{{lang_name('Our_Newsletter')}}</h6>
                            <div class="newsletter-form">
                                <form method="post" action="{{route('newsletter')}}" class="ajaxForm newsletter" data-name="newsletter">
                                    {{csrf_field()}}
                                    <div class="form-group clearfix">
                                        <input type="email" name="email" value="" class="cls" placeholder="{{lang_name('Email')}}"
                                               required="">
                                        <button type="submit" class="theme-btn"><span
                                                class="fa fa-envelope"></span></button>
                                    </div>
                                </form>
                            </div>
                            <div class="text">{{lang_name('Subscribe_desc')}}
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
                <div class="copyright">&copy; {{lang_name('Copy_Right')}} {{date('Y')}} - <a href="{{route('index')}}">{{setting()->name()}}</a></div>
            </div>
        </div>
    </div>

</footer>
