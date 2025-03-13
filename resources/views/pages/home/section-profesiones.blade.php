<section id="listado-profesiones" class="listado-profesiones py-4 swiper-profesiones-skeleton">

    <div class="d-flex justify-content-between align-items-center">
        <h2 class="mb-4">Profesiones</h2>
        {{-- <a href="#" class="text-muted">Descubre más</a> --}} {{-- Botón "Descubre más" --}}
    </div>

    {{-- Skeleton mientras se cargan las profesiones --}}
    @include('_partials.skeletons.skeleton-profesiones')

    {{-- Slider de profesiones --}}
    <div class="swiper-profesiones">
        <div class="swiper-wrapper" id="listado-profesiones-container">
            <!-- Aquí se cargarán las profesiones mediante AJAX -->
        </div>
    </div>

</section>
