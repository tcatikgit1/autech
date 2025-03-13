<div id="error-content" class="{{ $display ? '' : 'd-none' }}">
    <div class="d-flex flex-column justify-content-center align-items-center p-5">
        <div class="mb-5">
            @include('icons.svg.not-found')
        </div>
        <div>
            <p class="fs-3 fw-bold">{{ isset($error) ? $error : "Hubo un error al cargar la información" }}</p>
        </div>
    </div>
</div>