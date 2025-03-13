<div id="error-content" class="d-none d-flex justify-content-center">
    <div class="d-flex flex-column justify-content-center align-items-center p-5">
        <div class="mb-5 cursor-pointer reload-action">
            @include('icons.svg.refresh-reload')
        </div>
        <div>
            <p class="fs-3 fw-bold">{{ isset($error) ? $error : "Hubo un error al cargar la información" }}</p>
        </div>
        <div>
            <button class="btn btn-primary reload-action">Reintentar</button>
        </div>
    </div>
</div>