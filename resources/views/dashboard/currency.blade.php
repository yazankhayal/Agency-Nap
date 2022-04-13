@extends('dashboard.layouts.app')

@section('title')
    {{$lang->save_currecny}}
@endsection

@section('content')

    <form class="row currency_conversions ajaxForm" data-name="currency_conversions" method="post"
          action="{{route('dashboard_admin.currency_conversions')}}">
        {{csrf_field()}}
        @if($currens->where("select",'!=','1')->count() != 0 )
            @foreach($currens->where("select",'!=','1') as $item)
                <div class="col-md-6">
                    <div class="m-portlet m-portlet--tab">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
							<span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
							</span>
                                    <h3 class="m-portlet__head-text">
                                        {{$item->name}}
                                        <input id="currency_id" name="currency_id[]" type="hidden"
                                               value="{{$item->id}}">
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group">
                                <div class="form-group">
                                    <label for="price">{{$lang->The_value_of_the_currency_on_the}}</label>
                                    <input type="text" class="cls form-control" name="price[]" id="price"
                                           value="{{$item->CurrencyConversions != null ? $item->CurrencyConversions->price : ""}}"
                                           placeholder="{{$lang->The_value_of_the_currency_on_the}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-md-12">
                <div class="m-portlet m-portlet--tab">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group">
                            <div class="form-group">
                                <hr>
                                <button type="submit" class="btn btn-primary btn-load">
                                    @lang('table.submit')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </form>


@endsection
