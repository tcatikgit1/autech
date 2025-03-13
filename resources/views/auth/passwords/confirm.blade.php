@php
    $configData = Helper::applClasses();
@endphp
@extends('layouts.webContentLayoutMaster')

@section('title', 'Reset Password')

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
    <link href="/fonts/font-awesome/css/all.min.css" rel="stylesheet">
@endsection

    <div class="auth-wrapper auth-cover h-100 d-flex align-items-center">
        <div class="auth-inner row m-0">
            <!-- Reset password-->
            <div class="auth-bg d-flex col-12 w-100 my-auto p-2" >
                <div class="col-12 col-sm-8 mx-auto p-3">
                    <div class="d-flex justify-content-center mb-1">
                        <img src="/images/logo/logo1.png" alt="logo">
                    </div>
                    <h2 class="card-title text-white fw-bold mb-1">Reestablecer contraseña <i class="fa-solid fa-key"></i></h2>
                    <p class="card-text mb-2 text-white">Su nueva contraseña debe ser diferente de las contraseñas utilizadas anteriormente</p>

                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                <div class="alert-body">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info me-50"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                                    {{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form class="auth-reset-password-form mt-2" action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="mb-1 d-none">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" readonly class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="john@example.com" aria-describedby="email" tabindex="1" autofocus value="{{ $email ?? old('email') }}" />
                        </div>
                        <div class="mb-1">
                            <div class="d-flex justify-content-between">
                                <label class="form-label text-white" for="password">Nueva contraseña</label>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input class="form-control form-control-merge radius-border2" id="password" type="password" name="password" placeholder="············" aria-describedby="reset-password-new" autofocus="" tabindex="1" />
                                <span class="input-group-text cursor-pointer radius-border3"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                        <div class="mb-1">
                            <div class="d-flex justify-content-between">
                                <label class="form-label text-white" for="password_confirmation">Confirmar contraseña</label>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input class="form-control form-control-merge radius-border2" id="password_confirmation" type="password" name="password_confirmation" placeholder="············" aria-describedby="reset-password-confirm" tabindex="2" />
                                <span class="input-group-text cursor-pointer radius-border3"><i data-feather="eye"></i></span>
                            </div>
                        </div>
                        <button class="w-100 btn btn-primary border-btn text-uppercase fw-bolder fonts-20 espacio" tabindex="3">Establecer contraseña</button>
                    </form>
                    <p class="text-center mt-2">
                        <a href="{{ route('login') }}" style="color: white; font-weight: bold">
                            <i data-feather="chevron-left"></i> Volver al login
                        </a>
                    </p>
                </div>
            </div>
            <!-- /Reset password-->
        </div>
    </div>

@section('vendor-script')
    <script src="{{asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))}}"></script>
@endsection

@section('page-script')
    <script src="{{asset(mix('js/scripts/pages/auth-reset-password.js'))}}"></script>
@endsection
