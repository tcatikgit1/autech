import '../../../resources/assets/vendor/libs/sweetalert2/sweetalert2.js';
import '../../../resources/assets/js/extended-ui-sweetalert2.js';
import '../../../resources/assets/vendor/libs/sweetalert2/sweetalert2.scss';
import '../../../resources/assets/vendor/libs/animate-css/animate.scss';
import toastr from 'toastr';

export function standardAjaxResponse(title, text, url = null, type = 'success', showConfirmButton = false, confirmButtonText='Ok') {
    Swal.fire({
        title: title,
        text: text,
        icon: type,
        showConfirmButton: showConfirmButton,
        confirmButtonText: confirmButtonText,
        customClass: {
            title: 'text-primary fs-3 mx-auto',
            confirmButton: 'btn btn-primary waves-effect waves-light'
        },
    }).then(function (value) {
        if (url != null) {
            window.location = url
        }
    });
}

export function standardAjaxResponseTimer(title, text, time=2000, url = null, type = 'success') {
    Swal.fire({
        title: title,
        text: text,
        timer: time,
        timerProgressBar: true,
        icon: type,
        showConfirmButton: false,
        customClass: {},
    }).then(function (value) {
        if (url != null) {
            window.location = url
        }
    });
}

export function checkFailStatus(error){

    let errorMsg = error.responseJSON && error.responseJSON.mensaje 
    ? error.responseJSON.mensaje 
    : 'An error has occurred. Please try again';

    let title =  error.responseJSON && error.responseJSON.titulo
    ? error.responseJSON.titulo
    : 'Error';

    if(error.status === 401){   // 401 Unathorized => redirige al login
        standardAjaxResponse('Session expired', 'Log in again to continue', "/login", 'error')
    }else if(error.status === 403){
        standardAjaxResponse('Access Denied', 'You are not authorized to access this resource.', null, 'error');
    }else if(error.responseJSON.errors){
        errorListAjaxResponse(error)
    }else{
        standardAjaxResponse(title, errorMsg, null, 'error');
    }
}

