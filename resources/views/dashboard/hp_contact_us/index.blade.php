@extends('dashboard.layouts.app')

@section('title')
    {{$lang->Contact_us}}
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
                        <form class="ajaxForm dashboard_hp_contact_us" enctype="multipart/form-data" data-name="dashboard_hp_contact_us"
                              action="{{route('dashboard_hp_contact_us.post_data')}}" method="post">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <input id="id" name="id" class="cls" type="hidden">
                                <div class="row">
                                    <div class="form-group col-md-6 col-6">
                                        <label for="whatsapp">{{$lang->Whatsapp}}</label>
                                        <input type="text" class="cls form-control" name="whatsapp" id="whatsapp"
                                               placeholder="{{$lang->Whatsapp}}">
                                    </div>
                                    <div class="form-group col-md-6 col-6">
                                        <label for="phone">{{$lang->Phone}}</label>
                                        <input type="text" class="cls form-control" name="phone" id="phone"
                                               placeholder="{{$lang->Phone}}">
                                    </div>
                                    <div class="form-group col-md-6 col-6">
                                        <label for="email">{{$lang->Email}}</label>
                                        <input type="text" class="cls form-control" name="email" id="email"
                                               placeholder="{{$lang->Email}}">
                                    </div>
                                    <div class="form-group col-md-6 col-6">
                                        <label for="iframe_google">{{$lang->IframeGoogle}}</label>
                                        <input type="text" class="cls form-control" name="iframe" id="iframe"
                                               placeholder="{{$lang->IframeGoogle}}">
                                    </div>
                                    <div class="form-group col-md-6 col-6">
                                        <label for="address">{{$lang->Address}}</label>
                                        <input type="text" class="cls form-control" name="address" id="address"
                                               placeholder="{{$lang->Address}}">
                                    </div>
                                    <div class="form-group col-md-6 col-6">
                                        <label for="fax">{{$lang->Fax}}</label>
                                        <input type="text" class="cls form-control" name="fax" id="fax"
                                               placeholder="{{$lang->Fax}}">
                                    </div>
                                    <div class="form-group col-md-6 col-6">
                                        <label for="hours">{{$lang->Hours}}</label>
                                        <input type="text" class="cls form-control" name="hours" id="hours"
                                               placeholder="{{$lang->Hours}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6 col-6">
                                        <label for="facebook">{{$lang->Facebook}}</label>
                                        <input type="text" class="cls form-control" name="facebook" id="facebook"
                                               placeholder="{{$lang->Facebook}}">
                                    </div>
                                    <div class="form-group col-md-6 col-6">
                                        <label for="instagram">{{$lang->Instagram}}</label>
                                        <input type="text" class="cls form-control" name="instagram" id="instagram"
                                               placeholder="{{$lang->Instagram}}">
                                    </div>
                                    <div class="form-group col-md-6 col-6">
                                        <label for="twitter">{{$lang->Twitter}}</label>
                                        <input type="text" class="cls form-control" name="twitter" id="twitter"
                                               placeholder="{{$lang->Twitter}}">
                                    </div>
                                    <div class="form-group col-md-6 col-6">
                                        <label for="pinterest">{{$lang->Youtube}}</label>
                                        <input type="text" class="cls form-control" name="pinterest" id="pinterest"
                                               placeholder="{{$lang->Youtube}}">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="button_action" id="button_action" value="insert">
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

    <script type="text/javascript">
        $(document).ready(function() {
            "use strict";

            Render_Data();

        });

        var Render_Data = function () {
            $.ajax({
                url: "{{ route('dashboard_hp_contact_us.get_data_by_id') }}",
                method: "get",
                data: {},
                dataType: "json",
                success: function (result) {
                    if (result.success != null) {
                        $('#id').val(result.success.id);
                        $('#summary').val(result.success.summary);
                        $('#email').val(result.success.email);
                        $('#phone').val(result.success.phone);
                        $('#whatsapp').val(result.success.whatsapp);
                        $('#address').val(result.success.address);
                        $('#iframe').val(result.success.iframe);
                        $('#instagram').val(result.success.instagram);
                        $('#twitter').val(result.success.twitter);
                        $('#facebook').val(result.success.facebook);
                        $('#hours').val(result.success.hours);
                        $('#pinterest').val(result.success.pinterest);
                        $('#fax').val(result.success.fax);
                        //$('#hours').summernote('code',result.success.hours);
                    }
                }
            });
        };

    </script>


@endsection
