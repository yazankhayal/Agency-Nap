@extends('dashboard.layouts.app')

@section('title')
    @lang('language.testimonials')
@endsection

@section('create_btn'){{route('dashboard_testimonials.index')}}@endsection
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
                                <form class="ajaxForm users" enctype="multipart/form-data" data-name="users"
                                      action="{{route('dashboard_testimonials.post_data')}}" method="post">
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
                                        <div class="form-group col-12">
                                            <label for="bio">{{$lang->Bio}}</label>
                                            <input type="text" class="cls form-control" name="bio" id="bio" placeholder="{{$lang->Bio}}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="summary">{{$lang->Summary}}</label>
                                    <textarea rows="4" class="cls  form-control" name="summary"
                                              id="summary" placeholder="{{$lang->Summary}}"></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="avatar">{{$lang->Avatar}}</label>
                                            <input type="file" class="cls form-control" name="avatar" id="avatar">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <img style="width: 80px;height: 80px;"
                                                 class="img_usres avatar_view d-none img-thumbnail">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="button_action" id="button_action" value="insert">
                                        <a href="{{route('dashboard_testimonials.index')}}" class="btn btn-default">
                                            {{$lang->Close}}
                                        </a>
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
                                <form class="ajaxForm translate" data-name="translate" action="{{route('dashboard_testimonials_translate.post_data')}}" method="post">
                                    <div class="modal-body row">
                                        {{csrf_field()}}

                                        <input id="id_translate_{{$lang222->id}}" name="id" type="hidden">
                                        <input id="testimonials_id_{{$lang222->id}}" name="testimonials_id" type="hidden">
                                        <input id="language_id_{{$lang222->id}}" name="language_id" type="hidden"
                                               value="{{$lang222->id}}">

                                        <div class="form-group col-12">
                                            <label for="name_translate_{{$lang222->id}}">{{$lang->Name}}</label>
                                            <input type="text" class="cls form-control" name="name" id="name_translate_{{$lang222->id}}" placeholder="{{$lang->Name}}">
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="bio_translate_{{$lang222->id}}">{{$lang->Bio}}</label>
                                            <input type="text" class="cls form-control" name="bio" id="bio_translate_{{$lang222->id}}" placeholder="{{$lang->Bio}}">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="summary_translate_{{$lang222->id}}">{{$lang->Summary}}</label>
                            <textarea rows="4" class="cls  form-control" name="summary"
                                      id="summary_translate_{{$lang222->id}}" placeholder="{{$lang->Summary}}"></textarea>
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

            $(document).on("click",".get_content_language",function(){
                var language_id = $(this).data("id");
                var id = $("#id").val();
                $.ajax({
                    url: "{{route('dashboard_testimonials_translate.get_data_by_id')}}",
                    method: "get",
                    data: {
                        "id": id,
                        "language_id": language_id,
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.success != null) {
                            $('#id_translate_' + result.success.language_id).val(result.success.id);
                            $('#language_id_' + result.success.language_id).val(result.success.language_id);
                            $('#name_translate_' + result.success.language_id).val(result.success.name);
                            $('#bio_translate_' + result.success.language_id).val(result.success.bio);
                            $('#summary_translate_' + result.success.language_id).val(result.success.summary);
                            $('#testimonials_id_' + result.success.language_id).val(result.success.testimonials_id_id);
                        }
                        else{
                            $('#testimonials_id_'+language_id).val(id);
                        }
                    }
                });
            });

        });

        var Render_Data = function (id) {
            $.ajax({
                url: "{{route('dashboard_testimonials.get_data_by_id')}}",
                method: "get",
                data: {
                    "id": id,
                },
                dataType: "json",
                success: function (result) {
                    if (result.success != null) {
                        $('#id').val(result.success.id);
                        $('#name').val(result.success.name);
                        $('#bio').val(result.success.bio);
                        $('#summary').val(result.success.summary);
                        $('.avatar_view').removeClass('d-none');
                        $('.avatar_view').attr('src', geturlphoto() + result.success.avatar);
                    } else {
                        toastr.error('لا يوحد بيانات', 'العمليات');
                        window.location.href = "{{route('dashboard_testimonials.index')}}";
                    }
                }
            });
        };

    </script>
@endsection
