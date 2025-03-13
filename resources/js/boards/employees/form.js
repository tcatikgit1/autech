import { checkFailStatus, standardAjaxResponse } from '@/custom/custom-form-ajax-response.js';

$(() => {
    let accountUserImage = document.getElementById('uploadedFile');
    const fileInput = document.querySelector('.fileInput'),
        resetFileInput = document.querySelector('.account-image-reset');

    if (accountUserImage) {
        const resetImage = accountUserImage.src;
        fileInput.onchange = () => {
            if (fileInput.files[0]) {
                accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
            }
        };
        resetFileInput.onclick = () => {
            fileInput.value = '';
            accountUserImage.src = resetImage;
        };
    }


    $('#board-form').on('submit', function (e) {
        e.preventDefault();

        let data = $(this).serializeArray();
        let dataForm = new FormData();

        $.each(data, function (key, campo) {
            dataForm.append(campo.name, campo.value);
        });

        // Añadimos todos los input files al dataForm
        let inputs = $(this).find('input[type=file]');

        $.each(inputs, function (key, input) {
            let file = $(this).prop('files')[0];
            if(file instanceof File){
                dataForm.append(input.name, file);
            }else {
                dataForm.append(input.name, $(this).prop('data-url'));
            }
        });

        $.ajax({
            url: $(this).prop('action'),
            method: 'POST',
            contentType: false,
            processData: false,
            data: dataForm,
        })
        .done((response) => {
            standardAjaxResponse(response.titulo, response.mensaje);
        })
        .fail((error) => {
            checkFailStatus(error);
        })
        .always(() => {
            // $("#spinner-loading").fadeOut();
        });

    });
});
