<!-- Modal de Reporte -->
<div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 1px solid #dee2e6; padding-bottom: 10px;">
                <div class="d-flex flex-column">
                    <h5 class="modal-title" id="reportModalLabel">Reporte de nuncio</h5>
                    <span class="form-label">¿Por qué quieres reportar este anuncio?</span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="report-form">

                    <!-- skeleton mientras se cargan las opciones -->
                    @include('_partials.skeletons.skeleton-modal-select-report-option')

                    {{-- Aqui iran las opciones de reporte que provinen del AJAX --}}
                    <div id="opciones-reporte" class="d-none"></div>

                    <!-- Aqui irá el TextArea de observaciones, se incluye mediante JS con el AJAX -->

                    <!-- Botones Enviar y Cancelar -->
                    <div class="d-flex justify-content-start">
                        <button id="btn-report" type="submit" class="btn btn-primary">Enviar</button>
                        <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
