<section id="advs-section" class="advs-section">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Anuncios de {{ $autonomo['nombre'] . ' ' . $autonomo['apellidos'] }}</h3>
        <a href="{{ route('search') }}" target="_blank" class="btn btn-light ver-mas">Ver más</a>
    </div>
    <div class="ads">
        @forelse ($autonomo['anuncios'] as $anuncio)
            @include('_partials.cards.anuncio-card', ['anuncio' => $anuncio, 'autor' => $autonomo])
        @empty
            <p>Este profesional no dispone de más anuncios</p>
        @endforelse
    </div>
</section>

<section id="featured-freelancers-section" class="featured-freelancers">
    <div class="d-flex justify-content-between align-items-center">
        <h3>Otros autónomos destacados</h3>
        <a href="{{ route('search') }}" target="_blank" class="btn btn-light ver-mas">Ver más</a>
    </div>
    
    <div class="freelancers">
        @forelse ($autonomos_destacados as $autonomo)
            @include('_partials.cards.autonomo-card', ['autonomo' => $autonomo['autonomo_full']])
        @empty
            <p>Actualmente no existen otros autónomos destacados</p>
        @endforelse
    </div>
</section>
