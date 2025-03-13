'use strict';

const formAuthentication = document.querySelector('#formAuthentication');
const clienteRadio = document.getElementById('cliente');
const autonomoRadio = document.getElementById('autonomo');
const continueButton = document.getElementById('continueButton');
const errorMessage = document.getElementById('error-message');
document.addEventListener('DOMContentLoaded', function () {
  const stepperElements = document.querySelectorAll('.bs-stepper');
  const stepperInstances = new Map();

  stepperElements.forEach(stepperElement => {
    if (stepperElement) {
      const id = stepperElement.id || `stepper-${Math.random()}`;
      const instance = new Stepper(stepperElement, { linear: false, animation: true });
      stepperInstances.set(id, instance);

      stepperElement.querySelectorAll('.btn-next').forEach(button => {
        button.addEventListener('click', function (event) {
          event.preventDefault();
          instance.next();
        });
      });

      stepperElement.querySelectorAll('.btn-prev').forEach(button => {
        button.addEventListener('click', function (event) {
          event.preventDefault();
          instance.previous();
        });
      });
    }
  });

  function areInputsFilled(inputs) {
    let allFilled = true;
    inputs.forEach(input => {
      console.log(`Input ${input.id}: '${input.value.trim()}'`);
      if (input.value.trim() === '') {
        input.classList.add('is-invalid');
        allFilled = false;
      } else {
        input.classList.remove('is-invalid');
      }
    });
    return allFilled;
  }

  function clearInvalidInputs(inputs) {
    inputs.forEach(input => input.classList.remove('is-invalid'));
  }

  function handleVerifyButton(event, inputClass, stepperId) {
    const inputs = document.querySelectorAll(inputClass);
    event.preventDefault();
    clearInvalidInputs(inputs);

    if (!areInputsFilled(inputs)) {
      alert('Por favor, rellene todos los campos antes de continuar.');
      return;
    }

    const code = Array.from(inputs)
      .map(input => input.value)
      .join('');
    console.log('Código ingresado:', code);

    if (code.length !== 5) {
      alert('El código de verificación debe tener 5 dígitos.');
      return;
    }

    fetch('https://jsonplaceholder.typicode.com/posts') // TODO: Usar API REAL
      .then(response => {
        return response.json();
      })
      .then(() => {
        const stepperElement = document.querySelector(stepperId);
        if (stepperElement) {
          const stepperInstance = stepperInstances.get(stepperElement.id);
          if (stepperInstance) {
            stepperInstance.next();
          } else {
              alert('Hubo un problema al avanzar al siguiente paso.');

          }
        }
      })
      .catch(error => {
        alert('Hubo un error al verificar el código. Intenta de nuevo más tarde.');
      });
  }

  function setupInputHandlers(inputs) {
    inputs.forEach((input, index) => {
      input.addEventListener('input', function () {
        this.value = this.value.replace(/\D/, ''); // Solo permite dígitos
        if (this.value.length === 1 && index < inputs.length - 1) {
          inputs[index + 1].focus();
        }
      });
      input.addEventListener('keydown', function (event) {
        if (event.key === 'Backspace' && this.value === '' && index > 0) {
          inputs[index - 1].focus();
        }
      });
    });
  }

  const verifyButtonA = document.getElementById('verifyButtonA');
  if (verifyButtonA) {
    verifyButtonA.addEventListener('click', event =>
      handleVerifyButton(event, '.verify-input2', '#multiStepsValidationA')
    );
  }

  const verifyButton = document.getElementById('verifyButton');
  if (verifyButton) {
    verifyButton.addEventListener('click', event => handleVerifyButton(event, '.v-input', '#multiStepsValidation'));
  }

  setupInputHandlers(document.querySelectorAll('.verify-input2'));
  setupInputHandlers(document.querySelectorAll('.v-input'));

  document.getElementById('privacyPolicyA')?.addEventListener('change', function () {
    document.getElementById('registerButtonA').disabled = !this.checked;
  });
  document.getElementById('privacyPolicy')?.addEventListener('change', function () {
    document.getElementById('registerButton').disabled = !this.checked;
  });

  const numeralMask = document.querySelectorAll('.numeral-mask');
  if (numeralMask.length) {
    numeralMask.forEach(e => {
      new Cleave(e, { numeral: true });
    });
  }
});

//   if (formAuthentication) {
//     const fv = FormValidation.formValidation(formAuthentication, {
//       fields: {
//         username: {
//           validators: {
//             notEmpty: { message: 'Please enter username' },
//             stringLength: { min: 6, message: 'Username must be more than 6 characters' }
//           }
//         },
//         email: {
//           validators: {
//             notEmpty: { message: 'Please enter your email' },
//             emailAddress: { message: 'Please enter valid email address' }
//           }
//         },
//         password: {
//           validators: {
//             notEmpty: { message: 'Please enter your password' },
//             stringLength: { min: 6, message: 'Password must be more than 6 characters' }
//           }
//         },
//         'confirm-password': {
//           validators: {
//             notEmpty: { message: 'Please confirm password' },
//             identical: {
//               compare: function () {
//                 return formAuthentication.querySelector('[name="password"]').value;
//               },
//               message: 'The password and its confirm are not the same'
//             },
//             stringLength: { min: 6, message: 'Password must be more than 6 characters' }
//           }
//         },
//         'verify-input[]': {
//           validators: {
//             notEmpty: {
//               message: 'Por favor ingresa todos los dígitos del código de verificación.'
//             },
//             stringLength: {
//               min: 1,
//               max: 1,
//               message: 'Cada campo debe contener un solo dígito.'
//             }
//           }
//         },
//         terms: {
//           validators: {
//             notEmpty: { message: 'Please agree terms & conditions' }
//           }
//         }
//       },
//       plugins: {
//         trigger: new FormValidation.plugins.Trigger(),
//         bootstrap5: new FormValidation.plugins.Bootstrap5({
//           eleValidClass: '',
//           rowSelector: '.mb-6'
//         }),
//         submitButton: new FormValidation.plugins.SubmitButton(),
//         defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
//         autoFocus: new FormValidation.plugins.AutoFocus()
//       },
//       init: instance => {
//         instance.on('plugins.message.placed', function (e) {
//           if (e.element.parentElement.classList.contains('input-group')) {
//             e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
//           }
//         });
//       }
//     });
//   }
