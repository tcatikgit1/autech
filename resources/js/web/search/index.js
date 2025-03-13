// Importaciones necesarias para Swiper
import Swiper from 'swiper/bundle';
import 'swiper/swiper-bundle.css';   // Importar estilos de Swiper

const ordenOpciones = {
    autonomos: [
        { value: "relevancia", text: "Relevancia" },
        { value: "recientes", text: "Más reciente primero" }
    ],
    anuncios: [
        { value: "relevancia", text: "Relevancia" },
        { value: "recientes", text: "Más reciente primero" },
        { value: "precio_asc", text: "Precio: De menor a mayor" },
        { value: "precio_desc", text: "Precio: De mayor a menor" }
    ]
};

// Función autoejecutable para inicializar el código principal
(function () {

    initFiltersFromUrl();
    cargarListadoGeneral(); // Cargar los datos al inicio
    actualizarOpcionesOrden();

    // Evento click para el botón de búsqueda
    $('#btn-search-magnifier').on('click', function () {
        cargarListadoGeneral();  // Llama a la función que trae los datos
    });

    // Cambiar entre "autonomos" y "anuncios"
    $('#search-mode').on('change', function () {
        actualizarOpcionesOrden();
        cargarListadoGeneral();
    });

    // Cambiar el orden
    $('#search-order').on('change', function () {
        cargarListadoGeneral();
    });

    // Delegación de eventos para paginación
    $(document).on('click', '.pagination-prev, .pagination-next', function (e) {
        e.preventDefault();
        let page = $(this).data('page') || 1; // Obtener la página desde el botón
        if (page) {
            cargarListadoGeneral(page);
        }
    });

})();

// Función que realiza la llamada AJAX para cargar los datos
function cargarListadoGeneral(page = 1) {
    
    $('#listado-general-container').hide();
    $("#skeleton-listado-general").fadeIn(); 

    let titleSection = '';
    let url = '/search-autonomos-view';

    if($('#search-mode').val() == 'anuncios'){
        url = '/search-anuncios-view';
        titleSection = $('.title-section').data('title-anuncios');
    } else if($('#search-mode').val() == 'autonomos') {
        titleSection = $('.title-section').data('title-autonomos');
    }
    
    $('.title-section').text(titleSection);

    let params = buildParams(page);

    $.ajax({
        url: url,
        method: 'GET',
        data: params
    })
    .done((response) => {
        $('#skeleton-listado-general').fadeOut(400, function() {
            $('#listado-general-container').empty().append(response).fadeIn(400);
            ajustarDisposicionTarjetas();
        });
    })
    .fail((error) => {
        console.error('Error al cargar el listado:', error);
    })
    .always(() => {
        $("#skeleton-listado-general").fadeOut();
    });
}

function ajustarDisposicionTarjetas() {
    const container = $('#listado-general-container');
    const autonomoCards = container.find('.autonomo-card');

    // Si hay menos de 4 tarjetas, alinearlas al inicio
    if (autonomoCards.length < 4) {
        container.removeClass('justify-content-center').addClass('justify-content-start');
    } else {
        // Si hay 4 o más, alinearlas al centro
        container.removeClass('justify-content-start').addClass('justify-content-center');
    }
}

// Función para construir los parámetros de búsqueda
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

    // Actualizar la URL sin recargar la página
    const newUrl = window.location.pathname + '?' + params.toString();
    history.replaceState(null, '', newUrl);

    // Convertir URLSearchParams a objeto JS y retornamos para la petición AJAX
    const paramsObj = {};
    params.forEach((value, key) => {
        if (key.endsWith('[]')) {  // Detecta arrays (como 'profesion[]')
            const cleanKey = key.replace('[]', ''); 
            if (!paramsObj[cleanKey]) {
                paramsObj[cleanKey] = [];
            }
            paramsObj[cleanKey].push(value);
        } else {
            paramsObj[key] = value;
        }
    });

    return paramsObj;
}

// Función para actualizar las opciones del select de orden en funcion del modo seleccionado (autonomos, anuncios)
function actualizarOpcionesOrden() {
    const modo = $('#search-mode').val(); // Obtener el modo actual
    const selectOrden = $('#search-order');
    
    // Guardar la opción seleccionada antes de cambiar las opciones
    const opcionSeleccionada = selectOrden.val();

    // Limpiar y agregar nuevas opciones
    selectOrden.empty();
    ordenOpciones[modo].forEach(option => {
        selectOrden.append(new Option(option.text, option.value));
    });

    // Intentar restaurar la selección previa si sigue existiendo en las opciones nuevas
    if (ordenOpciones[modo].some(opt => opt.value === opcionSeleccionada)) {
        selectOrden.val(opcionSeleccionada);
    } else {
        selectOrden.val(ordenOpciones[modo][0].value); // Seleccionar la primera opción si la previa ya no es válida
    }
}

// Función para inicializar los filtros desde la URL
function initFiltersFromUrl() {
    // Recogemos los parámetros de la URL
    const urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has('titulo')) {
        $('#busqueda-rapida-search').val(urlParams.get('titulo'));
    }

    if (urlParams.has('orden')) {
        $('#search-order').val(urlParams.get('orden')).trigger('change'); // Trigger change para select
    }

    if (urlParams.has('modo')) {
        $('#search-mode').val(urlParams.get('modo')).trigger('change');
    }

    // Manejo de múltiples valores para profesiones (Select2)
    const profesiones = urlParams.getAll('profesion[]'); // Obtener array de profesiones
    if (profesiones.length > 0) {
        $('#select-professions').val(profesiones).trigger('change'); // Set valores y actualizar Select2
    }
}

