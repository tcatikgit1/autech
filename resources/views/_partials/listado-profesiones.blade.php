@if (count($profesiones) <= 0)
    <div>
        Estamos trabajando para incluir más profesiones
    </div>
@else
    {{-- @for ($i = 0; $i < 8; $i++) --}}
        @foreach ($profesiones as $profesion)
            @include('_partials.profesion-pill', ['profesion' => $profesion])
        @endforeach
    {{-- @endfor --}}
@endif