// TODO: Esta funcion hay que refactorizarla para que se pueda usar el multilenguaje
export function checkErrorLangCode(errorCodes){
    if (!Array.isArray(errorCodes) || errorCodes.length === 0) {
        return; // Si no hay errores, no hace nada
      }
    
      // Diccionario de mensajes personalizados para cada código de error
      const errorMessages = {
        // commons: 
        operationError: "Ha ocurrido un error durante la operación",
        userNotFound: "Usuario no encontrado",
        advNotFound: "No se ha encontrado el anuncio, inténtelo de nuevo más tarde",
        operationNotAllowed: "Operación no permitida",
        // Formulario de editar perfil
        nameRequired: "El nombre es requerido",
        nameFormat: "El nombre no es válido",
        surnameRequired: "El apellido es requerido",
        surnameFormat: "El apellido no es válido",
        cifRequired: "NIF/CIF es requerido",
        cifFormat: "NIF/CIF no es válido",
        telefonoRequired: "El teléfono es requerido",
        telefonoFormat: "El teléfono no es válido",
        telefonoPrefijoRequired: "El prefijo del teléfono es requerido",
        telefonoPrefijoFormat: "El prefijo del teléfono no es válido",
        telefonoPrefijo2Format: "El prefijo del teléfono adicional no es válido",
        birdthDateRequired: "La fecha de cumpleaños es requerida",
        birdthDateFormat: "La fecha de cumpleaños no es válida",
        profesionRequired: "La profesión es requerida",
        tipoAutonomoRequired: "El tipo de autónomo es requerido",
        // Formulario de cambiar email
        oldEmailRequired: "El email actual es requerido",
        oldEmailFormat: "El email actual no es válido",
        newEmailRequired: "El nuevo email es requerido",
        newEmailFormat: "El  nuevo email no es válido",
        newEmailDifferent: "El nuevo email no puede ser igual al actual",
        newEmailConfirmationRequired: "La confirmación del nuevo email es requerida",
        newEmailConfirmationSame: "Los correos no coinciden",
        userNotFoundByEmail: "No se ha encontrado un usuario con ese email",
        newEmailInUse: "El nuevo email ya está en uso",
        // Formulario de cambiar contraseña
        oldPasswordRequired: "La contraseña actual es requerida",
        newPasswordRequired: "La nueva contraseña es requerida",
        newPasswordMax: "La nueva contraseña no debe superar 50 caracteres",
        newPasswordMin: "La nueva contraseña es demasiado corta",
        newPasswordDifferent: "Los campos de contraseña actual y nueva contraseña no deben ser iguales",
        newPasswordConfirmationRequired: "La confirmación de la nueva contraseña es requerida",
        newPasswordConfirmationSame: "La contraseña de confirmación debe ser igual a la nueva contraseña",
        currentPasswordDoesNotMatch: "La contraseña actual no coincide con la proporcionada",
        newPasswordMatchesCurrent: "La nueva contraseña no puede ser igual a la actual",
        // Formulario de anuncio
        typeRequired: "El tipo de anuncio es requerido",
        titleRequired: "El título es requerido",
        titleMax: "El título no puede superar los 50 caracteres",
        titleMin: "El título debe tener al menos 3 caracteres",
        descriptionRequired: "La descripción es requerida",
        descriptionMax: "La descripción no puede superar los 5000 caracteres",
        descriptionMin: "La descripción debe tener al menos 10 caracteres",
        presupuestoRequired: "El presupuesto es requerido",
        presupuestoNumeric: "El presupuesto debe ser un número",
        presupuestoMin: "Debes establecer un presupuesto mínimo (Puede ser 0)",
        profesionRequired: "La profesión es requerida",
        imagesRequired: "Debe adjuntar un mínimo de 3 y un máximo de 8 imágenes al anuncio",
        badWords: "El texto contiene palabras no permitidas",
        // Renovar anuncio
        notEnoughMinTimeForRenewal: "No ha pasado el tiempo mínimo para renovar el anuncio",
        notEnoughMaxTimeForRenewal: "No han pasado el tiempo suficiente desde la última renovación. ¿Quieres gastar una renovación disponible?",
        noRenewalsAvailable: "No tienes renovaciones disponibles, por favor, adquiere un paquete de renovaciones",
        // Eliminar cuenta
        passwordRequired: "La contraseña es requerida para eliminar la cuenta",
        incorrectPassword: "La contraseña no es correcta",
        // Formulario convertirse en autonomo
        razonSocialRequired: "La razón social es requerida",
        razonSocialMin: "La razón social debe tener al menos 3 caracteres",
        razonSocialMax: "La razón social no puede superar los 50 caracteres",
        ssDateRequired: "La fecha de alta en la Seguridad Social es requerida",
        ssDateFormat: "La fecha de alta en la Seguridad Social no es válida",
        documentoCertificadoFile: "El documento certificado de autónomo es requerido",
        documentoCertificadoMax: "El documento certificado de autónomo no puede superar los 5MB",
        documentomodelo303File: "El documento modelo 303 es requerido",
        documentomodelo303Max: "El documento modelo 303 no puede superar los 5MB",
        // Formulario enviar datos autonomo
        fechaSSRequired: 'La fecha de alta en la Seguridad Social es requerida',
        fechaSSFormat: 'La fecha de alta en la Seguridad Social no es válida',
        doc3Required: 'El documento modelo 303 es requerido',
        doc2Required: 'El documento certificado de autónomo es requerido',
        // Packs de promoción
        packNotFound: 'El paquete de promoción no existe',
        packNotAvailable: 'El paquete de promoción no está disponible en este momento',
        transaccionTipoInvalido: 'El tipo de transacción no es válido',
        paymentFailed: 'El pago ha fallado, inténtelo de nuevo',
        announcementAlreadyPromoted: 'El anuncio ya ha sido promocionado',
      };
    
      let errorMessage = "";
      errorCodes.forEach(code => {
        if (errorMessages[code]) {
          errorMessage += `<p>${errorMessages[code]}</p>`;
        }
      });
    
      if (errorMessage === "") {
        return;
      }
    
      toastr.error(errorMessage, {
        timeOut: 7000,
        closeButton: true,
        escapeHtml: false, // Para que el HTML se renderice correctamente
        progressBar: true
      });
}

export function checkSuccessLangCode(successLangCode) {
    if (!successLangCode) {
        return;
    }

    // Diccionario de mensajes personalizados para cada código de éxito
    const successMessages = {
        // Formulario de anuncio
        advUpdateCorrectly: "Anuncio actualizado correctamente",
        advCreateCorrectly: "Anuncio creado correctamente",
        // Renovar anuncio
        advRenewedCorrectly: "Anuncio renovado correctamente",
    };

    // Obtener el mensaje correspondiente
    const successMessage = successMessages[successLangCode];

    // Si no hay mensaje para el código, no hace nada
    if (!successMessage) {
        return;
    }

    // Mostrar el mensaje con Toastr
    toastr.success(successMessage, {
        timeOut: 7000,
        closeButton: true,
        progressBar: true
    });
}

