@extends('layouts.app')

@section('title')
    {{lang_name('Welcome')}}
@endsection

@section('content')

    @includeIf("layouts.breadcrumb")

@endsection
