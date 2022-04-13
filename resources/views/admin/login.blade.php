@extends('auth.layouts')

@section('title')
    @lang('site.login')
@endsection

@section('content')

    <!-- Login 17 start -->
    <div class="login-17">
        <div class="container">
            <div class="col-md-12 pad-0">
                <div class="row login-box-6 ">

                    <div class="col-lg-12 col-md-12 col-sm-12 col-pad-0 align-self-center">
                        <div class="login-inner-form">
                            <div class="details">
                                <h3>Sign into your account</h3>
                                @includeIf("layouts.msg")
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                               type="text" id="email" value="{{ old('email') }}" name="email"
                                               placeholder="E-mail Address" required>
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                               type="password" name="password" placeholder="Password" required>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                    <div class="checkbox clearfix">
                                        <div class="form-check checkbox-theme">
                                            <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn-md btn-theme btn-block"> @lang('site.login')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login 17 end -->

@endsection
