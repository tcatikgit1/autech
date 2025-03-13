import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import {
    checkFailStatus,
    standardAjaxResponse,
    checkErrorLangCode
} from '@/custom/custom-form-ajax-response.js';

'use strict';

$(function () {

    $(document).on('submit', '#become-autonomus-form', function (e) {
        e.preventDefault();
        submitBecomeAutonomusForm($(this));
    });

});

// Función para enviar el formulario de convertirse en autonomo
function submitBecomeAutonomusForm(formElement) {

    const form = formElement.get(0); // Obtener el elemento DOM nativo desde el objeto jQuery

    let userType = $('#user_type').val();
    if(userType !== 'cliente') {
        toastr.error('No tienes permisos para realizar esta acción', 'Error');
        return;
    }

    const isValid = becomeAutonomusFormValidation(formElement);
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
            if(campo.name !== 'habilidades[]' && campo.name !== 'habilidades_generales[]') { // Evitar que se adjunten los campos de habilidades
                dataForm.append(campo.name, campo.value);
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
        dataForm.append('habilidades', habilidades);
        dataForm.append('habilidades_generales', habilidades_generales);

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
            url: '/become-autonomus',
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

function becomeAutonomusFormValidation(formElement) {
    let isValid = true; // Variable para rastrear el estado general de la validación

    // Obtener los valores de los campos
    const documentoCertificado = formElement.find('#documento_certificado').prop('files')[0];
    const documentoModelo303 = formElement.find('#documento_modelo303').prop('files')[0];
    const codigoCea = formElement.find('#codigo_cea_become_autonomus').val();
    const fechaCea = formElement.find('#fecha_cea_become_autonomus').val();
    const fechaSS = formElement.find('#fecha_ss_become_autonomus').val();
    const cif = formElement.find('#cif_become_autonomus').val();
    const razonSocial = formElement.find('#razon_social_become_autonomus').val();
    const direccionFiscal = formElement.find('#direccion_fiscal_become_autonomus').val();
    const profesionId = formElement.find('#select-profesion-become-autonomus').val();
    
    // Limpiar errores previos
    // Limpiar errores previos de los campos de archivos
    formElement.find('#documento_certificado').removeClass('is-invalid');
    formElement.find('#documento_certificado').next('.invalid-feedback').hide();

    formElement.find('#documento_modelo303').removeClass('is-invalid');
    formElement.find('#documento_modelo303').next('.invalid-feedback').hide();

    formElement.find('#codigo_cea_become_autonomus').removeClass('is-invalid');
    formElement.find('#codigo_cea_become_autonomus').next('.invalid-feedback').hide();

    formElement.find('#fecha_cea_become_autonomus').removeClass('is-invalid');
    formElement.find('#fecha_cea_become_autonomus').next('.invalid-feedback').hide();

    formElement.find('#fecha_ss_become_autonomus').removeClass('is-invalid');
    formElement.find('#fecha_ss_become_autonomus').next('.invalid-feedback').hide();

    formElement.find('#cif_become_autonomus').removeClass('is-invalid');
    formElement.find('#cif_become_autonomus').next('.invalid-feedback').hide();

    formElement.find('#razon_social_become_autonomus').removeClass('is-invalid');
    formElement.find('#razon_social_become_autonomus').next('.invalid-feedback').hide();

    formElement.find('#direccion_fiscal_become_autonomus').removeClass('is-invalid');
    formElement.find('#direccion_fiscal_become_autonomus').next('.invalid-feedback').hide();

    formElement.find('#select-profesion-become-autonomus').removeClass('is-invalid');
    formElement.find('#select-profesion-become-autonomus').next('.select2').find('.select2-selection').removeClass('is-invalid');
    formElement.find('#select-profesion-become-autonomus').closest('.col-md-6').find('.invalid-feedback').hide();

    // Validar documento certificado
    if (!documentoCertificado) {
        formElement.find('#documento_certificado').addClass('is-invalid');
        formElement.find('#documento_certificado').next('.invalid-feedback').text('El certificado de autónomo es requerido').show();
        isValid = false;
    } else if (documentoCertificado.type !== 'application/pdf') {
        formElement.find('#documento_certificado').addClass('is-invalid');
        formElement.find('#documento_certificado').next('.invalid-feedback').text('El archivo debe ser un PDF').show();
        isValid = false;
    } else if (documentoCertificado.size > 5 * 1024 * 1024) { // Validar tamaño del archivo (5MB)
        formElement.find('#documento_certificado').addClass('is-invalid');
        formElement.find('#documento_certificado').next('.invalid-feedback').text('El archivo no debe superar los 5 MB').show();
        isValid = false;
    }
    
    // Validar documento modelo 303
    if (!documentoModelo303) {
        formElement.find('#documento_modelo303').addClass('is-invalid');
        formElement.find('#documento_modelo303').next('.invalid-feedback').text('El Modelo 303 es requerido').show();
        isValid = false;
    } else if (documentoModelo303.type !== 'application/pdf') {
        formElement.find('#documento_modelo303').addClass('is-invalid');
        formElement.find('#documento_modelo303').next('.invalid-feedback').text('El archivo debe ser un PDF').show();
        isValid = false;
    } else if (documentoModelo303.size > 5 * 1024 * 1024) { // Validar tamaño del archivo (5MB)
        formElement.find('#documento_modelo303').addClass('is-invalid');
        formElement.find('#documento_modelo303').next('.invalid-feedback').text('El archivo no debe superar los 5 MB').show();
        isValid = false;
    }

    // Validar codigo CEA
    if (!codigoCea) {
        formElement.find('#codigo_cea_become_autonomus').addClass('is-invalid');
        formElement.find('#codigo_cea_become_autonomus').next('.invalid-feedback').text('El código CEA es requerido').show();
        isValid = false;
    } else if (codigoCea.length < 5) {
        formElement.find('#codigo_cea_become_autonomus').addClass('is-invalid');
        formElement.find('#codigo_cea_become_autonomus').next('.invalid-feedback').text('El código CEA debe tener al menos 5 caracteres').show();
        isValid = false;
    } else if (codigoCea.length > 150) {
        formElement.find('#codigo_cea_become_autonomus').addClass('is-invalid');
        formElement.find('#codigo_cea_become_autonomus').next('.invalid-feedback').text('El código CEA no puede superar los 150 caracteres').show();
        isValid = false;
    }

    // Validar la fecha CEA
    if (!fechaCea) {
        formElement.find('#fecha_cea_become_autonomus').addClass('is-invalid');
        formElement.find('#fecha_cea_become_autonomus').next('.invalid-feedback').text('La fecha CEA es requerida').show();
        isValid = false;
    }
    const datePattern = /^([0-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/;
    if (!datePattern.test(fechaCea)) { // Validar el formato de la fecha
        formElement.find('#fecha_cea_become_autonomus').addClass('is-invalid');
        formElement.find('#fecha_cea_become_autonomus').next('.invalid-feedback').text('La fecha debe tener el formato DD-MM-YYYY').show();
        isValid = false;
    }
    if (!isValidDate(fechaCea)) { // Validar la fecha en sí
        formElement.find('#fecha_cea_become_autonomus').addClass('is-invalid');
        formElement.find('#fecha_cea_become_autonomus').next('.invalid-feedback').text('La fecha no es válida').show();
        isValid = false;
    }

    // Validar la fecha SS
    if (!fechaSS) {
        formElement.find('#fecha_ss_become_autonomus').addClass('is-invalid');
        formElement.find('#fecha_ss_become_autonomus').next('.invalid-feedback').text('La fecha SS es requerida').show();
        isValid = false;
    }
    if (!datePattern.test(fechaSS)) { // Validar el formato de la fecha
        formElement.find('#fecha_ss_become_autonomus').addClass('is-invalid');
        formElement.find('#fecha_ss_become_autonomus').next('.invalid-feedback').text('La fecha debe tener el formato DD-MM-YYYY').show();
        isValid = false;
    }
    if (!isValidDate(fechaSS)) { // Validar la fecha en sí
        formElement.find('#fecha_ss_become_autonomus').addClass('is-invalid');
        formElement.find('#fecha_ss_become_autonomus').next('.invalid-feedback').text('La fecha no es válida').show();
        isValid = false;
    }

    // Validar CIF
    if (!cif) {
        formElement.find('#cif_become_autonomus').addClass('is-invalid');
        formElement.find('#cif_become_autonomus').next('.invalid-feedback').text('El NIF/NIE/DNI es requerido').show();
        isValid = false;
    } else {
        const nifPattern = /^[0-9]{8}[A-Z]$/; // NIF: 8 números + 1 letra
        const niePattern = /^[XYZ][0-9]{7}[A-Z]$/; // NIE: 1 letra inicial (X/Y/Z) + 7 números + 1 letra
        const cifPattern = /^[ABCDEFGHJKLMNPQRSUVW][0-9]{7}[0-9A-J]$/; // CIF: 1 letra inicial + 7 números + dígito/control
        const nifLetters = "TRWAGMYFPDXBNJZSQVHLCKE";
    
        // Validar formato general
        if (!nifPattern.test(cif) && !niePattern.test(cif) && !cifPattern.test(cif)) {
            formElement.find('#cif_become_autonomus').addClass('is-invalid');
            formElement.find('#cif_become_autonomus').next('.invalid-feedback').text('El NIF/NIE/DNI tiene un formato inválido').show();
            isValid = false;
        } else {
            // Validar NIF
            if (nifPattern.test(cif)) {
                const numbers = cif.slice(0, -1);
                const expectedLetter = nifLetters[numbers % 23];
                const providedLetter = cif.slice(-1);
    
                if (expectedLetter !== providedLetter) {
                    formElement.find('#cif_become_autonomus').addClass('is-invalid');
                    formElement.find('#cif_become_autonomus').next('.invalid-feedback').text('La letra del NIF no coincide con los números').show();
                    isValid = false;
                }
            }
    
            // Validar NIE
            if (niePattern.test(cif)) {
                let nieNumbers = cif.replace("X", "0").replace("Y", "1").replace("Z", "2").slice(0, -1);
                const expectedLetter = nifLetters[nieNumbers % 23];
                const providedLetter = cif.slice(-1);
    
                if (expectedLetter !== providedLetter) {
                    formElement.find('#cif_become_autonomus').addClass('is-invalid');
                    formElement.find('#cif_become_autonomus').next('.invalid-feedback').text('La letra del NIE no coincide con los números').show();
                    isValid = false;
                }
            }
        }
    }

    // Validar razon social
    if (!razonSocial) {
        formElement.find('#razon_social_become_autonomus').addClass('is-invalid');
        formElement.find('#razon_social_become_autonomus').next('.invalid-feedback').text('La razón social es requerida').show();
        isValid = false;
    } else if (razonSocial.length < 3) {
        formElement.find('#razon_social_become_autonomus').addClass('is-invalid');
        formElement.find('#razon_social_become_autonomus').next('.invalid-feedback').text('La razón social debe tener al menos 3 caracteres').show();
        isValid = false;
    } else if (razonSocial.length > 50) {
        formElement.find('#razon_social_become_autonomus').addClass('is-invalid');
        formElement.find('#razon_social_become_autonomus').next('.invalid-feedback').text('La razón social no puede exceder los 50 caracteres').show();
        isValid = false;
    }

    // Validar direccion fiscal
    if (!direccionFiscal) {
        formElement.find('#direccion_fiscal_become_autonomus').addClass('is-invalid');
        formElement.find('#direccion_fiscal_become_autonomus').next('.invalid-feedback').text('La dirección fiscal es requerida').show();
        isValid = false;
    } else if (direccionFiscal.length < 3) {
        formElement.find('#direccion_fiscal_become_autonomus').addClass('is-invalid');
        formElement.find('#direccion_fiscal_become_autonomus').next('.invalid-feedback').text('La dirección fiscal debe tener al menos 3 caracteres').show();
        isValid = false;
    } else if (direccionFiscal.length > 150) {
        formElement.find('#direccion_fiscal_become_autonomus').addClass('is-invalid');
        formElement.find('#direccion_fiscal_become_autonomus').next('.invalid-feedback').text('La dirección fiscal no puede exceder los 150 caracteres').show();
        isValid = false;
    }

    // Validar profesion_id
    if (!profesionId) {
        const select2Container = formElement.find('#select-profesion-become-autonomus').next('.select2'); // Contenedor de Select2
        formElement.find('#select-profesion-become-autonomus').addClass('is-invalid'); // Agrega clase de error al select original
        select2Container.find('.select2-selection').addClass('is-invalid'); // Marca el contenedor visual de Select2 como inválido
        formElement.find('#select-profesion-become-autonomus').closest('.col-md-6').find('.invalid-feedback').text('La profesión es requerida').show();
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