<div class="row clearfix">
    @if($items->count() != 0)
        @foreach($items as $item)
            <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="0ms"
                 data-wow-duration="1500ms">
                <div class="inner-box">
                    <div class="image-box">
                        <a href="{{$item->route()}}"><img src="{{$item->img()}}" alt="{{$item->name()}}"></a>
                    </div>
                    <div class="lower-box">
                        <h5><a href="{{$item->route()}}">{{$item->name()}}</a></h5>
                        <div class="text">{{$item->tags()}}</div>
                        <div class="link-box"><a class="theme-btn" href="{{$item->route()}}"><span
                                    class="flaticon-next-1"></span></a></div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-md-12 col-xs-12 col-sm-12 text-center alert alert-warning">
            {{$lang->Empty}}
        </div>
    @endif
</div>
<div class="more-box">
    <a data-current-page="{{$items->currentPage()}}" class="theme-btn btn_Load_more btn-style-one" href="javascript:void(0);">
        <i class="btn-curve"></i>
        <span class="btn-title">{{lang_name('Load_more')}}</span>
    </a>
</div>
