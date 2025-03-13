<a href="{{ url('/search') }}?profesion[]={{ \App\Helpers\Helpers::getId($profesion['_id']) }}" class="swiper-slide text-decoration-none">
    <div class="pill-profesion d-flex align-items-center">
        @php
            // Crear la variable de la URL de la imagen
            $imagen = isset($profesion['imagen']) 
                ? config('app.FILES_URL').$profesion['imagen'] 
                : null;
        @endphp

        @if ($imagen)
            {{-- Mostrar la imagen si está definida --}}
            <img src="{{ $imagen }}" alt="{{ $profesion['titulo'] }}" class="icono-profesion me-2">
        @else
            {{-- Incluir el SVG u otro contenido si no hay imagen disponible --}}
            <div class="me-2">
                @include('_partials.macros', ['height' => 24, 'width' => 24, 'withbg' => 'fill: #fff;'])
            </div>
        @endif

        <span>{{ $profesion['titulo'] }}</span>
    </div>
</a>
