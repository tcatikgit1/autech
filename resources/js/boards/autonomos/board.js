import { blockScreen, unblockScreen } from '@/custom/custom-blockUI.js';
import { checkFailStatus, standardAjaxResponseTimer } from '@/custom/custom-form-ajax-response.js';

$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    getAutonomo();

});

function getAutonomo(){
    blockScreen();
    $.ajax({
        url: `/autonomos/getUnvalidateAutonomo`,
        method: `GET`,
    })
        .done((response) => {
            console.log(response);
            // let dataTable = $(`.datatable`);
            // dataTable.DataTable().ajax.reload();
            standardAjaxResponseTimer(response.titulo, response.mensaje);
        })
        .fail((error) => {
            checkFailStatus(error);
        })
        .always(() => {
            unblockScreen();
        });
}
