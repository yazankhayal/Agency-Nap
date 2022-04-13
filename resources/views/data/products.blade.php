<div class="row clearfix">

    @if($items->count() != 0)
        @foreach($items as $r)
            <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="0ms"
                 data-wow-duration="1500ms">
                <div class="inner-box">
                    <div class="image-box">
                        <a href="{{$r->route()}}"><img src="{{$r->img()}}" alt="{{$r->name()}}"></a>
                        <div class="labels">
                            <span class="label-yellow">{{$r->Category->name()}}</span>
                        </div>
                    </div>
                    <div class="lower-box">
                        <div class="post-meta">
                            <ul class="clearfix">
                                @if($r->sq)
                                    <li><span class="fas fa-ruler-combined"></span> {{$r->sq}}</li>
                                @endif
                                @if($r->car)
                                    <li><span class="fas fa-car"></span>{{$r->car}}</li>
                                @endif
                                @if($r->bath_rooms)
                                    <li><span class="fas fa-shower"></span>{{$r->bath_rooms}}</li>
                                @endif
                            </ul>
                        </div>
                        <h5><a href="{{$r->route()}}">{{$r->name()}}</a></h5>
                        <div class="text">{{$r->sub_name()}}</div>
                        <ul></ul>
                        <div>
                            <a class="theme-btn" href="{{$r->route()}}">{{lang_name('Read_More')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

</div>

<div class="more-box">
    <a data-current-page="{{$items->currentPage()}}" class="theme-btn btn_Load_more btn-style-one" href="javascript:void(0);">
        <i class="btn-curve"></i>
        <span class="btn-title">{{lang_name('Load_more')}}</span>
    </a>
</div>
