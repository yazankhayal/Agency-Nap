@extends('dashboard.layouts.app')

@section('title')
    {{$lang->About}}
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
                                    <li class="nav-item get_content_language " data-id="{{$lang222->id}}">
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
                                <form class="ajaxForm dashboard_about" enctype="multipart/form-data"
                                      data-name="dashboard_about"
                                      action="{{route('dashboard_about.post_data')}}" method="post">
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        <input id="id" name="id" class="cls" type="hidden">
                                        <div class="form-group col-md-12">
                                            <label for="summary">{{$lang->Summary}}</label>
                                    <textarea rows="4" class="sumernote cls form-control" name="summary"
                                              id="summary" placeholder="{{$lang->Summary}}"></textarea>
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="link">{{$lang->Link}}</label>
                                            <input type="text" class="cls form-control" name="link" id="link" placeholder="{{$lang->Link}}">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="avatar1">{{$lang->Avatar}}</label>
                                            <input type="file" class="cls form-control" name="avatar1" id="avatar1">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <img style="width: 80px;height: 80px;"
                                                 class="img_usres avatar1_view d-none img-thumbnail">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="avatar2">{{$lang->Avatar}}2</label>
                                            <input type="file" class="cls form-control" name="avatar2" id="avatar2">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <img style="width: 80px;height: 80px;"
                                                 class="img_usres avatar2_view d-none img-thumbnail">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="button_action" id="button_action" value="insert">
                                        <a href="{{route('dashboard_about.index')}}" class="btn btn-default">
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
                                <form class="ajaxForm translate" data-name="translate"
                                      action="{{route('dashboard_about_translate.post_data')}}" method="post">
                                    <div class="modal-body row">
                                        {{csrf_field()}}

                                        <input id="id_translate_{{$lang222->id}}" name="id" type="hidden">
                                        <input id="language_id_{{$lang222->id}}" name="language_id" type="hidden"
                                               value="{{$lang222->id}}">
                                        <input id="hp_contents_id_{{$lang222->id}}" name="hp_contents_id" type="hidden">

                                        <div class="form-group col-md-12">
                                            <label for="summary_translate_{{$lang222->id}}">{{$lang->Summary}}</label>
                            <textarea rows="4" class="cls sumernote form-control" name="summary"
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

            Render_Data();

            $(document).on("click",".get_content_language",function(){
                var language_id = $(this).data("id");
                var id = $("#id").val();
                other(id,language_id);
                Render_Data();
            });

        });

        var other = function(x,y){
            $.ajax({
                url: "{{route('dashboard_about_translate.get_data_by_id')}}",
                method: "get",
                data: {
                    "id": x,
                    "language_id": y,
                },
                dataType: "json",
                success: function (result) {
                    if (result.success != null) {
                        $('#id_translate_' + result.success.language_id).val(result.success.id);
                        $('#language_id_' + result.success.language_id).val(result.success.language_id);
                        $('#hp_contents_id_' + result.success.language_id).val(result.success.hp_contents_id);
                        $('#summary_translate_' + result.success.language_id).summernote('code',result.success.summary);
                    }
                    else{
                        $('#hp_contents_id_'+y).val(x);
                        var r = '<h2 style="margin-right: 0px; margin-bottom: 10px; margin-left: 0px; font-family: Roboto, sans-serif; line-height: 1.3; color: rgb(102, 102, 102); font-size: 60px;">WHO’S<span style="font-size: 100px; font-weight: 700; color: rgb(57, 49, 133); line-height: 1; display: block;">Cozyincart</span></h2><h5 style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-family: Roboto, sans-serif; font-weight: 600; line-height: 1.3; color: rgb(69, 69, 69); font-size: 16px; border-bottom: 1px solid rgb(229, 229, 229);">FASHION DESIGN</h5><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; color: rgb(126, 126, 126); font-family: Roboto, sans-serif; font-size: 14px;">Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, fiant sollemnes in futurum.</p><h5 style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; font-family: Roboto, sans-serif; font-weight: 600; line-height: 1.3; color: rgb(69, 69, 69); font-size: 16px; border-bottom: 1px solid rgb(229, 229, 229);">LONDON ADDRESS</h5><p style="margin-right: 0px; margin-bottom: 15px; margin-left: 0px; color: rgb(126, 126, 126); font-family: Roboto, sans-serif; font-size: 14px;">34 Parer Place via Musk Avenue Kelvin Grove, QLD, 4059</p>';
                        $('#summary_translate_' + y).summernote('code',r);
                    }
                }
            });
        }

        var Render_Data = function () {
            $.ajax({
                url: "{{ route('dashboard_about.get_data_by_id') }}",
                method: "get",
                data: {},
                dataType: "json",
                success: function (result) {
                    if (result.success != null) {
                        $('#id').val(result.success.id);
                        $('#hp_contents_id').val(result.success.id);
                        $('#link').val(result.success.link);
                        $('.avatar1_view').removeClass('d-none');
                        $('.avatar1_view').attr('src', geturlphoto() + result.success.avatar1);
                        $('.avatar2_view').removeClass('d-none');
                        $('.avatar2_view').attr('src', geturlphoto() + result.success.avatar2);
                        $('#summary').summernote('code', result.success.summary);
                    }
                }
            });
        };

    </script>


@endsection
