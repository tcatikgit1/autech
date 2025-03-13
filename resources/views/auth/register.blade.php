@extends('layouts/layoutMaster')

@section('title', 'Register - Account')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/bs-stepper/bs-stepper.scss', 'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/bs-stepper/bs-stepper.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/pages-auth.js', 'resources/assets/js/form-layouts.js', 'resources/assets/js/pages-auth-rol.js'])
@endsection

@section('content')
    <div class="row mx-0">
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-center h-80" id="mainContent">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="logo-container">
                    <a href="{{ url('/') }}" class="app-brand-link">
                        <span class="app-brand-logo">@include('_partials.macros', ['height' => 50])</span>
                    </a>
                </div>

                {{-- Sección inicial de selección --}}
                <section id="initialSection">
                    <div class="mb-4 text-center">
                        <h4 class="mb-3" id="title">Regístrate</h4>
                        <p id="description">Encuentra talento o nuevas oportunidades, <b>todo en un solo lugar.</b></p>
                    </div>

                    <div class="mb-4">
                        <div class="options-container d-flex justify-content-center gap-3">
                            <button type="button" class="role-btn btn btn-outline-primary w-100 p-3" data-role="cliente">
                                <div class="option p-3">
                                    <label class="form-label fw-bold" style="font-size: medium">Cliente</label>
                                    <img src="{{ asset('assets/img/login/client.png') }}" alt="Cliente"
                                        class="img-fluid rounded mx-auto d-block">
                                </div>
                            </button>
                            <button type="button" class="role-btn btn btn-outline-primary w-100 p-3" data-role="autonomo">
                                <div class="option p-3">
                                    <label class="form-label fw-bold" style="font-size: medium">Autónomo</label>
                                    <img src="{{ asset('assets/img/login/freelancer.png') }}" alt="Autonomo"
                                        class="img-fluid rounded mx-auto d-block">
                                </div>
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <button type="button" id="continueButton" class="btn btn-primary w-100">Continuar</button>
                        </div>
                        <div class="text-center mt-4">
                            <span class="text-muted">¿Ya tienes cuenta? <a href="{{ url('login') }}"
                                    class="text-primary">Inicia
                                    sesión</a></span>
                        </div>
                    </div>
                </section>

                {{-- Sección de formulario para Cliente --}}
                <section id="clientForm" style="display: none;">
                    @include('auth.registerclient')
                </section>

                {{-- Sección de formulario para Autónomo --}}
                <section id="freelancerForm" style="display: none;">
                    @include('auth.registerautonomus')
                </section>
            </div>
        </div>
        <section id="imagesContainer" class="col-12 col-md-6 d-none d-md-block">
            <img id="stepImage" src="{{ asset('assets/img/login/register.png') }}" alt="Imagen paso" class="img-form">
        </section>

    </div>
@endsection
