@extends('layouts/layoutFront')

@section('content')



     @include('layouts.sections.content.information')

@endsection

@section('page-style')
    @vite(['resources/scss/information.scss'
])
@endsection
