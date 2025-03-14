@extends('layouts/layoutFront')
@section('page-style')
        @vite([
            'resources/scss/information.scss',
            'resources/scss/banner.scss',
            'resources/scss/partners.scss',
            'resources/scss/contact.scss',

        ])
@endsection
@section('page-script')
    @vite(['resources/js/partners.js'])
@endsection


@section('content')

    @include('layouts.sections.content.banner')
    @include('layouts.sections.content.carrousel')

     @include('layouts.sections.content.information')
     @include('layouts.sections.content.contact')
     @include('layouts.sections.content.partners')

@endsection


