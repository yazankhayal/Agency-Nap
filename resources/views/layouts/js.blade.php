<script src="{{path()}}files/home/js/jquery.js"></script>
<script src="{{path()}}files/home/js/popper.min.js"></script>
<script src="{{path()}}files/home/js/bootstrap.min.js"></script>
<script src="{{path()}}files/home/js/TweenMax.js"></script>
<script src="{{path()}}files/home/js/jquery-ui.js"></script>
<script src="{{path()}}files/home/js/jquery.fancybox.js"></script>
<script src="{{path()}}files/home/js/owl.js"></script>
<script src="{{path()}}files/home/js/mixitup.js"></script>
<script src="{{path()}}files/home/js/knob.js"></script>
<script src="{{path()}}files/home/js/appear.js"></script>
<script src="{{path()}}files/home/js/wow.js"></script>
<script src="{{path()}}files/home/js/jquery.easing.min.js"></script>
<script src="{{path()}}files/home/js/range-slider.js"></script>
<script src="{{path()}}files/home/js/custom-script.js"></script>

<script src="{{path()}}js/toastr.min.js"></script>
<script src="{{path()}}js/jquery.form.min.js"></script>
<script src="{{path()}}nprogress-master/nprogress.js"></script>
<script src="{{path()}}js/master.js"></script>
@if(scripts())
    @if(scripts()->js)
        {!! scripts()->js !!}
    @endif
    @if(scripts()->custom)
        {!! scripts()->custom !!}
    @endif
@endif
