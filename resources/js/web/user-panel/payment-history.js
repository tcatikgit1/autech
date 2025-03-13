import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import {
    checkFailStatus,
    standardAjaxResponse
} from '@/custom/custom-form-ajax-response.js';

'use strict';

let isHistoryPaymentsLoad = false;

$(function () {

    $(document).on('shown.bs.tab', '#tab-payment-history', function (e) {
        getPaymentHistory(e);
    });

});

function getPaymentHistory(e) {

    if (!isHistoryPaymentsLoad) {
        var target = $(e.target).attr("aria-controls"); // Obtenemos el ID del contenido del tab

        if (target === 'content-payment-history') {

            $.ajax({
                url: '/get-history-payment-view',
                method: 'GET',
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .done((response) => {
                isHistoryPaymentsLoad = true;
                $('#skeleton-history-payments').fadeOut(400, function () {
                    $('#payment-history-container').empty().append(response.content).fadeIn(400);
                });

            })
            .fail((error) => {
                checkFailStatus(error);
            });
        }
    }
}