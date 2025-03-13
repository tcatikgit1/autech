<section id="content-section" class="tab-content">

    {{-- Mis favoritos (Anuncios y autonomos) --}}
    @include('pages.profile.profile-my-favs')
    
    {{-- Formulario de perfil --}}
    @include('pages.profile.profile-form')

    {{-- Mis anuncios --}}
    @include('pages.profile.profile-ads', ['anuncios' => $user_info['profile']['anuncios']])

    {{-- Formulario hacerse autonomo --}}
    @if($user_info['user']['tipo'] == 'cliente')
        @include('pages.profile.profile-become-autonomus')
    @endif

    {{-- Datos autonomo --}}
    @if($user_info['user']['tipo'] == 'autonomo')
        @include('pages.profile.profile-autonomus-data', ['user' => $user_info])
    @endif

    {{-- Mis promociones --}}
    @include('pages.profile.profile-my-promotions')

    {{-- Historial de pagos --}}
    @include('pages.profile.profile-payment-history')

    {{-- Formulario cambiar correo electronico --}}
    @include('pages.profile.profile-change-email-form')

    {{-- Formulario cambiar contraseña --}}
    @include('pages.profile.profile-change-password-form')
    

    
</section>
