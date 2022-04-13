@extends('dashboard.layouts.app')

@section('title')
    {{$lang_item->name}}
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
                        <div class="">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                       aria-controls="home" aria-selected="true">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#dashboard" role="tab"
                                       aria-controls="profile" aria-selected="false">Dashboard</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                     aria-labelledby="home-tab">
                                    <div class="alert-warning alert">
                                        <span>Change Home site language</span>
                                    </div>
                                    <form class="ajaxForm row users" enctype="multipart/form-data" data-name="users"
                                          action="{{route('dashboard_language.lang_post')}}" method="post">
                                        {{csrf_field()}}
                                        <input type="hidden" name="id" id="id" value="{{$lang_item->id}}">
                                        <input type="hidden" name="type_dashboard_or_site" id="type_dashboard_or_site" value="1">
                                        <div id="dynamic_field"></div>
                                        <hr>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-load">
                                                {{$lang->Submit}}
                                            </button>
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            <hr>
                                            <p>
                                                اضافة حقول اخرى
                                            </p>
                                            <div class="form-group">
                                                <div class="row">
                                                    <input id="add_more_lab_name" class="col-md-8 form-control" placeholder="اسم الحقل بالانجليزي">
                                                    <button type="button" class="col-md-2 btn btn-success" id="add_more_lab">
                                                        اضافة كلمات اخرى
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @if($lang_first != null)
                                            @foreach($lang_first as $key => $value)
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label for="{{$key}}">
                                                                    {{$key}}
                                                                </label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" id="{{$key}}"
                                                                       name="{{$key}}"
                                                                       placeholder="{{$key}}" value="{{$value}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="dashboard" role="tabpanel"
                                     aria-labelledby="dashboard-tab">
                                    <div class="alert-warning alert">
                                        <span>Change Dashboard language</span>
                                    </div>
                                    <form class="ajaxForm row users" enctype="multipart/form-data" data-name="users"
                                          action="{{route('dashboard_language.lang_post')}}" method="post">
                                        {{csrf_field()}}
                                        <input type="hidden" name="id" id="id" value="{{$lang_item->id}}">
                                        <input type="hidden" name="type_dashboard_or_site" id="type_dashboard_or_site" value="2">
                                        <div id="dynamic_field2"></div>
                                        <hr>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-load">
                                                {{$lang->Submit}}
                                            </button>
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            <hr>
                                            <p>
                                                اضافة حقول اخرى
                                            </p>
                                            <div class="form-group">
                                                <div class="row">
                                                    <input id="add_more_lab_name2" class="col-md-8 form-control" placeholder="اسم الحقل بالانجليزي">
                                                    <button type="button" class="col-md-2 btn btn-success" id="add_more_lab2">
                                                        اضافة كلمات اخرى
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @if($lang2 != null)
                                            @foreach($lang2 as $key => $value)
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <label for="{{$key}}">
                                                                    {{$key}}
                                                                </label>
                                                            </div>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" id="{{$key}}"
                                                                       name="{{$key}}"
                                                                       placeholder="{{$key}}" value="{{$value}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function(){

            var i=1;
            var english = /^[A-Za-z0-9-_]*$/;
            $('#add_more_lab').click(function(){
                var str = $("#add_more_lab_name").val();
                if(str === null || str === '')
                {
                    toastr.error("برجاء ادخال اسم");
                }
                else{
                    var className = $('.tab-content #home #' +str).attr('id');
                    console.log(className);
                    if(className != null){
                        toastr.error("برجاء تغير الاسم موجود مسبقا");
                    }
                    else{
                        i++;
                        i = str.split(/[ ,]+/).filter(function(v){return v!==''}).join('_')                            ;
                        $('#dynamic_field').append('<div id="row'+i+'" class="col-12"><div class="form-group"><div class="row"><div class="col-md-2"><label for="'+ i +'">'+ i +'</label></div><div class="col-md-10"><input type="text" class="form-control" id="'+ i +'" name="'+ i +'" placeholder="'+ i +'" value=""></div><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div></div>');
                        //$('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
                    }
                }
            });
            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
            });
        });
    </script>
    <script>
        $(document).ready(function(){

            var i=1;
            var english = /^[A-Za-z0-9-_]*$/;
            $('#add_more_lab2').click(function(){
                var str = $("#add_more_lab_name2").val();
                if(str === null || str === '')
                {
                    toastr.error("برجاء ادخال اسم");
                }
                else{
                    var className = $('.tab-content #dashboard #' +str).attr('id');
                    console.log(className);
                    if(className != null){
                        toastr.error("برجاء تغير الاسم موجود مسبقا");
                    }
                    else{
                        i++;
                        i = str.split(/[ ,]+/).filter(function(v){return v!==''}).join('_')
                        $('#dynamic_field2').append('<div id="row'+i+'" class="col-12"><div class="form-group"><div class="row"><div class="col-md-2"><label for="'+ i +'">'+ i +'</label></div><div class="col-md-10"><input type="text" class="form-control" id="'+ i +'" name="'+ i +'" placeholder="'+ i +'" value=""></div><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove2">X</button></div></div></div>');
                        //$('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
                    }
                }
            });
            $(document).on('click', '.btn_remove2', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
            });
        });
    </script>
@endsection