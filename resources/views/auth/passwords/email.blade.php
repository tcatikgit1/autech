@php
    $configData = Helper::applClasses();
@endphp
@extends('layouts.webContentLayoutMaster')

@section('title', 'Forgot Password')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
    <link href="/fonts/font-awesome/css/all.min.css" rel="stylesheet">
@endsection


    {{-- <div class="d-flex align-items-center auth-wrapper auth-cover"> --}}
        <div class="auth-wrapper auth-cover h-100 d-flex align-items-center">
            <div class="mx-auto row m-0 p-0" style="border-radius: 1rem;">
                <!-- Forgot password-->
                <div class="d-flex col-12 w-100 my-auto p-5">
                    <div class="col-12 col-lg-12 mx-auto ">
                        <div class="d-flex justify-content-center mb-3">
                            <img src="/images/logo/logo1.png" alt="logo">
                        </div>
                        <h2 class="card-title text-white fw-bold mb-1">¿Contraseña olvidada? <i class="fa-solid fa-lock"></i></h2>
                        <p class="card-text text-white mb-2">Introduce tu email y te enviaremos las instrucciones para recuperar la contraseña</p>

                        @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                @foreach ($errors->all() as $error)

                                    <div class="alert-body"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info me-50"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                        {{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form class="auth-forgot-password-form mt-2 auth-login-form" action="{{route('password.email')}}" method="POST">
                            @csrf
                            <div class="mb-1">
                                {{-- <label class="form-label text-white" for="email">Email</label> --}}
                                <input class="form-control radius-border1" id="email" type="email"
                                    name="email" placeholder="Correo electrónico"
                                    aria-describedby="email" autofocus="" tabindex="1"/>
                            </div>
                            <button class="btn btn-primary border-btn text-uppercase fw-bolder fonts-20 espacio w-100" tabindex="2">Enviar </button>
                        </form>
                        <p class="text-center mt-2 ">
                            <a href="{{ route('login') }}" style="color: white; font-weight: bold">
                                <i data-feather="chevron-left"></i> Volver al Login
                            </a>
                        </p>
                    </div>
                </div>
                <!-- /Forgot password-->
            </div>
        </div>
    {{-- <div> --}}


{{-- @section('content')
    @include('pages.mainContainer.mainContainer')
@endsection --}}

@section('vendor-script')
    <script src="{{asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))}}"></script>
@endsection

@section('page-script')
    <script src="{{asset(mix('js/scripts/pages/auth-forgot-password.js'))}}"></script>
@endsection
