@extends('dashboard.layouts.app')

@section('title')
    {{$lang->Dashboard}}
@endsection

@section('content')

    <div class="row row-cards">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card">
                <div class="card-body text-center"><i
                            class="fa fa-shopping-cart text-primary fa-3x text-primary-shadow"></i>
                    <h6 class="mt-4 mb-2">Total Products</h6>
                    <h2 class="mb-2 number-font">{{$c_1}}</h2>
                </div>
            </div>
        </div><!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card">
                <div class="card-body text-center"><i
                            class="fa fa-thumb-tack text-secondary fa-3x text-secondary-shadow"></i>
                    <h6 class="mt-4 mb-2">Total Cateogry</h6>
                    <h2 class="mb-2  number-font">{{$c_2}}</h2>
                </div>
            </div>
        </div><!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card">
                <div class="card-body text-center"><i
                            class="fa fa-users text-success fa-3x text-success-shadow"></i> <h6 class="mt-4 mb-2">
                        Total User</h6>
                    <h2 class="mb-2 number-font">{{$c_3}}</h2>
                </div>
            </div>
        </div><!-- COL END -->
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
            <div class="card">
                <div class="card-body text-center"><i class="fa fa-folder text-info fa-3x text-info-shadow"></i> <h6
                            class="mt-4 mb-2">Total Posts</h6>
                    <h2 class="mb-2 number-font">{{$c_4}}</h2>
                </div>
            </div>
        </div><!-- COL END --> </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="m-portlet m-portlet--tab">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
							<span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
							</span>
                                    <h3 class="m-portlet__head-text">
                                        {{$lang->Order}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group">
                                <button type="button" class="btn btn-dark ajax_delete_all">
                                    SendAll
                                </button>
                                <table class="table data_Table table-bordered" id="data_Table">
                                    <thead>
                                    <th>
                                        <label>
                                            <input type="checkbox" class="btn_select_all">
                                            {{$lang->CheckAll}}
                                        </label>
                                    </th>
                                    <th>{{$lang->Name}}</th>
                                    <th>{{$lang->Email}}</th>
                                    <th>{{$lang->Phone}}</th>
                                    <th>{{$lang->Products}}</th>
                                    <th>{{$lang->Option}}</th>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModDelatils" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{$lang->Details}}
                    </h4>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-12">
                        <ul class="list-group" id="res_de">

                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        {{$lang->Close}}
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

@endsection

@section('js')

    <script type="text/javascript">
        var array = [];
        $(document).ready(function () {

            var datatabe;

            "use strict";
            //Code here.
            Render_Data();
            var name_form = $('.ajaxForm').data('name');

            $(document).on('click', '.btn_eye', function () {
                var id = $(this).data("id");
                $.ajax({
                    url: "{{ route('dashboard_order.details') }}",
                    method: "get",
                    data: {
                        "id": id,
                    },
                    dataType: "json",
                    success: function (result) {
                        if(result.success != null){
                            $('#ModDelatils').modal('show');
                            $('#res_de').html('');
                            $('#res_de').html('' +
                                '<li class="list-group-item">{{$lang->f_name}} : '+ result.success.f_name +'</li>' +
                                '<li class="list-group-item">{{$lang->l_name}} : '+ result.success.l_name +'</li>' +
                                '<li class="list-group-item">{{$lang->Email}} : '+ result.success.email +'</li>' +
                                '<li class="list-group-item">{{$lang->Phone}} : '+ result.success.phone +'</li>' +
                                '<li class="list-group-item">{{$lang->Summary}} : '+ result.success.summary +'</li>');
                        }
                    }
                });
            });

            $(document).on('click', '.btn_delete_current', function () {
                var id = $(this).data("id");
                $('#ModDelete').modal('show');
                $('#iddel').val(id);
                if (id) {
                    $('#data_Table tbody tr').css('background', 'transparent');
                    $('#data_Table tbody #' + id).css('background', 'hsla(64, 100%, 50%, 0.36)');
                }
            });

            $('.btn_deleted').on("click", function () {
                var id = $('#iddel').val();
                $.ajax({
                    url: "{{ route('dashboard_order.deleted') }}",
                    method: "get",
                    data: {
                        "id": id,
                    },
                    dataType: "json",
                    success: function (result) {
                        toastr.error(result.error);
                        $('.modal').modal('hide');
                        $('#data_Table').DataTable().ajax.reload();
                    }
                });
            });

            $(document).on('click', '.ajax_delete_all', function () {
                window.location.href = "/dashboard/send_email?emails=" + array;
            });

            $(document).on('click', '.btn_select_all', function () {
                array = [];
                $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
                $('.btn_select_btn_deleted').each(function (index, value) {
                    var id = $(value).data("id");
                    var status = $(value).prop("checked");
                    if(status == true){
                        array.push(id);
                    }
                    else{
                        var index2 = array.indexOf(id);
                        if (index2 > -1) {
                            array.splice(index2, 1);
                        }
                    }
                });
            });

            $(document).on('click', '.btn_select_btn_deleted', function () {
                var id = $(this).data("id");
                var status = $(this).prop("checked");
                var numberOfChecked = $('input:checkbox:checked').length;
                var numberOftext = $('.btn_select_btn_deleted').length;
                if(status == true){
                    array.push(id);
                }
                else{
                    var index = array.indexOf(id);
                    if (index > -1) {
                        array.splice(index, 1);
                    }
                }
                if(numberOftext != array.length){
                    $(".btn_select_all").prop('checked',false);
                }
                if(numberOftext == array.length){
                    $(".btn_select_all").prop('checked',$(this).prop('checked'));
                }
            });

        });

        var Render_Data = function () {
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
                "columnDefs": [{
                    "targets": [0],
                    "orderable": false
                }],
                "processing": true,
                "serverSide": true,
                "bStateSave": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', aData['id']);
                },
                "ajax": {
                    "url": "{{ route('dashboard_order.get_data') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{csrf_token()}}",
                    }
                },
                "columns": [
                    {"data": "id"},
                    {"data": "name"},
                    {"data": "email"},
                    {"data": "phone"},
                    {"data": "product_id"},
                    {"data": "options"}
                ]
            });
        };

    </script>

@endsection
