@extends('layouts/layoutFront')
@section('page-style')
        @vite([
    'resources/scss/information.scss',
    'resources/scss/banner.scss',
    'resources/scss/partners.scss',
    'resources/scss/contact.scss',
    'resources/scss/carrousel.scss',
    'resources/scss/index.scss'


])
@endsection
@section('page-script')
    @vite([
    'resources/js/partners.js',
    'resources/js/carrousel.js',
    'resources/js/banner.js',
    'resources/js/contact.js'
])
@endsection


@section('content')

    @include('layouts.sections.content.banner')
        <div class=" custom-container">
            @include('layouts.sections.content.carrousel')
            @include('layouts.sections.content.cibersecurity')
            @include('layouts.sections.content.peritajes')
            @include('layouts.sections.content.wifi')
            @include('layouts.sections.content.industria')
            @include('layouts.sections.content.information')
            @include('layouts.sections.content.contact')
            @include('layouts.sections.content.partners')
        </div>

@endsection


