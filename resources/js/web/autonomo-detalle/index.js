import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

(function () {

    cargarAutonomoDetalleContent();

})();

function cargarAutonomoDetalleContent() {
    const autonomoId = $('#autonomo-id').val();

    if(autonomoId != null && autonomoId != '') {
        $.ajax({
            url: `/get-autonomo-view/${autonomoId}`,
            method: 'GET',
        })
        .done((response) => {
            $('#skeleton-autonomo-detalle-page').fadeOut(400, function() {
                $('#profile').empty().append(response.aside).fadeIn(400);
                $('#content').empty().append(response.content).fadeIn(400);
            });
        })
        .fail((error) => {
            $('.grid-container').fadeOut(400, function() {
                $('#error-content').removeClass('d-none');
            });
        })
        .always(() => {
            $('#skeleton-autonomo-detalle-page').fadeOut();
        });
    }
}

// Función que realiza la llamada AJAX para dar like a un autonomo
function setLike() {

    const autonomoId = $('#autonomo-id').val();

    const data = {
        like_tipo: 'autonomo', // tipo de elemento al que se le da like (autonomo, anuncio)
        like_id: autonomoId // id del elemento al que se le da like (autonomo, anuncio)
    };

    if(autonomoId != null && autonomoId != '') {
        $.ajax({
            url: `/set-like`,
            method: 'POST',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // al usar CSRF ponemos esta linea
            }
        })
        .done((response) => {

            if(response.error) {
                if(response.error == "Unauthorized") {
                    toastr.error('Debe iniciar sesión para poder guardar como favoritos.');
                } else {
                    toastr.error('Hubo un error al intentar guardar como favorito.');
                }
                return;
            }

            // Actualizar el estado del corazón basado en la respuesta
            const isFav = response.is_fav;

            // Cambiar el fill del corazón dependiendo del estado
            const heart = $('.icon-heart path');
            heart.attr('fill', isFav ? '#52CFC4' : 'none');

            if (isFav) {
                toastr.options.timeOut = 2000;
                toastr.success("¡Se ha añadido a favoritos!");
            } else {
                toastr.options.timeOut = 2000;
                toastr.success("¡Se ha eliminado de favoritos!");
            }
        })
        .fail((error) => {
            toastr.options.timeOut = 2000;
            if(error.error == "Unauthorized") {
                toastr.error('Debe iniciar sesión para poder guardar como favoritos.');
            } else {
                toastr.error('Hubo un error al intentar guardar como favorito.');
            }
        })
        .always(() => {
            // Rehabilitamos el clic en el botón al finalizar la petición
            $('.icon-heart').removeClass('disabled');
        });
    }
}

// Funcion que copia al portapapeles la URL actual
async function copyToClipboard() {

    const urlActual = window.location.href;

    try {
        // Copiar la URL al portapapeles
        await navigator.clipboard.writeText(urlActual);

        // Notificación usando toastr
        toastr.options.timeOut = 2000;
        toastr.success("¡Enlace copiado al portapapeles!");
    } catch (err) {
        console.error('Error al copiar la URL:', err);
        
        // Si algo falla, muestra un error usando toastr
        toastr.options.timeOut = 2000;
        toastr.error("Error al copiar el enlace");
    }
};

// Delegación de eventos para el clic en el icono "me gusta"
$(document).on('click', '.icon-heart', function() {
    // Evitamos múltiples clics deshabilitando temporalmente el botón
    if ($(this).hasClass('disabled')) {
        return; // Si está deshabilitado, no hacemos nada
    }
    
    $(this).addClass('disabled'); // Añadimos la clase 'disabled' para deshabilitar el clic

    setLike(); // Llamamos la función para procesar el "like"
});

// Delegación de eventos para el clic en el icono "icon-share"
$(document).on('click', '.icon-share', function() {
    copyToClipboard();
});