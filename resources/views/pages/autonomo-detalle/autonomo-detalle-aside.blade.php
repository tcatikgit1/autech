<!-- Contenido del perfil -->
<div class="profile-header">

    <img
        src="{{ $autonomo['cliente']['avatar'] ? config('app.FILES_URL') . $autonomo['cliente']['avatar'] : asset('assets/img/avatars/avatar-default.webp') }}" 
        alt="Perfil" 
        class="profile-image"
    >

    <div class="profile-name-wrapper">
        {{-- Nombre --}}
        <h2>{{ $autonomo['nombre'] . ' ' . $autonomo['apellidos'] }}</h2>
        
        {{-- Verificado --}}
        @if(isset($autonomo['is_valid']) && $autonomo['is_valid'])
            <div class="verified-icon">
                @include('icons.svg.verified')
            </div>
        @endif
    </div>

    {{-- Profesion --}}
    <p>{{ $autonomo['profesion_full']['titulo'] }}</p>

    <div class="sub-container gap-1">
        {{-- Destacado tag --}}
        <span class="badge badge-destacado">Destacado</span>

        {{-- icon circle --}}
        <div class="profile-actions">

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

            {{-- like icon --}}
            @if(isset($autonomo['valoracion']) && !is_null($autonomo['valoracion']))
                <div class="icon icon-like">
                    @include('icons.svg.like')
                    <span class="percentage">{{$autonomo['valoracion']}}%</span>
                </div>
            @endif
        </div>
    </div>

</div>

{{-- phone & email --}}
@if(isset($autonomo['is_data_visibility']) && $autonomo['is_data_visibility'])
    <div class="profile-contact">
        <div class="contact-element">
            @include('icons.svg.phone', ['color' => '#757575'])
            @if(isset($autonomo['cliente']['telefono']))
                <p>{{ $autonomo['cliente']['telefono'] }}</p>
            @else
                <p>No disponible</p>	
            @endif
        </div>
        <span>|</span>
        <div class="contact-element">
            @include('icons.svg.email', ['stroke' => '#757575'])
            @if(isset($autonomo['cliente']['email']))
                <p title="{{ $autonomo['cliente']['email'] }}">{{ $autonomo['cliente']['email'] }}</p>
            @else
                <p>No disponible</p>	
            @endif
        </div>
    </div>
@endif

{{-- skills --}}
@if(isset($autonomo['habilidades_full']) && sizeOf($autonomo['habilidades_full']) > 0)
    <div class="profile-skills">
        <h3>Habilidades</h3>
        <ul class="skills-list">
            @foreach($autonomo['habilidades_full'] as $habilidad)
                <li title="{{ $habilidad['titulo'] }}">{{ $habilidad['titulo'] }}</li>
            @endforeach
        </ul>
    </div>
@else
    <div>
        <p>Este profesional no cuenta con ninguna habilidad asignada</p>
    </div>
@endif
