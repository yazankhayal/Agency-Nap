@extends('dashboard.layouts.app')

@section('title')
    {{$list->User->name}}
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
                                {{$list->User->name}}
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="form-group m-form__group ">

                        <div class="card-deck row">

                            <div class="card col-md-3">
                                <img src="{{path().$list->User->avatar}}" class="card-img-top"
                                     alt="{{$list->User->name}}">
                                <div class="card-body">
                                    <p class="card-text">{{$lang->Email}} <span class="badge badge-primary">{{$list->User->email}}</span></p>
                                    <p class="card-text">{{$lang->Address}} : <span class="badge badge-primary">{{$list->User->address}}</span></p>
                                    <p class="card-text">{{$lang->Phone}} : <span class="badge badge-primary">{{$list->User->phone}}</span></p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">{{$list->User->created_at}}</small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        @if($list->type == "paypal")
                                            <div class="badge badge-dark">{{$lang->PayPal}}</div>
                                        @elseif($list->type == "over_hand")
                                            <div class="badge badge-dark">{{$lang->over_hand}}</div>
                                        @else
                                            <div class="badge badge-dark">{{$lang->visa_master}}</div>
                                        @endif
                                    </li>
                                    <li class="list-group-item">{{$lang->transaction_id}} {{$list->transaction_id}}</li>
                                    <li class="list-group-item">{{$lang->Price}} {{$list->amount}}</li>
                                    @if($list->coupon != null)
                                        <li class="list-group-item">{{$lang->copuon}} <span class="badge-primary badge">{{$list->Copuon->price}}{{$curenc_cooki->code}}</span></li>
                                    @endif
                                </ul>
                            </div>

                            @if(count($carts) != 0)
                                @foreach($carts as $item)
                                    <div class="col-md-3">
                                        <div class="card">
                                            <a href="{{$item->Products->route()}}">
                                                <img src="{{$item->Products->img()}}" style="height: 120px"
                                                     class="card-img-top" alt="{{$item->Products->name()}}">
                                            </a>
                                            <div class="card-body">
                                                <h5 class="card-title">{{$item->Products->name()}}</h5>
                                                <div class="card-text">
                                                    {{$lang->Colors}} :
                                                    @if(count(explode(",",$item->colors)) != 0)
                                                        @foreach(explode(",",$item->colors) as $key => $value)
                                                            <ul style="display: inline-block;margin: 25px 0 0 0">
                                                                @if($value)
                                                                    <li style="width: 27px;height:27px;border-radius: 100%;background:{{$value}}">

                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <br>
                                                <p class="btn btn-primary">
                                                    {{$lang->Sizes}} :
                                                    @if(count(explode(",",$item->sizes)) != 0)
                                                        @foreach(explode(",",$item->sizes) as $key => $value)
                                                            @if($value)
                                                                {{$value}}
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
