@php
    $customizerHidden = 'customizer-hide';
@endphp
{{-- @extends('layouts/fullLayoutMaster') --}}
@extends('layouts/layoutMaster')

@section('title', 'Privacy Policy')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/pages-auth.js'])
@endsection

@section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/authentication.css')) }}">
@endsection
@section('content')

    <div class="container-xxl">
        <div class="row mx-0">
            <!-- Columna de texto -->
            <div class="container-xxl">
                <div class="row mx-0">
                    <!-- Columna de texto -->
                    <div class="col-12 col-md-6  align-items-start justify-content-start p-4 pt-5">
                        <div class="privacidad">
                            <h1>Política de Privacidad</h1>

                            <h3>Introducción:</h3>
                            <p>Valoramos su privacidad y nos comprometemos a proteger su información personal. Esta Política
                                de privacidad describe cómo recopilamos, usamos y protegemos sus datos cuando utiliza
                                nuestros servicios.</p>

                            <h3>Recopilación y uso de datos:</h3>
                            <p>Recopilamos solo los datos necesarios, como su nombre, correo electrónico y actividad de uso,
                                para brindar y mejorar nuestros servicios. Su información nunca se comparte con terceros no
                                autorizados.</p>

                            <h3>Sus derechos y seguridad:</h3>
                            <p>Tiene derecho a acceder, actualizar o eliminar sus datos. Implementamos medidas sólidas para
                                proteger su información contra el acceso no autorizado o las infracciones.</p>
                        </div>
                        <form id="formAuthentication">
                            <div class="mb-6 d-flex justify-content-start">
                                <a href="{{ url()->previous() }}" class="btn btn-primary w-100">
                                    <span class="align-middle">Continuar</span>
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-md-6 d-none d-md-block p-0">
                        <img src="{{ asset('assets/img/login/pana.png') }}" alt="Imagen de condiciones"
                            class="img-fluid img-condiciones">
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @section('vendor-script')
        <script src="{{ asset('vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    @endsection

    @section('page-script')
        <script src="{{ asset('js/scripts/pages/auth-register.js') }}"></script>
    @endsection
