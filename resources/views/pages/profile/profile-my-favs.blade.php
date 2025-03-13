<div id="content-my-favs" class="top-section tab-pane fade" role="tabpanel" aria-labelledby="tab-my-favs">

    {{-- skeleton mientras se cargan los anuncios favoritos --}}
    @include('_partials.skeletons.skeleton-favs-anuncios-user-panel')

    {{-- skeleton mientras se cargan los autonomos favoritos --}}
    @include('_partials.skeletons.skeleton-favs-autonomos-user-panel')

    <div id="favorites-container">
        {{-- Se hará un append del archivo profile-my-favs-content que viene por AJAX --}}
    </div>

</div>