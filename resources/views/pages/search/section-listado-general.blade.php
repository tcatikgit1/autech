<section id="listado-general" class="listado-general py-4">

    <h2 class="mb-4 title-section" data-title-autonomos="Listado de profesionales" data-title-anuncios="Listado de anuncios">Listado de profesionales</h2>

    {{-- Spinner o cargador mientras se cargan los anuncios --}}
    {{-- <div id="spinner-loading-listado-general" style="display: none;" class="text-center my-4">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div> --}}

    {{-- skeleton mientras se cargan los elementos del listado general --}}
    @include('_partials.skeletons.skeleton-listado-general')

    {{-- Contenedor donde se cargarán los anuncios mediante AJAX --}}
    <div class="row justify-content-center gap-12" id="listado-general-container" style="padding-left: 0">
        <!-- Aquí se cargarán los datos (anuncios o autonomos) mediante AJAX. Archivos listado.autonomos-search/listado-anuncios-search -->
    </div>

</section>
