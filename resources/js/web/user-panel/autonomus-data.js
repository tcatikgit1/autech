import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import {
    checkFailStatus,
    standardAjaxResponse,
    checkErrorLangCode
} from '@/custom/custom-form-ajax-response.js';

'use strict';

const rejectionMessages = {
    "autAvatarNotValid": "El avatar no es válido.",
    "autNameNotValid": "El nombre proporcionado no es válido.",
    "autLastNameNotValid": "El apellido proporcionado no es válido.",
    "autCompanyNotValid": "El nombre de la empresa no es válido.",
    "autCifNotValid": "El CIF proporcionado no es válido.",
    "autPhoneNotValid": "El número de teléfono no es válido.",
    "autBirthdateNotValid": "La fecha de nacimiento no es válida.",
    "autDateSSNotValid": "La fecha de alta en la Seguridad Social no es válida.",
    "autCertificadoNotValid": "El certificado proporcionado no es válido.",
    "autModel303NotValid": "El modelo 303 no es válido.",
    "autCEANotValid": "El CEA proporcionado no es válido.",
    "autDateCEANotValid": "La fecha del CEA no es válida."
};

$(function () {

    $(document).on('submit', '#autonomus-data-form', function (e) {
        e.preventDefault();
        submitAutonomusDataForm($(this));
    });

    $(document).on('shown.bs.tab', '#tab-autonomous-data', function (e) {
        getUserStatus();
    });

});

