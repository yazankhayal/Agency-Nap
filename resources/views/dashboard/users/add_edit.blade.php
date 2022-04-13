@extends('dashboard.layouts.app')

@section('title')
    {{$lang->Users}}
@endsection

@section('create_btn'){{route('dashboard_users.index')}}@endsection
@section('create_btn_btn'){{$lang->Close}}@endsection

@section('content')

    <div class="card mb-4 wow fadeIn">
        <div class="card-body">

            <h4 class="mb-2 mb-sm-0 pt-1">
                @lang('language.users')
            </h4>
            <hr>
            <form class="ajaxForm users" enctype="multipart/form-data" data-name="users"
                  action="{{route('dashboard_users.post_data')}}" method="post">
                {{csrf_field()}}
                <div class="modal-header">
                    <h5 class="modal-title title_info">

                    </h5>
                    <div class="stud"></div>
                </div>
                <div class="modal-body">
                    <input id="id" name="id" class="cls" type="hidden">
                    <div class="form-group">
                        <label for="name">{{$lang->Name}}</label>
                        <input type="text" class="cls form-control" name="name" id="name"
                               placeholder="{{$lang->Name}}">
                    </div>
                    <div class="form-group">
                        <label for="email">{{$lang->Email}}</label>
                        <input type="email" class="cls form-control" name="email" id="email"
                               placeholder="{{$lang->Email}}">
                    </div>
                    <div class="form-group">
                        <label for="role">{{$lang->Role}}</label>
                        <select class="cls form-control" name="role" id="role">
                            <option value="">{{$lang->Role}}</option>
                            <option value="1">{{$lang->Admin}}</option>
                            <option value="2">{{$lang->User}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="avatar">{{$lang->Avatar}}</label>
                        <input type="file" class="cls form-control" name="avatar" id="avatar">
                        <br>
                        <img class="img_usres avatar_view d-none img-thumbnail">
                    </div>
                    <div class="form-group">
                        <label for="password">{{$lang->Password}}</label>
                        <input type="password" class="cls form-control" name="password" id="password"
                               placeholder="{{$lang->Password}}">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">{{$lang->Password_Confirm}}</label>
                        <input type="password" class="cls form-control" name="password_confirmation"
                               id="password_confirmation" placeholder="{{$lang->Password_Confirm}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="button_action" id="button_action" value="insert">
                    <a href="{{route('dashboard_users.index')}}" class="btn btn-default">
                        {{$lang->Close}}
                    </a>
                    <button type="submit" class="btn btn-primary btn-load">
                        {{$lang->Submit}}
                    </button>
                </div>
            </form>
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
                url: "{{route('dashboard_users.get_data_by_id')}}",
                method: "get",
                data: {
                    "id": id,
                },
                dataType: "json",
                success: function (result) {
                    console.log(result);
                    if (result.success != null) {
                        $('#id').val(result.success.id);
                        $('#name').val(result.success.name);
                        $('.title').html(result.success.name);
                        $('#role').val(result.success.role);
                        $('#email').val(result.success.email);
                        $('.avatar_view').removeClass('d-none');
                        $('.avatar_view').attr('src', geturlphoto() + result.success.avatar);
                        $('#button_action').val('edit');
                    } else {
                        toastr.error('لا يوحد بيانات', 'العمليات');
                        window.location.href = "{{route('dashboard_users.index')}}";
                    }
                }
            });
        };

    </script>


@endsection
