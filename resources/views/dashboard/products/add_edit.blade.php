@extends('dashboard.layouts.app')

@section('title')
    {{$lang->Products}}
@endsection

@php
$selctor = "ltr";
if($select_lan_choice->dir == "ar"){
$selctor = "rtl";
}
@endphp

@section('css')
    <link rel="stylesheet" href="{{$path}}files/dash_board/{{$selctor}}/plugins/multipleselect/multiple-select.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <link type="text/css" rel="stylesheet" href="https://api.mqcdn.com/sdk/mapquest-js/v1.3.2/mapquest.css"/>
    <link type="text/css" rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css"/>
    <style>
        .dz-remove {
            display: inline-block !important;
            width: 1.2em;
            height: 1.2em;

            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 1000;

            font-size: 1.5em !important;
            line-height: 1em;

            text-align: center;
            font-weight: bold;
            border: 1px solid gray !important;
            border-radius: 1.2em;
            bath_rooms: #fff;
            background-bath_rooms: red;
            opacity: .7;

        }

        .dz-remove:hover {
            text-decoration: none !important;
            opacity: 1;
        }
    </style>
@endsection

@section('create_btn'){{route('dashboard_products.index')}}@endsection
@section('create_btn_btn'){{$lang->Close}}@endsection

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
							<span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
							</span>
                            <h3 class="m-portlet__head-text">
                                @yield('title')
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="form-group m-form__group">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active"
                                   id="home-tab" data-toggle="tab" href="#home"
                                   role="tab" aria-controls="home"
                                   aria-selected="true">
                                    <img class="img_flag" src="{{path().$select_lan_choice->avatar}}"
                                         alt="{{$select_lan_choice->name}}">
                                    {{$select_lan_choice->name}}
                                </a>
                            </li>
                            <li class="nav-item get_related_products {{dis()}}" data-id="related_products">
                                <a class="nav-link" id="related_products-tab"
                                   data-toggle="tab" href="#related_products" role="tab"
                                   aria-controls="related_products" aria-selected="false">
                                    Related Products
                                </a>
                            </li>
                            @if($langauges->where('dir','!=',$select_lan_choice->dir)->count() > 0)
                                @foreach($langauges->where('dir','!=',$select_lan_choice->dir) as $lang222)
                                    <li class="nav-item get_content_language {{dis()}}" data-id="{{$lang222->id}}">
                                        <a class="nav-link" id="{{$lang222->name}}-tab"
                                           data-toggle="tab" href="#{{$lang222->name}}" role="tab"
                                           aria-controls="{{$lang222->name}}" aria-selected="false">
                                            <img class="img_flag" src="{{path().$lang222->avatar}}"
                                                 alt="{{$select_lan_choice->name}}">
                                            {{$lang222->name}}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                 aria-labelledby="home-tab">
                                <br>
                                <div class="alert alert-warning">{{$select_lan_choice->name}}</div>
                                <hr>
                                <form method="post" action="{{route('dashboard_products.uploadjquery')}}"
                                      enctype="multipart/form-data"
                                      class="dropzone" id="dropzone">
                                    {{csrf_field()}}
                                </form>
                                <div style="margin: 10px 0;">
                                    <div id="render_gallery" class="d-none row">
                
                                    </div>
                                </div>
                                <form class="ajaxForm post_data" enctype="multipart/form-data" data-name="post_data"
                                      action="{{route('dashboard_products.post_data')}}" method="post">
                                    {{csrf_field()}}
                                    <div class="modal-body row">
                                        <input id="id" name="id" class="cls" type="hidden">
                                        <input id="images" name="images" type="hidden">
                                        <input id="old_images" name="old_images" type="hidden">
                                        <div class="form-group col-12">
                                            <label for="name">{{$lang->Name}}</label>
                                            <input type="text" class="cls form-control" name="name" id="name"
                                                   placeholder="{{$lang->Name}}">
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="sub_name">{{$lang->Sub_Name}}</label>
                                            <input type="text" class="cls form-control" name="sub_name" id="sub_name"
                                                   placeholder="{{$lang->Sub_Name}}">
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="price">{{$lang->Price}}</label>
                                            <input type="text" class="cls form-control" name="price" id="price"
                                                   placeholder="{{$lang->Price}}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="from_date">{{$lang->from_date}}</label>
                                            <input type="date" class="cls date form-control" name="from_date" id="from_date"
                                                   placeholder="{{$lang->from_date}}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="to_date">{{$lang->to_date}}</label>
                                            <input type="date" class="cls date form-control" name="to_date" id="to_date"
                                                   placeholder="{{$lang->to_date}}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="category_1">{{$lang->Category_Services}}</label>
                                            <select name="category_id" id="category_id" class="form-control">
                                                @if($category_id1->count() != 0)
                                                    @foreach($category_id1 as $item)
                                                        <option value="{{$item->id}}"
                                                                id="{{$item->id}}"
                                                            >{{$item->name()}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="summary">{{$lang->Summary}}</label>
                                    <textarea rows="4" class="cls sumernote form-control" name="summary"
                                              id="summary" placeholder="{{$lang->Summary}}"></textarea>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="avatar">{{$lang->Avatar}}</label>
                                            <input type="file" class="cls form-control" name="avatar" id="avatar">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <img style="height: 100px;height: 100px;"
                                                 class="img_usres avatar_view d-none img-thumbnail">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="avatar1">{{$lang->File}}</label>
                                            <input type="file" class="cls form-control" name="avatar1" id="avatar1">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <img style="height: 100px;height: 100px;"
                                                 class="img_usres avatar1_view d-none img-thumbnail">
                                        </div>

                                        <div class="form-group col-4">
                                            <label for="type">{{$lang->type}}</label>
                                            <input type="text" class="cls form-control" name="type" id="type"
                                                   placeholder="{{$lang->type}}">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="bed_rooms">{{$lang->bed_rooms}}</label>
                                            <input type="text" class="cls form-control" name="bed_rooms" id="bed_rooms"
                                                   placeholder="{{$lang->bed_rooms}}">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="bath_rooms">{{$lang->bath_rooms}}</label>
                                            <input type="text" class="cls form-control" name="bath_rooms" id="bath_rooms"
                                                   placeholder="{{$lang->bath_rooms}}">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="car">{{$lang->car}}</label>
                                            <input type="text" class="cls form-control" name="car" id="car"
                                                   placeholder="{{$lang->car}}">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="sq">{{$lang->sq}}</label>
                                            <input type="text" class="cls form-control" name="sq" id="sq"
                                                   placeholder="{{$lang->sq}}">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="address">{{$lang->address}}</label>
                                            <input type="text" class="cls form-control" name="address" id="address"
                                                   placeholder="{{$lang->address}}">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="provide">{{$lang->provide}}</label>
                                            <input type="text" class="cls form-control" name="provide" id="provide"
                                                   placeholder="{{$lang->provide}}">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="city">{{$lang->city}}</label>
                                            <input type="text" class="cls form-control" name="city" id="city"
                                                   placeholder="{{$lang->city}}">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="country">{{$lang->country}}</label>
                                            <input type="text" class="cls form-control" name="country" id="country"
                                                   placeholder="{{$lang->country}}">
                                        </div>
                                        <div class="form-group col-4">
                                            <label for="post_code">{{$lang->post_code}}</label>
                                            <input type="text" class="cls form-control" name="post_code" id="post_code"
                                                   placeholder="{{$lang->post_code}}">
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="area">{{$lang->area}}</label>
                                            <input type="text" class="cls form-control" name="area" id="area"
                                                   placeholder="{{$lang->area}}">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="video">{{$lang->Video}}</label>
                                            <input type="text" class="cls form-control" name="video" id="video"
                                                   placeholder="{{$lang->Video}}">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="btn_add1">
                                                {{$lang->features}}
                                                <button type="button" id="btn_add" class="btn btn-dark btn-sm">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </label>
                                            <div class="rows" id="d_features">
                                            </div>
                                        </div>

                                    </div>
                                    @includeIf("dashboard.layouts.seo")
                                    <div class="modal-footer">
                                        <input type="hidden" name="button_action" id="button_action" value="insert">
                                        <a href="{{route('dashboard_products.index')}}" class="btn btn-default">
                                            {{$lang->Close}}
                                        </a>
                                        <button type="submit" class="btn btn-primary btn-load">
                                            {{$lang->Submit}}
                                        </button>
                                    </div>
                                </form>
                            </div>
                            
                            <div class="tab-pane fade tab_related_products" id="related_products"
                                 role="tabpanel"
                                 aria-labelledby="related_products-tab">
                                <br>
                                <div class="alert alert-warning">{{$lang->Related_Products}}</div>
                                <hr>
                                <form class="ajaxForm related_products" data-name="related_products"
                                      action="{{route('dashboard_products.related_products')}}" method="post">
                                    <div class="modal-body">
                                        {{csrf_field()}}

                                        <input id="products_id" name="products_id" type="hidden">
                                        <input id="related_products_data" name="related_products" type="hidden">

                                        <hr>
                                        <table width="100%" class="table data_Table table-bordered" id="data_Table">
                                            <thead>
                                            <th>{{$lang->ID}}</th>
                                            <th>{{$lang->Name}}</th>
                                            <th>{{$lang->Avatar}}</th>
                                            <th>{{$lang->Option}}</th>
                                            </thead>
                                        </table>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-load">
                                            {{$lang->Submit}}
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @if($langauges->where('dir','!=',$select_lan_choice->dir)->count() > 0)
                                @foreach($langauges->where('dir','!=',$select_lan_choice->dir) as $lang222)

                                <div class="tab-pane fade tab_{{$lang222->id}}" id="{{$lang222->name}}"
                                 role="tabpanel"
                                 aria-labelledby="{{$lang222->name}}-tab">
                                <br>
                                <div class="alert alert-warning">{{$lang222->name}}</div>
                                <hr>
                                <form class="ajaxForm translate" data-name="translate"
                                      action="{{route('dashboard_products_translate.post_data')}}" method="post">
                                    <div class="modal-body row">
                                        {{csrf_field()}}

                                        <input id="id_current_{{$lang222->id}}" name="id" type="hidden">
                                        <input id="products_id_{{$lang222->id}}" name="products_id" type="hidden">
                                        <input id="language_id_{{$lang222->id}}" name="language_id" type="hidden"
                                               value="{{$lang222->id}}">

                                        <div class="form-group col-12">
                                            <label for="name_translate_{{$lang222->id}}">{{$lang->Name}}</label>
                                            <input type="text" class="cls form-control" name="name"
                                                   id="name_translate_{{$lang222->id}}"
                                                   placeholder="{{$lang->Name}}">
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="sub_name_translate_{{$lang222->id}}">{{$lang->Sub_Name}}</label>
                                            <input type="text" class="cls form-control" name="sub_name"
                                                   id="sub_name_translate_{{$lang222->id}}"
                                                   placeholder="{{$lang->Sub_Name}}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="summary_translate_{{$lang222->id}}">{{$lang->Summary}}</label>
                            <textarea rows="4" class="cls sumernote form-control" name="summary"
                                      id="summary_translate_{{$lang222->id}}"
                                      placeholder="{{$lang->Summary}}"></textarea>
                                        </div>


                                        <div class="form-group col-md-12">
                                            <label for="btn_add1">
                                                {{$lang->features}}
                                                <button type="button" id="btn_add1" class="btn btn-dark btn-sm">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </label>
                                            <div class="rows" id="d_features1">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">
                                            {{$lang->Close}}
                                        </button>
                                        <button type="submit" class="btn btn-primary btn-load">
                                            {{$lang->Submit}}
                                        </button>
                                    </div>
                                </form>
                            </div>
                                @endforeach
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('js')
    <script src="{{$path}}files/dash_board/{{$selctor}}/plugins/multipleselect/multiple-select.js"></script>
    <script src="{{$path}}files/dash_board/{{$selctor}}/plugins/multipleselect/multi-select.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
    <script type="text/javascript">
        var arry1 = [];
        var arry2 = [];
        var arry3 = [];
        var images = [];
        var old_images = [];
        var isizes =1;
        var isizes1 =1;
        Dropzone.options.dropzone =
        {
            maximagesize: 122,
            renameFile: function (file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + file.name;
            },
            removedfile: function (file) {
                var name = file.upload.filename;
                $.ajax({
                    url: "{{ route('dashboard_products.deleteuploadjquery') }}",
                    method: 'get',
                    data: {filename: name},
                    success: function (result) {
                        images.splice(result);
                        $('#images').val(images);
                    }
                });
                var fileRef;
                return (fileRef = file.previewElement) != null ?
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
            acceptedimages: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            dictRemoveFile: "×",
            timeout: 5000,
            success: function (file, response) {
                images.push(response['data']);
                $('#images').val(images);
            },
            error: function (file, response) {
                return false;
            }
        };
        $(document).ready(function () {

            "use strict";
            //Code here.

            var url = $(location).attr('href'),
                    parts = url.split("/"),
                    last_part = parts[parts.length - 1];

            var name_form = $('.ajaxForm').data('name');

            if (isNaN(last_part) == false) {
                if (last_part != null) {
                    $('.title_info').html("{{$lang->Edit}}");
                    Render_Data(last_part);
                    Other(last_part);
                    $(document).on("click", ".get_related_products", function () {
                        $('#products_id').val(last_part);
                    });
                    var array = [];
                    $(document).on("click", ".btn_featured", function () {
                        var id = $(this).data("id");
                        if ($(this).prop("checked") == true) {
                            array.push(id);
                        }
                        else if ($(this).prop("checked") == false) {
                            var index = array.indexOf(id);
                            if (index > -1) {
                                array.splice(index, 1);
                            }
                        }
                        $("#related_products_data").val(array);
                    });

                }
            } else {
                $('.title_info').html("{{$lang->Create}}");
            }

            
            $(document).on('click', '.btn_remove_gallery2', function () {
                var id = $(this).data("id");
                $.ajax({
                    url: "{{ route('dashboard_products.deleteuploadjquery') }}",
                    method: 'get',
                    data: {filename: id, "type": "1"},
                    success: function (result) {
                        var str = $("#old_images").val();
                        var array = str.split(",");
                        var dd = '';
                        $('#render_gallery').html('');
                        $('#render_gallery').removeClass('d-none');
                        for (var i = 0; i < array.length; i++) {
                            var v = array[i];
                            if (v) {
                                if (v != result) {
                                    dd = v + ',' + dd;
                                    var image = v;
                                    var id = v;
                                    var r = '<div class="col-md-3" style="margin-bottom: 20px;"><div class="card">\n' +
                                            '<img data-img="' + geturlphoto() + 'upload/gallery_products/' + image + '" style="width: 100%;80px;" src="' + geturlphoto() + 'upload/gallery_products/' + image + '" class="card-img-top" alt="...">\n' +
                                            '  <div class="card-body">\n' +
                                            '    <button type="button" data-id="' + id + '" class="btn_remove_gallery2 btn btn-primary"><i class="fa fa-trash"></i></button>\n' +
                                            '  </div>\n' +
                                            '</div></div>';
                                    $('#render_gallery').append(r);
                                }
                            }
                        }
                        $("#old_images").val(dd);
                    }
                });
            });

            $(document).on("click", ".get_content_language", function () {
                var language_id = $(this).data("id");
                var id = $("#id").val();
                $.ajax({
                    url: "{{route('dashboard_products_translate.get_data_by_id')}}",
                    method: "get",
                    data: {
                        "id": id,
                        "language_id": language_id,
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.success != null) {
                            $('#id_current_' + result.success.language_id).val(result.success.id);
                            $('#language_id_' + result.success.language_id).val(result.success.language_id);
                            $('#name_translate_' + result.success.language_id).val(result.success.name);
                            $('#sub_name_translate_' + result.success.language_id).val(result.success.sub_name);
                            $('#summary_translate_' + result.success.language_id).summernote('code', result.success.summary);
                            $('#products_id_' + result.success.language_id).val(result.success.products_id);

                            //Sizrs other
                            var adddss = result.success.features;
                            if(adddss){
                                var adddss_c = adddss.split(",");
                                if(adddss_c.length != 0){
                                    for(var i3 = 0 ; i3 < adddss_c.length ; i3++){
                                        if(adddss_c[i3]){
                                            isizes1++;
                                            var val = adddss_c[i3].split("-");
                                            var r = '<div id="row1'+isizes1+'" class="row"><div class="form-group col-11">\
                                                                <label for="names_sub">Name</label>\
                                                                <input type="text" class="cls form-control" value="'+ val[0] +'" name="names_sub[]" placeholder="Name">\
                                                            </div>\
                                                            <div><br><button type="button" name="remove" id="'+isizes1+'" class="btn-sm btn btn-danger btn_remove1">X</button></div></div>';
                                            $("#d_features1").append(r);
                                            //$('#d_sizes').append('<tr id="row'+isizes+'" class="dynamic-added"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+isizes+'" class="btn btn-danger btn_remove">X</button></td></tr>');

                                        }
                                    }
                                }
                            }

                        }
                        else {
                            $('#products_id_' + language_id).val(id);
                        }
                    }
                });
            });


            $('#btn_add').click(function(){
                isizes++;
                var r = '<div id="row'+isizes+'" class="row"><div class="form-group col-11">\
                                            <label for="names">Name</label>\
                                            <input type="text" class="cls form-control" name="names[]" placeholder="Name">\
                                        </div>\
                                        <div><br><button type="button" name="remove" id="'+isizes+'" class="btn-sm btn btn-danger btn_remove">X</button></div></div>';
                $("#d_features").append(r);
                //$('#d_sizes').append('<tr id="row'+isizes+'" class="dynamic-added"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+isizes+'" class="btn btn-danger btn_remove">X</button></td></tr>');
            });


            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id).remove();
            });

            $('#btn_add1').click(function(){
                isizes1++;
                var r = '<div id="row1'+isizes1+'" class="row"><div class="form-group col-11">\
                                            <label for="names_sub">Name</label>\
                                            <input type="text" class="cls form-control" name="names_sub[]" placeholder="Name">\
                                        </div>\
                                        <div><br><button type="button" name="remove" id="'+isizes1+'" class="btn-sm btn btn-danger btn_remove1">X</button></div></div>';
                $("#d_features1").append(r);
                //$('#d_sizes').append('<tr id="row'+isizes+'" class="dynamic-added"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+isizes+'" class="btn btn-danger btn_remove">X</button></td></tr>');
            });


            $(document).on('click', '.btn_remove1', function(){
                var button_id = $(this).attr("id");
                $('#row1'+button_id).remove();
            });

        });

        var Other = function (id) {
            datatabe = $('#data_Table').DataTable({
                "language": {
                    aria: {
                        sortAscending: "{{$lang->sortAscending}}",
                        sortDescending: "{{$lang->sortDescending}}"
                    }
                    ,
                    emptyTable: "{{$lang->emptyTable}}",
                    info: "{{$lang->info}}",
                    infoEmpty: "{{$lang->emptyTable}}",
                    infoFiltered: "{{$lang->infoFiltered}}",
                    lengthMenu: "_MENU_",
                    search: "{{$lang->search}}",
                    zeroRecords: "{{$lang->emptyTable}}",
                    paginate: {
                        sFirst: "{{$lang->paginate_sFirst}}",
                        sLast: "{{$lang->paginate_sLast}}",
                        sNext: "{{$lang->paginate_sNext}}",
                        sPrevious: "{{$lang->paginate_sPrevious}}",
                    }
                },
                "processing": true,
                "serverSide": true,
                "bStateSave": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', aData['id']);
                },
                "ajax": {
                    "url": "{{ route('dashboard_products.get_related_products') }}",
                    "dataType": "json",
                    "type": "post",
                    "data": {
                        _token: "{{csrf_token()}}",
                        'id': id,
                    }
                },
                "columns": [
                    {"data": "id"},
                    {"data": "name"},
                    {"data": "avatar"},
                    {"data": "options"}
                ]
            });
        };

        var Render_Data = function (id) {
            $.ajax({
                url: "{{route('dashboard_products.get_data_by_id')}}",
                method: "get",
                data: {
                    "id": id,
                },
                dataType: "json",
                success: function (result) {
                    if (result.success != null) {
                        $('#id').val(result.success.id);
                        $('#name').val(result.success.name);
                        $('#to_date').val(date_Ret(result.success.to_date));
                        $('#from_date').val(date_Ret(result.success.from_date));
                        $('#category_id').val(result.success.category_id);
                        $('#sub_name').val(result.success.sub_name);
                        $('#category_1').val(result.success.category_1);
                        $('#related_products_data').val(result.success.related_products);
                        $('#summary').summernote('code', result.success.summary);

                        $('.avatar_view').removeClass('d-none');
                        $('.avatar_view').attr('src', geturlphoto() + result.success.avatar);
                        $('.avatar1_view').removeClass('d-none');
                        $('.avatar1_view').attr('src', geturlphoto() + result.success.avatar1);

                        $('#video').val(result.success.video);
                        $('#price').val(result.success.price);
                        $('#area').val(result.success.area);

                        $('#type').val(result.success.type);
                        $('#bed_rooms').val(result.success.bed_rooms);
                        $('#body_style').val(result.success.body_style);
                        $('#bath_rooms').val(result.success.bath_rooms);
                        $('#car').val(result.success.car);
                        $('#sq').val(result.success.sq);
                        $('#address').val(result.success.address);
                        $('#provide').val(result.success.provide);
                        $('#city').val(result.success.city);
                        $('#country').val(result.success.country);
                        $('#post_code').val(result.success.post_code);

                        //images
                        var images = result.success.files;
                        $('#old_images').val(images);
                        if (images != null) {
                            var images_res = images.split(",");
                            if (images_res.length != 0) {
                                $('#render_gallery').html('');
                                $('#render_gallery').removeClass('d-none');
                                for (var i = 0; i < images_res.length; i++) {
                                    if (images_res[i]) {
                                        var image = images_res[i];
                                        var id = image;
                                        var r = '<div class="col-md-3" style="margin-bottom: 20px;"><div class="card">\n' +
                                                '<img data-img="' + geturlphoto() + 'upload/gallery_products/' + image + '" style="width: 100%;80px;" src="' + geturlphoto() + 'upload/gallery_products/' + image + '" class="card-img-top" alt="...">\n' +
                                                '  <div class="card-body">\n' +
                                                '    <button type="button" data-id="' + id + '" class="btn_remove_gallery2 btn btn-primary"><i class="fa fa-trash"></i></button>\n' +
                                                '  </div>\n' +
                                                '</div></div>';
                                        $('#render_gallery').append(r);
                                    }
                                }
                            }
                        }

                        //Sizrs other
                        var adddss = result.success.features;
                        if(adddss){
                            var adddss_c = adddss.split(",");
                            if(adddss_c.length != 0){
                                for(var i3 = 0 ; i3 < adddss_c.length ; i3++){
                                    if(adddss_c[i3]){
                                        isizes++;
                                        var val = adddss_c[i3].split("-");
                                        var r2 = '<div id="row'+isizes+'" class="row"><div class="form-group col-11">\
                                                                <label for="names">Name</label>\
                                                                <input type="text" class="cls form-control" value="'+ val[0] +'" name="names[]" placeholder="Name">\
                                                            </div>\
                                                            <div><br><button type="button" name="remove" id="'+isizes+'" class="btn-sm btn btn-danger btn_remove">X</button></div></div>';
                                        $("#d_features").append(r2);
                                    }
                                }
                            }
                        }


                    } else {
                        toastr.error('لا يوحد بيانات', 'العمليات');
                        window.location.href = "{{route('dashboard_products.index')}}";
                    }
                }
            });
        };

    </script>
@endsection
