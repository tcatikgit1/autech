<div id="content-become-autonomus" class="bottom-section tab-pane fade" role="tabpanel" aria-labelledby="tab-become-autonomus">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center">
            <h5 class="m-0 me-3">Convertirse en autónomo</h5>
        </div>
    </div>

    <form id="become-autonomus-form" novalidate enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            {{-- Documento 1 certificado --}}
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="documento_certificado" class="form-label">Certificado de autónomo<span class="text-danger">*</span></label>
                    <input 
                        type="file" 
                        name="documento_certificado" 
                        class="form-control" 
                        id="documento_certificado" 
                        accept="application/pdf"
                    >
                    <div class="invalid-feedback">Formato de archivo no permitido</div>
                </div>
            </div>

            {{-- Documento 2 modelo303 --}}
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="documento_modelo303" class="form-label">Modelo 303<span class="text-danger">*</span></label>
                    <input 
                        type="file" 
                        name="documento_modelo303" 
                        class="form-control" 
                        id="documento_modelo303" 
                        accept="application/pdf"
                    >
                    <div class="invalid-feedback">Formato de archivo no permitido</div>
                </div>
            </div>
        </div>

        <div class="row mb-3">

            {{-- Codigo CEA --}}
            <div class="col-md-6">
                <label for="codigo_cea_become_autonomus" class="form-label">Código CEA<span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    name="documento_codigoCEA" 
                    class="form-control" 
                    id="codigo_cea_become_autonomus"
                    value=""
                    placeholder="123456789A"
                    maxlength="150"
                    minlength="5"
                    required
                >
                <div class="invalid-feedback">Campo inválido</div>
            </div>

            {{-- Fecha CEA --}}
            <div class="col-md-6">
                <label for="fecha_cea_become_autonomus" class="form-label">Fecha CEA (dd-mm-yyyy)<span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    name="documento_fechaCEA" 
                    class="form-control" 
                    id="fecha_cea_become_autonomus" 
                    value=""
                    required
                    placeholder="06-03-1999" 
                    pattern="^([0-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$"
                    maxlength="10"
                >
                <div class="invalid-feedback">Campo inválido</div>
            </div>
        </div>

        <div class="row mb-3">

            {{-- Teléfono --}}
            <div class="col-md-6">
                <label for="telefono_become_autonomus" class="form-label">Número de teléfono<span class="text-danger">*</span></label>
                <div class="input-group gap-2">
                  <select class="form-select select2-flag select2" name="telefono_prefijo" id="prefijo_become_autonomus" required>
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
                    id="telefono_become_autonomus"
                    value="{{$user_info['cliente']['telefono']}}"
                    placeholder="000000000"
                    required
                    pattern="^[0-9]{9}$" 
                >
                <div class="invalid-feedback">Campo inválido</div>
                </div>
            </div>

            {{-- Fecha alta SS --}}
            <div class="col-md-6">
                <label for="fecha_ss_become_autonomus" class="form-label">Fecha de alta SS (dd-mm-yyyy)<span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    name="fecha_ss" 
                    class="form-control" 
                    id="fecha_ss_become_autonomus" 
                    value="" 
                    placeholder="06-03-1999" 
                    pattern="^([0-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$"
                    maxlength="10"
                    required
                >
                <div class="invalid-feedback">Campo inválido</div>
            </div>

        </div>

        <div class="row mb-3">

            {{-- NIF/CIF --}}
            <div class="col-md-6">
                <label for="cif_become_autonomus" class="form-label">Nº identificación fiscal (NIF/NIE/DNI)<span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    name="cif" 
                    class="form-control" 
                    id="cif_become_autonomus"
                    value=""
                    placeholder="123456789A"
                    required
                >
                <div class="invalid-feedback">Campo inválido</div>
            </div>

            {{-- Nombre empresa - Razon social --}}
            <div class="col-md-6">
                <label for="razon_social" class="form-label">Nombre de la empresa<span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    name="razon_social" 
                    class="form-control" 
                    id="razon_social_become_autonomus" 
                    value=""
                    required
                    maxlength="50"
                    minlength="3"
                >
                <div class="invalid-feedback">Campo inválido</div>
            </div>
        </div>

        <div class="row mb-3">

            {{-- Dirección fiscal --}}
            <div class="col-md-6">
                <label for="direccion_fiscal_become_autonomus" class="form-label">Dirección fiscal<span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    name="direccion_fiscal" 
                    class="form-control" 
                    id="direccion_fiscal_become_autonomus" 
                    value=""
                    required
                    maxlength="150"
                    minlength="3"
                >
                <div class="invalid-feedback">Campo inválido</div>
            </div>

            {{-- Ubicación --}}
            {{-- TODO: FALTA TODO ESTO CON RESPECTO A LA UBICACION
            place_id: "ChIJ5TCOcRaYpBIRCmZHTz37sEQ"
            place_lat: 41.3873974
            place_long: 2.168568
            place_name: "Barcelona"
            profesion_id: "65e83a8e4c4a92adc50645d2" --}}
            <div class="col-md-6">
                <label for="provincia_become_autonomus" class="form-label">Ubicación<span class="text-danger">*</span></label>
                <select id="provincia_become_autonomus" name="provincia" class="select2 form-select" required>
                    <option>Telde</option>
                    <option>Las Palmas</option>
                    <option>Tenerife</option>
                    <!-- Más opciones -->
                </select>
                <div class="invalid-feedback">Campo inválido</div>
            </div>
        </div>

        {{-- Tipos de autonomo --}}
        <div class="mb-3">
            <label for="select_tipo_become_autonomus" class="form-label">Tipo de autónomo<span class="text-danger">*</span></label>
            <select id="select_tipo_become_autonomus" name="tipo_autonomo" class="select2 form-select populate-tipo-autonomo" required>
                <option selected disabled>Seleccione una opción</option>
            </select>
            <div class="invalid-feedback">Campo inválido</div>
        </div>

        {{-- Profesión --}}
        <div class="mb-3">
            <label for="select-profesion-become-autonomus" class="form-label">Profesión<span class="text-danger">*</span></label>
            <select id="select-profesion-become-autonomus" name="profesion_id" class="select2 form-select populate-profesion" data-target="#select-habilidades-become-autonomus" required>
                <option selected disabled>Seleccione una opción</option>
            </select>
            <div class="invalid-feedback">Campo inválido</div>
        </div>

        {{-- Habilidades de profesion --}}
        <div class="mb-3">
            <label for="select-habilidades-become-autonomus" class="form-label">Habilidades de profesión</label>
            <div class="select2-info">
                <select id="select-habilidades-become-autonomus" class="select2 form-select populate-habilidades" name="habilidades[]" multiple data-parent-select-profesion-id="select-profesion-become-autonomus">
                    {{-- <option selected disabled>Seleccione una opción</option> --}}
                </select>
            </div>
        </div>

        {{-- Habilidades generales --}}
        <div class="mb-3">
            <label for="select_habilidades_generales_become_autonomus" class="form-label">Habilidades generales</label>
            <div class="select2-info">
                <select id="select_habilidades_generales_become_autonomus" class="select2 form-select populate-habilidades-generales" name="habilidades_generales[]" multiple>

                </select>
            </div>
        </div>

        <input type="hidden" name="userId" id="userId" value="{{session()->get('user')['_id']}}">

        <div class="mt-4">
            <button type="submit" id="submit-become-autonomus" class="btn btn-primary btn-lg">Guardar</button>
        </div>
    </form>
</div>
