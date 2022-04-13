<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title>{{setting()->name()}}-@yield('title')</title>

@yield("seo")

<meta charset="utf-8">
<link rel="shortcut icon" href="{{path().setting()->fav}}" type="image/x-icon">
<link rel="apple-touch-icon" href="{{path().setting()->fav}}">

<!-- Stylesheets -->
<link href="https://fonts.googleapis.com/css2?family=Teko:wght@300;400;500;600;700&amp;display=swap"
      rel="stylesheet">
<link href="{{path()}}files/home/css/bootstrap.css" rel="stylesheet">
<link href="{{path()}}files/home/css/fontawesome-all.css" rel="stylesheet">
<link href="{{path()}}files/home/css/owl.css" rel="stylesheet">
<link href="{{path()}}files/home/css/flaticon.css" rel="stylesheet">
<link href="{{path()}}files/home/css/animate.css" rel="stylesheet">
<link href="{{path()}}files/home/css/jquery-ui.css" rel="stylesheet">
<link href="{{path()}}files/home/css/jquery.fancybox.min.css" rel="stylesheet">
<link href="{{path()}}files/home/css/range-slider.css" rel="stylesheet">
<link href="{{path()}}files/home/css/hover.css" rel="stylesheet">
<link href="{{path()}}files/home/css/custom-animate.css" rel="stylesheet">
<link href="{{path()}}files/home/css/style.css" rel="stylesheet">
<!-- rtl css -->
<!-- Responsive File -->
<link href="{{path()}}files/home/css/responsive.css" rel="stylesheet">
<!-- Color css -->
<link rel="stylesheet" id="jssDefault" href="{{path()}}files/home/css/colors/color-default.css">

@if(app()->getLocale() == "ar")
    <link rel="stylesheet" href="{{path()}}files/home/css/rtl.css">
@endif

<link rel="stylesheet" href="{{path()}}css/toastr.min.css">
<link rel="stylesheet" href="{{path()}}nprogress-master/nprogress.css"/>
<style>
    .toast, #toast-container {
        z-index: 9999999999999999;
    }

    .menu_cat_ico {
        width: 22px;
        height: 14px;
    }

    .ho-form2 {
        padding: 30px;
        border-radius: 0;
        border: 1px solid #d5d5d5;
    }

    .flag_c {
        width: 25px;
        height: 18px;
    }

    /***** whatsapp ********/
    #whatsapp {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 99;
    }
</style>
@if(scripts())
    @if(scripts()->css)
        {!! scripts()->css !!}
    @endif
@endif
