@extends('layouts/layoutFront')

@section('content')

    @include('layouts/sections/content/banner')

    {{-- @include('header')
    @include('servicios')
    @include('cyberseguridad') --}}
@endsection

@section('page-style')
    @vite(['resources/scss/information.scss'
])
@endsection
