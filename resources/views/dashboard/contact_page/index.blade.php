@extends('dashboard.layouts.app')

@section('title')
    @lang('language.contact_page')
@endsection

@section('create_btn')

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
                        <form class="ajaxForm dashboard_contact_page" enctype="multipart/form-data"
                              data-name="dashboard_contact_page"
                              action="{{route('dashboard_contact_page.post_data')}}" method="post">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <input id="id" name="id" class="cls" type="hidden">
                                <div class="form-group col-md-12">
                                    <label for="name">@lang("site.name")</label>
                                    <input type="text" class="cls form-control" name="name" id="name"
                                           placeholder="@lang("site.name")">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="summary">@lang('table.summary')</label>
                                    <textarea rows="4" class="cls form-control" name="summary"
                                              id="summary" placeholder="@lang('table.summary')"></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="avatar1">@lang('table.avatar')</label>
                                    <input type="file" class="cls form-control" name="avatar1" id="avatar1">
                                </div>
                                <div class="form-group col-md-6">
                                    <img style="width: 80px;height: 80px;"
                                         class="img_usres avatar1_view d-none img-thumbnail">
                                </div>
                                <div class="form-group d-none" id="re_lan">
                                    <label for="avatar1">@lang('table.add_new_language')</label>
                                    <div></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="button_action" id="button_action" value="insert">
                                <a href="{{route('dashboard_users.index')}}" class="btn btn-default">
                                    @lang('table.close')
                                </a>
                                <button type="submit" class="btn btn-primary btn-load">
                                    @lang('table.submit')
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModNewMore" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('table.add_new_language')
                    </h4>
                </div>
                <form class="ajaxForm translate" data-name="translate"
                      action="{{route('dashboard_contact_page_translate.post_data')}}" method="post">
                    <div class="modal-body row">
                        {{csrf_field()}}
                        <input id="id_translate" name="id" type="hidden">
                        <input id="language_id" name="language_id" type="hidden">
                        <input id="hp_contents_id" name="hp_contents_id" type="hidden">
                        <div class="form-group col-md-12">
                            <label for="name_translate">@lang("site.name")</label>
                            <input type="text" class="cls form-control" name="name" id="name_translate"
                                   placeholder="@lang("site.name")">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="summary_translate">@lang('table.summary')</label>
                            <textarea rows="4" class="cls form-control" name="summary"
                                      id="summary_translate" placeholder="@lang('table.summary')"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            @lang('table.close')
                        </button>
                        <button type="submit" class="btn btn-primary btn-load">
                            @lang('table.submit')
                        </button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

@endsection


@section('js')

    <script type="text/javascript">
        $(document).ready(function () {
            "use strict";

            Render_Data();

            $(document).on('click', '.btn_current_lan', function () {
                var id = $(this).data("id");
                $('#ModNewMore').modal('show');
                $('#language_id').val(id);
                $('.error').remove();
                $('.form-control').removeClass('border-danger');
                $.ajax({
                    url: "{{ route('dashboard_contact_page_translate.get_data_by_id') }}",
                    method: "get",
                    data: {
                        "id": id,
                        "hp_contents_id": $('#hp_contents_id').val(),
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.success != null) {
                            $('#id_translate').val(result.success.id);
                            $('#name_translate').val(result.success.name);
                            $('#summary_translate').val(result.success.summary);
                        }
                    }
                });
            });

        });

        var languages = function (update) {
            $.ajax({
                url: "{{ route('dashboard_admin.languages_exption_em') }}",
                method: "get",
                data: {},
                dataType: "json",
                success: function (result) {
                    $('#' + update).html('');
                    if (result.data.length) {
                        for (var i = 0; i < result.data.length; i++) {
                            $('#' + update).append('<button class="btn btn-primary btn_current_lan" type="button" data-id="' + result.data[i].id + '">' + result.data[i].name + '</button>');
                        }
                    }
                }
            });
        };

        var Render_Data = function () {
            $.ajax({
                url: "{{ route('dashboard_contact_page.get_data_by_id') }}",
                method: "get",
                data: {},
                dataType: "json",
                success: function (result) {
                    if (result.success != null) {
                        $('#id').val(result.success.id);
                        $('#hp_contents_id').val(result.success.id);
                        $('#name').val(result.success.name);
                        $('#summary').val(result.success.summary);
                        $('.avatar1_view').removeClass('d-none');
                        $('.avatar1_view').attr('src', geturlphoto() + result.success.avatar1);
                        $('#re_lan').removeClass('d-none');
                        languages('re_lan div');
                    }
                }
            });
        };

    </script>


@endsection
