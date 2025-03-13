import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import {
    checkFailStatus,
    standardAjaxResponse
} from '@/custom/custom-form-ajax-response.js';

'use strict';

$(function () {

    $(document).on('submit', '#change-password-form', function (e) {
        e.preventDefault();
        submitChangePasswordForm($(this));
    });

});

// Función para enviar el formulario de cambio de email
function submitChangePasswordForm(formElement) {

    const form = formElement.get(0); // Obtener el elemento DOM nativo desde el objeto jQuery

    const isValid = ChangePasswordFormValidation(formElement);
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
        console.log(data);
        
        $.each(data, function (key, campo) {
            dataForm.append(campo.name, campo.value);
        });

        $.ajax({
            url: '/change-password',
            method: 'POST',
            contentType: false,
            processData: false,
            data: dataForm,
        })
        .done((response) => {
            standardAjaxResponse('¡Bien hecho!', 'Se ha modificado con éxito la contraseña', window.location.href, 'success', true, 'Vale');
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
        })
    }

    // Añadir la clase Bootstrap para mostrar los estilos de validación visualmente
    form.classList.add('was-validated');
}

function ChangePasswordFormValidation(formElement) {
    let isValid = true;
    // Obtener los valores de los campos de contraseña
    const oldPassword = formElement.find('#old_password').val();
    const newPassword = formElement.find('#new_password').val();
    const newPasswordConfirmation = formElement.find('#new_password_confirmation').val();

    // Limpiar errores previos
    formElement.find('#new_password_confirmation').removeClass('is-invalid');
    formElement.find('#new_password_confirmation').closest('.form-password-toggle').find('.invalid-feedback').hide();
    formElement.find('#new_password').removeClass('is-invalid');
    formElement.find('#new_password').closest('.form-password-toggle').find('.invalid-feedback').hide();
    formElement.find('#old_password').removeClass('is-invalid');
    formElement.find('#old_password').closest('.form-password-toggle').find('.invalid-feedback').hide();

    // Validar old_password
    if (!oldPassword) {
        formElement.find('#old_password').addClass('is-invalid');
        formElement.find('#old_password').closest('.form-password-toggle').find('.invalid-feedback').text('La contraseña actual es requerida').show();
        isValid = false;
    } else if (oldPassword.length > 50) {
        formElement.find('#old_password').addClass('is-invalid');
        formElement.find('#old_password').closest('.form-password-toggle').find('.invalid-feedback').text('La contraseña no puede exceder 50 caracteres').show();
        isValid = false;
    }

    // Validar new_password
    if (!newPassword) {
        formElement.find('#new_password').addClass('is-invalid');
        formElement.find('#new_password').closest('.form-password-toggle').find('.invalid-feedback').text('La nueva contraseña es requerida').show();
        isValid = false;
    } else if (newPassword.length < 8) {
        formElement.find('#new_password').addClass('is-invalid');
        formElement.find('#new_password').closest('.form-password-toggle').find('.invalid-feedback').text('La nueva contraseña debe tener al menos 8 caracteres').show();
        isValid = false;
    } else if (newPassword.length > 50) {
        formElement.find('#new_password').addClass('is-invalid');
        formElement.find('#new_password').closest('.form-password-toggle').find('.invalid-feedback').text('La nueva contraseña no puede exceder 50 caracteres').show();
        isValid = false;
    } else if (!/[0-9]/.test(newPassword)) {
        formElement.find('#new_password').addClass('is-invalid');
        formElement.find('#new_password').closest('.form-password-toggle').find('.invalid-feedback').text('La nueva contraseña debe contener al menos un número').show();
        isValid = false;
    } else if (!/[a-z]/.test(newPassword)) {
        formElement.find('#new_password').addClass('is-invalid');
        formElement.find('#new_password').closest('.form-password-toggle').find('.invalid-feedback').text('La nueva contraseña debe contener al menos una letra minúscula').show();
        isValid = false;
    } else if (!/[A-Z]/.test(newPassword)) {
        formElement.find('#new_password').addClass('is-invalid');
        formElement.find('#new_password').closest('.form-password-toggle').find('.invalid-feedback').text('La nueva contraseña debe contener al menos una letra mayúscula').show();
        isValid = false;
    }

    // Validar new_password_confirmation
    if (!newPasswordConfirmation) {
        formElement.find('#new_password_confirmation').addClass('is-invalid');
        formElement.find('#new_password_confirmation').closest('.form-password-toggle').find('.invalid-feedback').text('La confirmación de la nueva contraseña es requerida').show();
        isValid = false;
    } else if (newPasswordConfirmation !== newPassword) {
        formElement.find('#new_password_confirmation').addClass('is-invalid');
        formElement.find('#new_password_confirmation').closest('.form-password-toggle').find('.invalid-feedback').text('Las contraseñas no coinciden').show();
        isValid = false;
    }

    return isValid;
}
