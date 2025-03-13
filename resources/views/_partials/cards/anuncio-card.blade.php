<div 
    id="anuncio-{{ \App\Helpers\Helpers::getId($anuncio['_id']) }}" 
    class="anuncio-card card {{isset($classCard) ? $classCard : ""}}" 
    style="padding: 0;"
    data-link="{{ route('pageAnuncioDetalle', ['id' => \App\Helpers\Helpers::getId($anuncio['_id'])]) }}"
    onclick="if (!event.target.closest('.no-redirect')) { window.open(this.dataset.link, '_blank'); }"
>

    {{-- Etiqueta "Destacado" --}}
    {{-- @if($autonomo['destacado']) --}}
    <span class="badge badge-destacado top-0 start-0 m-2">Destacado</span>
    {{-- @endif --}}

    {{-- Ícono de verificación --}}
    {{-- @if($autonomo['verificado']) --}}
    <span class="badge badge-verificado top-0 end-0 m-2">
            @include('icons.svg.verified')
        </span>
    {{-- @endif --}}

    {{-- Imagen --}}
    @php
        // Obtener la cadena de imágenes
        $imagenes = $anuncio['imagenes'] ?? '';
        // Separar la cadena en un array
        $imagenesArray = explode(',', $imagenes);
        // Obtener la primera imagen si existe
        $primeraImagen = $imagenesArray[0] ?? asset('assets/img/elements/anuncio-default.png'); // Todo: definir una imagen por defecto en caso de que no haya imágenes
        // Concatenar la URL base con la primera imagen
        $imagenUrl = config('app.FILES_URL') . $primeraImagen;
    @endphp

    @include('_partials.avatar', [
        'avatar' => $imagenUrl,
        'class' => 'card-img-top w-full',
        'alt' => $anuncio["titulo"]
    ])

    <div class="card-body bg-white w-100 d-flex flex-column align-items-start rounded-bottom border-bottom border-1">
        <div>
            <h5 class="card-title">{{ $anuncio['titulo'] }}</h5>
            @isset($anuncio['profesion']['titulo'])
                <p class="card-text">{{ $anuncio['profesion']['titulo'] }}</p>
            @endisset
        </div>


        <div class="d-flex justify-content-between w-100 align-items-center mt-2">

            <a href="{{ route('pageAnuncioDetalle', ['id' => \App\Helpers\Helpers::getId($anuncio['_id'])]) }}" target="_blank" class="btn btn-primary">Ver más</a>

            {{-- Botones de acción --}}
            @if(is_null(session()->get('user')) || (isset($anuncio['cliente']['email']) && session()->get('user')['email'] != $anuncio['cliente']['email'])) {{-- Si el usuario está logueado y es el mismo que creó el anuncio, no se muestran los botones de chat y teléfono --}}
                <div class="d-flex">
                    @if(isset($autor) && !is_null($autor)) {{-- Segun donde se invoca 'anuncio-card' utilizo la variable autor --}}

                        @if($autor['is_data_visibility']) {{-- Si el autor tiene la visibilidad de datos activada --}}
                            @isset($autor['cliente']['telefono'])
                                <a href="tel:{{$autor['cliente']['telefono']}}" class="icon-circle me-3 no-redirect">
                                    @include('icons.svg.phone', ['color' => '#52CFC4'])
                                </a>
                            @endisset
                        @endif

                    @elseif($anuncio['autor_full'])
                        @if($anuncio['autor_full']['is_data_visibility']) {{-- Si el autor tiene la visibilidad de datos activada --}}
                            @isset($anuncio['cliente']['telefono'])
                                <a href="tel:{{$anuncio['cliente']['telefono']}}" class="icon-circle me-3 no-redirect">
                                    @include('icons.svg.phone', ['color' => '#52CFC4'])
                                </a>
                            @endisset
                        @endif

                    @endif

                    <a href="chat-url" class="icon-circle no-redirect">
                        @include('icons.svg.chat', ['color' => '#52CFC4'])
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
