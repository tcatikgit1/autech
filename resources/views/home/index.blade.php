@extends('layouts/layoutFront')
@section('page-style')
        @vite([
    'resources/scss/information.scss',
    'resources/scss/banner.scss',
    'resources/scss/partners.scss',
    'resources/scss/contact.scss',
    'resources/scss/carrousel.scss'

])
@endsection
@section('page-script')
    @vite([
    'resources/js/partners.js',
    'resources/js/carrousel.js',
])
@endsection


@section('content')

    @include('layouts.sections.content.banner')
        <main class="container-fluid">
            @include('layouts.sections.content.carrousel')
            @include('layouts.sections.content.cibersecurity')
            @include('layouts.sections.content.peritajes')
            @include('layouts.sections.content.wifi')
            @include('layouts.sections.content.industria')
            @include('layouts.sections.content.information')
            @include('layouts.sections.content.contact')
            @include('layouts.sections.content.partners')
        </main>

@endsection


