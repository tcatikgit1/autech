<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Autech - Ciberseguridad</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- Logo --}}
    <link rel="icon" type="image/x-icon" href="{{'assets/img/Logo.png'}}" alt="logo">

    @include('layouts/sections/styles')
    @include('layouts/sections/scipts')

</head>

<body >

    @yield('layoutContent')

</body>

</html>
