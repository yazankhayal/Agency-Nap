@extends('dashboard.layouts.app')

@section('title')
   {{$lang->Partners}}
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
    <style>
        .dz-remove {
            display: inline-block !important;
            width: 1.2em;
            height: 1.2em;

            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 1000;

            font-size: 1.5em !important;
            line-height: 1em;

            text-align: center;
            font-weight: bold;
            border: 1px solid gray !important;
            border-radius: 1.2em;
            color: #fff;
            background-color: red;
            opacity: .7;

        }

        .dz-remove:hover {
            text-decoration: none !important;
            opacity: 1;
        }
    </style>
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
                        <div class="modal-header">
                            <h5 class="modal-title title_info"></h5>
                        </div>
                        <div style="margin: 10px 0;">
                            <div id="render_gallery" class="d-none row">

                            </div>
                        </div>
                        <form class="ajaxForm certificate_file dropzone" id="dropzone" enctype="multipart/form-data"
                              data-name="certificate_file" action="{{route('dashboard_partners.certificate_file')}}"
                              method="post">
                            {{csrf_field()}}
                            <div class="modal-body row">
                                <input id="id_file" name="id" class="cls" type="hidden">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js"></script>
    <script>

        Array.prototype.remove = function () {
            var what, a = arguments, L = a.length, ax;
            while (L && this.length) {
                what = a[--L];
                while ((ax = this.indexOf(what)) !== -1) {
                    this.splice(ax, 1);
                }
            }
            return this;
        };

        var ary = [];

        $(function () {
            'use strict';

            $('#fileupload').ajaxForm({
                beforeSend: function () {
                    $('.percent').width('0%').html('0%');
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    $('.percent').width(percentComplete + '%').html(percentComplete + '%');
                },
                success: function (data) {
                    $('.percent').width('100%').html('100%');
                    ary.push(data);
                    loo();
                },
                error: function (xhr) {
                    $('.percent').width('0%').html('0%');
                },
                complete: function (xhr) {
                    $('.percent').width('0%').html('0%');
                    $('#fileupload #img').val('');
                }
            });

            $(document).on('click', '.btnremove', function () {
                var id = $(this).data("id");
                var id2 = id.substr(8);
                $.ajax({
                    url: "{{ route('dashboard_partners.file_deleted') }}" + "/" + id2,
                    method: 'get',
                    data: {},
                    success: function (result) {
                        if (result.success != "") {
                            toastr.success(result.success);
                            ary.shift(result.name);
                            loo();
                        }
                    }
                });
            });

        });

        var loo = function () {
            var st = '';
            for (var i = 0; i < ary.length; i++) {
                st += ',' + ary[i].data;
            }
            $('#gallery').val(st);
        };

    </script>
    <script type="text/javascript">
        Dropzone.options.dropzone =
            {
                maxFilesize: 122,
                renameFile: function (file) {
                    var dt = new Date();
                    var time = dt.getTime();
                    return time + file.name;
                },
                removedfile: function (file) {
                    var name = file.upload.filename;
                    $.ajax({
                        url: "{{ route('dashboard_partners.file_deleted') }}",
                        method: 'get',
                        data: {filename: name},
                        success: function (result) {
                            toastr.success('Dond deleted photo');
                            ary.shift(result);
                            loo();
                        }
                    });
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
                },
                acceptedFiles: ".jpeg,.jpg,.png,.gif",
                addRemoveLinks: true,
                dictRemoveFile: "×",
                timeout: 5000,
                success: function (file, response) {
                    ary.push(response);
                    loo();
                },
                error: function (file, response) {
                    return false;
                }
            };
    </script>
    <script type="text/javascript">
        $(document).ready(function () {

            "use strict";
            //Code here.

            gallery();

            $(document).on('click', '.btn_remove_hidden', function () {
                $('.div_result_img').addClass('hidden');
                $('.div_result_img img').attr('src', '');
            });

            $(document).on('click', '.review_img', function () {
                var img = $(this).data("img");
                $('.div_result_img').removeClass('hidden');
                $('.div_result_img img').attr('src', img);
            });

            $(document).on('click', '.btn_remove_gallery', function () {
                var id = $(this).data("id");
                $.ajax({
                    url: "{{ route('dashboard_partners.file_deleted_by_id') }}" + "/" + id,
                    method: 'get',
                    data: {},
                    success: function (result) {
                        if (result.success != "") {
                            toastr.success(result.success);
                            gallery();
                        }
                    }
                });
            });

        });


        var gallery = function () {
            $.ajax({
                url: "{{ route('dashboard_partners.attachments') }}" ,
                method: "get",
                data : {
                },
                dataType: "json",
                success: function (result) {
                    $('#render_gallery').html('');
                    $('#render_gallery').removeClass('d-none');
                    for (var i = 0; i < result.data.length; i++) {
                        var image = result.data[i].avatar;
                        var id = result.data[i].id;
                        var r = '<div class="col-md-3" style="margin-bottom: 20px;"><div class="card">\n' +
                            '<img data-img="' + geturlphoto() + 'upload/partners/' + image + '" style="width: 100%;80px;" src="' + geturlphoto() + 'upload/partners/' + image + '" class="card-img-top" alt="...">\n' +
                            '  <div class="card-body">\n' +
                            '    <button type="button" data-id="' + id + '" class="btn_remove_gallery btn btn-primary"><i class="fa fa-trash"></i></button>\n' +
                            '  </div>\n' +
                            '</div></div>';
                        $('#render_gallery').append(r);
                    }
                }
            });
        };

    </script>
@endsection
