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

    <div class="auth-wrapper auth-cover h-100 d-flex align-items-center">
        <div class="auth-inner row m-0">

            <!-- Login-->
            <div class="auth-bg d-flex col-12 w-100 my-auto p-2">
                <div class="col-12 col-sm-8 mx-auto text-center">
                    <div class="d-flex justify-content-center mb-2">
                        <img src="/images/logo/logo1.png" alt="logo">
                    </div>
                    <h2 class="card-title text-white fw-bold mb-1">Email enviado correctamente! <i class="fa-solid fa-envelope-circle-check"></i></h2>
                    <p class="card-text mb-2 text-white">En breve recibirá un correo electrónico con instrucciones sobre cómo restablecer su contraseña.</p>

                    <p class="text-center mt-2" style="color: white; font-weight: bold">
                        <a href="{{ route('login') }}">
                            <i data-feather="chevron-left"></i> Volver al login
                        </a>
                    </p>
                </div>
            </div>
            <!-- /Login-->
        </div>
    </div>

@section('vendor-script')
    <script src="{{asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))}}"></script>
@endsection

@section('page-script')
    <script src="{{asset(mix('js/scripts/pages/auth-login.js'))}}"></script>
@endsection
