<div class="row align-items-center gy-2">

    <!-- Búsqueda rápida -->
    <div class="col-12 col-md-6 col-lg-4">
        <div class="input-group input-group-merge">
            <input id="busqueda-rapida-search" type="text" class="form-control" placeholder="Búsqueda rápida" aria-label="Search...">
            <span class="input-group-text bg-gray-search" id="btn-search-magnifier">
                @include('icons.svg.magnifier', ["stroke" => '#fff'])
            </span>
        </div>
    </div>

    <!-- Botón de búsqueda avanzada -->
    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
        <button type="button" class="btn btn-primary w-100 d-flex align-items-center">
            @include('icons.svg.filter', ["fill" => '#fff'])
            <span class="ms-1">Búsqueda avanzada</span>
        </button>
    </div>

    <!-- Select de Relevancia -->
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <select class="form-control form-select" id="search-order">
            <option value="relevancia">Relevancia</option>
            <option value="recientes">Más reciente primero</option>
            <option value="precio_asc">Precio: De menor a mayor</option>
            <option value="precio_desc">Precio: De mayor a menor</option>
        </select>
    </div>

    <!-- Select de modo -->
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <select class="form-control form-select" id="search-mode">
            <option value="autonomos" selected>Autónomos</option>
            <option value="anuncios">Anuncios</option>
        </select>
    </div>

    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <label for="select-professions" class="form-label">Multiple</label>
        <select id="select-professions" class="select2 form-select" multiple>
            <option value="65e83a8e4c4a92adc50645d2">Ingeniero Informático</option>
            <option value="65e83a8e4c4a92adc50645d3">medico</option>
            <option value="65e83a8e4c4a92adc50645d5">Diseñador grafico</option>
            <option value="65e83a8e4c4a92adc50645d6">chef</option>
        </select>
    </div>

</div>
