<div class="row mx-0 vh-100">
    <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <!-- Logo -->
            <div class="logo-container">
                <a href="{{ url('/') }}" class="app-brand-link">
                    <span
                        class="app-brand-logo">@include('_partials.macros', ['height' => 50, 'withbg' => 'fill: #fff;'])</span>
                </a>
            </div>
            <div id="multiStepsValidation" class="bs-stepper border-none shadow-none hidden-steps">
                <div class="bs-stepper-header border-none hidden-steps">
                    <div class="step" data-target="#phoneNumber">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="ti ti-user"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Numero de teléfono</span>
                                <span class="bs-stepper-subtitle">Paso 1</span>
                            </span>
                        </button>
                    </div>
                    <div class="line"><i class="ti ti-chevron-right"></i></div>
                    <div class="step" data-target="#verification">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="ti ti-briefcase"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Verificacion</span>
                                <span class="bs-stepper-subtitle">Paso 2</span>
                            </span>
                        </button>
                    </div>
                    <div class="line"><i class="ti ti-chevron-right"></i></div>
                    <div class="step" data-target="#personalDetails">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="ti ti-lock"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Datos Personales</span>
                                <span class="bs-stepper-subtitle">Paso 3</span>
                            </span>
                        </button>
                    </div>
                    <div class="line"><i class="ti ti-chevron-right"></i></div>
                    <div class="step" data-target="#securityDetails">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="ti ti-lock"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Seguridad</span>
                                <span class="bs-stepper-subtitle">Paso 4</span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <form id="formAuthentication" action="{{ url('/register') }}" method="post">
                        @csrf
                        <!-- Numero de teléfono -->
                        <div id="phoneNumber" class="content">
                            <div class="content-header">
                                <h4 class="mb-1"><strong>Registro Cliente</strong></h4>
                            </div>
                            <div class="content-body">
                                @csrf
                                <input type="hidden" name="role" value="cliente">
                                <div class="mb-6">
                                    <label for="phone" class="form-label">Número de teléfono</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Introduce tu teléfono" autofocus>
                                </div>
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" id="privacyPolicy"
                                        name="privacyPolicy" required>
                                    <label class="form-check-label" for="privacyPolicy" style="font-size: 0.8rem;">
                                        He leído y acepto las <a href="/conditions" target="_blank"
                                            class="text-primary">condiciones de uso</a>
                                        y las
                                        <a href="/conditions" target="_blank" class="text-primary">políticas de
                                            privacidad</a>.
                                    </label>
                                </div>
                            </div>
                            <div class="content-footer">
                                <div class="mb-6">
                                    <button class="btn btn-primary d-grid w-100 btn-next" id="registerButton"
                                        disabled>Registrarse</button>
                                </div>
                                <div class="divider my-6">
                                    <div class="">o</div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-google w-100" type="button">
                                        <div class="d-flex align-items-center w-100">
                                            <img src="https://img.icons8.com/color/48/google-logo.png" alt="Google Logo"
                                                class="btn-icon" style="width: 24px; height: 24px;">
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
                                <div class="text-center mt-3">
                                    <span class="text-muted">¿Ya tienes cuenta? <a href="{{ url('/login') }}"
                                            class="text-primary">Iniciar
                                            sesión</a></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-label-secondary btn-prev" type="button"
                                        onclick="window.location.href='/register';">
                                        <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Volver</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Verificacion -->
                        <div id="verification" class="content col-12 text-center">
                            <img src="{{ asset('assets/img/login/Group 136.png') }}" alt="Verificación"
                                class="img-fluid mb-4" style="max-width: 150px;">
                            <h2 class="mb-3 text-center">Verifica tu Teléfono</h2>
                            <p class="text-center">
                                Hemos enviado un mensaje con un código de activación a <br>
                                <strong>+34 666666666</strong>. Por favor verifica tus mensajes y remitentes
                                desconocidos.
                            </p>
                            <div class="d-flex justify-content-center gap-2 mb-4">
                                <input type="text" class="form-control text-center v-input" id="v-input-0"
                                    maxlength="1">
                                <input type="text" class="form-control text-center v-input" id="v-input-1"
                                    maxlength="1">
                                <input type="text" class="form-control text-center v-input" id="v-input-2"
                                    maxlength="1">
                                <input type="text" class="form-control text-center v-input" id="v-input-3"
                                    maxlength="1">
                                <input type="text" class="form-control text-center v-input" id="v-input-4"
                                    maxlength="1">
                            </div>
                            <p class="mb-3">¿No has recibido ningún código? <br>
                                <a href="#" class="text-primary">Enviar otra vez</a>
                            </p>
                            @csrf
                            <button class="btn btn-primary w-100 mb-6" id="verifyButton">Aceptar</button>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev" type="button">
                                    <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                </button>
                            </div>
                        </div>
                        <!-- Datos Personales -->
                        <div id="personalDetails" class="content">
                            <div class="content-header mb-4">
                                <h4 class="mb-0">Datos Personales</h4>
                            </div>
                            <div class="content-body">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" autofocus>
                                </div>
                                <div class="mb-3">
                                    <label for="apellidos" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="multicol-birthdate">Fecha de nacimiento</label>
                                    <input type="text" id="multicol-birthdate" class="form-control dob-picker"
                                        placeholder="YYYY-MM-DD" />
                                </div>
                            </div>
                            <div class="content-footer">
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-label-secondary btn-prev" type="button">
                                        <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                    </button>
                                    <button class="btn btn-primary btn-next" type="button">
                                        <span
                                            class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Siguiente</span>
                                        <i class="ti ti-arrow-right ti-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Seguridad -->
                        <div id="securityDetails" class="content">
                            <div class="content-header mb-4">
                                <h4 class="mb-0">Seguridad</h4>
                            </div>
                            <div class="content-body">
                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password">Contraseña</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" />
                                        <span class="input-group-text cursor-pointer"><i
                                                class="ti ti-eye-off"></i></span>
                                    </div>
                                </div>
                                <div class="mb-3 form-password-toggle">
                                    <label class="form-label" for="password_confirmation">Confirmar Contraseña</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password_confirmation" class="form-control"
                                            name="password_confirmation"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password_confirmation" />
                                        <span class="input-group-text cursor-pointer"><i
                                                class="ti ti-eye-off"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="content-footer">
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-label-secondary btn-prev" type="button">
                                        <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                    </button>
                                    <button type="submit" class="btn btn-success btn-submit">Finalizar Registro</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
