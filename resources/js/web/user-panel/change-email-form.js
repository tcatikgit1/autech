import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import {
    checkFailStatus,
    standardAjaxResponse,
    checkErrorLangCode
} from '@/custom/custom-form-ajax-response.js';

'use strict';

$(function () {

    $(document).on('submit', '#change-email-form', function (e) {
        e.preventDefault();
        submitChangeEmailForm($(this));
    });

});

// Función para enviar el formulario de cambio de email
function submitChangeEmailForm(formElement) {

    const form = formElement.get(0); // Obtener el elemento DOM nativo desde el objeto jQuery

    const isValid = ChangeEmailFormValidation(formElement);
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

        $.ajax({
            url: '/change-email',
            method: 'POST',
            contentType: false,
            processData: false,
            data: dataForm,
        })
        .done((response) => {
            standardAjaxResponse('¡Bien hecho!', 'Se ha modificado con éxito el email', window.location.href, 'success', true, 'Vale');
        })
        .fail((error) => {
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

function ChangeEmailFormValidation(formElement) {
    let isValid = true;

    // Obtener los valores de los campos de correo
    const currentEmail = formElement.find('#old_email').val();
    const newEmail = formElement.find('#new_email').val();
    const emailConfirmation = formElement.find('#new_email_confirmation').val();

    formElement.find('#new_email_confirmation').removeClass('is-invalid');
    formElement.find('#new_email_confirmation').next('.invalid-feedback').hide();
    formElement.find('#new_email').removeClass('is-invalid');
    formElement.find('#new_email').next('.invalid-feedback').hide();

    // Verificar campos vacios
    if (newEmail === '') {
        formElement.find('#new_email').addClass('is-invalid');
        formElement.find('#new_email').next('.invalid-feedback').text('Indique el nuevo email').show();
        isValid = false;
    }

    if (emailConfirmation === '') {
        formElement.find('#new_email_confirmation').addClass('is-invalid');
        formElement.find('#new_email_confirmation').next('.invalid-feedback').text('La confirmación es requerida').show();
        isValid = false;
    }

    // Verificar si los correos electrónicos coinciden
    if (newEmail !== emailConfirmation) {
        formElement.find('#new_email_confirmation').addClass('is-invalid');
        formElement.find('#new_email_confirmation').next('.invalid-feedback').text('Los correos no coinciden').show();
        isValid = false;
    }

    // Verificar si el nuevo correo es igual al actual
    if (currentEmail === newEmail) {
        formElement.find('#new_email').addClass('is-invalid');
        formElement.find('#new_email').next('.invalid-feedback').text('El nuevo email no puede ser igual al actual').show();
        isValid = false;
    }

    return isValid;
}