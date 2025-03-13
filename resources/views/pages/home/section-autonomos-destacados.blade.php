<section id="autonomos-destacados" class="anuncios-destacados py-4">

    {{-- Contenedor con Flexbox para alinear el título y el botón a los lados opuestos --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-4">Autónomos destacados</h2>
        <a href="{{ route('search', ['modo' => 'autonomos']) }}" target="_blank" class="btn btn-link text-dark">Descubre más</a>
    </div>
    
    {{-- Skeleton mientras se cargan los autonomos destacados --}}
    @include('_partials.skeletons.skeleton-autonomos-destacados')

    {{-- Contenedor donde se cargarán los autonomos mediante AJAX --}}
    <div class="row" style="padding-left: 0">
        <div class="swiper swiper-autonomos-destacados">
            <div id="autonomos-destacados-container" class="swiper-wrapper mb-4">
                <!-- Aquí se cargarán los autonomos destacados con AJAX -->
            </div>
        </div>
    </div>

</section>
