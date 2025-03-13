@extends('layouts/layoutFront')

@section('vendor-style')
    {{-- @vite(['resources/assets/vendor/scss/pages/page-home.scss']) --}}
@endsection

@section('vendor-script')
@endsection

@section('content')

    <div class="container">
        Hola mundo
    </div>

@endsection

{{-- @section('page-script')
    @vite([
        'resources/js/web/home/pre-revolver.js'
    ])
@endsection --}}
