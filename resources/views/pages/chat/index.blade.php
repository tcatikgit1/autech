@extends('layouts/layoutFront')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.scss')
@endsection
@section('page-style')
    @vite('resources/assets/vendor/scss/pages/chat.scss')
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js')
@endsection

@section('page-script')
    @vite('resources/assets/js/app-chat.js')
@endsection

@section('content')
    @include('pages.chat.chat')
@endsection