// Función para enviar el formulario de convertirse en autonomo
function submitAutonomusDataForm(formElement) {

    const form = formElement.get(0); // Obtener el elemento DOM nativo desde el objeto jQuery

    let userType = $('#user_type').val();
    if(userType !== 'autonomo') {
        toastr.error('No tienes permisos para realizar esta acción', 'Error');
        return;
    }

    const isValid = autonomusDataFormValidation(formElement);
    if (!isValid) {
        return;
    }
    
    // Verificar la validez del formulario usando Bootstrap validation
    if (!form.checkValidity()) {
        // Evita el envío si el formulario es inválido
        event.preventDefault();
        event.stopPropagation();
    } else {

        // Inhabilitar el botón de envío mientras se procesa la solicitud
        formElement.find('button[type="submit"]').prop('disabled', true);

        let data = formElement.serializeArray();
        let dataForm = new FormData();

        $.each(data, function (key, campo) {
            dataForm.append(campo.name, campo.value);
        });

        // Agregar archivos PDF al FormData
        let fileNames = [];
        formElement.find('input[type="file"]').each(function () {
            const fileInput = $(this)[0]; // Obtener el elemento DOM nativo del input
            if (fileInput.files.length > 0) {
                const originalName = fileInput.name;
                fileNames.push(originalName);
                dataForm.append(fileInput.name, fileInput.files[0]);
            }
        });
        dataForm.append('filesName', fileNames);

        $.ajax({
            url: '/send-autonomus-data',
            method: 'POST',
            contentType: false,
            processData: false,
            data: dataForm,
        })
        .done((response) => {
            standardAjaxResponse('¡Bien hecho!', 'operación realizada correctamente', window.location.href, 'success', true, 'Vale');
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

    // Añadir la clase Bootstrap para mostrar los estilos de validación visualmente
    form.classList.add('was-validated');
}

// Funcion para obtener el estado de verificacion del autonomo
function getUserStatus() {

    const is_valid = $('#is_valid').val();
    const documentoCertificado = $('#documento_certificado_input_hidden').val();
    const documentoModelo303 = $('#documento_modelo303_input_hidden').val();

    // si el campo "documentos" es null, significa que el usuario no ha enviado la documentación
    if ((!documentoCertificado || documentoCertificado === 'null' || documentoCertificado === '' || documentoCertificado === undefined) ||
        (!documentoModelo303 || documentoModelo303 === 'null' || documentoModelo303 === '' || documentoModelo303 === undefined)) {
        enableForm(); // Habilitar el formulario
        showTextBox('formNotSend');
        return;
    }

    // Si el campo "documentos" no es null y el campo "is_valid" es false, significa que el usuario está esperando por la verificación o tiene rechazos
    // Por lo tanto, se debe verificar si tiene rechazos
    if ((documentoCertificado || documentoModelo303) && is_valid === 'false') {
        fetchData();
        return;
    }

    // Si el campo "is_valid" es true, significa que el usuario ya está verificado
    if (is_valid == 'true') {
        showTextBox('userAlreadyVerified');
        return;
    }
}

function fetchData() {
    $.ajax({
        url: '/get-rechazos-autonomus',
        method: 'GET',
    })
    .done((response) => {
        
        if(response.rechazos.length > 0) {
            showTextBox('rejectionsFound'); // El usuario ha sido rechazado por los administradores
            enableForm(); // Habilitar el formulario
            showRejectionReasons(response.rechazos); // Mostrar los motivos
        } else {
            showTextBox('waitResponse'); // El usuario está esperando por la respuesta de los administradores
        }
    })
    .fail((error) => {
        console.log('error:', error);
    });
}

// ? Status code
// formNotSend          ->  El usuario aún no ha enviado el formulario
// waitResponse         ->  El usuario ha enviado el formulario y está esperando respuesta
// rejectionsFound      ->  La respuesta contiene rechazos
// userAlreadyVerified  ->  El usuario ya está destacado
function showTextBox(statusCode) {
    $('.box').addClass('d-none'); // Ocultar todas las cajas
    $(`.${statusCode}`).removeClass('d-none'); // Mostrar la caja correspondiente
}

function showRejectionReasons(rejectionCodes) {
    const $list = $('.rejectionsFound .rejection-list');
    $list.empty(); // Limpiar la lista antes de agregar nuevos elementos

    rejectionCodes.forEach(code => {
        const message = rejectionMessages[code] || "Motivo desconocido.";
        $list.append(`<li>${message}</li>`);
    });
}


function autonomusDataFormValidation(formElement) {
    let isValid = true; // Variable para rastrear el estado general de la validación

    // Obtener los valores de los campos
    const documentoCertificado = formElement.find('#documento_certificado_autonomus_data').prop('files')[0];
    const documentoModelo303 = formElement.find('#documento_modelo303_autonomus_data').prop('files')[0];
    const codigoCea = formElement.find('#codigo_cea_autonomus_data').val();
    const fechaCea = formElement.find('#fecha_cea_autonomus_data').val();
    const fechaSS = formElement.find('#fecha_ss_autonomus_data').val();
    
    // Limpiar errores previos
    // Limpiar errores previos de los campos de archivos
    formElement.find('#documento_certificado_autonomus_data').removeClass('is-invalid');
    formElement.find('#documento_certificado_autonomus_data').next('.invalid-feedback').hide();

    formElement.find('#documento_modelo303_autonomus_data').removeClass('is-invalid');
    formElement.find('#documento_modelo303_autonomus_data').next('.invalid-feedback').hide();

    formElement.find('#codigo_cea_autonomus_data').removeClass('is-invalid');
    formElement.find('#codigo_cea_autonomus_data').next('.invalid-feedback').hide();

    formElement.find('#fecha_cea_autonomus_data').removeClass('is-invalid');
    formElement.find('#fecha_cea_autonomus_data').next('.invalid-feedback').hide();

    formElement.find('#fecha_ss_autonomus_data').removeClass('is-invalid');
    formElement.find('#fecha_ss_autonomus_data').next('.invalid-feedback').hide();

    // Validar documento certificado
    if (!documentoCertificado) {
        formElement.find('#documento_certificado_autonomus_data').addClass('is-invalid');
        formElement.find('#documento_certificado_autonomus_data').next('.invalid-feedback').text('El certificado de autónomo es requerido').show();
        isValid = false;
    } else if (documentoCertificado.type !== 'application/pdf') {
        formElement.find('#documento_certificado_autonomus_data').addClass('is-invalid');
        formElement.find('#documento_certificado_autonomus_data').next('.invalid-feedback').text('El archivo debe ser un PDF').show();
        isValid = false;
    } else if (documentoCertificado.size > 5 * 1024 * 1024) { // Validar tamaño del archivo (5MB)
        formElement.find('#documento_certificado_autonomus_data').addClass('is-invalid');
        formElement.find('#documento_certificado_autonomus_data').next('.invalid-feedback').text('El archivo no debe superar los 5 MB').show();
        isValid = false;
    }

    // Validar documento modelo 303
    if (!documentoModelo303) {
        formElement.find('#documento_modelo303_autonomus_data').addClass('is-invalid');
        formElement.find('#documento_modelo303_autonomus_data').next('.invalid-feedback').text('El Modelo 303 es requerido').show();
        isValid = false;
    } else if (documentoModelo303.type !== 'application/pdf') {
        formElement.find('#documento_modelo303_autonomus_data').addClass('is-invalid');
        formElement.find('#documento_modelo303_autonomus_data').next('.invalid-feedback').text('El archivo debe ser un PDF').show();
        isValid = false;
    } else if (documentoModelo303.size > 5 * 1024 * 1024) { // Validar tamaño del archivo (5MB)
        formElement.find('#documento_modelo303_autonomus_data').addClass('is-invalid');
        formElement.find('#documento_modelo303_autonomus_data').next('.invalid-feedback').text('El archivo no debe superar los 5 MB').show();
        isValid = false;
    }

    // Validar codigo CEA
    if (!codigoCea) {
        formElement.find('#codigo_cea_autonomus_data').addClass('is-invalid');
        formElement.find('#codigo_cea_autonomus_data').next('.invalid-feedback').text('El código CEA es requerido').show();
        isValid = false;
    } else if (codigoCea.length < 5) {
        formElement.find('#codigo_cea_autonomus_data').addClass('is-invalid');
        formElement.find('#codigo_cea_autonomus_data').next('.invalid-feedback').text('El código CEA debe tener al menos 5 caracteres').show();
        isValid = false;
    } else if (codigoCea.length > 150) {
        formElement.find('#codigo_cea_autonomus_data').addClass('is-invalid');
        formElement.find('#codigo_cea_autonomus_data').next('.invalid-feedback').text('El código CEA no puede superar los 150 caracteres').show();
        isValid = false;
    }

    // Validar la fecha CEA
    if (!fechaCea) {
        formElement.find('#fecha_cea_autonomus_data').addClass('is-invalid');
        formElement.find('#fecha_cea_autonomus_data').next('.invalid-feedback').text('La fecha CEA es requerida').show();
        isValid = false;
    }
    const datePattern = /^([0-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/;
    if (!datePattern.test(fechaCea)) { // Validar el formato de la fecha
        formElement.find('#fecha_cea_autonomus_data').addClass('is-invalid');
        formElement.find('#fecha_cea_autonomus_data').next('.invalid-feedback').text('La fecha debe tener el formato DD-MM-YYYY').show();
        isValid = false;
    }
    if (!isValidDate(fechaCea)) { // Validar la fecha en sí
        formElement.find('#fecha_cea_autonomus_data').addClass('is-invalid');
        formElement.find('#fecha_cea_autonomus_data').next('.invalid-feedback').text('La fecha no es válida').show();
        isValid = false;
    }

    // Validar la fecha SS
    if (!fechaSS) {
        formElement.find('#fecha_ss_autonomus_data').addClass('is-invalid');
        formElement.find('#fecha_ss_autonomus_data').next('.invalid-feedback').text('La fecha SS es requerida').show();
        isValid = false;
    }
    if (!datePattern.test(fechaSS)) { // Validar el formato de la fecha
        formElement.find('#fecha_ss_autonomus_data').addClass('is-invalid');
        formElement.find('#fecha_ss_autonomus_data').next('.invalid-feedback').text('La fecha debe tener el formato DD-MM-YYYY').show();
        isValid = false;
    }
    if (!isValidDate(fechaSS)) { // Validar la fecha en sí
        formElement.find('#fecha_ss_autonomus_data').addClass('is-invalid');
        formElement.find('#fecha_ss_autonomus_data').next('.invalid-feedback').text('La fecha no es válida').show();
        isValid = false;
    }

    return isValid;
}

// Función para validar si una fecha es válida
function isValidDate(dateString) {
    const [day, month, year] = dateString.split('-').map(Number);
    const date = new Date(year, month - 1, day); // Mes en JavaScript es 0-indexado
    return (
        date.getFullYear() === year &&
        date.getMonth() === month - 1 &&
        date.getDate() === day
    );
}

function enableForm() {
    $('#documento_certificado_autonomus_data').prop('disabled', false);
    $('#documento_modelo303_autonomus_data').prop('disabled', false);
    $('#codigo_cea_autonomus_data').prop('disabled', false);
    $('#fecha_cea_autonomus_data').prop('disabled', false);
    $('#fecha_ss_autonomus_data').prop('disabled', false);
    $('#submit-autonomus-data').prop('disabled', false);
}