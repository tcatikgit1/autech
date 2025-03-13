@php
    $anuncios_count = 0;
    if (isset($autonomo['anuncios'])) {
        $anuncios_count = count($autonomo['anuncios']);
    } elseif (isset($autonomo['anuncio_count'])) {
        $anuncios_count = $autonomo['anuncio_count'];
    } elseif (isset($autonomo['anuncios_count'])) {
        $anuncios_count = $autonomo['anuncios_count'];
    }
@endphp

<div id="autonomo-{{ \App\Helpers\Helpers::getId($autonomo['_id']) }}"
    class="autonomo-card card swiper-slide {{ isset($classCard) ? $classCard : '' }}"
    data-link="{{ route('pageAutonomoDetalle', ['id' => \App\Helpers\Helpers::getId($autonomo['_id'])]) }}"
    onclick="if (!event.target.closest('.no-redirect')) { window.open(this.dataset.link, '_blank'); }">

    <div class="image-container">

        {{-- Etiqueta "Destacado" --}}
        {{-- @if ($autonomo['destacado']) --}}
        <span class="badge badge-destacado top-0 start-0 m-2">Destacado</span>
        {{-- @endif --}}

        {{-- Ícono de verificación --}}
        {{-- @if ($autonomo['verificado']) --}}
        <span class="badge badge-verificado top-0 end-0 m-2">
            @include('icons.svg.verified')
        </span>
        {{-- @endif --}}

        {{-- Ícono de favorito | Solo se ve desde el panel de usuario --}}
        @if (isset($from) && $from == 'favorites')
            <span class="badge badge-fav no-redirect bottom-0 end-0 m-2" data-target-id="{{$autonomo['_id']}}" data-type="autonomo">
                @include('icons.svg.heart')
            </span>
        @endif

        @include('_partials.avatar', [
            'avatar' => $autonomo['cliente']['avatar'],
            'class' => 'card-img-top w-full',
            'alt' => $autonomo['nombre'] . ' ' . $autonomo['apellidos'],
            'default' => asset('assets/img/avatars/avatar-default.webp')
        ])
        
    </div>

    <div class="card-body bg-white w-100 d-flex flex-column align-items-start rounded-bottom border-bottom border-1">
        <h5 class="card-title">{{ $autonomo['nombre'] }} {{ @$autonomo['apellidos'] }}</h5>
        @isset($autonomo['profesion_full']['titulo'])
            <p class="card-text">{{ $autonomo['profesion_full']['titulo'] }}</p>
        @endisset


        <div class="d-flex justify-content-between w-100 align-items-center mt-2">
            {{-- Cantidad de anuncios --}}
            <a href="#" class="btn btn-primary">{{ $anuncios_count }} anuncio{{ $anuncios_count == 1 ? '' : 's' }}</a>

            {{-- Botones de acción --}}
            <div class="d-flex">
                @if(is_null(session()->get('user')) || (isset($autonomo['cliente']['email']) && session()->get('user')['email'] != $autonomo['cliente']['email']))
                    @if($autonomo['is_data_visibility'])
                        @isset($autonomo['cliente']['telefono'])
                            <a href="tel:{{ $autonomo['cliente']['telefono'] }}" class="icon-circle me-3 no-redirect">
                                @include('icons.svg.phone', ['color' => '#52CFC4'])
                            </a>
                        @endisset
                    @endif
                    <a href="chat-url" class="icon-circle no-redirect">
                        @include('icons.svg.chat', ['color' => '#52CFC4'])
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
