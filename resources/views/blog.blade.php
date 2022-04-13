@extends('layouts.app')

@section('title')
    {{$lang->Blog}}
@endsection

@section('content')

    @includeIf("layouts.breadcrumb")

    <section class="news-section">
        <div class="auto-container">
            @includeIf("data.blog")
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
                window.location.href = "blog?page="+page;
            });

        });
    </script>
@endsection
