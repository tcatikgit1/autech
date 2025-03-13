<section id="anuncios-destacados" class="anuncios-destacados py-4">

    {{-- Contenedor con Flexbox para alinear el título y el botón a los lados opuestos --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Anuncios destacados</h2>
        <a href="{{ route('search', ['modo' => 'anuncios']) }}" target="_blank" class="btn btn-link text-dark">Descubre más</a>
    </div>

    {{-- skeleton mientras se cargan los anuncios destacados --}}
    @include('_partials.skeletons.skeleton-anuncios-destacados')

    {{-- Contenedor donde se cargarán los anuncios mediante AJAX --}}
    <div class="row" id="anuncios-destacados-container" style="padding-left: 0;">
        <!-- Aquí se cargarán los anuncios destacados con AJAX -->
    </div>

</section>
