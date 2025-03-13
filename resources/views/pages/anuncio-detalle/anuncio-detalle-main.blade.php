<div class="container" id="page-anuncio-detalle">

    {{-- skeleton mientras se cargan el perfil del anuncio --}}
    @include('_partials.skeletons.skeleton-anuncio-detalle-page')
    
    {{-- error si no se encuentra al autónomo o hay algun problema con la petición --}}
    @include('_partials.error', ['error' => 'Hubo un error al cargar la información', 'display' => false])

    {{-- modal para reportar el anuncio --}}
    @include('_partials._modals.modal-select-report-option')

    <div class="grid-container">
        <aside id="aside">
            <!-- Aquí se cargará la vista de anuncio-detalle-aside con los datos del anuncio con AJAX -->
        </aside>
        <main id="content">
            <!-- Aquí se cargará la vista de anuncio-detalle-content con los anuncios con AJAX -->
        </main>
    </div>
</div>