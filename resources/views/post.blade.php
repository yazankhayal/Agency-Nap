@extends('layouts.app')

@section('title')
    {{$item->name()}}
@endsection


@section('content')

    @includeIf("layouts.breadcrumb")

    <div class="sidebar-page-container">
        <div class="auto-container">
            <div class="row clearfix">

                <!--Content Side-->
                <div class="content-side col-sm-12">
                    <div class="blog-details">
                        <!--News Block-->
                        <div class="post-details">
                            <div class="inner-box">
                                <a class="image-box" href="{{$item->img()}}">
                                    <img class="img-fluid" src="{{$item->img()}}" style="width: 100%;"
                                         alt="{{$item->name()}}"/>
                                </a>
                                <div class="lower-box">
                                    <h4>@yield("title")</h4>
                                    <div class="entry-content">
                                        {!! $item->summary() !!}
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


@endsection
