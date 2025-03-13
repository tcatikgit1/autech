<div id="favorites-anuncios" class="favorites-list d-none {{ empty($anuncios) ? 'empty' : '' }}"">
    @if(empty($anuncios))
        <div class="empty-favs-container">
            @include('icons.svg.magnifier-3')
            <h5>No tienes ningún anuncio como favorito</h5>
        </div>
    @else
        @foreach ($anuncios as $anuncio)
            @include('_partials.cards.anuncio-card-destacado', ['anuncio' => $anuncio, 'from' => 'favorites'])
        @endforeach
    @endif
</div>

<div id="favorites-autonomos" class="favorites-list d-none {{ empty($autonomos) ? 'empty' : '' }}"">
    @if(empty($autonomos))
        <div class="empty-favs-container">
            @include('icons.svg.magnifier-3')
            <h5>No tienes ningún profesional como favorito</h5>
        </div>
    @else
        <div class="grid-container">
            @foreach ($autonomos as $autonomo)
                @include('_partials.cards.autonomo-card', ["autonomo" => $autonomo, 'classCard' => 'w-18', 'from' => 'favorites'])
            @endforeach
        </div>
    @endif
</div>

{{-- Plantilla del contenido vacío. Aparece en el empty cuando se elimina el ultimo anuncio favorito mediante javascript --}}
<meta name="empty-template-anuncio" content='
    <div class="empty-favs-container">
        @include("icons.svg.magnifier-3")
        <h5>No tienes ningún anuncio como favorito</h5>
    </div>
'>

{{-- Plantilla del contenido vacío. Aparece en el empty cuando se elimina el ultimo autonomo favorito mediante javascript --}}
<meta name="empty-template-autonomo" content='
    <div class="empty-favs-container">
        @include("icons.svg.magnifier-3")
        <h5>No tienes ningún profesional como favorito</h5>
    </div>
'>
