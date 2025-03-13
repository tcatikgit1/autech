<div class="modal fade" id="modal-filters-advertisement" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Filtro anuncios</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="advertisement-filters-form">
                    @csrf
                    <!-- Campo de búsqueda -->
                    <div class="mb-3">
                        <label class="form-label visually-hidden" for="search-text">¿Qué estás buscando?</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                            <input type="text" class="form-control" name="search-text" id="search-text" placeholder="¿Qué estás buscando?" aria-label="Search..." aria-describedby="basic-addon-search31" />
                        </div>
                    </div>

                    <!-- Línea divisoria | 24px es el padding por cada lado del modal -->
                    <hr style="width: calc(100% + 48px); margin-left: -24px;"> 

                    <!-- Tipo de anuncio -->
                    @if($user_info['user']['tipo'] == 'autonomo')
                        <div class="mb-3">
                            <label class="form-label" for="tipo_anuncio">Tipo de anuncio</label>
                            <select id="tipo_anuncio" name="tipo_anuncio" class="form-select">
                                <option value="">Todos</option>
                                <option value="oferta">Oferta</option>
                                <option value="demanda">Demanda</option>
                            </select>
                        </div>
                    @endif()

                    <!-- Estado visible -->
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <div class="btn-group w-100" role="group" aria-label="Basic radio toggle button group">
                          <input type="radio" class="btn-check" name="btnradio" id="btnradio1" checked value="todos">
                          <label class="btn btn-outline-primary flex-grow-1" for="btnradio1">Todos</label>
                      
                          <input type="radio" class="btn-check" name="btnradio" id="btnradio2" value="visibles">
                          <label class="btn btn-outline-primary flex-grow-1" for="btnradio2">Visibles</label>
                      
                          <input type="radio" class="btn-check" name="btnradio" id="btnradio3" value="ocultos">
                          <label class="btn btn-outline-primary flex-grow-1" for="btnradio3">Ocultos</label>
                        </div>
                    </div>

                    <!-- Profesión/Sector -->
                    <div class="mb-3">
                        <label class="form-label" for="select-profesion-filter">Sector</label>
                        <select id="select-profesion-filter" name="profesion_id" class="form-select populate-profesion">
                            <option value="" selected>Todos</option>
                        </select>
                    </div>

                    <!-- Botón Filtrar -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100 mb-2">Filtrar</button>
                        <button type="button" id="clear-filters" class="btn btn-secondary w-100">Resetear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
