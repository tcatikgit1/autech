<div id="skeleton-profesiones-container">
    <div class="overflow-hidden">
        <div class="d-flex gap-6">
            @for ($i = 0; $i < 10; $i++)
                <div class="w-auto">
                    <div class="skeleton-pill-container">
                        <div class="skeleton-pill">
                            <div class="skeleton-icon"></div>
                            <div class="skeleton-text"></div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>
