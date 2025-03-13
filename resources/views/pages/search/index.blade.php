@extends('layouts/layoutFront')

@section('vendor-style')
    @vite(['resources/assets/vendor/scss/pages/page-search.scss'])
@endsection

@section('vendor-script')
    @vite([
        'resources/assets/vendor/libs/select2/select2.js',
    ])
@endsection

@section('content')

    <div class="container">

        @include('pages.search.barra-filtros-search')
        @include('pages.search.section-listado-general')
    </div>

@endsection

@section('page-script')
    @vite([
        'resources/js/web/search/index.js'
    ])
@endsection
