@php
    $user_type = session()->get('user')['tipo'] ?? null;
@endphp
<div class="row">
    @if($user_type == 'autonomo')
        <div class="col-md mb-md-0 mb-4">
            <div class="form-check custom-option custom-option-icon">
                <label class="form-check-label custom-option-content" for="radioPromoFreelancer">
                    <span class="custom-option-body">
                        @include('icons.svg.promo1')
                        <span class="custom-option-title"> Autónomo </span>
                        <small> Promocionarse como autónomo </small>
                    </span>
                    <input name="radioPromo" class="form-check-input" type="radio" value="autonomos" id="radioPromoFreelancer" />
                </label>
            </div>
        </div>
    @endif
    <div class="col-md mb-md-0 mb-4">
        <div class="form-check custom-option custom-option-icon">
            <label class="form-check-label custom-option-content" for="radioPromoAdvertisement">
                <span class="custom-option-body">
                    @include('icons.svg.promo2')
                    <span class="custom-option-title"> Anuncios </span>
                    <small> Promocionar un anuncio </small>
                </span>
                <input name="radioPromo" class="form-check-input" type="radio" value="anuncios" id="radioPromoAdvertisement" />
            </label>
        </div>
    </div>
    <div class="col-md mb-md-0 mb-4">
        <div class="form-check custom-option custom-option-icon">
            <label class="form-check-label custom-option-content" for="radioPromoRenewals">
                <span class="custom-option-body">
                    @include('icons.svg.promo3')
                    <span class="custom-option-title"> Renovaciones </span>
                    <small> Renovaciones de anuncios </small>
                </span>
                <input name="radioPromo" class="form-check-input" type="radio" value="renovar" id="radioPromoRenewals" />
            </label>
        </div>
    </div>
</div>

<div id="packs-container">
    {{-- Aqui cargaremos mediante ajax el archivo "profile-promotions-packs.blade.php" --}}
</div>

