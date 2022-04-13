@extends('dashboard.layouts.app')

@section('title')
    {{$lang->Scripts}}
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
                        <form class="ajaxForm dashboard_scripts" enctype="multipart/form-data" data-name="dashboard_scripts"
                              action="{{route('dashboard_scripts.post_data')}}" method="post">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <input id="id" name="id" class="cls" type="hidden">
                                <div class="row">
                                    <div class="form-group col-md-6 col-6">
                                        <label for="js">JS</label>
                                        <textarea rows="7" placeholder="JS" class="cls form-control" name="js" id="js"></textarea>
                                    </div>
                                    <div class="form-group col-md-6 col-6">
                                        <label for="css">CSS</label>
                                        <textarea rows="7" placeholder="CSS" class="cls form-control" name="css" id="css"></textarea>
                                    </div>
                                    <div class="form-group col-md-12 col-12">
                                        <label for="custom">Custom</label>
                                        <textarea rows="12" placeholder="Custom" class="cls form-control" name="custom" id="custom"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="button_action" id="button_action" value="insert">
                                <a href="{{route('dashboard_scripts.index')}}" class="btn btn-default">
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
                url: "{{ route('dashboard_scripts.get_data_by_id') }}",
                method: "get",
                data: {},
                dataType: "json",
                success: function (result) {
                    if (result.success != null) {
                        $('#id').val(result.success.id);
                        $('#js').val(result.success.js);
                        $('#driver').val(result.success.driver);
                        $('#host').val(result.success.host);
                        $('#port').val(result.success.port);
                        $('#encrption').val(result.success.encrption);
                        $('#css').val(result.success.css);
                        if(result.success.active == 1){
                            $('#active').attr("checked", "checked");
                        }
                    }
                }
            });
        };

    </script>


@endsection
