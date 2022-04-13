@extends('dashboard.layouts.app')

@section('title')
    {{$lang->Bunner}}
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
                        <form class="ajaxForm dashboard_banner" enctype="multipart/form-data" data-name="dashboard_banner"
                              action="{{route('dashboard_banner.post_data')}}" method="post">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <input id="id" name="id" class="cls" type="hidden">
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label for="avatar1">{{$lang->Avatar}}</label>
                                        <input type="file" class="cls form-control" name="avatar1" id="avatar1">
                                        <br>
                                        <label for="name">{{$lang->Link}}</label>
                                        <input type="text" class="cls form-control" name="name" id="name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <img style="width: 80px;height: 80px;"
                                             class="img_usres avatar1_view d-none img-thumbnail">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="avatar2">{{$lang->Avatar}}</label>
                                        <input type="file" class="cls form-control" name="avatar2" id="avatar2">
                                        <br>
                                        <label for="sub_name">{{$lang->Link}}</label>
                                        <input type="text" class="cls form-control" name="sub_name" id="sub_name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <img style="width: 80px;height: 80px;"
                                             class="img_usres avatar2_view d-none img-thumbnail">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="avatar3">{{$lang->Avatar}}</label>
                                        <input type="file" class="cls form-control" name="avatar3" id="avatar3">
                                        <br>
                                        <label for="summary">{{$lang->Link}}</label>
                                        <input type="text" class="cls form-control" name="summary" id="summary">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <img style="width: 80px;height: 80px;"
                                             class="img_usres avatar3_view d-none img-thumbnail">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="avatar4">{{$lang->Avatar}}</label>
                                        <input type="file" class="cls form-control" name="avatar4" id="avatar4">
                                        <br>
                                        <label for="sub_summary">{{$lang->Link}}</label>
                                        <input type="text" class="cls form-control" name="sub_summary" id="sub_summary">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <img style="width: 80px;height: 80px;"
                                             class="img_usres avatar4_view d-none img-thumbnail">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="avatar5">{{$lang->Avatar}}</label>
                                        <input type="file" class="cls form-control" name="avatar5" id="avatar5">
                                        <br>
                                        <label for="summary1">{{$lang->Link}}</label>
                                        <input type="text" class="cls form-control" name="summary1" id="summary1">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <img style="width: 80px;height: 80px;"
                                             class="img_usres avatar5_view d-none img-thumbnail">
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="button_action" id="button_action" value="insert">
                                <a href="{{route('dashboard_banner.index')}}" class="btn btn-default">
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
                url: "{{ route('dashboard_banner.get_data_by_id') }}",
                method: "get",
                data: {},
                dataType: "json",
                success: function (result) {
                    if (result.success != null) {
                        $('#id').val(result.success.id);
                        $('#name').val(result.success.name);
                        $('#sub_name').val(result.success.sub_name);
                        $('#sub_summary').val(result.success.sub_summary);
                        $('#summary1').val(result.success.summary1);
                        $('#summary').val(result.success.summary);

                        $('.avatar1_view').removeClass('d-none');
                        $('.avatar1_view').attr('src', geturlphoto() + result.success.avatar1);
                        $('.avatar2_view').removeClass('d-none');
                        $('.avatar2_view').attr('src', geturlphoto() + result.success.avatar2);
                        $('.avatar3_view').removeClass('d-none');
                        $('.avatar3_view').attr('src', geturlphoto() + result.success.avatar3);
                        $('.avatar4_view').removeClass('d-none');
                        $('.avatar4_view').attr('src', geturlphoto() + result.success.avatar4);
                        $('.avatar5_view').removeClass('d-none');
                        $('.avatar5_view').attr('src', geturlphoto() + result.success.avatar5);

                    }
                }
            });
        };

    </script>


@endsection
