@extends('layouts/layoutFront')

@section('vendor-style')
    @vite(['resources/assets/vendor/scss/pages/page-autonomo-detalle.scss'])
@endsection

@section('vendor-script')
@endsection

@section('content')

    <input type="hidden" id="autonomo-id" value="{{ $autonomoId }}">
    @include('pages.autonomo-detalle.autonomo-detalle-main')

@endsection

@section('page-script')
    @vite(['resources/js/web/autonomo-detalle/index.js'])
@endsection
