<div class="filter-list row">
    @if($items->count() != 0)
        @foreach($items as $r)
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
<div class="more-box">
    <a data-current-page="{{$items->currentPage()}}" class="theme-btn btn_Load_more btn-style-one" href="javascript:void(0);">
        <i class="btn-curve"></i>
        <span class="btn-title">{{lang_name('Load_more')}}</span>
    </a>
</div>
