<!-- Skeleton Loader HTML -->
<div class="row" id="skeleton-favs-anuncios-user-panel">
    <!-- Skeleton Card -->
    @for ($i = 0; $i < 3; $i++)
        <div class="card skeleton-card mb-3" style="max-width: 100%;">
            <div class="row g-0">
                <div class="col-md-3 col-xl-2 p-4">
                    <!-- Simula la imagen -->
                    <div class="skeleton-img rounded" style="width: 100%; height: 150px; background-color: #e0e0e0;"></div>
                </div>
                <div class="col-md-9 col-xl-10">
                    <div class="card-body">
                        <!-- Simula el título -->
                        <div class="skeleton-title rounded"
                            style="width: 50%; height: 20px; background-color: #e0e0e0; margin-bottom: 10px;"></div>
                        <!-- Simula la descripción -->
                        <div class="skeleton-text rounded"
                            style="width: 100%; height: 15px; background-color: #e0e0e0; margin-bottom: 10px;"></div>
                        <div class="skeleton-text rounded"
                            style="width: 90%; height: 15px; background-color: #e0e0e0; margin-bottom: 10px;"></div>
                        <!-- Simula los botones -->
                        <div class="d-flex gap-2">
                            <div class="skeleton-btn rounded" style="width: 80px; height: 35px; background-color: #e0e0e0;">
                            </div>
                            <div class="skeleton-btn rounded" style="width: 80px; height: 35px; background-color: #e0e0e0;">
                            </div>
                            <div class="skeleton-btn rounded" style="width: 80px; height: 35px; background-color: #e0e0e0;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endfor
</div>
