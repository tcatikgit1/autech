<div id="content-autonomous-data" class="bottom-section tab-pane fade" role="tabpanel" aria-labelledby="tab-autonomous-data">

    {{-- <input type="hidden" id="documents" value="{{ $user['profile']['documentos'] ?? 'null' }}"> --}}

    <input type="hidden" id="documento_certificado_input_hidden" value="{{ $user['profile']['documento_certificado'] ?? 'null' }}">
    <input type="hidden" id="documento_modelo303_input_hidden" value="{{ $user['profile']['documento_modelo303'] ?? 'null' }}">
    <input type="hidden" id="is_valid" value="{{$user['profile']['is_valid'] === true ? 'true' : 'false'}}">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center">
            <h5 class="m-0 me-3">Datos autónomo</h5>
        </div>
    </div>

    <form id="autonomus-data-form" class="mb-3" novalidate enctype="multipart/form-data">
        @csrf
        <div class="row mb-3">
            {{-- Documento 1 certificado --}}
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="documento_certificado_autonomus_data" class="form-label">Certificado de autónomo<span class="text-danger">*</span></label>
                    <input 
                        type="file" 
                        name="documento_certificado" 
                        class="form-control" 
                        id="documento_certificado_autonomus_data" 
                        accept="application/pdf"
                        disabled
                    >
                    <div class="invalid-feedback">Formato de archivo no permitido</div>
                    @if(!is_null($user['profile']['documento_certificado']))
                        <a href="{{ env('GATEWAY_URL') }}{{ $user['profile']['documento_certificado'] }}" target="_blank" class="d-block text-end">Descargar documento</a>
                    @endif
                </div>
            </div>

            {{-- Documento 2 modelo303 --}}
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="documento_modelo303_autonomus_data" class="form-label">Modelo 303<span class="text-danger">*</span></label>
                    <input 
                        type="file" 
                        name="documento_modelo303" 
                        class="form-control" 
                        id="documento_modelo303_autonomus_data" 
                        accept="application/pdf"
                        disabled
                    >
                    <div class="invalid-feedback">Formato de archivo no permitido</div>
                    @if(!is_null($user['profile']['documento_modelo303']))
                        <a href="{{ env('GATEWAY_URL') }}{{ $user['profile']['documento_modelo303'] }}" target="_blank" class="d-block text-end">Descargar documento</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="row mb-3">

            {{-- Fecha SS --}}
            <div class="col-md-6 mb-3">
                <label for="fecha_ss_autonomus_data" class="form-label">Fecha de alta SS (dd-mm-yyyy)<span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    name="fecha_alta_autonomo" 
                    class="form-control" 
                    id="fecha_ss_autonomus_data" 
                    value="{{ \Carbon\Carbon::parse(@$user_info['profile']['fecha_alta_autonomo'])->format('d-m-Y') }}" 
                    placeholder="06-03-1999" 
                    pattern="^([0-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$"
                    maxlength="10"
                    required
                    disabled
                >
                <div class="invalid-feedback">Campo inválido</div>
            </div>

            {{-- Fecha CEA --}}
            <div class="col-md-6">
                <label for="fecha_cea_autonomus_data" class="form-label">Fecha CEA (dd-mm-yyyy)<span class="text-danger">*</span></label>
                <input 
                    type="text" 
                    name="documento_fechaCEA" 
                    class="form-control" 
                    id="fecha_cea_autonomus_data" 
                    value="{{ \Carbon\Carbon::parse(@$user_info['profile']['documento_fechaCEA'])->format('d-m-Y') }}"
                    required
                    placeholder="06-03-1999" 
                    pattern="^([0-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$"
                    maxlength="10"
                    disabled
                >
                <div class="invalid-feedback">Campo inválido</div>
            </div>
        </div>

        {{-- Codigo CEA --}}
        <div class="mb-3">
            <label for="codigo_cea_autonomus_data" class="form-label">Código CEA<span class="text-danger">*</span></label>
            <input 
                type="text" 
                name="documento_codigoCEA" 
                class="form-control" 
                id="codigo_cea_autonomus_data"
                value="{{@$user_info['profile']['documento_codigoCEA']}}"
                placeholder="123456789A"
                maxlength="150"
                minlength="5"
                required
                disabled
            >
            <div class="invalid-feedback">Campo inválido</div>
        </div>

        

        <div class="mt-4">
            <button type="submit" id="submit-autonomus-data" class="btn btn-primary btn-lg" disabled>Enviar</button>
        </div>
    </form>

    <div class="box formNotSend d-none">
        <p class="mb-0">Para verificar tu cuenta, por favor envía el formulario con los datos requeridos. Una vez que lo recibamos, nuestros administradores revisarán tu solicitud. Te notificaremos cuando tu verificación haya sido aprobada. ¡Gracias por tu paciencia y colaboración!</p>
    </div>
    <div class="box waitResponse d-none">
        <p class="mb-0">Tu solicitud de verificación ha sido enviada con éxito. Estamos revisando tu información, por favor espera mientras los administradores validan tu solicitud</p>
    </div>
    <div class="box rejectionsFound d-none">
        <p class="mb-0">Lamentablemente, tu solicitud de verificación ha sido rechazada. Revisa los detalles proporcionados y realiza los cambios necesarios antes de volver a enviarla</p>
        <ul class="rejection-list"></ul> <!-- Aquí se agregarán los motivos del rechazo -->
    </div>
    <div class="box userAlreadyVerified d-none">
        <p class="mb-0">Enhorabuena, ahora tu perfil se destaca por delante de los no verificados, aumentando la confianza de tus seguidores y atrayendo a más personas interesadas en tus anuncios</p>
    </div>


</div>