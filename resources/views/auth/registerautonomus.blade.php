<div class="row mx-0 vh-100">
    <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <!-- Logo -->
            <div class="logo-container">
                <a href="{{ url('/') }}" class="app-brand-link">
                    <span
                        class="app-brand-logo">@include('_partials.macros', ['height' => 50, 'withbg' => 'fill: #fff;'])</span>
                    {{-- <span class="app-brand-text demo text-heading fw-bold">{{ config('variables.templateName')
                        }}</span> --}}
                </a>
            </div>
            <div id="multiStepsValidationA" class="bs-stepper border-none shadow-none hidden-steps">
                <div class="bs-stepper-header border-none hidden-steps">
                    <div class="step" data-target="#phoneNumberA">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="ti ti-user"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Numero de teléfono</span>
                                <span class="bs-stepper-subtitle">Paso 1</span>
                            </span>
                        </button>
                    </div>
                    <div class="line"><i class="ti ti-chevron-right"></i></div>
                    <div class="step" data-target="#verificationA">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="ti ti-briefcase"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Verificacion</span>
                                <span class="bs-stepper-subtitle">Paso 2</span>
                            </span>
                        </button>
                    </div>
                    <div class="line"><i class="ti ti-chevron-right"></i></div>
                    <div class="step" data-target="#personalDetailsA">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="ti ti-lock"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Datos Personales</span>
                                <span class="bs-stepper-subtitle">Paso 3</span>
                            </span>
                        </button>
                    </div>
                    <div class="line"><i class="ti ti-chevron-right"></i></div>
                    <div class="step" data-target="#companyDetailsA">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="ti ti-lock"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Datos Empresa</span>
                                <span class="bs-stepper-subtitle">Paso 4</span>
                            </span>
                        </button>
                    </div>
                    <div class="line"><i class="ti ti-chevron-right"></i></div>
                    <div class="step" data-target="#securityDetailsA">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-circle"><i class="ti ti-lock"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Seguridad</span>
                                <span class="bs-stepper-subtitle">Paso 5</span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <form id="formAuthenticationA" action="{{ url('/register') }}" method="post">
                        @csrf
                        <!-- Numero de teléfono -->
                        <div id="phoneNumberA" class="content">
                            <div class="content-header">
                                <h4 class="mb-1"><strong>Registro Autonomo</strong></h4>
                            </div>
                            <div class="content-body">
                                @csrf
                                <input type="hidden" name="role" value="autonomo">
                                <div class="mb-6">
                                    <label for="phoneA" class="form-label">Número de teléfono</label>
                                    <input type="text" class="form-control" id="phoneA" name="phoneA"
                                        placeholder="Introduce tu teléfono" autofocus>
                                </div>
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="checkbox" id="privacyPolicyA"
                                        name="privacyPolicy" required>
                                    <label class="form-check-label" for="privacyPolicyA" style="font-size: 0.8rem;">
                                        He leído y acepto las <a href="/conditions" target="_blank"
                                            class="text-primary">condiciones de
                                            uso</a> y las
                                        <a href="/conditions" target="_blank" class="text-primary">políticas de
                                            privacidad</a>.
                                    </label>
                                </div>
                            </div>
                            <div class="content-footer">
                                <div class="mb-6">
                                    <button class="btn btn-primary d-grid w-100 btn-next" id="registerButtonA"
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
                                    <a href="{{ url('register') }}" class="btn btn-label-secondary">
                                        <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                                        <span class="align-middle">Volver</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Verificacion -->
                        <div id="verificationA" class="content col-12 text-center">
                            <img src="{{ asset('assets/img/login/Group 136.png') }}" alt="Verificación"
                                class="img-fluid mb-4" style="max-width: 150px;">
                            <h2 class="mb-3 text-center">Verifica tu Teléfono</h2>
                            <p class="text-center">
                                Hemos enviado un mensaje con un código de activación a <br>
                                <strong>+34 666666666</strong>. Por favor verifica tus mensajes y remitentes
                                desconocidos.
                            </p>
                            <div class="d-flex justify-content-center gap-2 mb-4">
                                <div class="d-flex justify-content-center gap-2 mb-4">
                                    <input type="text" class="form-control text-center verify-input2"
                                        id="verify-input2-0" maxlength="1">
                                    <input type="text" class="form-control text-center verify-input2"
                                        id="verify-input2-1" maxlength="1">
                                    <input type="text" class="form-control text-center verify-input2"
                                        id="verify-input2-2" maxlength="1">
                                    <input type="text" class="form-control text-center verify-input2"
                                        id="verify-input2-3" maxlength="1">
                                    <input type="text" class="form-control text-center verify-input2"
                                        id="verify-input2-4" maxlength="1">
                                </div>

                            </div>
                            <p class="mb-3">¿No has recibido ningún código? <br>
                                <a href="#" class="text-primary">Enviar otra vez</a>
                            </p>
                            @csrf
                            <button class="btn btn-primary w-100 mb-6" id="verifyButtonA">Aceptar</button>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev" data-bs-step="prev">
                                    <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                </button>
                            </div>
                        </div>
                        <!-- Datos Personales -->
                        <div id="personalDetailsA" class="content">
                            <div class="content-header mb-4">
                                <h4 class="mb-0">Datos Personales</h4>
                            </div>
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombreA" name="nombre" autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellidosA" name="apellidos">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-phone">Numero de teléfono</label>
                                <input type="text" id="basic-default-phoneA" class="form-control phone-mask" />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="emailA" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="fiscal" class="form-label">Dirección fiscal</label>
                                <input type="text" class="form-control" id="fiscalA" name="fiscal">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="multicol-birthdate">Fecha de nacimiento</label>
                                <input type="text" id="multicol-birthdateA" class="form-control dob-picker"
                                    placeholder="YYYY-MM-DD" />
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev" data-bs-step="prev">
                                    <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                </button>
                                <button class="btn btn-primary btn-next" data-bs-step="next">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Siguiente</span>
                                    <i class="ti ti-arrow-right ti-xs"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Datos de la Empresa -->
                        <div id="companyDetailsA" class="content">
                            <div class="content-header mb-4">
                                <h4 class="mb-0">Datos de la Empresa</h4>
                            </div>
                            <div class="mb-3">
                                <label for="fiscal" class="form-label">Nº identificación fiscal</label>
                                <input type="text" class="form-control" id="Idfiscal" name="fiscal">
                            </div>
                            <div class="mb-3">
                                <label for="empresa" class="form-label">Nombre de la empresa</label>
                                <input type="text" class="form-control" id="empresa" name="empresa">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="profession">Profesión</label>
                                <select id="profession-type" class="select2 form-select" data-allow-clear="true">
                                    <option value="1">Profesion 1</option>
                                    <option value="2">Profesion 2</option>
                                    <option value="3">Profesion 3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="generals-skills">Habilidades generales</label>
                                <select id="generals-skills" class="select2 form-select" multiple="multiple"
                                    placeholder="Seleccione una o varias habilidades">
                                    <option value="1">Habilidad 1</option>
                                    <option value="2">Habilidad 2</option>
                                    <option value="3">Habilidad 3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="profession-skills">Habilidades de profesión</label>
                                <select id="profession-skills" class="select2 form-select" multiple="multiple"
                                    placeholder="Seleccione una o varias habilidades">
                                    <option value="1">Habilidad 1</option>
                                    <option value="2">Habilidad 2</option>
                                    <option value="3">Habilidad 3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="autonomus-type">Tipo de autónomo</label>
                                <select id="autonomus-type" class="select2 form-select" data-allow-clear="true">
                                    <option value="1">Tipo 1</option>
                                    <option value="2">Tipo 2</option>
                                    <option value="3">Tipo 3</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev" data-bs-step="prev">
                                    <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                </button>
                                <button class="btn btn-primary btn-next" data-bs-step="next">
                                    <span class="align-middle d-sm-inline-block d-none me-sm-1 me-0">Siguiente</span>
                                    <i class="ti ti-arrow-right ti-xs"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Seguridad -->
                        <div id="securityDetailsA" class="content">
                            <div class="content-header mb-4">
                                <h4 class="mb-0">Seguridad</h4>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Contraseña</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="passwordA" class="form-control" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password_confirmation">Confirmar Contraseña</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmationA" class="form-control"
                                        name="password_confirmation"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password_confirmation" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-label-secondary btn-prev" data-bs-step="prev">
                                    <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                                    <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                </button>
                                <button type="submit" class="btn btn-success btn-submit">Finalizar Registro</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
