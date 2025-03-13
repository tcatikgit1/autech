/**
 * Pages User Profile
 */
import { initGooglePlaceElements } from '@/google-place-api.js';
import { previewTemplate, initDropzone } from '../../../assets/vendor/libs/dropzone/dropzone.js';
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import {
  checkFailStatus,
  standardAjaxResponse,
  standardAjaxResponseTimer,
  checkErrorLangCode
} from '@/custom/custom-form-ajax-response.js';

'use strict';

$(function () {
  loadDashboard();

  // Evento para enviar el formulario de edición de perfil
  $(document).on('submit', '#edit-profile-form', function (e) {
    e.preventDefault();
    submitEditProfileForm($(this));
  });

  // Llama a la función handleImagePreview cuando cambie el input de archivo
  $(document).on('change', '#avatar', handleImagePreview);

  // Evento para eliminar la cuenta
  $(document).on('click', '#delete-account-button', function (e) {
    e.preventDefault();
    deleteAccount($(this));
  });

  // Evento para activar/desactivar los datos del usuario
  $(document).on('change', '#toggle-user-data-switch', function () {
    toggleUserData(this);
  });

  // Evento que deselecciona las habilidades al cambiar la profesión
  $(document).on('change', '.populate-profesion', function () {
    const selectHabilidades = $(this).data('target'); // Obtener el selector de habilidades correspondiente desde el atributo data-target
    $(selectHabilidades).val(null).trigger('change'); // Deseleccionar todas las opciones en el selector de habilidades
    handleProfessionSelection(document.querySelector(selectHabilidades)); // Manejar la selección de habilidades por grupo de profesión
  });

  // Arreglando la forma en la que se cambia entre los tabs de arriba (Favoritos y seguidos) con los del listado de abajo
  $(document).on('click', '.buttons-action .action-button', function (e) {
    $('.menu-list .menu-item').removeClass('active').removeClass('show');
    $('.bottom-section.tab-pane').removeClass('active').removeClass('show'); // Ocultar todos los tabs de abajo (Los <li> del aside)
  }); 
  $(document).on('click', '.menu-list .menu-item', function (e) {
    if ($(e.target).closest('.menu-item').hasClass('no-tab')) return; // Verifica si el elemento o su contenedor tiene la clase "no-tab"
    $('.buttons-action .action-button').removeClass('active').removeClass('show');
    $('.top-section.tab-pane').removeClass('active').removeClass('show'); // Ocultar todos los tabs de arriba (Los botones de favoritos/Segidos)
  });

  $(document).on('click', '.reload-action', function (e) {
    location.reload();
  })

});

// Primera petición para cargar el dashboard
function loadDashboard() {

  const dashboardRequest = $.ajax({
    url: '/get-dashboard-view',
    method: 'GET',
  });

  // Segunda petición para obtener los datos adicionales (habilidades generales, profesiones, tipos de autonomo)
  const additionalDataRequest = $.ajax({
    url: '/general-data',
    method: 'GET',
  });

  // Ejecutar ambas peticiones en paralelo y esperar que ambas finalicen
  $.when(dashboardRequest, additionalDataRequest)
    .done((dashboardResponse, additionalDataResponse) => {

      // Procesar la respuesta de `/get-dashboard-view`
      $('#skeleton-user-panel-page').fadeOut(400, function () {
        $('#profile').empty().append(dashboardResponse[0].aside).fadeIn(400);
        $('#content').empty().append(dashboardResponse[0].content).fadeIn(400);

        // Inicializar componentes del dashboard
        initializeDashboardComponents();
        // Inicializar el campo ubicacion
        initGooglePlaceElements('location-input');

        // Procesar los datos adicionales para rellenar los formulario del panel de usuario
        populateForm(additionalDataResponse[0]);
      });
    })
    .fail((error) => {

      let navbarHeight = document.querySelector('.layout-navbar').offsetHeight; // Get element nav with class layout-navbar y calcular su altura
      let footerHeight = document.querySelector('.landing-footer').offsetHeight; // Get element footer with class "landing-footer" y calcular su altura

      $('.grid-container').fadeOut(400, function () {
        $('#error-content').removeClass('d-none');
        $('#error-content').css('height', `calc(100vh - ${footerHeight}px - ${navbarHeight}px)`);
      });
    })
    .always(() => {
      $('#skeleton-user-panel-page').fadeOut();
    });
}

