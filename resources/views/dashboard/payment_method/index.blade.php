@extends('dashboard.layouts.app')

@section('title')
        {{$lang->payment_method}}
@endsection

@section('create_btn')

@endsection

@section('content')



<div class="row row-cards">
							
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-bottom-0 p-4">
                <h2 class="card-title">
                @yield('title')
                </h2>
            </div>
            <div class="e-table px-5 pb-5">
                <div class="table-responsive table-lg">
                    <form class="ajaxForm dashboard_payment_method" enctype="multipart/form-data"
                              data-name="dashboard_payment_method"
                              action="{{route('dashboard_payment_method.post_data')}}" method="post">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <input id="id" name="id" class="cls" type="hidden">
                                <p class="alert alert-warning">
                                    Debit Card account
                                </p>
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="debit_card_enable">
                                            Debit Card Enable
                                         <input type="checkbox" class="cls" name="debit_card_enable" id="debit_card_enable">
                                        </label>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="app_key_id_debit_card">App Key</label>
                                        <input placeholder="App Key" type="text" class="cls form-control" name="app_key_id_debit_card" id="app_key_id_debit_card">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="app_key_id_debit_card">App Secret</label>
                                        <input placeholder="App Secret" type="text" class="cls form-control" name="app_secret_debit_card" id="app_secret_debit_card">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="debit_card_live">Live</label>
                                        <select class="cls form-control" name="debit_card_live" id="debit_card_live">
                                            <option value="sandbox">Sandbox</option>
                                            <option value="live">Live</option>
                                        </select>
                                    </div>
                                </div>

                                <hr>
                                <p class="alert alert-warning">
                                    PayPal account
                                </p>
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="paypal_enable">
                                            PayPal Enable
                                         <input type="checkbox" class="cls" name="paypal_enable" id="paypal_enable">
                                        </label>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="app_key_id_paypal">App Key</label>
                                        <input placeholder="App Key" type="text" class="cls form-control" name="app_key_id_paypal" id="app_key_id_paypal">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="app_secret_paypal">App Secret</label>
                                        <input placeholder="App Secret" type="text" class="cls form-control" name="app_secret_paypal" id="app_secret_paypal">
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label for="paypal_live">Live</label>
                                        <select class="cls form-control" name="paypal_live" id="paypal_live">
                                            <option value="sandbox">Sandbox</option>
                                            <option value="live">Live</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <hr>
                                <p class="alert alert-warning">
                                    Hand Over account
                                </p>
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label for="hand_over_enable">
                                            Hand Over Enable
                                         <input type="checkbox" class="cls" name="hand_over_enable" id="hand_over_enable">
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="button_action" id="button_action" value="insert">
                                <a href="{{route('dashboard_users.index')}}" class="btn btn-default">
                                    @lang('table.close')
                                </a>
                                <button type="submit" class="btn btn-primary btn-load">
                                    @lang('table.submit')
                                </button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
        
    </div><!-- COL-END -->
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
                url: "{{ route('dashboard_payment_method.get_data_by_id') }}",
                method: "get",
                data: {},
                dataType: "json",
                success: function (result) {
                    if (result.success != null) {
                        $('#id').val(result.success.id);
                        $('#payment_method_id').val(result.success.id);
                       
                            if(result.success.debit_card_enable == 1){
                                $('#debit_card_enable').attr("checked", "checked");
                            }
                            $('#app_key_id_debit_card').val(result.success.app_key_id_debit_card);
                            $('#app_secret_debit_card').val(result.success.app_secret_debit_card);
                            $('#debit_card_live').val(result.success.debit_card_live);

                            if(result.success.paypal_enable == 1){
                                $('#paypal_enable').attr("checked", "checked");
                            }
                            $('#app_key_id_paypal').val(result.success.app_key_id_paypal);
                            $('#app_secret_paypal').val(result.success.app_secret_paypal);
                            $('#paypal_live').val(result.success.paypal_live);

                            if(result.success.hand_over_enable == 1){
                                $('#hand_over_enable').attr("checked", "checked");
                            }
                        
                    }
                }
            });
        };

    </script>


@endsection
