@extends('dashboard.layouts.app')

@section('title')
    {{$lang->City}}
@endsection

@section('create_btn'){{route('dashboard_city.add_edit')}}@endsection
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
                            <th>{{$lang->Primary}}</th>
                            <th>{{$lang->Option}}</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ModNewMore" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"> {{$lang->Add_new_language}}
                    </h4>
                </div>
                <form class="ajaxForm translate" data-name="translate" action="{{route('dashboard_city_translate.post_data')}}" method="post">
                    <div class="modal-body row">
                        {{csrf_field()}}
                        <input id="id_current" name="id" type="hidden">
                        <input id="city_id" name="city_id" type="hidden">
                        <div class="form-group col-12">
                            <label for="name">{{$lang->Name}}</label>
                            <input type="text" class="cls form-control" name="name" id="name" placeholder="{{$lang->Name}}">
                        </div>
                        <div class="form-group col-12">
                            <label for="language_id">{{$lang->Name_Language}}</label>
                            <select class="cls form-control" name="language_id" id="language_id">

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
        $(document).ready(function() {

            var datatabe ;

            "use strict";
            //Code here.
            Render_Data();
            languages();
            var name_form = $('.ajaxForm').data('name');

            $(document).on('click', '.btn_delete_current', function () {
                var id = $(this).data("id");
                $('#ModDelete').modal('show');
                $('#iddel').val(id);
                if(id){
                    $('#data_Table tbody tr').css('background','transparent');
                    $('#data_Table tbody #' + id).css('background','hsla(64, 100%, 50%, 0.36)');
                }
            });

            $(document).on('click', '.btn_add_lan', function () {
                var id = $(this).data("id");
                $('#name').val('');
                $('#language_id').val('');
                $('#id_current').val('');
                $('#ModNewMore').modal('show');
                $('#city_id').val(id);
                $('.error').remove();
                $('.form-control').removeClass('border-danger');
                $('.note-image-popover').css("display",'block');
                $('.note-link-popover').css("display",'block');
                $('.note-table-popover').css("display",'block');
            });


            $(document).on('click', '.btn_edit_lan', function () {
                var id = $(this).data("id");
                $('#ModNewMore').modal('show');
                $('#ModNewMore .modal-title').html("{{$lang->Edit_new_language}}");
                $('#city_id').val(id);
                $('.error').remove();
                $('.form-control').removeClass('border-danger');
                $.ajax({
                    url:"{{route('dashboard_city_translate.get_data_by_id')}}",
                    method:"get",
                    data : {
                        "id" : id,
                    },
                    dataType:"json",
                    success:function(result)
                    {
                        if(result.success != null){
                            $('#id_current').val(result.success.id);
                            $('#name').val(result.success.name);
                            $('#city_id').val(result.success.city_id);
                            $('#language_id').val(result.success.language_id);
                        }
                    }
                });
            });

            $('.btn_deleted').on("click",function () {
                var id = $('#iddel').val();
                $.ajax({
                    url:"{{ route('dashboard_city.deleted') }}",
                    method:"get",
                    data : {
                        "id" : id,
                    },
                    dataType:"json",
                    success:function(result)
                    {
                        toastr.error(result.error);
                        $('.modal').modal('hide');
                        $('#data_Table').DataTable().ajax.reload();
                    }
                });
            });

        });


        var languages = function (update = 0) {
            $.ajax({
                url: "{{ route('dashboard_admin.languages_exption_em') }}",
                method: "get",
                data: {},
                dataType: "json",
                success: function (result) {
                    $('#language_id').html('<option value="">{{$lang->Name_Language}}</option>');
                    if (result.data.length) {
                        for (var i = 0; i < result.data.length; i++) {
                            $('#language_id').append('<option value="' + result.data[i].id + '">' + result.data[i].name + '</option>');
                        }
                    }
                }
            });
        };

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
                "processing": true,
                "serverSide": true,
                "bStateSave": true,
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('id', aData['id']);
                },
                "ajax":{
                    "url": "{{ route('dashboard_city.get_data') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{
                        _token: "{{csrf_token()}}",
                        'filter_role' : $('#filter_role').val(),
                    }
                },
                "columns": [
                    { "data": "id" },
                    { "data": "name" },
                    { "data": "language" },
                    { "data": "options" }
                ]
            });
        };

    </script>


@endsection