// Funcion que inicializa todo lo que tenga que ver del DOM tras cargar el dashboard (Select2, tooltips, etc)
function initializeDashboardComponents() {
  initDropzone('dropzone-adv', '/upload-image', 'file', true, 8, 5);
  window.Helpers.initPasswordToggle(); // Toggle Password Visibility
  const select2 = $('.select2');
  const editButton = document.querySelector(".edit-profile-button");
  const submitButton = document.querySelector("#submit-edit-profile");

  // Inicializar tooltips de Bootstrap
  let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // Inicializar select2
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>').select2({
        placeholder: 'Seleccione una opción',
        dropdownParent: $this.parent()
      });
    });
  }

  // Inicializar select2 para prefijo con plantilla personalizada
  $('.select2-flag').select2({
    templateResult: formatFlag,
    templateSelection: formatFlag,
    width: 'auto',
    minimumResultsForSearch: Infinity  // Ocultar barra de búsqueda
  });

  // Plantilla para renderizar bandera y texto
  function formatFlag(option) {
    if (!option.id) {
      return option.text;
    }
    var flagSvg = $(option.element).data('flag');
    return $(
      '<span class="flag-icon">' + flagSvg + '</span>' +
      '<span class="country-code"> ' + option.text + '</span>'
    );
  }
  
  

  // Activar formulario al hacer clic en "Editar perfil"
  if (editButton) {
    editButton.addEventListener("click", function () {
      const fieldset = document.querySelector("#content-personal-information fieldset");
      fieldset.disabled = false;
      document.querySelectorAll("#content-personal-information select")
        .forEach(element => {
          element.disabled = false;
        });
    });
  } else {
    console.warn("El botón de edición no se encontró en el DOM");
  }

  // En caso de que el usuario haga click en "Crear" del navbar, abrimos el tab y el modal correspondiente para crear anuncio
  const activeTab = document.querySelector('meta[name="tab"]').content;
  const activeModal = document.querySelector('meta[name="modal').content;

  if (activeTab && activeTab !== '') {

    const defaultActiveTab = document.querySelector('.menu-item.active');
    const defaultActiveContent = document.querySelector('.tab-pane.show.active');

    if (defaultActiveTab) {
      defaultActiveTab.classList.remove('active');
    }
    if (defaultActiveContent) {
      defaultActiveContent.classList.remove('show', 'active');
    }

    const tabElement = document.querySelector(`[data-bs-target="#content-${activeTab}"]`);
    if (tabElement) {
      new bootstrap.Tab(tabElement).show(); // Mostrar la pestaña
    }

    // Abrir el modal correspondiente
    if (activeModal) {
      const modalElement = document.getElementById(activeModal);
      if (modalElement) {
        const modalInstance = new bootstrap.Modal(modalElement);
        modalInstance.show(); // Mostrar el modal
      }
    }
  }
}

// Funcion para activar/desactivar los datos del usuario
function toggleUserData(checkbox) {

  const originalState = !checkbox.checked; // Estado original del checkbox
  $(checkbox).prop('disabled', true); // Desactivamos el checkbox temporalmente

  $.ajax({
    url: '/change-data-visibility',
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  })
  .done((response) => {
    toastr.success('Se ha actualizado la visibilidad de los datos');
  })
  .fail((error) => {
    checkFailStatus(error);
    checkbox.checked = originalState; // Restauramos el estado original en caso de error
  })
  .always(() => {
    $(checkbox).prop('disabled', false); // Reactivamos el checkbox
  });
}

