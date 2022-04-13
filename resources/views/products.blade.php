@extends('layouts.app')

@section('title')
    {{$lang->Products}}
@endsection

@section('css')
@endsection

@section('content')

    @includeIf("layouts.breadcrumb")

    <div class="l-main-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <aside class="l-sidebar">
                        <div class="widget section-sidebar bg-light">
                            <h3 class="widget-title bg-dark"><i class="ic flaticon-car-4"></i>{{lang_name('search_a_car')}}</h3>
                            <div class="widget-content">
                                <div class="widget-inner">
                                    <form class="b-filter bg-light" method="get" action="{{route('products')}}">
                                        <div class="b-filter__main">
                                            <div class="b-filter__row ">
                                                <select name="category_id" id="category_id" class="form-control">
                                                @if(category()->count() != 0)
                                                    @foreach(category() as $item)
                                                        <option value="{{$item->id}}"
                                                                id="{{$item->id}}"
                                                        >{{$item->name()}}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </div>
                                            <div class="b-filter__row">
                                                <select name="type_car" id="type_car" class="form-control">
                                                    <option value="1">{{$lang->small}}</option>
                                                    <option value="2">{{$lang->large}}</option>
                                                    <option value="3">{{$lang->medium}}</option>
                                                </select>
                                            </div>
                                            <div class="b-filter__row">
                                                <select name="fual_disel" id="fual_disel" class="form-control">
                                                    <option value="1">{{$lang->fual}}</option>
                                                    <option value="2">{{$lang->disel}}</option>
                                                </select>
                                            </div>
                                            <div class="b-filter__row">
                                                <select name="autoamtic_manual" id="autoamtic_manual" class="form-control">
                                                    <option value="1">{{$lang->autoamtic}}</option>
                                                    <option value="2">{{$lang->manual}}</option>
                                                </select>
                                            </div>
                                            <div class="b-filter__row">
                                                <input type="text" class="cls form-control" name="staring_price" id="staring_price"
                                                       placeholder="{{$lang->staring_price}}">
                                            </div>
                                            <div class="b-filter__row">
                                                <input type="text" class="cls form-control" name="km" id="km"
                                                       placeholder="{{$lang->km}}">
                                            </div>
                                            <div class="b-filter__row">
                                                <select name="condition_2" id="condition_2" class="form-control">
                                                    <option value="1">{{$lang->condition_2}}-{{$lang->Yes}}</option>
                                                    <option value="2">{{$lang->condition_2}}-{{$lang->No}}</option>
                                                </select>
                                            </div>
                                            <div class="b-filter__row">
                                                <select name="available" id="available" class="form-control">
                                                    <option value="1">{{$lang->available}}-{{$lang->Yes}}</option>
                                                    <option value="2">{{$lang->available}}-{{$lang->No}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary w-100" type="submit">{{lang_name('Search_now')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </aside>
                </div>
                <div class="col-lg-9">

                    @include("data.product.products")
                </div>
            </div>
        </div>
    </div>


@endsection
