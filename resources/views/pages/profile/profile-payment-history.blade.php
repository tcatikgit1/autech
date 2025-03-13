<div id="content-payment-history" class="bottom-section tab-pane fade" role="tabpanel" aria-labelledby="tab-payment-history">
    <h5>Historial de pago</h5>

    @include('_partials.skeletons.skeleton-historial-pagos')

    <div id="payment-history-container">
        {{-- Aqui se carga mediante AJAX la vista del historial de pagos (profile-payment-history-content.blade.php) --}}
    </div>

    

</div>