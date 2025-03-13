<div id="skeleton-autonomo-detalle-page">

    <div class="skeleton-aside shadow-sm card d-flex align-items-center flex-column" style="height: 550px; padding: 20px;">

        <div class="skeleton-img" style="width: 165px; height: 165px; background-color: #e0e0e0; border-radius: 50%; margin-bottom: 35px;"></div>

        <div class="skeleton-title rounded" style="width: 80%; height: 15px; background-color: #e0e0e0; margin-bottom: 10px;"></div>

        <div class="skeleton-title rounded" style="width: 80%; height: 45px; background-color: #e0e0e0; margin-bottom: 10px;"></div>

        <div style="width: 100%;">
            <div class="row justify-content-evenly mb-1">
                <div class="skeleton-icon col-5 rounded" style="height: 45px; background-color: #e0e0e0; margin-bottom: 10px;"></div>
                <div class="skeleton-icon col-5 rounded" style="height: 45px; background-color: #e0e0e0; margin-bottom: 10px;"></div>
            </div>

            <div class="row justify-content-evenly mb-1">
                <div class="skeleton-icon col-5 rounded" style="height: 45px; background-color: #e0e0e0; margin-bottom: 10px;"></div>
                <div class="skeleton-icon col-5 rounded" style="height: 45px; background-color: #e0e0e0; margin-bottom: 10px;"></div>
            </div>

            <div class="row justify-content-evenly">
                <div class="skeleton-icon col-5 rounded" style="height: 45px; background-color: #e0e0e0; margin-bottom: 10px;"></div>
                <div class="skeleton-icon col-5 rounded" style="height: 45px; background-color: #e0e0e0; margin-bottom: 10px;"></div>
            </div>
        </div>


    </div>

    <div class="row justify-content-center gap-2 overflow-hidden">
        @for ($i = 0; $i < 6; $i++)
            <!-- Skeleton Loader Card -->
            <div class="w-auto">
                <div class="skeleton-autonomo-detalle-page-container">
                    <div class="card skeleton-card shadow-sm mb-1" style="padding-left: 0; width: 18rem;">
                        <div class="g-0 card-content">
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