function deleteAccount() {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "Esta acción no se puede deshacer, por favor, introduce tu contraseña para confirmar la eliminación.",
    icon: "warning",
    input: "password", // Campo de entrada para contraseña
    inputPlaceholder: "Introduce tu contraseña",
    inputAttributes: {
      autocapitalize: "off",
      autocomplete: "current-password",
    },
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Si, eliminar cuenta",
    customClass: {
      title: 'text-primary fs-3 mx-auto',
      confirmButton: 'btn btn-danger waves-effect waves-light',
      cancelButton: 'btn btn-primary waves-effect waves-light',
    },
    preConfirm: (password) => {
      if (!password) {
        Swal.showValidationMessage("Por favor, introduce tu contraseña");
      }
      return password; // Devuelve la contraseña al bloque `then`
    },
  }).then((result) => {
    const password = result.value; // Recupera la contraseña ingresada
    if (result.isConfirmed) {
      $.ajax({
        url: '/delete-account',
        method: 'POST',
        data: {
          password: password,
        },
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      })
      .done((response) => {
        window.location.href = '/';
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

// Funcion que modifica la imagen de perfil cuando el usuario selecciona una imagen
function handleImagePreview(event) {
  const file = event.target.files[0];
  const reader = new FileReader();

  // Cuando el archivo esté listo, actualiza el src de la imagen
  reader.onload = function (e) {
    document.getElementById('profile-image').src = e.target.result;
  };

  reader.readAsDataURL(file); // Lee el archivo como una URL
}

// Función para enviar el formulario de edición de perfil
function submitEditProfileForm(formElement) {
  const form = formElement.get(0); // Obtener el elemento DOM nativo desde el objeto jQuery

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

    // Añadir archivos al dataForm
    let inputs = formElement.find('input[type=file]');
    $.each(inputs, function (key, input) {
      let file = $(input).prop('files')[0];
      if (file instanceof File) {
        dataForm.append(input.name, file);
      }
    });

    $.ajax({
      url: '/update-profile-data',
      method: 'POST',
      contentType: false,
      processData: false,
      data: dataForm,
    })
      .done((response) => {
        standardAjaxResponse('¡Bien hecho!', 'Se han guardado con éxito los cambios', window.location.href, 'success', true, 'Vale');
      })
      .fail((error) => {
        formElement.find('button[type="submit"]').prop('disabled', false);
        error = error.responseJSON;
        if(error.errorLangCode) {
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

function populateForm(data) {
  populateTipoAutonomoSelect(data.tiposAutonomo);
  populateProfesionSelect(data.profesiones);
  populateHabilidadesSelect(data.profesiones);
  populateHabilidadesGeneralesSelect(data.habilidadesGenerales);
}

// Rellenar select de profesiones de todos los formularios del panel de usuario
function populateProfesionSelect(profesiones) {

  const selectores = document.querySelectorAll('.populate-profesion'); // Seleccionar todos los selectores de profesion

  selectores.forEach((selector) => {
    
    const userProfesionId = selector.dataset.userProfesion || null; // Obtener la profesión del usuario (si corresponde) desde el atributo data-user-profesion

    profesiones.forEach((profesion) => {
      // Crear opción para el <select>
      const option = document.createElement('option');
      option.value = profesion._id;
      option.text = profesion.titulo;

      // Seleccionar la opción si coincide con la profesión del usuario en el formulario de perfil
      if (selector.id === 'select-profesion' && profesion._id == userProfesionId) {
        option.selected = true;
      }

      // Añadir la opción al <select>
      selector.appendChild(option);
    });
  });
}

// Rellenar select de habilidades de todos los formularios del panel de usuario
function populateHabilidadesSelect(profesiones) {
  
  const selects = document.querySelectorAll('.populate-habilidades'); // Seleccionar todos los <select> que necesitan ser rellenados con habilidades

  selects.forEach((select) => {
    const userHabilidades = JSON.parse(select.dataset.userHabilidades || '[]'); // Habilidades del usuario
    const parentProfesionId = select.dataset.parentSelectProfesionId; // ID del selector relacionado (si existe)

    select.innerHTML = ''; // Limpiar las opciones antes de rellenar

    profesiones.forEach((profesion) => {
      // Crear un grupo de opciones (optgroup) por cada profesión
      const optgroup = document.createElement('optgroup');
      optgroup.label = profesion.titulo;
      optgroup.dataset.profesionId = profesion._id;

      profesion.habilidades.forEach((habilidad) => {
        const option = document.createElement('option');
        option.value = habilidad._id;
        option.text = habilidad.titulo;

        // Seleccionar habilidades del usuario solo si aplica
        if (userHabilidades.includes(habilidad._id)) {
          option.selected = true;
        }

        optgroup.appendChild(option); // Añadir opción al optgroup
      });

      select.appendChild(optgroup); // Añadir el optgroup al select
    });

    // Aplicar la lógica de habilitación/deshabilitación por grupo según el selector de profesión relacionado
    if (parentProfesionId) {
      handleProfessionSelection(select);
      $(select).on('change', () => handleProfessionSelection(select));
    }
  });
}

// Rellenar select de habilidades generales de todos los formularios del panel de usuario
function populateHabilidadesGeneralesSelect(habilidadesGenerales) {
  
  const selects = document.querySelectorAll('.populate-habilidades-generales'); // Seleccionar todos los <select> que necesitan habilidades generales

  selects.forEach((select) => {
    const userHabilidadesGenerales = JSON.parse(select.dataset.userHabilidadesGenerales || '[]'); // Obtener habilidades del usuario
    select.innerHTML = ''; // Limpiar opciones antes de agregar nuevas

    habilidadesGenerales.forEach((habilidad) => {
      const option = document.createElement('option');
      option.value = habilidad._id;
      option.text = habilidad.titulo;

      if (select.id == 'select-habilidades-generales' && userHabilidadesGenerales.includes(habilidad._id)) {
        option.selected = true;
      }

      select.appendChild(option); // Añadir opción al <select>
    });

    // Refrescar Select2 (si se utiliza)
    $(select).trigger('change');
  });
}

// Rellenar select de tipos de autónomo de todos los formularios del panel de usuario
function populateTipoAutonomoSelect(tipoAutonomos) {

  const selects = document.querySelectorAll('.populate-tipo-autonomo');  // Seleccionar todos los <select> que necesitan los tipos de autónomo

  selects.forEach((select) => {
    const userTipoAutonomoId = select.dataset.userTipoAutonomo; // Obtener el tipo de autónomo del usuario
    select.innerHTML = ''; // Limpiar opciones antes de agregar nuevas

    tipoAutonomos.forEach((tipoAutonomo) => {
      const option = document.createElement('option');
      option.value = tipoAutonomo._id;
      option.text = tipoAutonomo.display;

      // Seleccionar el tipo de autónomo del usuario si aplica
      if (tipoAutonomo._id == userTipoAutonomoId) {
        option.selected = true;
      }

      select.appendChild(option); // Añadir la opción al <select>
    });

    // Refrescar Select2 (si se utiliza)
    $(select).trigger('change');
  });
}

// Permite manejar la selección de habilidades por grupo de profesión (solo se pueden seleccionar habilidades de la profesión seleccionada)
function handleProfessionSelection(selectHabilidades) {
  const parentProfesionId = selectHabilidades.dataset.parentSelectProfesionId; // ID del selector relacionado
  const selectedProfesionId = document.getElementById(parentProfesionId)?.value; // Profesión seleccionada en el selector relacionado

  const optgroups = selectHabilidades.getElementsByTagName('optgroup'); // Obtener optgroups

  Array.from(optgroups).forEach((optgroup) => {
    const profesionId = optgroup.dataset.profesionId;
    Array.from(optgroup.children).forEach((option) => {
      option.disabled = profesionId !== selectedProfesionId; // Habilitar/deshabilitar según profesión seleccionada
    });
  });

  // Refrescar Select2 si se utiliza
  $(selectHabilidades).trigger('change.select2');
}