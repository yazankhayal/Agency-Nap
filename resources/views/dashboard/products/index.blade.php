@extends('dashboard.layouts.app')

@section('title')
    {{$lang->Products}}
@endsection

@section('create_btn'){{route('dashboard_products.add_edit')}}@endsection
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

    <div class="modal fade" id="ModRating" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">{{$lang->Rating}}
                    </h4>
                </div>
                <form class="ajaxForm post_data_rating" data-name="post_data_rating"
                      action="{{route('dashboard_products.post_data_rating')}}" method="post">
                    <div class="modal-body row">
                        {{csrf_field()}}
                        <input id="products_id_rating" name="products_id_rating" type="hidden">
                        <div class="form-group col-12">
                            <label for="rating">{{$lang->Rating}}</label>
                            <select type="text" class="cls form-control" name="rating" id="rating">
                                <option value="">{{$lang->Rating}}</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="form-group col-12">
                            <label for="rating">{{$lang->Summary}}</label>
                            <textarea rows="4" class="cls form-control" name="text" id="text"></textarea>
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
        var ary_data_amen = '[]';
        $(document).ready(function () {

            var datatabe;

            "use strict";
            //Code here.
            Render_Data();

            var name_form = $('.ajaxForm').data('name');

            $(document).on('click', '.btn_delete_current', function () {
                var id = $(this).data("id");
                $('#ModDelete').modal('show');
                $('#iddel').val(id);
                if (id) {
                    $('#data_Table tbody tr').css('background', 'transparent');
                    $('#data_Table tbody #' + id).css('background', 'hsla(64, 100%, 50%, 0.36)');
                }
            });

            $(document).on('click', '.btn_rating', function () {
                var id = $(this).data("id");
                if (id) {
                    $('#data_Table tbody tr').css('background', 'transparent');
                    $('#data_Table tbody #' + id).css('background', 'hsla(64, 100%, 50%, 0.36)');
                }
                $.ajax({
                    url:"{{route('dashboard_products.get_data_by_id')}}",
                    method:"get",
                    data : {
                        "id" : id,
                    },
                    dataType:"json",
                    success:function(result)
                    {
                        if(result.success != null){
                            $('#ModRating').modal('show');
                            $('#products_id_rating').val(id);
                            if(result.success.review != null){
                                $('#text').val(result.success.review.text);
                                $('#rating').val(result.success.review.star);
                            }
                            else{
                                $('#text').val('');
                                $('#rating').val('');
                            }
                        }
                    }
                });
            });

            $(document).on('click', '.btn_copy', function () {
                var id = $(this).data("id");
                if (id) {
                    $('#data_Table tbody tr').css('background', 'transparent');
                    $('#data_Table tbody #' + id).css('background', 'hsla(64, 100%, 50%, 0.36)');
                }
                $.ajax({
                    url:"{{route('dashboard_products.copy')}}",
                    method:"get",
                    data : {
                        "id" : id,
                    },
                    dataType:"json",
                    success:function(result)
                    {
                        if(result.success != null){
                            toastr.success(result.success);
                            $('#data_Table').DataTable().ajax.reload();
                        }
                        else{
                            toastr.error(result.error);
                        }
                    }
                });
            });

            $('.btn_deleted').on("click", function () {
                var id = $('#iddel').val();
                $.ajax({
                    url: "{{ route('dashboard_products.deleted') }}",
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
                "processing": true,
                "serverSide": true,
                "bStateSave": true,
                "fnCreatedRow": function (nRow, aData, iDataIndex) {
                    $(nRow).attr('id', aData['id']);
                },
                "ajax": {
                    "url": "{{ route('dashboard_products.get_data') }}",
                    "dataType": "json",
                    "type": "post",
                    "data": {
                        _token: "{{csrf_token()}}",
                        'filter_role': $('#filter_role').val(),
                    }
                },
                "columns": [
                    {"data": "id"},
                    {"data": "name"},
                    {"data": "avatar"},
                    {"data": "language"},
                    {"data": "options"}
                ]
            });
        };

    </script>


@endsection
