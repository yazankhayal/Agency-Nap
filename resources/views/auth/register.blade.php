@extends('layouts.app')
@section('title')
    {{$lang->Register}}
@endsection

@section('content')

    @includeIf("layouts.breadcrumb")


    <div class="ps-page">
        <div class="ps-account">
            <div class="container">
                <form class="ps-form--account" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="ps-form__header">
                        <h3>{{lang_name('Register')}}</h3>
                    </div>
                    <div class="ps-form__content">
                        <div class="form-group">
                            <label for="name">{{$lang->Name}}</label>
                            <input id="name" type="text"
                                   class="form-control  {{ $errors->has('name') ? ' border-danger' : '' }}" name="name"
                                   value="{{ old('name') }}"
                                   placeholder="{{$lang->Name}}">

                            @if ($errors->has('name'))
                                <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>{{$lang->Email}}<sup>*</sup></label>
                            <input class="form-control  {{ $errors->has('email') ? ' border-danger' : '' }}"
                                   id="email" value="{{ old('email') }}" name="email"
                                   type="text" placeholder="{{$lang->Email}}">
                            @if ($errors->has('email'))
                                <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>{{$lang->Password}}<sup>*</sup></label>
                            <input class="form-control  {{ $errors->has('password') ? ' border-danger' : '' }}"
                                   id="password" value="{{ old('password') }}" name="password"
                                   type="password" placeholder="{{$lang->Password}}">
                            @if ($errors->has('password'))
                                <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">{{$lang->Password2}}</label>
                            <input id="password_confirmation" type="password" class="form-control  "
                                   placeholder="{{$lang->Password2}}"
                                   name="password_confirmation">
                        </div>
                        <div class="form-group submit">
                            <button class="ps-btn ps-btn--outline ps-btn--black">{{lang_name('Register')}}</button>
                            <p><a href="{{route('login')}}">{{lang_name('Login')}}</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

