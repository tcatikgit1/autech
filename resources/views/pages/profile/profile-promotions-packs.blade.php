@if($type == 'autonomos')
  <aside>
      @php
          $avatar = asset('assets/img/elements/anuncio-default.png');
          $nombre = '';
          if($type == 'autonomos') {
              $nombre = session()->get('cliente')['nombre'].' '.session()->get('cliente')['apellidos'];
              $avatar = session()->get('cliente')['avatar'];
              $avatar = $avatar
                  ? (str_starts_with($avatar, 'https:')
                      ? $avatar
                      : config('app.FILES_URL') . $avatar)
                  : asset('assets/img/avatars/avatar-default.webp');
          }
      @endphp

      <div class="aside-header">
          <img src="{{ $avatar }}" alt="Perfil" id="aside-image" class="aside-image">
      </div>

      <div class="aside-content">
          {{-- Nombre --}}
          <div class="aside-name-wrapper">
              <h2>{{ $nombre }}</h2>
          </div>

          <hr>

          <button class="btn btn-primary btnAdquirirPromo" disabled>
              Adquirir paquete de promoción
          </button>

      </div>
  </aside>
@endif

<main id="packs-content">
    <div id="wizard-create-app" class="@if(isset($myAdvertisements)) ? bs-stepper : '' @endif shadow-none">

      {{-- ? Esto de aqui es necesario para que el stepper funcione, pero está oculto. --}}
      @if (isset($myAdvertisements))
        <div class="bs-stepper-header border-0 p-1 d-none">

          <div class="step" data-target="#select-adv-pack">
            <button type="button" class="step-trigger">
              <span class="bs-stepper-circle"><i class="ti ti-box"></i></span>
              <span class="bs-stepper-label">
                <span class="bs-stepper-title text-uppercase">Packs</span>
                <span class="bs-stepper-subtitle">Selecciona el pack</span>
              </span>
            </button>
          </div>

          <div class="line"></div>

          <div class="step" data-target="#select-advertisement">
            <button type="button" class="step-trigger">
              <span class="bs-stepper-circle"><i class="ti ti-file-text"></i></span>
              <span class="bs-stepper-label">
                <span class="bs-stepper-title text-uppercase">Anuncios</span>
                <span class="bs-stepper-subtitle">Selecciona el anuncio</span>
              </span>
            </button>
          </div>

        </div>
      @endif

      <div class="bs-stepper-content p-1">

        {{-- Seleccionar el pack de promoción --}}
        <div id="select-adv-pack" class="content">
          <h5>Selecciona la promoción</h5>

          @foreach($advPacks as $pack)
              <div class="card mb-3 w-100 shadow-sm selectable-pack" data-element-id="{{ $pack['_id'] }}">
                  <div class="card-body align-items-center">
                      <div class="flex-grow-1">
                          <h5 class="card-title fw-bold mb-1">{{ $pack['titulo'] }}</h5>
                          <div class="d-flex align-items-center gap-2 text-muted small">
                              @include('icons.svg.euro')
                              <span class="fw-semibold">
                                {{ isset($pack['importe']) ? \App\Helpers\Helpers::formatear_presupuesto($pack['importe']) : '--' }}
                              </span>
                          </div>
                          <p class="card-text small text-muted mt-1">
                              {{ $pack['descripcion'] }}
                          </p>
                      </div>
                  </div>
              </div>
          @endforeach

          @if (!isset($myAdvertisements))
            <button class="btn btn-primary btnAdquirirPromo" disabled>
              Adquirir paquete de promoción
            </button>
          @endif

          @if (isset($myAdvertisements))
            <button class="btn btn-label-secondary btn-prev me-1" disabled> <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i>
                <span class="align-middle d-sm-inline-block d-none">Previous</span>
            </button>
            <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span> <i class="ti ti-arrow-right ti-xs"></i></button>
          @endif
        </div>

        {{-- Si se ha seleccionado "Promocionar anuncio" se muestran los anuncios del usuario --}}
        @if (isset($myAdvertisements))
          <div id="select-advertisement" class="content">
            <h5>Selecciona el anuncio a promocionar</h5>

            @foreach($myAdvertisements as $advertisement)
              <div class="container-my-ads">
                @include('_partials.cards.anuncio-card-panel-usuario', ['anuncio' => $advertisement, 'from' => 'adv-pack'])
              </div>
            @endforeach

            <div class="col-12 d-flex mt-6">
              <button class="btn btn-label-secondary btn-prev me-1"> <i class="ti ti-arrow-left ti-xs me-sm-2 me-0"></i> <span class="align-middle d-sm-inline-block d-none">Previous</span> </button>
              {{-- <button class="btn btn-primary btn-next"> <span class="align-middle d-sm-inline-block d-none me-sm-2">Next</span> <i class="ti ti-arrow-right ti-xs"></i></button> --}}
              <button class="btn btn-primary btnAdquirirPromo" disabled>
                Adquirir paquete de promoción
              </button>
            </div>
          </div>
        @endif

      </div>
    </div>


</main>