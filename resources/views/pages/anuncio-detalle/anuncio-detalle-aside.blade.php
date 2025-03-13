<!-- Contenido del anuncio -->
@php
    use Illuminate\Support\Facades\Auth;
@endphp
<div id="top-aside">
    <div class="aside-header">
    
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
            alt="Imagen de anuncio"
            class="aside-image"
        >
    
        <div class="aside-title-wrapper">
            {{-- Nombre --}}
            <h2>{{$anuncio['titulo']}}</h2>
    
            {{-- Verificado --}}
            {{-- @if(isset($autonomo['is_valid']) && $autonomo['is_valid']) --}}
                {{-- <div class="verified-icon">
                    @include('icons.svg.verified')
                </div> --}}
            {{-- @endif --}}
        </div>
    
        {{-- Profesion --}}
    
    
    
        <div class="sub-container gap-1">
            {{-- Destacado tag --}}
            <span class="badge badge-destacado">Destacado</span>
    
            {{-- icon circle --}}
            <div>
    
                {{-- heart icon --}}
                <div class="icon icon-heart">
                    @include('icons.svg.heart', [
                        'stroke' => '#52CFC4',
                        'fill' => (isset($autonomo['is_fav']) && $autonomo['is_fav']) ? '#52CFC4' : 'none'
                    ])
                </div>
    
                {{-- share icon --}}
                <div class="icon icon-share">
                    @include('icons.svg.share', ['color' => '#52CFC4'])
                </div>
    
            </div>
        </div>
    
    </div>
    
    <div class="aside-footer">
    
        <div class="info-container">
    
            {{-- ubicacion y precio --}}
            <div class="ubication-price">
                <div class="contact-element">
                    @include('icons.svg.ubication')
                    @if(isset($anuncio['place_name']) && $anuncio['place_name'])
                        <p>{{ $anuncio['place_name'] }}</p>
                    @else
                        <p>No disponible</p>
                    @endif
                </div>
                <span>|</span>
                <div class="contact-element">
                    @include('icons.svg.euro')
                    @if(isset($anuncio['presupuesto']))
                        <p>{{ \App\Helpers\Helpers::formatear_presupuesto($anuncio['presupuesto']) }}€/h</p>
                    @else
                        <p>No disponible</p>
                    @endif
                </div>
            </div>
    
            {{-- descripcion --}}
            <div class="description">
                @if(isset($anuncio['descripcion']) && $anuncio['descripcion'])
                    <p>{{ $anuncio['descripcion'] }}</p>
                @endif
                <span>
                    Publicado el {{ \Carbon\Carbon::parse($anuncio['created_at'])->format('d/m/y') }} a las {{ \Carbon\Carbon::parse($anuncio['created_at'])->format('H:i') }}
                </span>
            </div>
        </div>
    
        {{-- phone & email --}}
        @if(isset($anuncio['autor']['is_data_visibility']) && $anuncio['autor']['is_data_visibility'])
            <div class="aside-contact">
                <div class="contact-element">
                    @include('icons.svg.phone', ['color' => '#757575'])
                    @if(isset($anuncio['cliente']['telefono']))
                        <p>{{$anuncio['cliente']['telefono']}}</p>
                    @else
                        <p>No disponible</p>
                    @endif
                </div>
                <span>|</span>
                <div class="contact-element">
                    @include('icons.svg.email', ['stroke' => '#757575'])
                    @if(isset($anuncio['cliente']['email']))
                        <p title="{{$anuncio['cliente']['email']}}">{{$anuncio['cliente']['email']}}</p>
                    @else
                        <p>No disponible</p>
                    @endif
                </div>
            </div>
        @endif
    
    </div>
</div>

<h3 class="h3-class">Oferta de</h3>
<div id="bottom-aside">
    <div class="owner-card">
        <div class="d-flex align-items-center">
            <div class="owner-image-content">
                <img
                    src="{{ $anuncio['cliente']['avatar'] ? config('app.FILES_URL') . $anuncio['cliente']['avatar'] : asset('assets/img/avatars/avatar-default.webp') }}"
                    alt="Avatar"
                    class="owner-image"
                >
                {{-- TODO: Verificiar si is_valid varia dinamicamente en el back --}}
                @if(isset($anuncio['autor']['is_valid']) && $anuncio['autor']['is_valid'])
                    <div class="verified-icon">
                        @include('icons.svg.verified')
                    </div>
                @endif
            </div>
            <div class="owner-details">
                <h2 class="owner-name">{{$anuncio['autor']['nombre'] . ' ' . $anuncio['autor']['apellidos']}}</h2>
                @if(is_null(session()->get('user')) || session()->get('user')['email'] != $anuncio['autor']['cliente']['email'])
                    <a href="#" class="report-ad" data-bs-toggle="modal" data-bs-target="#reportModal">Reportar anuncio</a>
                @endif
            </div>
        </div>
        {{-- TODO: No viene la valoracion en esta peticion --}}
        {{-- @if(isset($anuncio['autor']['valoracion']) && !is_null($anuncio['autor']['valoracion'])) --}}
            <div class="icon icon-like">
                @include('icons.svg.like')
                <span class="percentage">98%</span>
            </div>
        {{-- @endif --}}
    </div>
</div>

