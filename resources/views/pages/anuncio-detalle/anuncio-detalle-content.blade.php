<section id="advs-section">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Anuncios de {{ $anuncio['autor']['nombre'] . ' ' . $anuncio['autor']['apellidos'] }}</h3>
        <a href="{{ route('search') }}" target="_blank" class="btn btn-light ver-mas">Ver más</a>
    </div>
    <div class="ads">
        @forelse ($anuncio['autor']['anuncios'] as $anuncioAutor)
            @include('_partials.cards.anuncio-card', ['anuncio' => $anuncioAutor, 'autor' => $anuncio['autor']])
        @empty
            <p>Este profesional no dispone de más anuncios</p>
        @endforelse
    </div>
</section>

<section id="featured-ads-section">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Otros anuncios destacados</h3>
        <a href="{{ route('search') }}" target="_blank" class="btn btn-light ver-mas">Ver más</a>
    </div>
    <div class="ads">
        @forelse ($anuncios_destacados as $anuncio_destacado)
            @include('_partials.cards.anuncio-card', ['anuncio' => $anuncio_destacado['anuncio_full']])
        @empty
            <p>Actualmente no existen otros autónomos destacados</p>
        @endforelse
    </div>
</section>
