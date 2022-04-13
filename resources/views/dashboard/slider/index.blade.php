@extends('dashboard.layouts.app')

@section('title')
    {{$lang->Slider}}
@endsection

@section('css')
@endsection

@section('create_btn'){{route('dashboard_slider.add_edit')}}@endsection
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
                            <th>{{$lang->Avatar}}</th>
                            <th>{{$lang->Primary}}</th>
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
        $(document).ready(function() {

            var datatabe ;

            "use strict";
            //Code here.
            Render_Data();

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
                $('#hp_contents_id').val(id);
                $('.error').remove();
                $('.form-control').removeClass('border-danger');
                $('.note-image-popover').css("display",'block');
                $('.note-link-popover').css("display",'block');
                $('.note-table-popover').css("display",'block');
            });

            $('.btn_deleted').on("click",function () {
                var id = $('#iddel').val();
                $.ajax({
                    url:"{{ route('dashboard_slider.deleted') }}",
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

        var Render_Data = function () {
            datatabe = $('#data_Table').DataTable({
                "language": {
                    aria: {
                        sortAscending: "@lang('table.datatables.sortAscending')", sortDescending: "@lang('table.datatables.sortDescending')"
                    }
                    , emptyTable: "@lang('table.datatables.emptyTable')", info: "@lang('table.datatables.info')",
                    infoEmpty: "@lang('table.datatables.emptyTable')",
                    infoFiltered: "@lang('table.datatables.infoFiltered')",
                    lengthMenu: "_MENU_", search: "@lang('table.datatables.search')", zeroRecords: "@lang('table.datatables.emptyTable')",
                    paginate: { sFirst: "@lang('table.datatables.paginate.sFirst')", sLast: "@lang('table.datatables.paginate.sFirst')", sNext: "@lang('table.datatables.paginate.sNext')", sPrevious: "@lang('table.datatables.paginate.sPrevious')" }
                },
                "processing": true,
                "serverSide": true,
                "bStateSave": true,
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('id', aData['id']);
                },
                "ajax":{
                    "url": "{{ route('dashboard_slider.get_data') }}",
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
                    { "data": "avatar" },
                    { "data": "language" },
                    { "data": "options" }
                ]
            });
        };

    </script>


@endsection
