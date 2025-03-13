@php
    $autor = $anuncio['autor_full'] ?? $anuncio['autor'] ?? null;
    $autorEmail = $anuncio['cliente']['email'] ?? $cliente['user']['email'] ?? null; // Si en el anuncio no se encuentra el cliente, el email lo cogemos del user
@endphp

<div id="anuncio-card-destacado" class="card mb-3 shadow-sm anuncio-card" style="max-width: 100%; padding-left: 0;">
    <div class="row g-0 card-content">

        {{-- Imagen --}}
        <div class="col-md-3 col-xl-2 p-4 d-flex justify-content-center" style="cursor: pointer;">
            @php
                // Obtener la cadena de imágenes
                $imagenes = $anuncio['imagenes'] ?? '';
                // Separar la cadena en un array
                $imagenesArray = explode(',', $imagenes);
                // Obtener la primera imagen si existe
                $primeraImagen = $imagenesArray[0] ?? asset('assets/img/elements/anuncio-default.png');
                // Concatenar la URL base con la primera imagen
                $imagenUrl = config('app.FILES_URL') . $primeraImagen;
            @endphp
            <img 
                src="{{ $imagenUrl }}" 
                class="img-fluid rounded object-fit-cover" 
                alt="Imagen del anuncio" 
                style="max-height: 20rem;"
                data-link="{{ route('pageAnuncioDetalle', ['id' => \App\Helpers\Helpers::getId($anuncio['_id'])]) }}"
                onclick="window.open(this.dataset.link, '_blank');"
            >
            
        </div>

        <div class="col-md-9 col-xl-10">
            <div class="card-body">

                {{-- Titulo y descripcion --}}
                <div class="d-flex justify-content-between align-items-center">
                    <h5 
                        class="card-title" 
                        data-link="{{ route('pageAnuncioDetalle', ['id' => \App\Helpers\Helpers::getId($anuncio['_id'])]) }}"
                        onclick="window.open(this.dataset.link, '_blank');"
                        style="cursor: pointer;"
                    >
                        {{ $anuncio['titulo'] }}
                        
                    </h5>

                    {{-- Ícono de favorito | Solo se ve desde el panel de usuario --}}
                    @if (isset($from) && $from == 'favorites')
                        <span class="badge-fav bottom-0 end-0 m-2 cursor-pointer" data-target-id="{{$anuncio['_id']}}" data-type="anuncio">
                            @include('icons.svg.heart')
                        </span>
                    @endif
                </div>

                <p class="card-text">{{ $anuncio['descripcion'] }}</p>

                {{-- Nombre y profesion --}}
                <div class="d-flex">
                    <p><strong>Nombre:</strong> {{ $autor['nombre'] }}</p>

                    @isset($anuncio['profesion']['titulo'])
                        <p class="ms-4"><strong>Profesión:</strong>
                            {{ $anuncio['profesion']['titulo'] }}</p>
                    @endisset
                </div>

                <div class="row mb-1 justify-content-between align-items-center">

                    {{-- Ubicacion y precio --}}
                    <div class="d-flex col-md-6 align-items-center">
                        <div class="d-flex align-items-center">
                            @include('icons.svg.ubication')
                            <p class="mb-0">{{ $anuncio['place_name'] }}</p>
                        </div>
                        <div class="ms-4 d-flex align-items-center">
                            @include('icons.svg.euro')
                            <p class="mb-0 ms-1">{{ \App\Helpers\Helpers::formatear_presupuesto($anuncio['presupuesto']) }}</p>
                        </div>
                    </div>

                    {{-- Botones de accion --}}
                    <div class="d-flex col-md-6 justify-content-center justify-content-md-end align-items-center gap-2 flex-column flex-sm-row">

                        @if($autor['is_data_visibility'] ?? false)
                            @if(is_null(session()->get('user')) || session()->get('user')['email'] != $autorEmail)
                                <a href="#" class="btn btn-outline-primary mb-2 mb-md-0">
                                    <div class="d-flex align-items-center">
                                        @include('icons.svg.phone') 
                                        <p class="mb-0 ms-2">
                                            Llamar
                                        </p>
                                    </div>
                                </a>
                                <a href="#" class="btn btn-outline-primary mb-2 mb-md-0">
                                    <div class="d-flex align-items-center">
                                        @include('icons.svg.email') 
                                        <p class="mb-0 ms-2">
                                            Email
                                        </p>
                                    </div>
                                </a>
                            @endif
                        @endif

                        @if(is_null(session()->get('user')) || session()->get('user')['email'] != $autorEmail)
                            <a href="#" class="btn btn-primary text-white mb-2 mb-md-0">
                                <div class="d-flex align-items-center">
                                    @include('icons.svg.chat') 
                                    <p class="mb-0 ms-2">
                                        Mensajes
                                    </p>
                                </div>
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>