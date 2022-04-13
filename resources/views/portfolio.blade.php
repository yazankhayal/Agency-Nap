@extends('layouts.app')

@section('title')
    {{$lang->Portfolio}}
@endsection

@section('content')

    @includeIf("layouts.breadcrumb")

    <section class="gallery-section">
        <div class="auto-container">
            <!--MixitUp Galery-->
            <div class="mixitup-gallery">
                <!--Filter-->
                <div class="filters centered clearfix" id="tag_container">
                    <ul class="filter-tabs filter-btns clearfix">
                        <li class="active filter" data-role="button" data-filter="all">
                            All<sup>[{{$items->count()}}]</sup></li>
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
                @include("data.portfolio")
            </div>

        </div>
    </section>

@endsection

@section("js")
    <script type="text/javascript">
        var page = 1;
        $(document).ready(function () {
            $(document).on('click', '.btn_Load_more', function (event) {
                event.preventDefault();
                page++;
                window.location.href = "portfolio?page="+page;
            });

        });
    </script>
@endsection
