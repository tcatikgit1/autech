// TODO: VOY POR CREANDO ANUNCIO
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import {
    checkFailStatus,
    standardAjaxResponse,
    checkSuccessLangCode,
    checkErrorLangCode
} from '@/custom/custom-form-ajax-response.js';

'use strict';

$(function () {

    // Función para enviar el formulario de cambio de email
    $(document).on('submit', '#advertisement-form', function (e) {
        e.preventDefault();
        submitAdvertisementForm($(this));
    });

    $(document).on('click', '.delete-ad-btn', function () {
        const advertisementId = $(this).data('ad-id');
        deleteAdvertisement(advertisementId);
    });

    $(document).on('click', '.edit-ad-btn', function () {
        openModalForEditAdvertisement($(this).data('ad-id'));
    });

    // Limpiar el formulario de anuncio al cerrar el modal
    $(document).on('hide.bs.modal', '#modal-form-advertisement', function (e) {
        const formElement = $('#advertisement-form');
        cleanAndCloseModal(formElement, this);
    });

    // Evento para renovar un anuncio
    $(document).on('click', '.renewal-btn', function () {
        const advertisementId = $('#anuncioId').val();
        renewalAdvertisement(advertisementId);
    });

    // Evento para enviar el formulario de filtros
    $(document).on('submit', '#advertisement-filters-form', function (e) {
        e.preventDefault();
        filterAds($(this));
    });

    // Evento para limpiar filtros
    $(document).on('click', '#clear-filters', function (e) {
        $('#advertisement-filters-form')[0].reset(); // Restablecer formulario
        $('input[name="btnradio"][value="todos"]').prop('checked', true); // Restablecer el radio a "Todos"
        filterAds();
    });
});

function submitAdvertisementForm(formElement) {

    const isValid = submitAdvertisementFormValidation(formElement);
    if (!isValid) {
        return;
    }

    // Inhabilitar el botón de envío mientras se procesa la solicitud
    formElement.find('button[type="submit"]').prop('disabled', true);

    let data = formElement.serializeArray();
    const formData = new FormData();
    $.each(data, function (key, campo) {
        if (campo.name === "oldImages" && campo.value.trim() === "") { // Comprobar si el campo "oldImages" es vacío
            return;
        }
        // formData.append(campo.name, campo.value);
        if(campo.name !== 'habilidades[]' && campo.name !== 'habilidades_generales[]') { // Evitar que se adjunten los campos de habilidades
            formData.append(campo.name, campo.value);
        }
    });

    // Debido a un error que impide enviar arrays junto con archivos, se deben envian como string y luego convertirlos a array en el backend
    let habilidades= []
    let habilidades_generales = [];
    formElement.find('select[name="habilidades[]"]').val().forEach(value => {
        habilidades.push(value)
    });
    formElement.find('select[name="habilidades_generales[]"]').val().forEach(value => {
        habilidades_generales.push(value)
    });
    formData.append('habilidades', habilidades);
    formData.append('habilidades_generales', habilidades_generales);

    // Adjuntar los archivos Dropzone
    const dropzoneInstance = Dropzone.forElement("#dropzone-adv");
    if (dropzoneInstance.files.length > 0) {
        let fileNames = [];
        dropzoneInstance.files
            .filter(file => !file.isMock) // Filtrar solo archivos nuevos
            .forEach((file) => {
                const customName = file.previewElement.getAttribute("data-name");
                const originalName = customName;
                fileNames.push(originalName);
                formData.append(originalName, file);
        });
        formData.append('filesName', fileNames);
    }
    
    $.ajax({
        url: '/store-advertisement',
        method: 'POST',
        contentType: false,
        processData: false,
        data: formData,
    })
    .done((response) => {

        const method = $('#form-adv-method').val();
        const container = $('.container-my-ads');

        if(method == 'new') { // Creando anuncio nuevo

            if (container.find('.empty-ads-container').length > 0) {
                container.find('.empty-ads-container').remove();
            }
            
            // Agregar la nueva tarjeta
            container.append(response.anuncioCardView);

            // Seleccionar el último anuncio añadido
            const lastAd = container.find('.ad-container:last');
            
            // Hacer scroll hasta la tarjeta recién añadida
            $('html, body').animate({
                scrollTop: lastAd.offset().top - 100 
            }, 1000);

        } else { // Editando anuncio existente

            const adId = `#anuncio-card-${response.anuncio._id}`;
            const adCard = $(adId);

            if (adCard.length > 0) {
                // Reemplazar el contenido de la tarjeta con la nueva vista
                adCard.replaceWith(response.anuncioCardView);
            }

        }

        cleanAndCloseModal(formElement, document.getElementById('modal-form-advertisement'), true);
        checkSuccessLangCode(response.successLangCode);
    })
    .fail((error) => {

        formElement.find('button[type="submit"]').prop('disabled', false);

        error = error.responseJSON;
        if (error.errorLangCode) {
            checkErrorLangCode(error.errorLangCode)
        } else {
            checkFailStatus(error);
        }
    })
    .always(() => {
        formElement.find('button[type="submit"]').prop('disabled', false);
    });
}

