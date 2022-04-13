<!DOCTYPE html>
<html lang="">
<head>
    @includeIf('layouts.css')
    @yield('css')
</head>
<body>

<div class="page-wrapper">

    <!-- Preloader -->
    <div class="preloader">
        <div class="icon" style=" background-image: url('{{path().setting()->fav}}');"></div>
    </div>

    @include("layouts.header")

    <!--Search Popup-->
    <div class="search-popup">
        <div class="search-popup__overlay custom-cursor__overlay">
            <div class="cursor"></div>
            <div class="cursor-follower"></div>
        </div><!-- /.search-popup__overlay -->
        <div class="search-popup__inner">
            <form action="#" class="search-popup__form">
                <input type="text" name="search" placeholder="Type here to Search....">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div><!-- /.search-popup__inner -->
    </div><!-- /.search-popup -->

    @yield("content")

    @include("layouts.footer")

</div>

<a href="#" data-target="html" class="scroll-to-target scroll-to-top"><i class="fa fa-angle-up"></i></a>

<!-- SCRIPTS -->
@includeIf('layouts.js')
<script>
    var geturlphoto = function () {
        return "{{$setting->public}}";
    };
    var curracn_code = "{{$curenc_cooki->code}}";
    var select_lan = "{{$select_lan->id}}";
    $(document).ready(function () {

        $(document).on('keypress', '#serarch', function (e) {
            if (e.which == 13) {
                var val = $(this).val();
                window.location.href = geturlphoto() + "products?q=" + val;
            }
        });

        $(document).ajaxStart(function () {
            NProgress.start();
        });
        $(document).ajaxStop(function () {
            NProgress.done();
        });
        $(document).ajaxError(function () {
            NProgress.done();
        });

    });
</script>
@yield('js')

</body>

</html>
