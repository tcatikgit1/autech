<!-- Contenido del perfil -->
<div class="profile-header-container">
    <div class="profile-header">

        @php
            $avatar = $user_info['cliente']['avatar']
                ? (str_starts_with($user_info['cliente']['avatar'], 'https:')
                    ? $user_info['cliente']['avatar']
                    : config('app.FILES_URL') . $user_info['cliente']['avatar'])
                : asset('assets/img/avatars/avatar-default.webp');
        @endphp

        <img src="{{ $avatar }}" alt="Perfil" id="profile-image" class="profile-image">

        <div class="profile-name-wrapper">
            {{-- Nombre --}}
            <h2>{{$user_info['cliente']['nombre'] .' '. $user_info['cliente']['apellidos']}}</h2>

            {{-- Verificado icon --}}
            @if ($user_info['user']['tipo'] == 'autonomo')
                @if (isset($user_info['profile']['is_valid']) && $user_info['profile']['is_valid'])
                    <div class="verified-icon">
                        @include('icons.svg.verified')
                    </div>
                @endif
            @endif
        </div>

        {{-- Destacado tag - Si el usuario es autonomo y su "autonomo_destacado->fecha_fin" es superior a hoy --}}
        @if($user_info['user']['tipo'] == 'autonomo')
            @if(isset($user_info['profile']['autonomo_destacado']) && 
                isset($user_info['profile']['autonomo_destacado']['fecha_fin']) && 
                strtotime($user_info['profile']['autonomo_destacado']['fecha_fin']) > time())
                <div class="sub-container gap-1">
                    <span class="badge badge-destacado">Destacado</span>
                </div>
            @endif
        @endif


    </div>

    <div class="buttons-action" role="tablist">
        <button class="action-button" id="tab-my-favs" data-type="anuncios" data-bs-toggle="pill" data-bs-target="#content-my-favs" role="tab" aria-controls="content-my-favs">
            @include('icons.svg.heart-2')
            <span class="text">Favoritos</span>
        </button>
        <button class="action-button" id="tab-my-followed" data-type="autonomos" data-bs-toggle="pill" data-bs-target="#content-my-favs" role="tab" aria-controls="content-my-favs">
            @include('icons.svg.user-circle')
            <span class="text">Seguidos</span>
        </button>
    </div>
</div>

<div class="menu">
    <ul class="menu-list tab-content" role="tablist">
        <li class="menu-item active" id="tab-personal-information" data-bs-toggle="pill" data-bs-target="#content-personal-information" role="tab" aria-controls="content-personal-information" aria-selected="true">
            <span class="icon">@include('icons.svg.profile-menu.icon-1')</span>
            <span class="text">Información personal</span>
        </li>
        <li class="menu-item" id="tab-my-ads" data-bs-toggle="pill" data-bs-target="#content-my-ads" role="tab" aria-controls="content-my-ads">
            <span class="icon">@include('icons.svg.profile-menu.icon-2')</span>
            <span class="text">Mis anuncios</span>
        </li>
        @if($user_info['user']['tipo'] == 'cliente')
            <li class="menu-item" id="tab-become-autonomus" data-bs-toggle="pill" data-bs-target="#content-become-autonomus" role="tab" aria-controls="content-become-autonomus">
                <span class="icon">@include('icons.svg.profile-menu.icon-3')</span>
                <span class="text">Hacerse autónomo</span>
            </li>
        @endif
        @if($user_info['user']['tipo'] == 'autonomo')
            <li class="menu-item" id="tab-autonomous-data" data-bs-toggle="pill" data-bs-target="#content-autonomous-data" role="tab" aria-controls="content-autonomous-data">
                <span class="icon">@include('icons.svg.profile-menu.icon-4')</span>
                <span class="text">Datos autónomo</span>
                @if(!isset($user_info['profile']['is_valid']) || !$user_info['profile']['is_valid'])
                    <span class="info-icon" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Verificar tu cuenta, aumentas la confianza de tus seguidores y atraes a más personas interesadas en tus anuncios" data-bs-original-title="Verificar tu cuenta, aumentas la confianza de tus seguidores y atraes a más personas interesadas en tus anuncios">@include('icons.svg.info-icon')</span>
                @endif
            </li>
        @endif
        <li class="menu-item" id="tab-my-promotions" data-bs-toggle="pill" data-bs-target="#content-my-promotions" role="tab" aria-controls="content-my-promotions">
            <span class="icon">@include('icons.svg.payment-history')</span> {{-- Todo: Cambiar icono --}}
            <span class="text">Mis promociones</span>
        </li>
        <li class="menu-item" id="tab-payment-history" data-bs-toggle="pill" data-bs-target="#content-payment-history" role="tab" aria-controls="content-payment-history">
            <span class="icon">@include('icons.svg.payment-history')</span>
            <span class="text">Historial de pagos</span>
        </li>
        <li class="menu-item" id="tab-change-email" data-bs-toggle="pill" data-bs-target="#content-change-email" role="tab" aria-controls="content-change-email">
            <span class="icon">@include('icons.svg.profile-menu.icon-5')</span>
            <span class="text">Cambiar correo electrónico</span>
        </li>
        <li class="menu-item" id="tab-change-password" data-bs-toggle="pill" data-bs-target="#content-change-password" role="tab" aria-controls="content-change-password">
            <span class="icon">@include('icons.svg.profile-menu.icon-6')</span>
            <span class="text">Cambiar contraseña</span>
        </li>
        {{-- <li class="menu-item">
            <span class="icon">@include('icons.svg.profile-menu.icon-7')</span>
            <span class="text">Soporte técnico</span>
        </li> --}}
        <li class="menu-item no-tab" onclick="document.getElementById('logout-form').submit();">
            <span class="icon">@include('icons.svg.profile-menu.icon-8')</span>
            <span class="text">Cerrar sesión</span>
        </li>
        <li class="menu-item no-tab" id="delete-account-button">
            <span class="icon">@include('icons.svg.profile-menu.icon-8')</span>
            <span class="text">Eliminar cuenta</span>
        </li>
    </ul>
</div>

<!-- Formulario de cierre de sesión oculto -->
<form id="logout-form" action="/logout" method="post" style="display: none;">
    @csrf
</form>
