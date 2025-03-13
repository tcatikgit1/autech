/**
 * Pages User Profile
 */

import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import {
  checkFailStatus,
} from '@/custom/custom-form-ajax-response.js';

'use strict';

let isFavsLoad = false;

$(function () {

    $(document).on('shown.bs.tab', '#tab-my-favs, #tab-my-followed', function (e) {
        const type = $(e.target).data("type"); // Captura el tipo desde el botón
        
        if(!isFavsLoad) {
            getFavs(e, type)
        } else {
            toggleFavoritesView(type);
        }
        
    });

    $(document).on('click', '.badge-fav', function(e) {
        const type = $(e.currentTarget).data("type");
        removeFavorite(e, type);
    })
});

function getFavs(e, type) {
    
    // Ocultar el skeleton contrario a la pestaña activa
    if(type == 'anuncios'){
        $('#skeleton-favs-autonomos-user-panel').addClass('d-none');
    }
    if(type == 'autonomos'){
        $('#skeleton-favs-anuncios-user-panel').addClass('d-none');
    }
    
    var target = $(e.target).attr("aria-controls"); // Obtenemos el ID del contenido del tab

    if (target === 'content-my-favs') {

        $.ajax({
            url: '/get-my-favorites-view',
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done((response) => {
            isFavsLoad = true;
        
            if(type == 'anuncios'){
                $('#skeleton-favs-anuncios-user-panel').fadeOut(400, function () {
                    $('#favorites-container').empty().append(response).fadeIn(400);
                    toggleFavoritesView(type);
                });
            }

            if(type == 'autonomos'){
                $('#skeleton-favs-autonomos-user-panel').fadeOut(400, function () {
                    $('#favorites-container').empty().append(response).fadeIn(400);
                    toggleFavoritesView(type);
                });
            }

        })
        .fail((error) => {
            checkFailStatus(error);
        });
    }
}

// Alterna la vista de favoritos entre "anuncios" y "autonomos"
function toggleFavoritesView(type) {
    $('.favorites-list').hide(); // Oculta todas las listas
    if (type === 'anuncios') {
        $('#favorites-anuncios').css('display', 'block').removeClass('d-none');
    } else if (type === 'autonomos') {
        $('#favorites-autonomos').css('display', 'grid').removeClass('d-none');
    }
}

// Función para quitar a un autonomo/anuncio de favoritos
function removeFavorite(e, type) {

    const targetId =  $(e.currentTarget).data('target-id');

    const data = {
        like_tipo: type, // tipo de elemento al que se le da like (autonomo, anuncio)
        like_id: targetId // id del elemento al que se le da like (autonomo, anuncio)
    };

    if(targetId != null && targetId != '') {
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

            // Eliminar la card del autonomo si se ha eliminado de favoritos
            $(e.currentTarget).closest(`.${type}-card`).fadeOut(400, function() {
                $(this).remove();

                // Verificar si el contenedor está vacío de elementos para mostrar mensaje de vacío
                const container = $(`#favorites-${type}s`);
                if (container.children(`.${type}-card`).length === 0) {
                    container.addClass('empty');
                    container.html(`
                        ${$(`meta[name="empty-template-${type}"]`).attr('content')}
                    `);
                }
            });

            toastr.options.timeOut = 2000;
            toastr.success("¡Se ha eliminado de favoritos!");
            
        })
        .fail((error) => {
            toastr.options.timeOut = 2000;
            if(error.error == "Unauthorized") {
                toastr.error('Debe iniciar sesión para poder guardar como favoritos.');
            } else {
                toastr.error('Hubo un error al intentar guardar como favorito.');
            }
        });
    }
}
