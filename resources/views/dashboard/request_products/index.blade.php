@extends('dashboard.layouts.app')

@section('title')
    {{$lang->Order}}
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
                                {{$lang->Order}}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="form-group m-form__group">
                        <table class="table data_Table table-bordered" id="data_Table">
                            <thead>
                            <th>{{$lang->ID}}</th>
                            <th>{{$lang->Date}}</th>
                            <th>{{$lang->transaction_id}}</th>
                            <th>{{$lang->esult}}</th>
                            <th>{{$lang->User}}</th>
                            <th>{{$lang->Type}}</th>
                            <th>{{$lang->Type}}</th>
                            <th>{{$lang->Option}}</th>
                            </thead>
                        </table>
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
                    <h4 class="modal-title">@lang('table.details')
                    </h4>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-12">
                        <ul class="list-group" id="res_de">

                        </ul>
                        <hr>
                        <div class="row" id="res_de2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        @lang('table.close')
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="ModEdit" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{$lang->Details}}
                    </h4>
                </div>
                <form class="ajaxForm edit" data-name="edit" action="{{route('dashboard_user_payment.edit')}}"
                      method="post">
                    <div class="modal-body row">
                        {{csrf_field()}}
                        <input id="id_current" name="id" type="hidden">
                        <div class="form-group col-12">
                            <label for="type">{{$lang->Type}}</label>
                            <select id="type" class="form-control" name="type">
                                <option value="">{{$lang->Type}}</option>
                                <option value="2">{{$lang->Processing}}</option>
                                <option value="3">{{$lang->Completed}}</option>
                                <option value="4">{{$lang->On_Hold}}</option>
                                <option value="5">{{$lang->Pending}}</option>
                                <option value="6">{{$lang->Canceled}}</option>
                            </select>
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
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {

            var datatabe;

            "use strict";
            //Code here.
            var type = getUrlParameter('type');

            Render_Data(type);
            var name_form = $('.ajaxForm').data('name');


            $(document).on('click', '.btn_edit_current', function () {
                var id = $(this).data("id");
                $('#ModEdit').modal('show');
                $('#id_current').val(id);
                if (id) {
                    $('#data_Table tbody tr').css('background', 'transparent');
                    $('#data_Table tbody #' + id).css('background', 'hsla(64, 100%, 50%, 0.36)');
                }
            });

            $(document).on('click', '.btn_eye', function () {
                var id = $(this).data("id");
                $.ajax({
                    url: "{{ route('dashboard_user_payment.details') }}",
                    method: "get",
                    data: {
                        "id": id,
                    },
                    dataType: "json",
                    success: function (result) {
                        if (result.success != null) {
                            $('#ModDelatils').modal('show');
                            $('#res_de').html('');
                            var lis_r2 = "";
                            var co = "No";
                            if(result.data.item.copuon){
                                co = result.data.item.copuon.name
                            }
                            if (result.success.type == "paypal") {
                                $('#res_de').html('' +
                                        '<li class="list-group-item">{{$lang->transaction_id}} : ' + result.data.item.pt_invoice_id + '</li>' +
                                        '<li class="list-group-item">{{$lang->transaction_id}} : ' + result.data.item.transaction_id + '</li>' +
                                        '<li class="list-group-item">{{$lang->User}} : ' + result.data.item.user.name + '</li>' +
                                        '<li class="list-group-item">{{$lang->Price}} : ' + result.data.paypal.e3 + '</li>' +
                                        '<li class="list-group-item">{{$lang->Email}} : ' + result.data.paypal.e2 + '</li>');
                            }
                            else {
                                $('#res_de').html('' +
                                        '<li class="list-group-item">{{$lang->Price}} : ' + result.data.item.amount + '</li>' +
                                        '<li class="list-group-item">{{$lang->transaction_id}} : ' + result.data.item.transaction_id + '</li>' +
                                        '<li class="list-group-item">{{$lang->User}} : ' + result.data.item.user.name + '</li>' +
                                '<li class="list-group-item">{{$lang->copuon}} : ' + co + '</li>');
                            }
                            if (result.data.carts_many.length) {
                                for (var i = 0; i < result.data.carts_many.length; i++) {
                                    var p = result.data.carts_many[i].products.price;
                                    if (result.data.carts_many[i].products.new_price != null) {
                                        p = result.data.carts_many[i].products.new_price;
                                    }
                                    var sizes = "";
                                    if(result.data.carts_many[i].sizes != null){
                                        var split2 = result.data.carts_many[i].sizes.split(",");
                                        var c11 = split2.length;
                                        if(c11 != 0){
                                            for (var j1 = 0 ; j1 < c11 ; j1++){
                                                var id = split2[j1];
                                                if(id){
                                                    sizes = sizes + id;
                                                }
                                            }
                                        }
                                    }
                                    var colors = "";
                                    if(result.data.carts_many[i].colors != null){
                                        var split22 = result.data.carts_many[i].colors.split(",");
                                        var c112 = split22.length;
                                        if(c112 != 0){
                                            for (var j21 = 0 ; j21 < c112 ; j21++){
                                                var id2 = split22[j21];
                                                if(id2){
                                                    colors = colors + '<p style="width: 27px;height:27px;border-radius: 100%;background: '+  id2 +'"></p>';
                                                }
                                            }
                                        }
                                    }
                                    var link = "{{url('/')}}/product/" + result.data.carts_many[i].products.id + "/" + result.data.carts_many[i].products.name;
                                    lis_r2 += '<div class="col-md-6"><div class="media">\n' +
                                            '  <a href="' + link + '" target="_blank"><img style="\n' +
                                            '    width: 100px;\n' +
                                            '    height: 100px;\n' +
                                            '" src="' + geturlphoto() + result.data.carts_many[i].products.avatar + '" class="mr-3" alt="..."></a>\n' +
                                            '  <div class="media-body">\n' +
                                            '    <h5 style="font-size: 11px;" class="mt-0">' + result.data.carts_many[i].products.name + '</h5>\n' +
                                            '    {{$lang->Qun}} X : ' + result.data.carts_many[i].qun +
                                            '    {{$lang->Price}} : ' + p + '{{$curenc_cooki->code}}' +
                                            '<br><span class="badge badge-dark">    Sizes : ' +  sizes +'</span>'+
                                            '<br>Color : ' + colors+
                                            '  </div>\n' +
                                            '</div></div>';
                                }
                                $('#res_de2').html(lis_r2);
                            }
                        }
                    }
                });
            });

        });

        var Render_Data = function (type) {
            datatabe = $('#data_Table').DataTable({
                "language": {
                    aria: {
                        sortAscending: "@lang('table.datatables.sortAscending')",
                        sortDescending: "@lang('table.datatables.sortDescending')"
                    }
                    ,
                    emptyTable: "@lang('table.datatables.emptyTable')",
                    info: "@lang('table.datatables.info')",
                    infoEmpty: "@lang('table.datatables.emptyTable')",
                    infoFiltered: "@lang('table.datatables.infoFiltered')",
                    lengthMenu: "_MENU_",
                    search: "@lang('table.datatables.search')",
                    zeroRecords: "@lang('table.datatables.emptyTable')",
                    paginate: {
                        sFirst: "@lang('table.datatables.paginate.sFirst')",
                        sLast: "@lang('table.datatables.paginate.sFirst')",
                        sNext: "@lang('table.datatables.paginate.sNext')",
                        sPrevious: "@lang('table.datatables.paginate.sNext')"
                    }
                },
                "processing": true,
                "serverSide": true,
                "bStateSave": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', aData['id']);
                },
                "ajax": {
                    "url": "{{ route('dashboard_user_payment.get_data') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {
                        _token: "{{csrf_token()}}",
                        "type" : type,
                    }
                },
                "columns": [
                    {"data": "id"},
                    {"data": "created_at"},
                    {"data": "transaction_id"},
                    {"data": "result"},
                    {"data": "ip"},
                    {"data": "type"},
                    {"data": "type_order"},
                    {"data": "options"}
                ]
            });
        };

    </script>
@endsection
