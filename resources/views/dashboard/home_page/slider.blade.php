@extends('dashboard.layouts.app')

@section('title')
    {{$lang->Slider}}
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

                        <form class="ajaxForm post_slider" enctype="multipart/form-data" data-name="post_slider"
                              action="{{route('dashboard_home_page.post_slider')}}" method="post">
                            {{csrf_field()}}
                            <div class="modal-body row">
                                <input id="id" name="id" class="cls" type="hidden">

                                <div class="form-group col-6">
                                    <label for="category_id">{{$lang->Category_Services}}</label>
                                    <input id="category_id" name="category_id" class="cls" type="hidden">
                                    <ul class="list-group">
                                        @if($category_id->count() != 0)
                                            @foreach($category_id as $item)
                                                <li class="list-group-item">
                                                    <label>
                                                        <input type="checkbox" class="cat_select" value="{{$item->id}}"
                                                               id="category_id_select_{{$item->id}}">
                                                        <img src="{{$path.$item->avatar}}" class="img-circle">
                                                        {{$item->name()}}
                                                    </label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>

                            </div>
                            <div class="modal-footer">
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
    <script type="text/javascript">
        var arry1 = [];
        $(document).ready(function () {

            "use strict";
            //Code here.

            Render_Data();

            //cat_select
            $(document).on("click", ".cat_select", function () {
                var value = $(this).val();
                if($(this).prop("checked") == true){
                    arry1.push(value);
                }
                else if($(this).prop("checked") == false){
                    var index = arry1.indexOf(value);
                    if (index > -1) {
                        arry1.splice(index, 1);
                    }
                }
                $("#category_id").val(arry1);
            });

        });

        var Render_Data = function () {
            $.ajax({
                url: "{{ route('dashboard_home_page.get_data_slider_by_id') }}",
                method: "get",
                data: {},
                dataType: "json",
                success: function (result) {
                    if (result.success != null) {
                        $('#id').val(result.success.id);
                        //category_id
                        var cat = result.success.summary;
                        var count_cat = cat.split(",");
                        if (count_cat.length != 0) {
                            for (var i = 0; i < count_cat.length; i++) {
                                if (count_cat[i]) {
                                    var id = count_cat[i];
                                    $("#category_id_select_" + id).attr("checked", "checked");
                                    arry1.push(id);
                                }
                            }
                        }
                        $("#category_id").val(arry1);


                    }
                }
            });
        };

    </script>
@endsection
