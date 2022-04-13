@extends('dashboard.layouts.app')

@section('title')
    {{$lang->Header}} 1
@endsection

@php
$selctor = "ltr";
if(app()->getLocale() == "ar"){
$selctor = "rtl";
}
@endphp

@section('css')
    <link rel="stylesheet" href="{{$path}}files/dash_board/{{$selctor}}/plugins/multipleselect/multiple-select.css">
@endsection

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

                        <form class="ajaxForm post_header" enctype="multipart/form-data" data-name="post_header"
                              action="{{route('dashboard_home_page.post_header')}}" method="post">
                            {{csrf_field()}}
                            <div class="modal-body row">
                                <input id="id" name="id" class="cls" type="hidden">
                                <input id="type" name="type" class="cls" value="1" type="hidden">

                                <div class="form-group col-12">
                                    <label for="name">{{$lang->Name}}</label>
                                    <select class="cls form-control" name="name" id="name">
                                        <option>{{$lang->Name}}</option>
                                        @if($category_id1->count() != 0)
                                            @foreach($category_id1 as $item2)
                                                <option value="{{$item2->id}}">{{$item2->name()}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="category_1">{{$lang->Brand}}</label>
                                    <select multiple="multiple" name="brand_id[]" id="brand_id" class="multiselect">
                                        @if($brand_id->count() != 0)
                                            @foreach($brand_id as $item)
                                                <option value="{{$item->id}}"
                                                        id="{{$item->id}}"
                                                >{{$item->name()}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="category_1">{{$lang->Category_Services}}</label>
                                    <select multiple="multiple" name="category_1[]" id="category_1" class="multiselect">
                                        @if($category_id1->count() != 0)
                                            @foreach($category_id1 as $item)
                                                <option value="{{$item->id}}"
                                                        id="{{$item->id}}"
                                                >{{$item->name()}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="avatar1">{{$lang->Avatar}}</label>
                                    <input type="file" class="cls form-control" name="avatar1" id="avatar1">
                                    <hr>
                                    <input type="text" placeholder="{{$lang->Link}}" class="cls form-control" name="link" id="link">
                                </div>
                                <div class="form-group col-md-6">
                                    <img style="width: 80px;height: 80px;"
                                         class="img_usres avatar1_view d-none img-thumbnail">
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="avatar2">{{$lang->Avatar}}</label>
                                    <input type="file" class="cls form-control" name="avatar2" id="avatar2">
                                    <hr>
                                    <input type="text" placeholder="{{$lang->Link}}" class="cls form-control" name="video" id="video">
                                </div>
                                <div class="form-group col-md-6">
                                    <img style="width: 80px;height: 80px;"
                                         class="img_usres avatar2_view d-none img-thumbnail">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <a href="{{route('dashboard_hp_contact_us.index')}}" class="btn btn-default">
                                    {{$lang->Close}}
                                </a>
                                <button type="submit" class="btn btn-primary btn-load">
                                    {{$lang->Submit}}
                                </button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{$path}}files/dash_board/{{$selctor}}/plugins/multipleselect/multiple-select.js"></script>
    <script src="{{$path}}files/dash_board/{{$selctor}}/plugins/multipleselect/multi-select.js"></script>
    <script type="text/javascript">
        var arry1 = [];
        var arry2 = [];
        $(document).ready(function () {

            "use strict";
            //Code here.

            Render_Data();

        });

        var Render_Data = function () {
            $.ajax({
                url: "{{ route('dashboard_home_page.get_data_header_by_id') }}",
                method: "get",
                data: {},
                dataType: "json",
                success: function (result) {
                    if (result.success != null) {
                        $('#id').val(result.success.id);
                        $('#type').val("1");
                        $('#name').val(result.success.name);
                        $('#link').val(result.success.link);
                        $('#video').val(result.success.video);

                        $('.avatar1_view').removeClass('d-none');
                        $('.avatar1_view').attr('src', geturlphoto() + result.success.avatar1);

                        $('.avatar2_view').removeClass('d-none');
                        $('.avatar2_view').attr('src', geturlphoto() + result.success.avatar2);

                        //category_id
                        var cat = result.success.summary;
                        var count_cat = cat.split(",");
                        if (count_cat.length != 0) {
                            for (var i = 0; i < count_cat.length; i++) {
                                if (count_cat[i]) {
                                    var id = count_cat[i];
                                    // $("#category_id_select_" + id).attr("selected", "selected");
                                    arry1.push(id);
                                }
                            }
                        }
                        $('#category_1').multipleSelect('setSelects', arry1);
                        $("#category_1").val(arry1);

                        //brand_id
                        var brand_id = result.success.sub_summary;
                        var count_brand_id = brand_id.split(",");
                        if (count_brand_id.length != 0) {
                            for (var i2 = 0; i2 < count_brand_id.length; i2++) {
                                if (count_brand_id[i2]) {
                                    var id2 = count_brand_id[i2];
                                    // $("#category_id_select_" + id).attr("selected", "selected");
                                    arry2.push(id2);
                                }
                            }
                        }
                        $('#brand_id').multipleSelect('setSelects', arry2);
                        $("#brand_id").val(arry2);


                    }
                }
            });
        };

    </script>
@endsection