function openModalForEditAdvertisement(advertisementId) {

    $('#form-adv-method').val('edit'); // Cambiar el método del formulario a 'edit'
    $('.modal-title').text('Editar anuncio');
    $('.modal-subtitle').text('Edita tu anuncio en cuestión de segundos');
    $('.renewal-btn').removeClass('d-none');

    $.ajax({
        url: `/get-advertisement/${advertisementId}`,
        method: 'GET',
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    .done((response) => {

        $('#anuncioId').val(response.anuncio._id);
        $('#titulo').val(response.anuncio.titulo);
        $('#descripcion').val(response.anuncio.descripcion);
        $('#presupuesto').val(window.Helpers.formatearPresupuesto(response.anuncio.presupuesto));
        $('#is_visible').val(response.anuncio.is_visible.toString()).trigger('change');
        $('#select-profesion-adv').val(response.anuncio.profesion_id.toString()).trigger('change');
        $('#select-habilidades-adv').val(response.anuncio.habilidades).trigger('change');
        $('#select-habilidades-generales-adv').val(response.anuncio.habilidades_generales).trigger('change');
        $('#place_id').val(response.anuncio.place_id);
        $('#place_lat').val(response.anuncio.place_lat);
        $('#place_long').val(response.anuncio.place_long);
        $('#place_name').val(response.anuncio.place_name);

        // Procesar imágenes del anuncio
        const dropzone = Dropzone.forElement("#dropzone-adv");
        const imagenes = response.anuncio.imagenes.split(',');
        const baseUrl = document.querySelector('meta[name="gateway-url"]').content;
        dropzone.removeAllFiles(true); // Limpiar imágenes previas del Dropzone

        let oldImages = [];

        imagenes.forEach((imagen, index) => {
            const fullUrl = `${baseUrl}${imagen}`;
            const mockFile = { 
                name: imagen.split('/').pop(),  // Nombre del archivo
                onlyName: imagen.split('/').pop().split('.').shift(),  // Nombre del archivo sin extensión
                size: 12345, // Tamaño ficticio
                accepted: true, // Importante para que Dropzone lo considere válido
                isMock: true // Marca este archivo como mock
            };

            // Construir oldImages
            oldImages.push({
                uri: fullUrl,
                fileName: imagen.split('/').pop(),
                name: imagen.split('/').pop(),
                route: imagen,
                order: index
            });
        
            // Añadir archivo al array interno de Dropzone
            dropzone.files.push(mockFile);
        
            // Emitir eventos para mostrar las imágenes en Dropzone
            dropzone.emit("addedfile", mockFile);
            dropzone.emit("thumbnail", mockFile, fullUrl);
            dropzone.emit("complete", mockFile);
        });

        // Agregar oldImages al formulario como campo oculto
        $('#old-images-input').val(JSON.stringify(oldImages));

        // Evento para manejar la eliminación de imágenes
        dropzone.on("removedfile", function(file) {
            if (file.isMock) {
                // Buscar y remover la imagen del array oldImages
                oldImages = oldImages.filter(oldImage => oldImage.fileName !== file.name);

                // Actualizar el campo oculto con las imágenes restantes
                $('#old-images-input').val(JSON.stringify(oldImages));
            }
        });

        const modalInstance = new bootstrap.Modal(document.getElementById('modal-form-advertisement'));
        modalInstance.show();

    })
    .fail((error) => {
        error = error.responseJSON;
        if (error.errorLangCode) {
            checkErrorLangCode(error.errorLangCode)
        } else {
            checkFailStatus(error);
        }
    });
}

function deleteAdvertisement(advertisementId) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¿Estás seguro de que quieres eliminar este anuncio?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, eliminar anuncio",
        customClass: {
          title: 'text-primary fs-3 mx-auto',
          confirmButton: 'btn btn-danger waves-effect waves-light',
          cancelButton: 'btn btn-primary waves-effect waves-light'
      },
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: `/delete-advertisement/${advertisementId}`,
            method: 'DELETE',
            contentType: false,
            processData: false,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          })
          .done((response) => {
            toastr.success('Se ha eliminado el anuncio correctamente');

            // Eliminar el anuncio de la lista
            $(`#anuncio-card-${advertisementId}`).fadeOut(300, function() {
                $(this).remove();

                // Verificar si el contenedor está vacío
                const container = $('.container-my-ads');
                if (container.children('.ad-container').length === 0) {
                    // Agregar el contenido del @empty
                    container.html(`
                        <div class="empty-ads-container">
                            ${$('meta[name="empty-template"]').attr('content')}
                        </div>
                    `);
                }
            });
          })
          .fail((error) => {
            error = error.responseJSON;
            if (error.errorLangCode) {
                checkErrorLangCode(error.errorLangCode)
            } else {
                checkFailStatus(error);
            }
          });
        }
      });
}

