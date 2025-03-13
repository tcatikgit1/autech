@if (count($response['data']) <= 0)
    <div class="text-center p-5">
        @include('_partials.error', ['error' => 'No se han encontrado resultados', 'display' => true])
    </div>
@else
    @foreach ($response['data'] as $autonomo)
        @include('_partials.cards.autonomo-card', ["autonomo" => $autonomo, 'classCard' => 'w-18'])
    @endforeach

    {{-- Pagination --}}
    <div class="col-12">
        <div class="demo-inline-spacing">
          <nav aria-label="Page navigation">
            <ul class="pagination pagination-rounded justify-content-center">
              @if (isset($response['currentPage']) && $response['currentPage'] > 1)
                <li class="page-item prev">
                    <a class="page-link pagination-prev cursor-pointer" data-page="{{ $response['currentPage'] - 1 }}"><i class="ti ti-chevron-left ti-sm"></i></a>
                </li>
                <li class="page-item">
                    <a class="page-link pagination-prev cursor-pointer" data-page="{{ $response['currentPage'] - 1 }}">{{ $response['currentPage'] - 1 }}</a>
                </li>
              @endif

              <li class="page-item active">
                <a class="page-link">{{ $response['currentPage'] }}</a>
              </li>

              @if (isset($response['next_page']))
                <li class="page-item">
                    <a class="page-link pagination-next cursor-pointer" data-page="{{ $response['next_page'] }}">{{ $response['next_page'] }}</a>
                </li>
                <li class="page-item next">
                    <a class="page-link pagination-next cursor-pointer" data-page="{{ $response['next_page'] }}"><i class="ti ti-chevron-right ti-sm"></i></a>
                </li>
              @endif

            </ul>
          </nav>
        </div>
    </div>

@endif
