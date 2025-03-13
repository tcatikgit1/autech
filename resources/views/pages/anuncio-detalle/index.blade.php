@extends('layouts/layoutFront')

@section('vendor-style')
    @vite(['resources/assets/vendor/scss/pages/page-anuncio-detalle.scss'])
@endsection

@section('vendor-script')
@endsection

@section('content')

    <input type="hidden" id="anuncio-id" value="{{ $anuncioId }}">
    @include('pages.anuncio-detalle.anuncio-detalle-main')

@endsection

@section('page-script')
    @vite(['resources/js/web/anuncio-detalle/index.js'])
@endsection
