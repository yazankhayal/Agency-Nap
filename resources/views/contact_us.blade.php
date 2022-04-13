@extends('layouts.app')

@section('title')
    {{$lang->Contact}}
@endsection

@section('css')
    <style>
        iframe {
            width: 100%;
        }

        .contact-desc p {
            margin-top: 10px;
        }
    </style>
@endsection

@section('content')

    @includeIf("layouts.breadcrumb")

    <section class="contact-section">
        <div class="auto-container">
            <div class="sec-title centered">
                <h2>@yield("title")<span class="dot">.</span></h2>
            </div>

            <div class="upper-info">
                <div class="row clearfix">
                    <div class="info-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="0ms"
                         data-wow-duration="1500ms">
                        <div class="inner-box">
                            <h5>{{lang_name('Email')}}</h5>
                            <div class="text">
                                <ul class="info">
                                    <li><a href="mailto:{{hp_contact()->email}}"><i class="fa fa-envelope"></i> {{hp_contact()->email}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="info-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="300ms"
                         data-wow-duration="1500ms">
                        <div class="inner-box">
                            <h5>{{lang_name('Address')}}</h5>
                            <div class="text">
                                <ul class="info">
                                    <li><i class="fa fa-map"></i> {{hp_contact()->address}}</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="info-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="600ms"
                         data-wow-duration="1500ms">
                        <div class="inner-box">
                            <h5>{{lang_name('Phone')}}</h5>
                            <div class="text">
                                <ul class="info">
                                    <li><a href="tel:{{hp_contact()->phone}}"><i class="fa fa-phone"></i> {{hp_contact()->phone}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="info-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="900ms"
                         data-wow-duration="1500ms">
                        <div class="inner-box">
                            <h5>{{lang_name('WHATSAPP')}}</h5>
                            <div class="text">
                                <ul class="info">
                                    <li><a href="tel:{{hp_contact()->whatsapp}}"><i class="fab fa-whatsapp-square"></i> {{hp_contact()->whatsapp}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="map-box">
                {!! hp_contact()->iframe !!}
            </div>
            <div class="form-box">
                <div class="sec-title">
                    <h2>{{lang_name('Contact_Us')}}<span class="dot">.</span></h2>
                </div>
                <div class="default-form">
                    <form
                        class="b-form-contacts ui-form contact_post ps-form--contact ajaxForm ho-form contact-form"
                        method="post"
                        action="{{route('contact_post')}}"
                        data-name="contact_post">
                        {{csrf_field()}}

                        <div class="row clearfix">
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <div class="field-inner">
                                    <input class="cls" type="text" id="f_name" name="f_name"
                                           placeholder="{{$lang->f_Name}}">
                                </div>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <div class="field-inner">
                                    <input class="cls" type="text" id="l_name" name="l_name"
                                           placeholder="{{$lang->l_Name}}">
                                </div>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <div class="field-inner">
                                    <input class="cls" type="text" id="phone" name="phone" placeholder="{{$lang->Phone}}">
                                </div>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                <div class="field-inner">
                                    <input class=" cls" type="email" id="email" name="email" placeholder="{{$lang->Email}}">
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="field-inner">
                                    <textarea class=" cls" id="summary" name="summary" rows="6"
                                              placeholder="{{$lang->Comments}}"></textarea>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <button type="submit" class="theme-btn btn-style-one">
                                    <i class="btn-curve"></i>
                                    <span class="btn-title">{{lang_name('Send_Message')}}</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
