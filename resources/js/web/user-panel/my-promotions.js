import toastr from 'toastr';
import 'toastr/build/toastr.min.css';
import {
    checkFailStatus,
    standardAjaxResponse,
    checkErrorLangCode
} from '@/custom/custom-form-ajax-response.js';

'use strict';

let isPromotionsLoad = false;
let selectedMode = null;

$(function () {

    $(document).on('shown.bs.tab', '#tab-my-promotions', function (e) {
        getMyPromotions(e);
        window.Helpers.initCustomOptionCheck(); // Init custom option check
    });

    $(document).on('change', 'input[name="radioPromo"]', function (e) {
        selectedMode = $(this).val();
        getAdvPacks(selectedMode);
    });

    $(document).on('click', '.selectable-pack, .selectable-adv', function () {
        selectElement($(this));
    });

    $(document).on('click', '.btnAdquirirPromo', function (e) {
        handlePromoAcquisition();
    });

});

function getMyPromotions(e) {

    if (!isPromotionsLoad) {
        var target = $(e.target).attr("aria-controls"); // Obtenemos el ID del contenido del tab

        if (target === 'content-my-promotions') {

            $.ajax({
                url: '/get-my-promotions-view',
                method: 'GET',
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            .done((response) => {
                
                isPromotionsLoad = true;
                $('#skeleton-my-promotions').fadeOut(400, function () {
                    $('#my-promotions-container').empty().append(response.content).fadeIn(400);
                });
                // $('#my-promotions-container').empty().append(response.content).fadeIn(400);

            })
            .fail((error) => {
                checkFailStatus(error);
            });
        }
    }
}

function getAdvPacks(selectedMode) {
    if(selectedMode == null && selectedMode == '') {
        return;
    }
    
    $('#spinner-loading').fadeIn();
    $.ajax({
        url: '/get-adv-packs-view',
        method: 'POST',
        data: {
            type: selectedMode
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    .done((response) => {
        $('#packs-container').empty().append(response.view);
        if(selectedMode == 'anuncios') {
            initStepWizard(); // Se habilita Stepper, para gestionar los pasos
        }
    })
    .fail((error) => {
        checkFailStatus(error);
    })
    .always(() => {
        $('#spinner-loading').fadeOut();
    });
    
}

function selectElement(element) {
    let isPack = element.hasClass('selectable-pack');
    let isAdv = element.hasClass('selectable-adv');
    
    if (element.hasClass('selected')) {
        element.removeClass('selected');
    } else {
        if (isPack) {
            $('.selectable-pack').removeClass('selected');
        }
        if (isAdv) {
            $('.selectable-adv').removeClass('selected');
        }
        element.addClass('selected');
    }
    
    let packSelected = $('.selectable-pack.selected').length > 0;
    let advSelected = $('.selectable-adv.selected').length > 0;
    
    let enableButton = packSelected && (selectedMode !== 'anuncios' || advSelected);

    // activar/Desactivar los botones de adquirir promoción 
    let btnAdquirirPromo = [].slice.call(document.querySelectorAll('.btnAdquirirPromo'));
    if (btnAdquirirPromo) {
        btnAdquirirPromo.forEach(btn => {
            btn.disabled = !enableButton;
        });
    }
}

function handlePromoAcquisition() {
    let packSelected = $('.selectable-pack.selected').length > 0;
    let advSelected = $('.selectable-adv.selected').length > 0;
    let packId = $('.selectable-pack.selected').data('element-id');
    let advId = $('.selectable-adv.selected').data('element-id');
    let selectedMode = $('input[name="radioPromo"]:checked').val();
    let selectedPack = packSelected ? packId : null;
    let selectedAdv = advSelected ? advId : null;

    if (!packSelected) {
        toastr.error('Debe seleccionar un paquete de promoción');
        return;
    }

    if (selectedMode === 'anuncios' && !advSelected) {
        toastr.error('Debe seleccionar un anuncio');
        return;
    }

    switch (selectedMode) {
        case 'anuncios':
            selectedMode = 'promote_announcement';
            break;
        case 'autonomos':
            selectedMode = 'promote_freelancer';
            break;
        case 'renovar':
            selectedMode = 'renewal_package';
            break;
        default:
            toastr.error('Debe seleccionar un paquete de promoción');
            return;
    }

    $('#spinner-loading').fadeIn();

    $.ajax({
        url: '/adquirir-promocion',
        method: 'POST',
        data: {
            paquete_id: selectedPack,
            anuncio_id: selectedAdv,
            transaccion_tipo: selectedMode,
            metodo_pago: '1' // Esto es temporal, se debe implementar el método de pago
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    .done((response) => {
        standardAjaxResponse('Promoción adquirida', 'Se ha adquirido la promoción correctamente', location.reload());
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
        $('#spinner-loading').fadeOut();
    });
}

function initStepWizard() {
    const wizardCreateApp = document.querySelector('#wizard-create-app');
    if (typeof wizardCreateApp !== undefined && wizardCreateApp !== null) {
        // Wizard next prev button
        const wizardCreateAppNextList = [].slice.call(wizardCreateApp.querySelectorAll('.btn-next'));
        const wizardCreateAppPrevList = [].slice.call(wizardCreateApp.querySelectorAll('.btn-prev'));
  
        const createAppStepper = new Stepper(wizardCreateApp, {
          linear: true,
        });
        
        console.log(wizardCreateAppNextList, wizardCreateAppPrevList, createAppStepper);
        
        if (wizardCreateAppNextList) {
          wizardCreateAppNextList.forEach(wizardCreateAppNext => {
            wizardCreateAppNext.addEventListener('click', event => {
              createAppStepper.next();
            });
          });
        }
        if (wizardCreateAppPrevList) {
          wizardCreateAppPrevList.forEach(wizardCreateAppPrev => {
            wizardCreateAppPrev.addEventListener('click', event => {
              createAppStepper.previous();
            });
          });
        }
    }
}