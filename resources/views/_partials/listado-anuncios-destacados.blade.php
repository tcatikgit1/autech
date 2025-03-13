@if (count($anuncios) <= 0)
    <div>
        Actualmente no hay anuncios destacados
    </div>
@else
    @foreach ($anuncios as $anuncio)
        @include('_partials.cards.anuncio-card-destacado', ['anuncio' => $anuncio["anuncio_full"]])
    @endforeach
@endif
