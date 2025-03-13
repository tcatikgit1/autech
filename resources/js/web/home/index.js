import Swiper from 'swiper/bundle';  // Asegúrate de tener la dependencia instalada
import 'swiper/swiper-bundle.css';     // Para los estilos de Swiper


(function () {
    console.log('El archivo index.js se ha cargado correctamente');

    cargarAnunciosDestacados();
    cargarAutonomosDestacados();
    cargarRecursosHome();

    // Evento click para el botón de búsqueda
    $('#btn-search-magnifier').on('click', function () {
        buildParams();
    });

})();

function cargarAnunciosDestacados() {
    $.ajax({
        url: '/anuncios-destacados-view',
        method: 'GET',
    })
    .done((response) => {
        $('#skeleton-anuncios-destacados').fadeOut(400, function() {
            $('#anuncios-destacados-container').empty().append(response).fadeIn(400);
        });
    })
    .fail((error) => {
        console.log(error);
    })
    .always(() => {
        $('#skeleton-anuncios-destacados').fadeOut();
    });
}

function cargarAutonomosDestacados() {
    $.ajax({
        url: `/autonomos-destacados-view`,
        method: `GET`,
    })
    .done((response) => {

        $('#skeleton-autonomos-destacados').fadeOut(400, function() {
            $('#autonomos-destacados-container').empty().append(response).fadeIn(400);
            // Inicializar Swiper después de cargar el contenido
            const swiper = new Swiper(".swiper-autonomos-destacados", {
                slidesPerView: 1,
                spaceBetween: 30,
                breakpoints: {
                    576: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                    },
                    1400: {
                        slidesPerView: 4,
                        spaceBetween: 30,
                    },
                }
            });
        });

    })
    .fail((error) => {
        console.log(error);
    })
    .always(() => {
        $('#skeleton-autonomos-destacados').fadeOut();
    });
}

function cargarRecursosHome() {
    $.ajax({
        url: `/getAll-view`,
        method: `GET`,
    })
    .done((response) => {

        $('#skeleton-profesiones-container').fadeOut(400, function() {
            $('#listado-profesiones-container').empty().append(response.profesiones).fadeIn(400);

            new Swiper('.swiper-profesiones', {
                slidesPerView: 'auto',  // Mostrar varias píldoras
                spaceBetween: 10,  // Espacio entre píldoras
            });
        });
    })
    .fail((error) => {
        console.log(error);
    })
    .always(() => {
        $('#skeleton-profesiones-container').fadeOut();
    });
}

// Función que construye los parámetros de búsqueda en la URL y redirecciona al listado
function buildParams(page = 1) {
    const params = new URLSearchParams();

    params.set('page', page);
    
    const order = $('#search-order').val();
    if (order) params.set('order', order);

    const titulo = $('#busqueda-rapida-search').val();
    if (titulo) params.set('titulo', titulo);

    const modo = $('#search-mode').val();
    if (modo) params.set('modo', modo);

    const selectedProfessions = $('#select-professions').val();
    
    if (selectedProfessions && selectedProfessions.length > 0) {
        selectedProfessions.forEach(profesion => {
            params.append('profesion[]', profesion); // Agregar múltiples valores correctamente
        });
    }

    // rdireccionar a la ruta /search con los parametros
    window.location.href = '/search?' + params.toString();
}