@extends('dashboard.layouts.app')

@section('title')
    {{$lang->sort}}
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
                        <form class="ajaxForm dashboard_home_page" enctype="multipart/form-data"
                              data-name="dashboard_home_page"
                              action="{{route('dashboard_home_page.post_sort')}}" method="post">
                            {{csrf_field()}}
                            <div class="modal-body row">
                                <input id="id" name="id" class="cls" type="hidden">

                                @for($i = 1 ; $i < 11 ; $i++)

                                    @php
                                    $name ="";
                                    if($i == 1){
                                    $name = $lang->features_area;
                                    }
                                    else if($i == 2){
                                    $name = $lang->banner1;
                                    }
                                    else if($i == 3){
                                    $name = $lang->products1;
                                    }
                                    else if($i == 4){
                                    $name = $lang->ourproducts;
                                    }
                                    else if($i == 5){
                                    $name = $lang->products2;
                                    }
                                    else if($i == 6){
                                    $name = $lang->banner2;
                                    }
                                    else if($i == 7){
                                    $name = $lang->ourproducts2;
                                    }
                                    else if($i == 8){
                                    $name = $lang->logos;
                                    }
                                    else if($i == 9){
                                    $name = $lang->blog;
                                    }
                                    else if($i == 10){
                                    $name = $lang->instgram;
                                    }
                                    @endphp

                                    <div class="form-group col-md-3">
                                        <label for="sec_enable_{{$i}}">{{$name}}</label>
                                        <br/>
                                        <label class="custom-switch">
                                            <input type="checkbox" name="sec_enable_{{$i}}" id="sec_enable_{{$i}}"
                                                   class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span> <span
                                                    class="custom-switch-description">
                                                Active/Disable
                                            </span>
                                        </label>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="sec_sort_{{$i}}">{{$lang->sort}} {{$i}}</label>
                                        <input type="number" class="cls form-control" name="sec_sort_{{$i}}"
                                               id="sec_sort_{{$i}}">
                                    </div>
                                @endfor


                            </div>
                            <div class="modal-footer">
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
        $(document).ready(function () {
            "use strict";

            Render_Data();

        });

        var Render_Data = function () {
            $.ajax({
                url: "{{ route('dashboard_home_page.get_data_sort_by_id') }}",
                method: "get",
                data: {},
                dataType: "json",
                success: function (result) {
                    if (result.success != null) {
                        $('#id').val(result.success.id);

                        $('#sec_sort_1').val(result.success.sec_sort_1);
                        if(result.success.sec_enable_1 == 1){
                            $('#sec_enable_1').attr("checked","checked");
                        }

                        $('#sec_sort_2').val(result.success.sec_sort_2);
                        if(result.success.sec_enable_2 == 1){
                            $('#sec_enable_2').attr("checked","checked");
                        }

                        $('#sec_sort_3').val(result.success.sec_sort_3);
                        if(result.success.sec_enable_3 == 1){
                            $('#sec_enable_3').attr("checked","checked");
                        }

                        $('#sec_sort_4').val(result.success.sec_sort_4);
                        if(result.success.sec_enable_4 == 1){
                            $('#sec_enable_4').attr("checked","checked");
                        }

                        $('#sec_sort_5').val(result.success.sec_sort_5);
                        if(result.success.sec_enable_5 == 1){
                            $('#sec_enable_5').attr("checked","checked");
                        }

                        $('#sec_sort_6').val(result.success.sec_sort_6);
                        if(result.success.sec_enable_6 == 1){
                            $('#sec_enable_6').attr("checked","checked");
                        }

                        $('#sec_sort_7').val(result.success.sec_sort_7);
                        if(result.success.sec_enable_7 == 1){
                            $('#sec_enable_7').attr("checked","checked");
                        }

                        $('#sec_sort_8').val(result.success.sec_sort_8);
                        if(result.success.sec_enable_8 == 1){
                            $('#sec_enable_8').attr("checked","checked");
                        }

                        $('#sec_sort_9').val(result.success.sec_sort_9);
                        if(result.success.sec_enable_9 == 1){
                            $('#sec_enable_9').attr("checked","checked");
                        }
                        $('#sec_sort_10').val(result.success.sec_sort_10);
                        if(result.success.sec_enable_10 == 1){
                            $('#sec_enable_10').attr("checked","checked");
                        }
                        /*
                         $('#sec_sort_10').val(result.success.sec_sort_10);
                         $('#sec_enable_10').val(result.success.sec_enable_10);

                         $('#sec_sort_11').val(result.success.sec_sort_11);
                         $('#sec_enable_11').val(result.success.sec_enable_11);

                         $('#sec_sort_12').val(result.success.sec_sort_12);
                         $('#sec_enable_12').val(result.success.sec_enable_12);*/

                    }
                }
            });
        };

    </script>


@endsection
