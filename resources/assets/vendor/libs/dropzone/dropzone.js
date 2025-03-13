import Dropzone from 'dropzone/dist/dropzone';

Dropzone.autoDiscover = false;

// File upload progress animation
Dropzone.prototype.uploadFiles = function (files) {
  const minSteps = 6;
  const maxSteps = 60;
  const timeBetweenSteps = 100;
  const bytesPerStep = 100000;
  const isUploadSuccess = true;

  const self = this;

  for (let i = 0; i < files.length; i++) {
    const file = files[i];
    const totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));

    for (let step = 0; step < totalSteps; step++) {
      const duration = timeBetweenSteps * (step + 1);

      setTimeout(
        (function (file, totalSteps, step) {
          return function () {
            file.upload = {
              progress: (100 * (step + 1)) / totalSteps,
              total: file.size,
              bytesSent: ((step + 1) * file.size) / totalSteps
            };

            self.emit('uploadprogress', file, file.upload.progress, file.upload.bytesSent);
            if (file.upload.progress === 100) {
              if (isUploadSuccess) {
                file.status = Dropzone.SUCCESS;
                self.emit('success', file, 'success', null);
              } else {
                file.status = Dropzone.ERROR;
                self.emit('error', file, 'Some upload error', null);
              }

              self.emit('complete', file);
              self.processQueue();
            }
          };
        })(file, totalSteps, step),
        duration
      );
    }
  }
};

const previewTemplate = `<div class="dz-preview dz-file-preview">
<div class="dz-details">
  <div class="dz-thumbnail">
    <img data-dz-thumbnail>
    <span class="dz-nopreview">No preview</span>
    <div class="dz-success-mark"></div>
    <div class="dz-error-mark"></div>
    <div class="dz-error-message"><span data-dz-errormessage></span></div>
    <div class="progress">
      <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
    </div>
  </div>
  <div class="dz-filename" data-dz-name></div>
  <div class="dz-size" data-dz-size></div>
</div>
</div>`;

function initDropzone(
  elementId,
  url,
  paramName = "file", // Parámetro del archivo en el servidor
  isDraggable = true, // Determina si las imágenes pueden ordenarse
  maxFiles = 10, // Número máximo de archivos 
  maxFilesize = 5, // Tamaño máximo por archivo en MB
) {
  const dropzoneElement = document.querySelector(`#${elementId}`);

  if (!dropzoneElement) {
    console.error(`El elemento con ID "${elementId}" no existe.`);
    return;
  }

  let acceptedFiles = ".png,.jpg,.jpeg";

  const dropzoneInstance = new Dropzone(`#${elementId}`, {
    url: url,
    paramName: paramName,
    autoProcessQueue: true,
    previewTemplate: previewTemplate,
    parallelUploads: 1,
    acceptedFiles: acceptedFiles,
    maxFilesize: maxFilesize,
    maxFiles: maxFiles,
    addRemoveLinks: true,
    init: function () {
      this.on("addedfile", function (file) {
        const previewElement = file.previewElement;
        if (previewElement) {

          if (file.isMock) {
            // Si es mock, usa el nombre existente
            previewElement.setAttribute("data-name", file.onlyName);
          } else {
            // Si no es mock, genera un nombre aleatorio
            const randomName = window.Helpers.generateRandomText();(5);
            previewElement.setAttribute("data-name", randomName);
          }
        }

        // Actualizar el orden al agregar una imagen
        updateFileOrder(dropzoneElement);

        // Actualizar el orden al eliminar una imagen
        this.on("removedfile", function () {
          updateFileOrder(dropzoneElement);
        });
      });
    },
  });

  // Variable global para guardar el orden de los archivos
  let fileOrder = {};

  if (isDraggable) {
    Sortable.create(dropzoneElement, {
      draggable: ".dz-preview",
      onEnd: function () {
        updateFileOrder(dropzoneElement);
      },
    });
  }

  // Función para actualizar el orden
  function updateFileOrder(dropzoneElement) {
    const items = dropzoneElement.querySelectorAll(".dz-preview");
    fileOrder = Array.from(items).reduce((acc, item, index) => {
      // const fileName = item.dataset.name;
      const fileName = item.getAttribute("data-name");
      acc[fileName] = index;
      return acc;
    }, {});
    
    // Actualizar el campo oculto del formulario si este existe en el formulario
    if(document.querySelector('#file-order-input')) {
      document.querySelector('#file-order-input').value = JSON.stringify(fileOrder); 
    }
  }

  dropzoneElement.dropzoneInstance = dropzoneInstance;
  dropzoneElement.fileOrder = fileOrder;
}

try {
  window.Dropzone = Dropzone;
} catch (e) { }

export { Dropzone, initDropzone, previewTemplate };
