@extends('dashboard.layouts.app')

@section('title')
    {{$lang->our_trending_products}} 6
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
                        <form id="form_sarach">
                            <div class="form-group">
                                <label for="name">{{$lang->Category_Services}}</label>
                                <select class="cls form-control" id="txt_cat">
                                    @if($category_id->count() != 0)
                                        @foreach($category_id as $item)
                                            <option value="{{$item->id}}">{{$item->name()}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <table class="table data_Table table-bordered" id="data_Table">
                            <thead>
                            <th>{{$lang->ID}}</th>
                            <th>{{$lang->Name}}</th>
                            <th>{{$lang->Avatar}}</th>
                            <th>{{$lang->Option}}</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        var ary_data_amen = '[]';
        $(document).ready(function () {

            var datatabe;

            $(document).on('submit', '#form_sarach', function (event) {
                event.preventDefault(); //prevent default action
                var va = $("#txt_cat").val();
                $.ajax({
                    url: "{{ route('dashboard_home_page.save_cat') }}",
                    method: "get",
                    data: {
                        "id": va,
                        "type": 6,
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.error != null) {
                            toastr.error(result.error);
                        }
                        else {
                            toastr.success(result.success);
                        }
                    }
                });
                $('#data_Table').dataTable().fnClearTable();
                $('#data_Table').dataTable().fnDestroy();
                Render_Data(va);
            });

            "use strict";
            //Code here.
            // Render_Data();

            $(document).on('click', '.btn_featured', function () {
                var id = $(this).data("id");
                if (id) {
                    $('#data_Table tbody #' + id).css('background', 'hsla(64, 100%, 50%, 0.36)');
                }
                $.ajax({
                    url: "{{ route('dashboard_home_page.save_pro') }}",
                    method: "get",
                    data: {
                        "id": id,
                        "type": 6,
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.error != null) {
                            toastr.error(result.error);
                        }
                        else {
                            toastr.success(result.success);
                        }
                        $('#data_Table').DataTable().ajax.reload();
                    }
                });
            });

        });

        var Render_Data = function (cat_id) {
            datatabe = $('#data_Table').DataTable({
                "language": {
                    aria: {
                        sortAscending: "{{$lang->sortAscending}}",
                        sortDescending: "{{$lang->sortDescending}}"
                    }
                    ,
                    emptyTable: "{{$lang->emptyTable}}",
                    info: "{{$lang->info}}",
                    infoEmpty: "{{$lang->emptyTable}}",
                    infoFiltered: "{{$lang->infoFiltered}}",
                    lengthMenu: "_MENU_",
                    search: "{{$lang->search}}",
                    zeroRecords: "{{$lang->emptyTable}}",
                    paginate: {
                        sFirst: "{{$lang->paginate_sFirst}}",
                        sLast: "{{$lang->paginate_sLast}}",
                        sNext: "{{$lang->paginate_sNext}}",
                        sPrevious: "{{$lang->paginate_sPrevious}}",
                    }
                },
                "processing": true,
                "serverSide": true,
                "bStateSave": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', aData['id']);
                },
                "ajax": {
                    "url": "{{ route('dashboard_home_page.get_products') }}",
                    "dataType": "json",
                    "type": "post",
                    "data": {
                        _token: "{{csrf_token()}}",
                        'type':"f6",
                        'cat_id':cat_id,
                    }
                },
                "columns": [
                    {"data": "id"},
                    {"data": "name"},
                    {"data": "avatar"},
                    {"data": "options"}
                ]
            });
        };

    </script>


@endsection
