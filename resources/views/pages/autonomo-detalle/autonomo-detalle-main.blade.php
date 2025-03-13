<div class="container" id="page-autonomo-detalle">

    {{-- skeleton mientras se cargan el perfil del autonomo --}}
    @include('_partials.skeletons.skeleton-autonomo-detalle-page')
    
    {{-- error si no se encuentra al autónomo o hay algun problema con la petición --}}
    @include('_partials.error', ['error' => 'Hubo un error al cargar la información', 'display' => false])

    <div class="grid-container">
        <aside id="profile">
            <!-- Aquí se cargará la vista de autonomo-detalle-aside con los datos del autonomo con AJAX -->
        </aside>
        <main id="content">
            <!-- Aquí se cargará la vista de autonomo-detalle-content con los anuncios con AJAX -->
        </main>
    </div>
</div>