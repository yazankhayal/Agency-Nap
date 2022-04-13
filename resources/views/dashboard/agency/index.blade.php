@extends('dashboard.layouts.app')

@section('title')
    {{$lang->agency}}
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
                                <form class="ajaxForm dashboard_agency" enctype="multipart/form-data"
                                      data-name="dashboard_agency"
                                      action="{{route('dashboard_agency.post_data')}}" method="post">
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        <input id="id" name="id" class="cls" type="hidden">

                                        <div class="form-group col-12">
                                            <label for="name">{{$lang->Name}}</label>
                                            <input type="text" class="cls form-control" name="name" id="name" placeholder="{{$lang->Name}}">
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="sub_name">{{$lang->Sub_Name}}</label>
                                            <input type="text" class="cls form-control" name="sub_name" id="sub_name"
                                                   placeholder="{{$lang->Sub_Name}}">
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="summary">{{$lang->Summary}} 1</label>
                                            <textarea rows="4" class=" cls sumernote form-control" name="summary"
                                                      id="summary" placeholder="{{$lang->Summary}} 1"></textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="sub_summary">{{$lang->Mission}}</label>
                                            <textarea rows="4" class=" cls sumernote form-control" name="sub_summary"
                                                      id="sub_summary" placeholder="{{$lang->Mission}}"></textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="summary1">{{$lang->Vision}}</label>
                                            <textarea rows="4" class=" cls sumernote form-control" name="summary1"
                                                      id="summary1" placeholder="{{$lang->Vision}}"></textarea>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="sub_summary2">{{$lang->History}}</label>
                                            <textarea rows="4" class=" cls sumernote form-control" name="sub_summary2"
                                                      id="sub_summary2" placeholder="{{$lang->History}}"></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="summary3">{{$lang->Summary}} 2</label>
                                            <textarea rows="4" class=" cls sumernote form-control" name="summary3"
                                                      id="summary3" placeholder="{{$lang->Summary}} 2"></textarea>
                                        </div>

                                        <div class="form-group col-6">
                                            <label for="avatar">{{$lang->Avatar}}</label>
                                            <input type="file" class="cls form-control" name="avatar1" id="avatar1">
                                        </div>
                                        <div class="form-group col-6">
                                            <img class="img_usres avatar_view d-none img-thumbnail">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="button_action" id="button_action" value="insert">
                                        <a href="{{route('dashboard_agency.index')}}" class="btn btn-default">
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
                                              action="{{route('dashboard_agency_translate.post_data')}}" method="post">
                                            <div class="modal-body row">
                                                {{csrf_field()}}

                                                <input id="id_translate_{{$lang222->id}}" name="id" type="hidden">
                                                <input id="language_id_{{$lang222->id}}" name="language_id" type="hidden"
                                                       value="{{$lang222->id}}">
                                                <input id="hp_contents_id_{{$lang222->id}}" name="hp_contents_id" type="hidden">

                                                <div class="form-group col-12">
                                                    <label for="name_translate_{{$lang222->id}}">{{$lang->Name}}</label>
                                                    <input type="text" class="cls form-control" name="name" id="name_translate_{{$lang222->id}}" placeholder="{{$lang->Name}}">
                                                </div>

                                                <div class="form-group col-12">
                                                    <label for="sub_name_translate_{{$lang222->id}}">{{$lang->Sub_Name}}</label>
                                                    <input type="text" class="cls form-control" name="sub_name" id="sub_name_translate_{{$lang222->id}}"
                                                           placeholder="{{$lang->Sub_Name}}">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="summary_translate_{{$lang222->id}}">{{$lang->Summary}}</label>
                                                    <textarea rows="4" class="cls sumernote form-control" name="summary"
                                                              id="summary_translate_{{$lang222->id}}" placeholder="{{$lang->Summary}}"></textarea>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="sub_summary_translate_{{$lang222->id}}">{{$lang->Mission}}</label>
                                                    <textarea rows="4" class=" cls sumernote form-control" name="sub_summary"
                                                              id="sub_summary_translate_{{$lang222->id}}" placeholder="{{$lang->Mission}}"></textarea>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="summary1_translate_{{$lang222->id}}">{{$lang->Vision}}</label>
                                                    <textarea rows="4" class=" cls sumernote form-control" name="summary1"
                                                              id="summary1_translate_{{$lang222->id}}" placeholder="{{$lang->Vision}}"></textarea>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="sub_summary2_translate_{{$lang222->id}}">{{$lang->History}}</label>
                                                    <textarea rows="4" class=" cls sumernote form-control" name="sub_summary2"
                                                              id="sub_summary2_translate_{{$lang222->id}}" placeholder="{{$lang->History}}"></textarea>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label for="summary3_translate_{{$lang222->id}}">{{$lang->Summary}} 2</label>
                                                    <textarea rows="4" class=" cls sumernote form-control" name="summary3"
                                                              id="summary3_translate_{{$lang222->id}}" placeholder="{{$lang->Summary}} 2"></textarea>
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
                url: "{{route('dashboard_agency_translate.get_data_by_id')}}",
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
                        $('#name_translate_' + result.success.language_id).val(result.success.name);
                        $('#sub_name_translate_' + result.success.language_id).val(result.success.sub_name);
                        $('#summary_translate_' + result.success.language_id).summernote('code',result.success.summary);
                        $('#summary1_translate_' + result.success.language_id).summernote('code',result.success.summary1);
                        $('#summary2_translate_' + result.success.language_id).summernote('code',result.success.summary2);
                        $('#summary3_translate_' + result.success.language_id).summernote('code',result.success.summary3);
                        $('#sub_summary_translate_' + result.success.language_id).summernote('code',result.success.sub_summary);
                        $('#sub_summary2_translate_' + result.success.language_id).summernote('code',result.success.sub_summary2);
                    }
                    else{
                        $('#hp_contents_id_'+y).val(x);
                        $('#summary_translate_' + y).summernote('code','');
                    }
                }
            });
        }

        var Render_Data = function () {
            $.ajax({
                url: "{{ route('dashboard_agency.get_data_by_id') }}",
                method: "get",
                data: {},
                dataType: "json",
                success: function (result) {
                    if (result.success != null) {
                        $('#id').val(result.success.id);
                        $('#name').val(result.success.name);
                        $('#sub_name').val(result.success.sub_name);
                        $('#video').val(result.success.video);
                        $('#link').val(result.success.link);
                        $('#summary').summernote('code', result.success.summary);
                        $('#summary1').summernote('code', result.success.summary1);
                        $('#summary3').summernote('code', result.success.summary3);
                        $('#summary2').summernote('code', result.success.summary2);
                        $('#sub_summary').summernote('code', result.success.sub_summary);
                        $('#sub_summary2').summernote('code', result.success.sub_summary2);
                        $('.avatar_view').removeClass('d-none');
                        $('.avatar_view').attr('src', geturlphoto() + result.success.avatar1);
                    }
                }
            });
        };

    </script>
@endsection
