@extends('dashboard.layouts.app')

@section('title')
    {{$lang->Language}}
@endsection

@section('create_btn'){{route('dashboard_language.index')}}@endsection
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
                                @lang('language.manage')
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="form-group m-form__group">
                        <form class="ajaxForm users" enctype="multipart/form-data" data-name="users" action="{{route('dashboard_language.post_data')}}" method="post">
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
                                <div class="form-group col">
                                    <label for="avatar">{{$lang->Avatar}}</label>
                                    <input type="file" class="cls form-control" name="avatar" id="avatar">
                                    <br>
                                    <img class="img_usres avatar_view d-none img-thumbnail">
                                </div>
                                <div class="form-group col">
                                    <label for="name">{{$lang->Code}}</label>
                                    <input type="text" class="cls form-control" name="dir" id="dir" placeholder="{{$lang->Code}} :en - ar">
                                </div>
                                <div class="form-group col col-12">
                                    <label for="select">{{$lang->Primary}}</label>
                                    <input class="" id="select" name="select" type="checkbox">
                                </div>
                            </div>
                            @includeIf("dashboard.layouts.seo")
                            <div class="modal-footer">
                                <input type="hidden" name="button_action" id="button_action" value="insert">
                                <a href="{{route('dashboard_language.index')}}" class="btn btn-default" >
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
        $(document).ready(function() {

            "use strict";
            //Code here.

            var url = $(location).attr('href'),
                parts = url.split("/"),
                last_part = parts[parts.length-1];

            var name_form = $('.ajaxForm').data('name');

            if(isNaN(last_part) == false ){
                if(last_part != null){
                    $('.title_info').html("@lang('language.edit')");
                    Render_Data(last_part);
                }
            }else {
                $('.title_info').html("@lang('language.create')");
            }

        });

        var Render_Data = function (id) {
            $.ajax({
                url:"{{route('dashboard_language.get_data_by_id')}}",
                method:"get",
                data : {
                    "id" : id,
                },
                dataType:"json",
                success:function(result)
                {
                    console.log(result);
                   if(result.success != null){
                       $('#id').val(result.success.id);
                       $('#name').val(result.success.name);
                       $('#dir').val(result.success.dir);
                       $('#description').val(result.success.description);
                       $('#keywords').val(result.success.keywords);
                       $('.title').html(result.success.name);
                       $('.avatar_view').removeClass('d-none');
                       $('.avatar_view').attr('src', geturlphoto() + result.success.avatar);
                       if(result.success.select == 1){
                           $('#select').attr("checked", "checked");
                       }
                   }
                   else{
                       toastr.error('لا يوحد بيانات','العمليات');
                       window.location.href = "{{route('dashboard_language.index')}}";
                   }
                }
            });
        };

    </script>


@endsection
