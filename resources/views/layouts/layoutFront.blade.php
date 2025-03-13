@extends('layouts/commonMaster')

@section('layoutContent')

    <div class="main-container">
        <!-- Navbar -->
         <div class="navbar-container">
            @include('layouts/sections/navbar/navbar')
        </div>

        <!-- Contenido principal -->
        <div class="content-container">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="footer-container">
            @include('layouts/sections/footer/footer')
        </div>
    </div>

@endsection
