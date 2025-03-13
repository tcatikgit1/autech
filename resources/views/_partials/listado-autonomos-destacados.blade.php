@if (count($autonomos) <= 0)
    <div>
        No hay autonomos destacados
    </div>
@else
    {{-- @foreach ($autonomos as $autonomo) --}}
    @for ($i = 0; $i < 8; $i++)
        @include('_partials.cards.autonomo-card-destacado', ["autonomo" => $autonomos[0]['autonomo_full']])
        {{-- @endforeach --}}
    @endfor


@endif
