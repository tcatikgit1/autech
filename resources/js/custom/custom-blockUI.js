import '../../../resources/assets/vendor/libs/block-ui/block-ui.js';
import '../../../resources/assets/vendor/libs/spinkit/spinkit.scss';

export function blockScreen(){
  $('body').block({
    message:
      '<div class="sk-wave mx-auto"><div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div> <div class="sk-rect sk-wave-rect"></div></div>',
    timeout: 1000,
    css: {
      backgroundColor: 'transparent',
      border: '0'
    },
    overlayCSS: {
      opacity: 0.5
    }
  });
}

export function unblockScreen(){
  $('body').unblock()
}
