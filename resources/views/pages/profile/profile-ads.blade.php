<div id="content-my-ads" class="bottom-section tab-pane fade" role="tabpanel" aria-labelledby="tab-my-ads">

    <input type="hidden" id="form-adv-method" value="">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Anuncios publicados</h5>
        <div class="d-flex justify-content-center align-items-center gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form-advertisement" onclick="$('#form-adv-method').val('new')"><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i> Crear anuncio</button>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modal-filters-advertisement"><span class="me-2">@include('icons.svg.filter')</span> Filtros</button>
        </div>
    </div>

    <div class="container-my-ads">
        @forelse ($anuncios as $anuncio)
            @include('_partials.cards.anuncio-card-panel-usuario', ['anuncio' => $anuncio, 'from' => 'profile-ads'])
        @empty
            <div class="empty-ads-container">
                @include('icons.svg.magnifier-3')
                <h5>No tienes ninguna publicación de anuncios</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form-advertisement" onclick="$('#form-adv-method').val('new')"><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i> Crear anuncio</button>
            </div>
        @endforelse
    </div>

    {{-- Plantilla del contenido vacío. Aparece en el empty cuando se elimina el ultimo anuncio mediante javascript --}}
    <meta name="empty-template" content='
        <div class="empty-ads-container">
            @include("icons.svg.magnifier-3")
            <h5>No tienes ninguna publicación de anuncios</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-form-advertisement">
                <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i> Crear anuncio
            </button>
        </div>
    '>
        
    @include('_partials/_modals/modal-form-advertisement')
    @include('_partials/_modals/modal-filters-advertisement')
    
</div>