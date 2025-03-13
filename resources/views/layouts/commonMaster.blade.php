<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    {{-- TODO: COMENTAR ESTO --}}
    {{-- @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
    @else

    @endif --}}

    {{-- 2. Crear archivo layouts/sections/styles e incluirlo aqui con @include --}}
    @include('layouts/sections/styles')

    {{-- 1. Crear archivo layouts/sections/scripts e incluirlo aqui con @include --}}
    {{-- 1.1 Dentro crear las secciones => "page-script" y "vendor-script" --}}
    {{-- 1.2 En el index unar la seccion "page-script" y crear un script con un alert para comprobar que se incluye bien--}}
    @include('layouts/sections/scipts')

</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">

    @yield('layoutContent')

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif

</body>

</html>
