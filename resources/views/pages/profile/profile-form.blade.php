<div id="content-personal-information" class="bottom-section tab-pane fade show active" role="tabpanel" aria-labelledby="tab-personal-information">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center">
            <h5 class="m-0 me-3">Información personal</h5>

            @if($user_info['user']['tipo'] == 'autonomo')
                <label class="switch switch-primary me-1">
                    <input type="checkbox" id="toggle-user-data-switch" class="switch-input" @if(@$user_info['profile']['is_data_visibility']) checked @endif />
                    <span class="switch-toggle-slider">
                        <span class="switch-on">
                            <i class="ti ti-check"></i>
                        </span>
                        <span class="switch-off">
                            <i class="ti ti-x"></i>
                        </span>
                    </span>
                    <span class="switch-label">Mostrar datos</span>
                </label>
                <i class="text-muted ti ti-help" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Los demás podrán ver tus datos como el teléfono o correo electrónico" data-bs-original-title="Los demás podrán ver tus datos como el teléfono o correo electrónico"></i>
            @endif

        </div>
        <button class="edit-profile-button">
            <span class="edit-profile-icon">
                @include("icons.svg.edit")
            </span>
            Editar perfil
        </button>
    </div>

    <form id="edit-profile-form" novalidate enctype="multipart/form-data">
        @csrf

        <fieldset disabled>
            <div class="row mb-3">
                {{-- Nombre --}}
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre<span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        name="nombre" 
                        class="form-control" 
                        id="nombre" 
                        placeholder="Jhon" 
                        value="{{@$user_info['cliente']['nombre']}}"
                        required
                        maxlength="150"
                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                    >
                    <div class="invalid-feedback">Campo inválido</div>
                </div>

                {{-- Apellidos --}}
                <div class="col-md-6">
                    <label for="apellidos" class="form-label">Apellidos<span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        name="apellidos" 
                        class="form-control" 
                        id="apellidos" 
                        value="{{@$user_info['cliente']['apellidos']}}" 
                        placeholder="Doe"
                        required
                        maxlength="150"
                        pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                    >
                    <div class="invalid-feedback">Campo inválido</div>
                </div>
            </div>

            <div class="row mb-3">
                {{-- Fecha de nacimiento --}}
                <div class="col-md-6">
                    <label for="fecha-nacimiento" class="form-label">Fecha de nacimiento (dd-mm-yyyy)<span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        name="fecha_nacimiento" 
                        class="form-control" 
                        id="fecha-nacimiento" 
                        value="{{ \Carbon\Carbon::parse(@$user_info['cliente']['fecha_nacimiento'])->format('d-m-Y') }}" 
                        placeholder="06-03-1999" 
                        pattern="^([0-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$"
                        maxlength="10"
                        required
                    >
                    <div class="invalid-feedback">Campo inválido</div>
                </div>

                {{-- NIF/CIF --}}
                <div class="col-md-6">
                    <label for="cif" class="form-label">NIF/CIF<span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        name="cif" 
                        class="form-control" 
                        id="cif"
                        value="{{@$user_info['cliente']['cif']}}"
                        placeholder="123456789A"
                        maxlength="15"
                        required
                    >
                    <div class="invalid-feedback">Campo inválido</div>
                </div>
            </div>

            <div class="row mb-3">

                {{-- Teléfono --}}
                <div class="col-md-6">
                    <label for="telefono" class="form-label">Número de teléfono<span class="text-danger">*</span></label>
                    <div class="input-group gap-2">
                    <select class="form-select select2-flag select2" name="telefono_prefijo" id="prefijo" required disabled>
                        @foreach (config('phone_prefixes') as $prefix => $info)
                            <option 
                                value="{{ $prefix }}" 
                                {{ @$user_info['cliente']['telefono_prefijo'] == $prefix ? 'selected' : '' }}
                                data-flag='@include('icons.svg.flags.'.$info['flag'])'>
                                {{ $prefix }}
                            </option>
                        @endforeach
                    </select>
                    <input 
                        type="text" 
                        name="telefono" 
                        class="form-control" 
                        id="telefono"
                        value="{{@$user_info['cliente']['telefono']}}"
                        placeholder="000000000"
                        required
                        pattern="^[0-9]{9}$" 
                    >
                    <div class="invalid-feedback">Campo inválido</div>
                    </div>
                </div>

                {{-- Teléfono adicional --}}
                <div class="col-md-6">
                    <label for="telefono2" class="form-label">Teléfono adicional</label>
                    <div class="input-group gap-2">
                    <select class="form-select select2-flag select2" name="telefono_prefijo2" id="prefijo2" disabled>
                        @foreach (config('phone_prefixes') as $prefix => $info)
                            <option 
                                value="{{ $prefix }}" 
                                {{ @$user_info['cliente']['telefono_prefijo2'] == $prefix ? 'selected' : '' }}
                                data-flag='@include('icons.svg.flags.'.$info['flag'])'>
                                {{ $prefix }}
                            </option>
                        @endforeach
                    </select>
                    <input 
                        type="text" 
                        name="telefono2" 
                        class="form-control" 
                        id="telefono2"
                        value="{{ @$user_info['cliente']['telefono2'] }}"
                        placeholder="000000000"
                        pattern="^[0-9]{9}$" 
                    >
                    <div class="invalid-feedback">Campo inválido</div>
                    </div>
                </div>
            </div>

            {{-- Ubicación --}}
            {{-- TODO: FALTA TODO ESTO CON RESPECTO A LA UBICACION
            place_id: "ChIJ5TCOcRaYpBIRCmZHTz37sEQ"
            place_lat: 41.3873974
            place_long: 2.168568
            place_name: "Barcelona"
            profesion_id: "65e83a8e4c4a92adc50645d2" --}}
            <div class="mb-3">
                <label for="location-input" class="form-label">Ubicación<span class="text-danger">*</span></label>
                <input id="location-input" type="text" placeholder="Escribe una ubicación" class="form-control location-input" value={{ @$user_info['profile']['place_name'] }}>
                <input type="hidden" id="place_lat" name="place_lat" value={{ @$user_info['profile']['place_lat'] }}>
                <input type="hidden" id="place_long" name="place_long" value={{ @$user_info['profile']['place_long'] }}>
                <input type="hidden" id="place_id" name="place_id" value={{ @$user_info['profile']['place_id'] }}>
                <input type="hidden" id="place_name" name="place_name" value={{ @$user_info['profile']['place_name'] }}>
                <div class="invalid-feedback">Campo inválido</div>
            </div>

            @if($user_info['user']['tipo'] == 'autonomo')

                {{-- Profesión --}}
                <div class="mb-3">
                    <label for="select-profesion" class="form-label">Profesión<span class="text-danger">*</span></label>
                    <select id="select-profesion" name="profesion_id" class="select2 form-select populate-profesion" data-user-profesion="{{@$user_info['profile']['profesion_id']}}" data-target="#select-habilidades" required disabled>
                        <option selected>Seleccione una opción</option>
                    </select>
                    <div class="invalid-feedback">Campo inválido</div>
                </div>

                {{-- Habilidades de profesion --}}
                <div class="mb-3">
                    <label for="select-habilidades" class="form-label">Habilidades de profesión</label>
                    <div class="select2-info">
                        <select id="select-habilidades" class="select2 form-select populate-habilidades" name="habilidades[]" data-user-habilidades='@json(@$user_info['profile']['habilidades'])' multiple data-parent-select-profesion-id="select-profesion" disabled>

                        </select>
                    </div>
                </div>

                {{-- Habilidades generales --}}
                <div class="mb-3">
                    <label for="select-habilidades-generales" class="form-label">Habilidades generales</label>
                    <div class="select2-info">
                        <select id="select-habilidades-generales" class="select2 form-select populate-habilidades-generales" name="habilidades_generales[]" data-user-habilidades-generales='@json(@$user_info['profile']['habilidades_generales'])' multiple disabled>

                        </select>
                    </div>
                </div>

                {{-- Tipos de autonomo --}}
                <div class="mb-3">
                    <label for="select-tipo-autonomo" class="form-label">Tipo de autónomo<span class="text-danger">*</span></label>
                    <select id="select-tipo-autonomo" name="tipo_autonomo" class="select2 form-select populate-tipo-autonomo" data-user-tipo-autonomo="{{@$user_info['profile']['tipo_autonomo_id']}}" required disabled>
                        <option selected disabled>Seleccione una opción</option>
                    </select>
                    <div class="invalid-feedback">Campo inválido</div>
                </div>

                {{-- Razón social --}}
                <div class="mb-3">
                    <label for="razon_social" class="form-label">Razón social<span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        name="razon_social" 
                        class="form-control" 
                        id="razon_social"
                        value="{{@$user_info['profile']['razon_social']}}"
                        required
                    >
                    <div class="invalid-feedback">Campo inválido</div>
                </div>

                {{-- Dirección fiscal --}}
                <div class="mb-3">
                    <label for="direccion_fiscal" class="form-label">Dirección fiscal<span class="text-danger">*</span></label>
                    <input 
                        type="text" 
                        name="direccion_fiscal" 
                        class="form-control" 
                        id="direccion_fiscal"
                        value="{{@$user_info['profile']['direccion_fiscal']}}"
                        required
                    >
                    <div class="invalid-feedback">Campo inválido</div>
                </div>

            @endif

            <div class="mb-3">
                <label for="avatar" class="form-label">Imagen de perfil</label>
                <input 
                    type="file" 
                    name="avatar" 
                    class="form-control" 
                    id="avatar" 
                    accept="image/png, image/jpeg, image/jpg"
                >
                <div class="invalid-feedback">Formato de archivo no permitido</div>
            </div>

            <input type="hidden" name="tipo" value="{{session()->get('user')['tipo']}}">

            <div class="mt-4">
                <button type="submit" id="submit-edit-profile" class="btn btn-primary btn-lg">Guardar</button>
            </div>
        </fieldset>
    </form>
</div>
