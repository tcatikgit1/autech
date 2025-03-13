<div class="container" id="page-user-panel">

    {{-- skeleton mientras se cargan el perfil del anuncio --}}
    @include('_partials.skeletons.skeleton-user-panel-page')

    {{-- error si no se encuentra al autónomo o hay algun problema con la petición --}}
    @include('_partials.error-profile', ['error' => 'Se ha producido un error de carga del perfil', 'display' => false])

    <div class="grid-container">
        <aside id="profile">
            <!-- Aquí se cargará la vista de user-panel-aside con los datos del usuario con AJAX -->
            {{-- @include('pages.profile.profile-aside') --}}
        </aside>
        <main id="content">
            <!-- Aquí se cargará la vista del contenido con AJAX -->
            {{-- @include('pages.profile.profile-content') --}}
        </main>
    </div>
</div>