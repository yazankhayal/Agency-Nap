@extends('dashboard.layouts.app')

@section('title')
    {{$lang->Users}}
@endsection

@section('create_btn'){{route('dashboard_users.add_edit')}}@endsection
@section('create_btn_btn'){{$lang->Create}}@endsection

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
                                {{$lang->Users}}
                            </h3>
                            <button type="button" class="btn btn-dark ajax_delete_all">
                                SendAll
                            </button>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="form-group m-form__group">
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
                            <th>{{$lang->Avatar}}</th>
                            <th>{{$lang->Role}}</th>
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
        var array = [];
        $(document).ready(function () {

            var datatabe;

            "use strict";
            //Code here.
            var type = getUrlParameter('type');

            Render_Data(type);
            var name_form = $('.ajaxForm').data('name');

            $(document).on("click", ".PopUp", function () {
                $('#PopUp .modal-title').html($(this).attr("title"));
                $('.modal .title').html('انشاء مستخدم جديد');
                $("#PopUp").modal({show: true, backdrop: "static"});
            });

            $(document).on("click", ".btn_edit_current", function () {
                $('#PopUp .modal-title').html($(this).attr("title"));
                $("#PopUp").modal({show: true, backdrop: "static"});
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
                    url: "{{ route('dashboard_users.deleted') }}",
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

            $(document).on('click', '.btn_confirm_email_current', function () {
                var id = $(this).data("id");
                if (id) {
                    $('#data_Table tbody #' + id).css('background', 'hsla(64, 100%, 50%, 0.36)');
                }

                $.ajax({
                    url: "{{ route('dashboard_users.confirm_email') }}",
                    method: "get",
                    data: {
                        "id": id,
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.error != null) {
                            toastr.error(result.error, "@lang('table.confirm_email')");
                        } else {
                            toastr.success(result.success, "@lang('table.confirm_email')");
                        }
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


            $(document).on('click', '.btn_suspended_current', function () {
                var id = $(this).data("id");
                if (id) {
                    $('#data_Table tbody #' + id).css('background', 'hsla(64, 100%, 50%, 0.36)');
                }

                $.ajax({
                    url: "{{ route('dashboard_users.suspended') }}",
                    method: "get",
                    data: {
                        "id": id,
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.error != null) {
                            toastr.error(result.error);
                        } else {
                            toastr.success(result.success);
                        }
                        $('#data_Table').DataTable().ajax.reload();
                    }
                });
            });

        });

        var Render_Data = function (type) {
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
                "columnDefs": [{
                    "targets": [0],
                    "orderable": false
                }],
                "ajax": {
                    "url": "{{ route('dashboard_users.get_data') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{csrf_token()}}",
                        'type': type,
                    }
                },
                "columns": [
                    {"data": "id"},
                    {"data": "name"},
                    {"data": "email"},
                    {"data": "avatar"},
                    {"data": "role"},
                    {"data": "options"}
                ]
            });
        };

    </script>


@endsection
