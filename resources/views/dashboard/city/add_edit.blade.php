@extends('dashboard.layouts.app')

@section('title')
    {{$lang->City}}
@endsection

@section('create_btn'){{route('dashboard_city.index')}}@endsection
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
                        <form class="ajaxForm users" enctype="multipart/form-data" data-name="users"
                              action="{{route('dashboard_city.post_data')}}" method="post">
                            {{csrf_field()}}
                            <div class="modal-header">
                                <h5 class="modal-title title_info"></h5>
                            </div>
                            <div class="modal-body row">
                                <input id="id" name="id" class="cls" type="hidden">
                                <div class="form-group col-12">
                                    <label for="name">{{$lang->Name}}</label>
                                    <input type="text" class="cls form-control" name="name" id="name" placeholder="{{$lang->Name}}">
                                </div>
                            </div>
                            @includeIf("dashboard.layouts.seo")
                            <div class="modal-footer">
                                <input type="hidden" name="button_action" id="button_action" value="insert">
                                <a href="{{route('dashboard_city.index')}}" class="btn btn-default">
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
    <script type="text/javascript">
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
                }
            } else {
                $('.title_info').html("{{$lang->Create}}");
            }

        });

        var Render_Data = function (id) {
            $.ajax({
                url: "{{route('dashboard_city.get_data_by_id')}}",
                method: "get",
                data: {
                    "id": id,
                },
                dataType: "json",
                success: function (result) {
                    if (result.success != null) {
                        $('#id').val(result.success.id);
                        $('#name').val(result.success.name);
                        $('#description').val(result.success.description);
                        $('#keywords').val(result.success.keywords);
                    } else {
                        toastr.error('لا يوحد بيانات', 'العمليات');
                        window.location.href = "{{route('dashboard_city.index')}}";
                    }
                }
            });
        };

    </script>
@endsection