function renewalAdvertisement(advertisementId) {

    $('.renewal-btn').prop('disabled', true);

    const sendRequest = (spendRenewals = false) => {
        $.ajax({
            url: `/renewal-advertisement/${advertisementId}`,
            method: 'POST',
            data: {
                spendRenewals: spendRenewals
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .done((response) => {
            checkSuccessLangCode(response.successLangCode);
        })
        .fail((error) => {
            $('.renewal-btn').prop('disabled', false);
            
            const response = error.responseJSON;

            // Si no ha pasado suficiente tiempo para renovar, se le pide al usuario si quiere gastar una renovación
            if (response.errorLangCode && response.errorLangCode.includes('notEnoughMaxTimeForRenewal')) {
                Swal.fire({
                    title: 'Renovación necesaria',
                    text: 'No han pasado el tiempo suficiente desde la última renovación. ¿Quieres gastar una renovación disponible?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, gastar renovación',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        sendRequest(true); // Ejecuta la solicitud con spendRenewals a true
                    }
                });

            } else if (response.errorLangCode) {
                checkErrorLangCode(response.errorLangCode);
            } else {
                checkFailStatus(response);
            }
        })
        .always(() => {
            $('.renewal-btn').prop('disabled', false);
        });
    };

    // Ejecuta la primera solicitud con spendRenewals en false
    sendRequest();
}

function filterAds() {
    // Obtener los valores de los filtros
    const searchText = $('#search-text').val().toLowerCase();
    const tipoAnuncio = $('#tipo_anuncio').val();
    const isVisibleOption = $('input[name="btnradio"]:checked').val();
    const profesionId = $('#select-profesion-filter').val();

    let visibleAdsCount = 0;

    // Filtrar los anuncios
    $('.ad-container').each(function() {
        const adCard = $(this);
        
        const title = adCard.data('filter-title').toLowerCase();
        const description = adCard.data('filter-description').toLowerCase();
        const type = adCard.data('filter-type');
        const profession = adCard.data('filter-profession-id');
        const visible = adCard.data('filter-visible');

        // Verificar si el anuncio cumple con todos los filtros
        const matchesSearch = title.includes(searchText) || description.includes(searchText);
        const matchesType = tipoAnuncio === '' || type === tipoAnuncio;
        const matchesProfession = profesionId === '' || profession == profesionId;
        let matchesVisibility = false;

        if (isVisibleOption === 'todos') {
            matchesVisibility = true;
        } else if (isVisibleOption === 'visibles') {
            matchesVisibility = visible === 1;
        } else if (isVisibleOption === 'ocultos') {
            matchesVisibility = visible === 0;
        }

        // ? Si se prefiere que las tarjetas aparezcan/desaparezcan SIN animación
        // Si el anuncio no cumple con algún filtro, lo escondemos
        // if (matchesSearch && matchesType && matchesVisibility && matchesProfession) {
        //     adCard.show();
        // } else {
        //     adCard.hide();
        // }

        // ? Si se prefiere que las tarjetas aparezcan/desaparezcan CON animación
        if (matchesSearch && matchesType && matchesVisibility && matchesProfession) {
            if (!adCard.is(':visible')) {
                adCard.stop().slideDown(300);
            }
            visibleAdsCount++;
        } else {
            if (adCard.is(':visible')) {
                adCard.stop().slideUp(300);
            }
        }
    });

    const container = $('.container-my-ads');
    const emptyContainer = container.find('.empty-ads-container');

    // Si no hay anuncios visibles, mostramos el mensaje vacío
    if (visibleAdsCount === 0) {
        if (emptyContainer.length === 0) {
            container.append(`
                <div class="empty-ads-container">
                    ${$('meta[name="empty-template"]').attr('content')}
                </div>
            `);
        } else {
            emptyContainer.show();
        }
    } else {
        if (emptyContainer.length > 0) {
            emptyContainer.hide();
        }
    }

    // Cerrar el modal
    const modalElement = document.getElementById('modal-filters-advertisement');
    const modalInstance = bootstrap.Modal.getInstance(modalElement);
    if (modalInstance) {
        modalInstance.hide();
    }
}

function submitAdvertisementFormValidation(formElement) {
    let isValid = true; // Variable para rastrear el estado general de la validación

    // Obtener los valores de los campos
    const titulo = formElement.find('#titulo').val();
    const presupuesto = formElement.find('#presupuesto').val();
    const descripcion = formElement.find('#descripcion').val();
    const is_visible = formElement.find('#is_visible').val();
    const profesionId = formElement.find('#select-profesion-adv').val();
    const dropzoneInstance = Dropzone.forElement("#dropzone-adv");

    // Limpiar errores previos
    formElement.find('#titulo').removeClass('is-invalid');
    formElement.find('#titulo').next('.invalid-feedback').hide();
    formElement.find('#descripcion').removeClass('is-invalid');
    formElement.find('#descripcion').next('.invalid-feedback').hide();
    formElement.find('#dropzone-adv').next('.invalid-feedback').hide();

    formElement.find('#is_visible').removeClass('is-invalid');
    formElement.find('#is_visible').next('.select2').find('.select2-selection').removeClass('is-invalid');
    formElement.find('#is_visible').closest('.col-md-6').find('.invalid-feedback').hide();
    
    formElement.find('#select-profesion-adv').removeClass('is-invalid');
    formElement.find('#select-profesion-adv').next('.select2').find('.select2-selection').removeClass('is-invalid');
    formElement.find('#select-profesion-adv').closest('.col-md-6').find('.invalid-feedback').hide();

    formElement.find('#presupuesto').removeClass('is-invalid');
    formElement.find('#presupuesto').next('.invalid-feedback').hide();

    if (!titulo) {
        formElement.find('#titulo').addClass('is-invalid');
        formElement.find('#titulo').next('.invalid-feedback').text('El título es requerido').show();
        isValid = false;
    } else if (titulo.length < 3) {
        formElement.find('#titulo').addClass('is-invalid');
        formElement.find('#titulo').next('.invalid-feedback').text('El título debe tener al menos 3 caracteres').show();
        isValid = false;
    } else if (titulo.length > 150) {
        formElement.find('#titulo').addClass('is-invalid');
        formElement.find('#titulo').next('.invalid-feedback').text('El título no puede superar los 150 caracteres').show();
        isValid = false;
    }

    // validar que is_visible sea requerido
    if (!is_visible) {
        const select2Container = formElement.find('#is_visible').next('.select2'); // Contenedor de Select2
        formElement.find('#is_visible').addClass('is-invalid'); // Agrega clase de error al select original
        select2Container.find('.select2-selection').addClass('is-invalid'); // Marca el contenedor visual de Select2 como inválido
        formElement.find('#is_visible').closest('.col-md-6').find('.invalid-feedback').text('El campo visibilidad es requerido').show();
        isValid = false;
    }

    // Validar presupuesto
    if (!presupuesto) {
        formElement.find('#presupuesto').addClass('is-invalid');
        formElement.find('#presupuesto').next('.invalid-feedback').text('El presupuesto es requerido, puede ser 0').show();
        isValid = false;
    } else if (isNaN(presupuesto)) {
        formElement.find('#presupuesto').addClass('is-invalid');
        formElement.find('#presupuesto').next('.invalid-feedback').text('El presupuesto debe ser un número válido').show();
        isValid = false;
    } else if (presupuesto > 5000) {
        formElement.find('#presupuesto').addClass('is-invalid');
        formElement.find('#presupuesto').next('.invalid-feedback').text('El presupuesto es inválido').show();
    }

    // Validar descripcion
    if (!descripcion) {
        formElement.find('#descripcion').addClass('is-invalid');
        formElement.find('#descripcion').next('.invalid-feedback').text('La descripción es requerida').show();
        isValid = false;
    } else if (descripcion.length < 10) {
        formElement.find('#descripcion').addClass('is-invalid');
        formElement.find('#descripcion').next('.invalid-feedback').text('La descripción debe tener al menos 10 caracteres').show();
        isValid = false;
    } else if (descripcion.length > 5000) {
        formElement.find('#descripcion').addClass('is-invalid');
        formElement.find('#descripcion').next('.invalid-feedback').text('La descripción no puede exceder los 5000 caracteres').show();
        isValid = false;
    } else {
        const palabras = descripcion.trim().split(/\s+/).filter(Boolean);
        if (palabras.length > 300) {
            formElement.find('#descripcion').addClass('is-invalid');
            formElement.find('#descripcion').next('.invalid-feedback').text('La descripción no puede tener más de 300 palabras').show();
            isValid = false;
        }
    }

    // Validar profesion_id
    if (!profesionId) {
        const select2Container = formElement.find('#select-profesion-adv').next('.select2'); // Contenedor de Select2
        formElement.find('#select-profesion-adv').addClass('is-invalid'); // Agrega clase de error al select original
        select2Container.find('.select2-selection').addClass('is-invalid'); // Marca el contenedor visual de Select2 como inválido
        formElement.find('#select-profesion-adv').closest('.col-md-6').find('.invalid-feedback').text('El sector es requerido').show();
        isValid = false;
    }

    // Validar Dropzone minimo 3 fotos y maximo 8
    if (dropzoneInstance.files.length < 3 || dropzoneInstance.files.length > 8) {
        formElement.find('#dropzone-adv').next('.invalid-feedback').text('Debe adjuntar un mínimo de 3 y un máximo de 8 imágenes al anuncio').show();
        isValid = false;
    }

    return isValid; // Devuelve el estado general de la validación
}

function cleanAndCloseModal(formElement, modalElement, wantToCloseModal = false) {
    const $modal = $(modalElement);

    $modal.find('.modal-title').text('Crear anuncio');
    $modal.find('.modal-subtitle').text('Publica tu anuncio en cuestión de segundos');
    $modal.find('.renewal-btn').addClass('d-none');

    if (wantToCloseModal) {
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide(); // Cierra el modal
        }
    }

    // Restablecer valores del formulario
    formElement[0].reset();

    // Limpiar inputs específicos dentro del modal
    $modal.find('#old-images-input').val(null);
    $modal.find('#anuncioId').val(null);
    $modal.find('#place_id').val(null);
    $modal.find('#place_lat').val(null);
    $modal.find('#place_long').val(null);
    $modal.find('#place_name').val(null);

    // Resetea el estado de Dropzone
    const dropzoneElement = $modal.find("#dropzone-adv")[0]; // Encuentra el dropzone dentro del modal
    if (dropzoneElement) {
        const dropzoneInstance = Dropzone.forElement(dropzoneElement);
        if (dropzoneInstance) {
            dropzoneInstance.removeAllFiles(true); // Limpia los archivos cargados
        }
    }

    // Reiniciar select2 dentro del modal
    $modal.find('.select2').val(null).trigger('change');
}