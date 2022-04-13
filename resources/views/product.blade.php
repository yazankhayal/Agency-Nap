@extends('layouts.app')

@section('title')
    {{$item->name()}}
@endsection

@section('css')

@endsection

@section('content')

    @includeIf("layouts.breadcrumb")

    <div class="estate-details-section">
        <div class="auto-container">
            <div class="row clearfix">

                <div class="col-12">
                    <div class="estate-top-details">
                        <div class="left">
                            <h5>{{$item->Category->name()}}</h5>
                            <p><i class="fas fa-map-marker-alt"></i> {{$item->address}}</p>
                        </div>
                        <div class="right">
                            <p>{{lang_name('Price')}} <strong>{!! $item->price() !!}</strong></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12">
                    <div class="estate-sync-slider-wraper">
                        <!-- .estate-sync-slider-preview -->
                        <div id="sync1" class="estate-sync-slider-preview owl-carousel">
                            <div class="estate-sync-preview">
                                <img src="{{$item->img()}}" alt="{{$item->name()}}">
                            </div>
                            @if(count(explode(",",$item->files)) != 0)
                                @foreach(explode(",",$item->files) as $key => $value)
                                    @if($value)
                                        <div class="estate-sync-preview">
                                            <img src="{{$path.'upload/gallery_products/'.$value}}"
                                                 alt="{{$item->name()}}">
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        <!-- .estate-sync-slider-thumb -->
                        <div id="sync2" class="estate-sync-slider-thumb owl-carousel">
                            <div class="estate-sync-thumb">
                                <img src="{{$item->img()}}" alt="{{$item->name()}}">
                            </div>
                            @if(count(explode(",",$item->files)) != 0)
                                @foreach(explode(",",$item->files) as $key => $value)
                                    @if($value)
                                        <div class="estate-sync-thumb">
                                            <img src="{{$path.'upload/gallery_products/'.$value}}"
                                                 alt="{{$item->name()}}">
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="details-wrapper">
                        <div class="top-title">
                            <h6>{{lang_name('Description')}}</h6>
                            <p>{{$item->sub_name()}}</p>
                        </div>
                        <ul class="details-list">
                            <li>
                                <strong>{{lang_name('type')}}</strong>
                                <span>{{$item->type}}</span>
                            </li>
                            <li>
                                <strong><i class="fas fa-bed"></i></strong>
                                <span>{{$item->bed_rooms}}</span>
                            </li>
                            <li>
                                <strong><i class="fas fa-shower"></i></strong>
                                <span>{{$item->bath_rooms}}</span>
                            </li>
                            <li>
                                <strong><i class="fas fa-car"></i></strong>
                                <span>{{$item->car}}</span>
                            </li>
                            <li>
                                <strong><i class="fas fa-ruler-combined"></i></strong>
                                <span>{{$item->sq}}</span>
                            </li>
                            <li>
                                <strong><i class="far fa-calendar-alt"></i></strong>
                                <span>{{$item->date()}}</span>
                            </li>
                        </ul>
                        <hr>
                        {!! $item->summary() !!}
                    </div>

                    <div class="details-wrapper">
                        <div class="top-title">
                            <h6>{{lang_name('Files')}}</h6>
                        </div>
                        <ul class="details-list">
                            @if($item->avatar1 != null)
                                <li>
                                    <span><i class="far fa-sticky-note"></i>{{lang_name('Files')}}</span>
                                </li>
                                <li>
                                    <a href="{{path().$item->avatar1}}">{{lang_name('Download')}}</a>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="details-wrapper address">
                        <div class="top-title">
                            <h6>{{lang_name('Address')}}</h6>
                            <a href="#"><i class="far fa-map"></i> Open in google map</a>
                        </div>
                        <ul class="details-list">
                            <li>
                                <strong>{{lang_name('address')}}</strong>
                                <span>{{$item->address}}</span>
                            </li>
                            <li>
                                <strong>{{lang_name('area')}}</strong>
                                <span>{{$item->area}}</span>
                            </li>
                            <li>
                                <strong>{{lang_name('provide')}}</strong>
                                <span>{{$item->provide}}</span>
                            </li>
                            <li>
                                <strong>{{lang_name('post_code')}}</strong>
                                <span>{{$item->post_code}}</span>
                            </li>
                            <li>
                                <strong>{{lang_name('city')}}</strong>
                                <span>{{$item->city}}</span>
                            </li>
                            <li>
                                <strong>{{lang_name('country')}}</strong>
                                <span>{{$item->country}}</span>
                            </li>
                        </ul>
                    </div>

                    <div class="details-wrapper props">
                        <div class="top-title">
                            <h6>Properties</h6>
                        </div>
                        <ul class="details-list">
                            @if(app()->getLocale() == select_lang()->dir)
                                @if($item->features != null)
                                    @if(count(explode(",",$item->features)) != 0)
                                        @foreach(explode(",",$item->features) as $r)
                                            @if($r)
                                                <li><span>{{$r}}</span></li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endif
                            @else
                                @if($item->Translatex->count() != 0)
                                    @foreach($item->Translatex as $r)
                                        @if(count(explode(",",$r->features)) != 0)
                                            @foreach(explode(",",$r->features) as $r)
                                                @if($r)
                                                    <li><span>{{$r}}</span></li>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endif
                        </ul>
                    </div>

                    <div class="details-wrapper video">
                        <div class="top-title">
                            <h6>{{lang_name('Video')}}</h6>
                        </div>
                        <div class="video-content">
                            {!! $item->video !!}
                        </div>
                    </div>

                    <!-- News Section -->
                    <section class="news-section estate-section">
                        <div class="auto-container">
                            <h6>{{lang_name('Related_Products')}}</h6>
                            <div class="row clearfix">
                                {!! $item->Related() !!}
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12">
                    <div class="default-form">

                        <form class="mt-4 ajaxForm request_product"
                              method="post"
                              action="{{route('request_product')}}"
                              data-name="request_product">
                            {{csrf_field()}}
                            <input id="products_id" name="products_id" value="{{$item->id}}"
                                   type="hidden">

                            <div class="form-group">
                                <div class="field-inner">
                                    <input class="cls cls_a" type="text" id="f_name"
                                           name="f_name"
                                           placeholder="{{$lang->f_Name}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="field-inner">
                                    <input class=" cls cls_a" type="text" id="l_name"
                                           name="l_name"
                                           placeholder="{{$lang->l_Name}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="field-inner">
                                    <input class="cls cls_a" type="email" id="email"
                                           name="email"
                                           placeholder="{{$lang->Email}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="field-inner">
                                    <input class=" cls cls_a" type="text" id="phone"
                                           name="phone"
                                           placeholder="{{$lang->Phone}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="field-inner">
                                        <textarea class=" cls cls_a" id="summary" name="summary"
                                                  placeholder="{{$lang->Comments}}"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="theme-btn btn-style-one">
                                    <i class="btn-curve"></i>
                                    <span class="btn-title">{{'Order_Now'}}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Call To Section -->
    <section class="call-to-section-two alternate">
        <div class="auto-container">
            <div class="inner clearfix">
                <h2>We’re Ready to Bring Bigger <br>& Stronger Projects</h2>
                <div class="link-box">
                    <a class="theme-btn btn-style-two" href="about.html">
                        <i class="btn-curve"></i>
                        <span class="btn-title">Contact with us</span>
                    </a>
                </div>
            </div>
        </div>
    </section>


@endsection

