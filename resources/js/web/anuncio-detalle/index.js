import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

let opcionesCargadas = false; // Variable para controlar si ya se cargaron las opciones de reporte

(function () {

    cargarAnuncioDetalleContent();

    // Accion que se ejecuta cuando se abre el modal de reporte de anuncio
    $('#reportModal').on('show.bs.modal', function () {
        if (!opcionesCargadas) {
            // Mostrar el spinner y ocultar las opciones mientras se cargan
            $('#spinner-reporte').removeClass('d-none');
            $('#opciones-reporte').addClass('d-none');

            // Ejecutar la petición AJAX
            cargarOpcionesReporte();
        }
    });

    // Cuando se envía el formulario de reporte
    $('#report-form').on('submit', function (e) {
        enviarFormularioReporte(e);
    });

})();

// Función que realiza la llamada AJAX para cargar el contenido de la pagina de detalle de un anuncio
function cargarAnuncioDetalleContent() {
    const anuncioId = $('#anuncio-id').val();

    if (anuncioId != null && anuncioId != '') {
        $.ajax({
            url: `/get-anuncio-view/${anuncioId}`,
            method: 'GET',
        })
        .done((response) => {
            $('#skeleton-autonomo-detalle-page').fadeOut(400, function () {
                $('#aside').empty().append(response.aside).fadeIn(400);
                $('#content').empty().append(response.content).fadeIn(400);
            });
        })
        .fail((error) => {
            $('.grid-container').fadeOut(400, function () {
                $('#error-content').removeClass('d-none');
            });
        })
        .always(() => {
            $('#skeleton-autonomo-detalle-page').fadeOut();
        });
    }
}

// Función que realiza la llamada AJAX para dar like a un anuncio
function setLike() {

    const anuncioId = $('#anuncio-id').val();

    const data = {
        like_tipo: 'anuncio', // tipo de elemento al que se le da like (autonomo, anuncio)
        like_id: anuncioId // id del elemento al que se le da like (autonomo, anuncio)
    };

    if (anuncioId != null && anuncioId != '') {
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

// Funcion ajax que carga las opciones para reportar un anuncio
function cargarOpcionesReporte() {
    $.ajax({
        url: `/get-opciones-reporte`,
        method: 'GET'
    })
        .done((response) => {
            
            $('#skeleton-modal-select-report-option').fadeOut(400, function () {
                // Verificar si la respuesta contiene un campo de error
                if (response.error) {
                    // Si hay un error en la respuesta, manejarlo como si fuera un 'fail'
                    console.error('Error recibido en la respuesta:', response.error);
                    $('#opciones-reporte').html('<p>Debes iniciar sesión para poder reportar un anuncio.</p>').removeClass('d-none');
                    return; // Terminar la ejecución si hay un error
                }
    
                // Limpiar el contenedor antes de agregar las nuevas opciones
                const contenedorOpciones = $('#opciones-reporte');
                contenedorOpciones.empty();

                // Recorrer el array y construir las opciones dinámicamente
                response.forEach((opcion, index) => {
                    // Crear el HTML de cada opción
                    const opcionHTML = `
                        <div class="form-check">
                            <label class="form-check-label custom-option-content" for="customRadioTemp${opcion._id}">
                                <input name="customRadioTemp" class="form-check-input" type="radio" value="${opcion._id}" id="customRadioTemp${opcion._id}" />
                                <span class="custom-option-header">
                                    <span class="h6 mb-0 d-flex align-items-center">${opcion.titulo}</span>
                                </span>
                            </label>
                        </div>
                    `;
    
                    // Inyectar cada opción en el contenedor
                    contenedorOpciones.append(opcionHTML);
                });

                // Agregar el campo de observaciones al final de las opciones
                contenedorOpciones.append(`
                    <div id="campo-observaciones" class="my-3">
                        <label for="observaciones" class="form-label">Observaciones (opcional)</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"
                            placeholder="Escribe tus observaciones aquí"></textarea>
                    </div>`
                )
    
                // Una vez que las opciones están cargadas, mostrar las opciones
                $('#opciones-reporte').removeClass('d-none');
    
                // Marcar que las opciones ya han sido cargadas
                opcionesCargadas = true;
            });

        })
        .fail((error) => {
            console.error('Error al cargar las opciones de reporte:', error);
            $('#skeleton-modal-select-report-option').fadeOut();
            $('#opciones-reporte').html('<p>Error al cargar las opciones de reporte.</p>').removeClass('d-none');
        });
}

// Función para enviar el formulario de reporte
function enviarFormularioReporte(e) {
    e.preventDefault();

    const opcionSeleccionada = $('input[name="customRadioTemp"]:checked').val(); // Obtener la opción seleccionada
    const anuncioId = $('#anuncio-id').val(); // Obtener el ID del anuncio
    const observacion = $('#observaciones').val(); // Obtener las observaciones

    if (!opcionSeleccionada || !anuncioId) {
        toastr.error('Debes seleccionar una opción para reportar.');
        return;
    }
    
    const data = {
        anuncio_id: anuncioId,
        opcion_reporte_id: opcionSeleccionada,
        observacion: observacion
    };

    $.ajax({
        url: '/send-report',
        method: 'POST',
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    .done(function (response) {

        if(response.errorLangCode) {
            if(response.errorLangCode == "reporteAlreadyExists") {
                toastr.error('Ya has reportado este anuncio.');
                limpiarFormularioReporte()
            } else {
                toastr.error('Ocurrió un error al enviar el reporte. Inténtalo de nuevo.');
            }
            return;
        }

        toastr.success('¡El reporte se ha enviado con éxito!');

        limpiarFormularioReporte()

    })
    .fail(function (error) {
        console.error('Error al enviar el reporte:', error);
        toastr.error('Ocurrió un error al enviar el reporte. Inténtalo de nuevo.');
    });
}

// Delegación de eventos para el clic en el icono "me gusta"
$(document).on('click', '.icon-heart', function () {
    // Evitamos múltiples clics deshabilitando temporalmente el botón
    if ($(this).hasClass('disabled')) {
        return; // Si está deshabilitado, no hacemos nada
    }
    
    $(this).addClass('disabled'); // Añadimos la clase 'disabled' para deshabilitar el clic

    setLike(); // Llamamos la función para procesar el "like"
});

// Delegación de eventos para el clic en el icono "icon-share"
$(document).on('click', '.icon-share', function () {
    copyToClipboard();
});

// funcion limpiar y cerrar formulario de reporte
function limpiarFormularioReporte() {
    // Cerrar el modal
    const modalElement = document.getElementById('reportModal');
    const modal = bootstrap.Modal.getInstance(modalElement); // Obtén la instancia del modal
    modal.hide(); // Cerrar el modal

    // Limpiar el formulario
    $('#report-form')[0].reset();
}