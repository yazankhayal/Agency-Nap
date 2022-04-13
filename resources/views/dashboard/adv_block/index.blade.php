@extends('dashboard.layouts.app')

@section('title')
    {{$lang->AdvBlock}}
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
                        <form class="ajaxForm dashboard_adv_block" enctype="multipart/form-data" data-name="dashboard_adv_block"
                              action="{{route('dashboard_adv_block.post_data')}}" method="post">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <input id="id" name="id" class="cls" type="hidden">
                                <div class="row">
                                    <div class="form-group col-md-6 col-6">
                                        <label for="adv_blog_1">Adv_blog_1</label>
                                        <textarea rows="7" class="cls form-control" name="adv_blog_1" id="adv_blog_1"></textarea>
                                    </div>
                                    <div class="form-group col-md-6 col-6">
                                        <label for="adv_blog_2">Adv_blog_2</label>
                                        <textarea rows="7" class="cls form-control" name="adv_blog_2" id="adv_blog_2"></textarea>
                                    </div>
                                    <div class="form-group col-md-6 col-6">
                                        <label for="adv_blog_view_1">Adv_blog_view_1</label>
                                        <textarea rows="7" class="cls form-control" name="adv_blog_view_1" id="adv_blog_view_1"></textarea>
                                    </div>
                                    <div class="form-group col-md-6 col-6">
                                        <label for="adv_blog_view_2">Adv_blog_view_2</label>
                                        <textarea rows="7" class="cls form-control" name="adv_blog_view_2" id="adv_blog_view_2"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="button_action" id="button_action" value="insert">
                                <a href="{{route('dashboard_adv_block.index')}}" class="btn btn-default">
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

            Render_Data();

        });

        var Render_Data = function () {
            $.ajax({
                url: "{{ route('dashboard_adv_block.get_data_by_id') }}",
                method: "get",
                data: {},
                dataType: "json",
                success: function (result) {
                    if (result.success != null) {
                        $('#id').val(result.success.id);
                        $('#adv_blog_1').val(result.success.adv_blog_1);
                        $('#adv_blog_view_1').val(result.success.adv_blog_view_1);
                        $('#adv_blog_2').val(result.success.adv_blog_2);
                        $('#adv_blog_view_2').val(result.success.adv_blog_view_2);
                    }
                }
            });
        };

    </script>


@endsection
