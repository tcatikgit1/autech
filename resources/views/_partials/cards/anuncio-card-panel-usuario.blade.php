<div 
    id="anuncio-card-{{\App\Helpers\Helpers::getId($anuncio['_id'])}}" 
    class="card mb-3 shadow-sm ad-container" 
    style="max-width: 100%; padding-left: 0;"
    data-filter-title="{{ $anuncio['titulo'] }}"
    data-filter-description="{{ $anuncio['descripcion'] }}"
    data-filter-type="{{ $anuncio['tipo_anuncio'] }}"
    data-filter-profession-id="{{ $anuncio['profesion_id'] }}"
    data-filter-visible="{{ $anuncio['is_visible'] ? 1 : 0 }}"
>
    <div class="row g-0 card-content">

        @if($from != 'adv-pack')
            {{-- Imagen --}}
            <div class="col-md-3 col-xl-2 p-4 d-flex justify-content-center">
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
                    class="img-fluid rounded image-card" 
                    alt="Imagen del anuncio" 
                    style="max-height: 10rem;"
                >
                
            </div>
        @endif

        <div class="{{$from == 'profile-ads' ? "col-md-9 col-xl-10" : ''}} selectable-adv" data-element-id="{{ \App\Helpers\Helpers::getId($anuncio['_id']) }}">
            <div class="card-body">

                {{-- Titulo y descripcion --}}
                <div class="d-flex justify-content-between">
                    <h5 class="card-title">
                        {{ $anuncio['titulo'] }}
                    </h5>

                    {{-- Tipo anuncio tag --}}
                    {{-- <span class="badge badge-tipo {{ $anuncio['tipo_anuncio'] }}">{{ ucfirst($anuncio['tipo_anuncio']) }}</span> --}}
                    <div class="badge-tipo {{ $anuncio['tipo_anuncio'] }}">
                        <span class="badge-text">
                            {{ ucfirst($anuncio['tipo_anuncio']) }}
                        </span>
                    </div>
                </div>
                <p class="card-text">{{ $anuncio['descripcion'] }}</p>

                <div class="row mb-1 justify-content-between align-items-center">

                    {{-- Ubicacion y precio --}}
                    <div class="d-flex align-items-center {{$from == 'profile-ads' ? "col-md-6" : ''}}">
                        <div class="d-flex align-items-center">
                            @include('icons.svg.ubication')
                            @if($anuncio['place_name'])
                                <p class="mb-0">{{ $anuncio['place_name'] }}</p>
                            @else
                                <p class="mb-0">--</p>
                            @endif
                        </div>
                        <div class="ms-4 d-flex align-items-center">
                            @include('icons.svg.euro')
                            <p class="mb-0 ms-1">{{ \App\Helpers\Helpers::formatear_presupuesto($anuncio['presupuesto']) }} €/h</p>
                        </div>
                    </div>

                    @if($from != 'adv-pack')
                        {{-- Botones de accion --}}
                        <div class="d-flex col-md-6 justify-content-center justify-content-md-end align-items-center gap-2 flex-column flex-sm-row">
                            <button class="btn btn-outline-primary edit-ad-btn" data-ad-id="{{ \App\Helpers\Helpers::getId($anuncio['_id']) }}">@include('icons.svg.edit') <span class="ms-1">Editar</span></button>
                            <button class="btn btn-outline-danger delete-ad-btn" data-ad-id="{{ \App\Helpers\Helpers::getId($anuncio['_id']) }}">@include('icons.svg.delete') <span class="ms-1">Eliminar</span></button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>