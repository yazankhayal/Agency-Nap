<section class="page-banner">
    <div class="image-layer" style="background-image:url('{{setting()->bunner()}}');"></div>
    <div class="shape-1"></div>
    <div class="shape-2"></div>
    <div class="banner-inner">
        <div class="auto-container">
            <div class="inner-container clearfix">
                <h1>@yield("title")</h1>
                <div class="page-nav">
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{route('index')}}">{{$lang->Home_Page}}</a></li>
                        <li class="active">@yield("title")</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
