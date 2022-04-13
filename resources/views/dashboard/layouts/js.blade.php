<!-- BACK-TO-TOP -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

@php
$selctor = "ltr";
if(app()->getLocale() == "ar"){
$selctor = "rtl";
}
@endphp

<!-- JQUERY JS -->
<script src="{{$path}}files/dash_board/{{$selctor}}/js/jquery-3.4.1.min.js"></script>

<!-- BOOTSTRAP JS -->
<script src="{{$path}}files/dash_board/{{$selctor}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{$path}}files/dash_board/{{$selctor}}/plugins/bootstrap/js/popper.min.js"></script>

<!-- SPARKLINE JS-->
<script src="{{$path}}files/dash_board/{{$selctor}}/js/jquery.sparkline.min.js"></script>

<!-- CHART-CIRCLE JS-->
<script src="{{$path}}files/dash_board/{{$selctor}}/js/circle-progress.min.js"></script>

<!-- RATING STARJS -->
<script src="{{$path}}files/dash_board/{{$selctor}}/plugins/rating/jquery.rating-stars.js"></script>

<!-- sweet alert -->
<script src="{{$path}}files/dash_board/{{$selctor}}/plugins/sweet-alert/sweetalert.min.js"></script>

<!-- CHARTJS CHART JS-->
<script src="{{$path}}files/dash_board/{{$selctor}}/plugins/chart/Chart.bundle.js"></script>
<script src="{{$path}}files/dash_board/{{$selctor}}/plugins/chart/utils.js"></script>

<!-- PIETY CHART JS-->
<script src="{{$path}}files/dash_board/{{$selctor}}/plugins/peitychart/jquery.peity.min.js"></script>
<script src="{{$path}}files/dash_board/{{$selctor}}/plugins/peitychart/peitychart.init.js"></script>

<!-- ECHART JS-->
<script src="{{$path}}files/dash_board/{{$selctor}}/plugins/echarts/echarts.js"></script>

<!-- SIDE-MENU JS-->
<script src="{{$path}}files/dash_board/{{$selctor}}/plugins/sidemenu/sidemenu.js"></script>

<!-- CUSTOM SCROLLBAR JS-->
<script src="{{$path}}files/dash_board/{{$selctor}}/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- SIDEBAR JS -->
<script src="{{$path}}files/dash_board/{{$selctor}}/plugins/sidebar/sidebar.js"></script>

<!-- APEXCHART JS -->
<script src="{{$path}}files/dash_board/{{$selctor}}/js/apexcharts.js"></script>

<!-- INDEX JS -->
<script src="{{$path}}files/dash_board/{{$selctor}}/js/index1.js"></script>

<!-- CUSTOM JS -->
<script src="{{$path}}files/dash_board/{{$selctor}}/js/custom.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="{{$path.'js/toastr.min.js'}}"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote-lite.min.js"></script>
<script src="{{$path.'nprogress-master/nprogress.js'}}"></script>
<script src="{{$path.'js/jquery.form.min.js'}}"></script>
<script src="{{$path.'js/master.js'}}"></script>
