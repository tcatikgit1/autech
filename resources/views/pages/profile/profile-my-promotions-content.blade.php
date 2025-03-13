
{{-- Selectores de paquetes de promoción --}}
@include('pages.profile.profile-promotions-choice')

<div>
    <div class="accordion mt-4" id="accordionMyPromotions">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Mis promociones adquiridas
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionMyPromotions">
                <div class="accordion-body">

                    @forelse($myPromotions as $item)
                        @php

                            if ($item['type'] == 'anuncios') {
                                if (
                                    isset($item['transaccion']['anuncio']['imagenes']) &&
                                    $item['transaccion']['anuncio']['imagenes'] != ''
                                ) {
                                    $avatar = config('app.FILES_URL') . explode(',', $item['transaccion']['anuncio']['imagenes'])[0];
                                } else {
                                    $avatar = asset('assets/img/elements/anuncio-default.png');
                                }
                            } elseif ($item['type'] == 'autonomos') {
                                if (isset($item['transaccion']['autonomo']['cliente']['avatar'])) {
                                    $avatar = config('app.FILES_URL') . $item['transaccion']['autonomo']['cliente']['avatar'];
                                } else {
                                    $avatar = asset('assets/img/avatars/avatar-default.webp');
                                }
                            }

                        @endphp

                        <div class="card mb-3 w-100 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <!-- Imagen a la izquierda -->
                                <img src="{{ $avatar }}" class="rounded object-fit-cover me-3" style="width: 145px; height: 120px;" alt="Imagen">

                                <!-- Contenido a la derecha -->
                                <div class="flex-grow-1">
                                    <h5 class="card-title fw-bold mb-1">{{ $item['titulo'] }}</h5>
                                    <div class="d-flex align-items-center gap-2 text-muted small">
                                        @include('icons.svg.euro')
                                        <span class="fw-semibold">{{ isset($item['importe']) ? \App\Helpers\Helpers::formatear_presupuesto($item['importe']) : '--' }}</span>
                                        <span>Pagado: {{ \Carbon\Carbon::parse($item['created_at'])->format('d/m/y') }}</span>
                                    </div>
                                    <p class="card-text small text-muted mt-1">
                                        {{ $item['descripcion'] }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    @empty
                        <p>Aún no has adquirido ninguna promoción</p>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>
