@extends('layouts.app')

@section('title')
    @lang('site.reset')
@endsection

@section('content')


    <section class="section bg-light top_non_home">
        <div class="container">
            <div class="align-items-center row">
                <div class="col-md-4 col-lg-4">
                    <img src="/home_page/media/app_development_SVG.1744d3c9.svg" alt="">
                </div>
                <div class="col-md-8 col-lg-8">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">
                                @lang('table.email')
                            </label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    @lang('site.reset_send')
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>


@endsection
