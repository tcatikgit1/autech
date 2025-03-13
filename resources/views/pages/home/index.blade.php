@extends('layouts/layoutFront')

@section('vendor-style')
    @vite(['resources/assets/vendor/scss/pages/page-home.scss'])
@endsection

@section('vendor-script')
@endsection

@section('content')

    <div class="container">
        @include('pages.search.barra-filtros-search')
        @include('pages.home.section-profesiones')
        @include('pages.home.section-anuncios-destacados')
        @include('pages.home.section-autonomos-destacados')
    </div>

@endsection

@section('page-script')
    @vite([
        'resources/js/google-place-api.js',
        'resources/js/web/home/index.js'
    ])
@endsection
