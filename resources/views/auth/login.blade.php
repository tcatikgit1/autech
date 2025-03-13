@php
    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Login Basic - Pages')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
    @vite(entrypoints: ['resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/pages-auth.js'])
@endsection

@section('content')

    <div class="row mx-0">
        <div class="col-12 col-md-6 col-lg-4 mx-auto">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="card-body container-p-y py-6">
                    <!-- Logo -->
                    <div class="logo-container">
                        <a href="{{ url('/') }}" class="app-brand-link">
                            <span class="app-brand-logo">@include('_partials.macros', ['height' => 50, 'withbg' => 'fill: #fff;'])</span>
                            {{-- <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName')
                                }}</span> --}}
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-1">Inicia sesión</h4>
                    {{-- <p class="mb-6">Please sign-in to your account and start the adventure</p> --}}

                    <form id="formAuthentication" class="mb-4" action="{{ url('/login') }}" method="post">
                        @csrf
                        @if ($errors->has('email'))
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                        <div class="mb-6">
                            <label for="email" class="form-label">Email o número de telefono</label>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Introduce tu email o telefono" autofocus>
                        </div>
                        <div class="mb-6 form-password-toggle">
                            <label class="form-label" for="password">Contraseña</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                    aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                        <div>
                            <a href="" class="text-primary">¿Olvidaste la contraseña?</a>
                        </div>
                        {{-- <div class="my-8">
                            <div class="d-flex justify-content-between">
                                <div class="form-check mb-0 ms-2">
                                    <input class="form-check-input" type="checkbox" id="remember-me">
                                    <label class="form-check-label" for="remember-me">
                                        Recuerdame
                                    </label>
                                </div>
                            </div>
                        </div> --}}
                        <div class="mb-6">
                            <button class="btn btn-primary d-grid w-100" type="submit">Inicia sesión</button>
                        </div>
                        <div class="divider my-6">
                            <div class="">o</div>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-google w-100" type="button">
                                <div class="d-flex align-items-center w-100">
                                    <img src="https://img.icons8.com/color/48/google-logo.png" alt="Google Logo"
                                        class="btn-icon" style="width: 24px; height: 24px; border: 3cm;">
                                    <span class="mx-auto">Continuar con Google</span>
                                </div>
                            </button>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-facebook w-100" type="button">
                                <div class="d-flex align-items-center w-100">
                                    <img src="https://img.icons8.com/ios-filled/50/ffffff/facebook-f.png"
                                        alt="Facebook Logo" style="width: 24px; height: 24px;">
                                    <span class="mx-auto">Continuar con Facebook</span>
                                </div>
                            </button>
                        </div>


                        <div class="text-center mt-4">
                            <span class="text-muted">¿No tienes cuenta? <a href="{{ url('register') }}"
                                    class="text-primary">Regístrate</a></span>
                        </div>


                    </form>
                    {{-- <div class="divider my-6">
                        <div class="divider-text">Any problems?</div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <a href="mailto:soporte@tcatik.com"
                            class="btn btn-sm btn-icon rounded-pill btn-text-facebook me-1_5">
                            <i class="tf-icons ti ti-mail"></i>
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="flex-shrink-0 d-flex align-items-center">
                <img src="{{ asset('assets/img/login/login.png') }}" alt="google home" class="img-login">
            </div>
        </div>
    </div>
    <div class="container-xxl">
        {{-- <div class="authentication-wrapper authentication-basic container-p-y"> --}}
        {{-- <div class="authentication-inner py-6"> --}}
        {{-- <!-- Login --> --}}
        {{-- <div class="card"> --}}

        {{-- </div> --}}
        {{-- <!-- /Register --> --}}
        {{-- </div> --}}
        {{-- </div> --}}
    </div>
@endsection
