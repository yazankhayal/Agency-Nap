<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" dir="{{app()->getLocale() == "ar" ? "rtl" : "ltr"}}">
<head>
    @includeIf('dashboard.layouts.css')
    @yield('css')
</head>

<body class="app sidebar-mini">

<!-- GLOBAL-LOADER
<div id="global-loader">
    <img src="{{$path}}files/dash_board/images/loader.svg" class="loader-img" alt="Loader">
</div>
 /GLOBAL-LOADER -->

<!-- PAGE -->
<div class="page">

    <div class="page-main">


        <!--APP-SIDEBAR-->
        @if($user->role == 1)
        @includeIf('dashboard.layouts.sidebar')
        @else
        @includeIf('dashboard.layouts.sidebar_store')
        @endif
                <!--/APP-SIDEBAR-->


        <!-- Mobile Header -->
        @includeIf('dashboard.layouts.mobile')
                <!-- /Mobile Header -->

        <!--app-content open-->
        <div class="app-content">
            <div class="side-app">

                @includeIf('dashboard.layouts.breadcrumb')
                @includeIf('layouts.msg')
                @if (trim($__env->yieldContent('create_btn')))
                    <div class="card">
                        <div class="card-header border-bottom-0 p-4">
                            <h2 class="card-title">@yield("title")</h2>
                        </div>
                        <div class="e-table px-5 pb-5">
                            <div class="table-responsive table-lg">
                                <a href="@yield('create_btn')" class="btn btn-primary">
                                    @yield('create_btn_btn')
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                @if(!current_route('dashboard_admin.index'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    @yield("content")
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @yield("content")
                @endif

            </div>
        </div>

    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-md-12 col-sm-12 text-center">
                    Copyright © 2020 <a href="#">Foxytech</a> All rights reserved.
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER END -->
</div>


<div class="modal" id="ModDelete" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('delete.title')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{csrf_field()}}
                <input id="iddel" name="id" type="hidden">
                <p class="text-danger">
                    @lang('delete.desc')
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn_deleted btn btn-primary">Yes</button>
            </div>
        </div>
    </div>
</div>
@includeIf('dashboard.layouts.js')
@yield('js')
<script>
    var step_wizard = 1;
    var geturlphoto = function () {
        return "{{$setting->public}}";
    };
    var date_Ret = function (x) {
        var now = new Date(x);
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear()+"-"+(month)+"-"+(day);
        return today;
    };
    var sweet_alert = function (title, text, icon, button) {
        swal({
            title: title,
            text: text,
            icon: icon,
            button: button,
        });
    }
    $(document).ready(function () {
        "use strict";
        //Code here.
        $('.sumernote').summernote();

        // $( ".date" ).datepicker();

        $(document).on('click', '.btn_current_lan', function () {
            $('.trans').val('');
            $('.trans2').summernote('code', '');
        });

        $('.PopUp').on("click", function () {
            $('#button_action').val('insert');
            $('.form-control').val('');
            $('#id').val('');
            $('.sumernote').summernote('code', '');
            $('.avatar_view').addClass('d-none');
            $('.error').remove();
            $('.form-control').removeClass('border-danger');
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

        $('.modal .close').on("click", function () {
            $('#data_Table tbody tr').css('background', 'transparent');
        });

        $('.modal .btn-secondary').on("click", function () {
            $('#data_Table tbody tr').css('background', 'transparent');
        });

        $('.modal .btn-default').on("click", function () {
            $('#data_Table tbody tr').css('background', 'transparent');
        });

        $(document).on('keyup', function (evt) {
            if (evt.keyCode == 27) {
                $('#data_Table tbody tr').css('background', 'transparent');
            }
        });

    });
</script>

</body>

</html>
