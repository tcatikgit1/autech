<div id="skeleton-listado-general">
    <div class="row justify-content-center gap-12 overflow-hidden">
        @for ($i = 0; $i < 8; $i++)
            <!-- Skeleton Loader Card -->
            <div class="w-auto">
                <div class="skeleton-listado-general-container">
                    <div class="card skeleton-card shadow-sm mb-1" style="padding-left: 0; width: 18rem;">
                        <div class=" g-0 card-content">
                            {{-- Imagen del esqueleto --}}
                            <div class="col-12">
                                <div class="skeleton-img"
                                    style="width: 100%; height: 190px; background-color: #e0e0e0; border-radius: 8px 8px 0 0;">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-body p-2">
                                    {{-- Titulo y descripcion en esqueleto --}}
                                    <div class="skeleton-title"
                                        style="width: 50%; height: 15px; background-color: #e0e0e0; margin-bottom: 10px;">
                                    </div>
                                    <div class="skeleton-description"
                                        style="width: 70%; height: 10px; background-color: #e0e0e0; margin-bottom: 15px;">
                                    </div>
                                    {{-- Botón de autonomos y botones de acción en esqueleto --}}
                                    <div class="d-flex justify-content-between align-items-center">
                                        {{-- Botón de cantidad de autonomos (esqueleto) --}}
                                        <div class="skeleton-btn"
                                            style="width: 80px; height: 25px; background-color: #e0e0e0; border-radius: 12px;">
                                        </div>
                                        {{-- Botones de llamada, chat, etc. (esqueleto) --}}
                                        <div class="d-flex gap-2">
                                            <div class="skeleton-icon"
                                                style="width: 30px; height: 30px; background-color: #e0e0e0; border-radius: 50%;">
                                            </div>
                                            <div class="skeleton-icon"
                                                style="width: 30px; height: 30px; background-color: #e0e0e0; border-radius: 50%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>
