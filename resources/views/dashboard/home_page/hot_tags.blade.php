@extends('dashboard.layouts.app')

@section('title')
    {{$lang->Cat_Home}}
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

                 
                            <div class="modal-body row">
                              
                                <div class="form-group col-12">
                                    <label for="category_id">{{$lang->Category_Services}}</label>
                                    <ul class="list-group">
                                        @if($category_id->count() != 0)
                                            @foreach($category_id as $item)
                                                <li class="list-group-item">
                                                    <label>
                                                        <img src="{{$path.$item->avatar}}" class="img-circle" style="width: 19px;height: 19px;;">
                                                        {{$item->name()}}
                                                        <label class="custom-switch">
                                                            <input type="checkbox" id="new"
                                                                value="{{$item->id}}"
                                                                {{$item->hot_tags == 1 ? "checked" : ""}}
                                                                class="custom-switch-input hot_tags">
                                                            <span class="custom-switch-indicator"></span> <span
                                                                    class="custom-switch-description">
                                                                    Active / Disactive
                                                                </span>
                                                        </label>
                                                    </label>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>

                            </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {

            "use strict";
            //Code here.

            //Render_Data();

            //cat_select
            $(document).on("click", ".hot_tags", function () {
                var value = $(this).val();
                var type = $(this).prop("checked");
                
                $.ajax({
                    url: "{{route('dashboard_home_page.post_hot_tags')}}",
                    method: "get",
                    data:{
                        "id" : value,
                        "type" : type,
                        "c1" : "1",
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.success != null) {
                            toastr.success(result.success);
                        }
                        else {
                            toastr.error(result.error);
                        }
                    }
                });
            });

        });

        var Render_Data = function () {
            $.ajax({
                url: "{{ route('dashboard_home_page.get_data_hot_tags_by_id') }}",
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
