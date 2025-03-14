@extends('layouts/layoutFront')

@section('content')

    @include('layouts.sections.content.banner')
    @include('layouts.sections.content.carrousel')

    @include('layouts.sections.content.information')

@endsection

@section('page-style')
    @vite(['resources/scss/information.scss'
])
@endsection
