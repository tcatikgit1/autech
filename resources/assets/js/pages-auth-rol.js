document.addEventListener('DOMContentLoaded', function () {
  const continueButton = document.getElementById('continueButton');
  const roleButtons = document.querySelectorAll('.role-btn');
  const initialSection = document.getElementById('initialSection');
  const clientForm = document.getElementById('clientForm');
  const freelancerForm = document.getElementById('freelancerForm');
  const mainContent = document.getElementById('mainContent');
  const imagesContainer = document.getElementById('imagesContainer');
  const stepImage = document.getElementById('stepImage');
  const errorMessage = document.getElementById('error-message');
  const stepperElements = document.querySelectorAll('.bs-stepper');

  let selectedRole = null;

//Imagenes de los pasos
  const stepImages = {
    cliente: [
      'https://autonomus-app-web.test/assets/img/login/image.png',
      'https://autonomus-app-web.test/assets/img/login/image4.png',
      'https://autonomus-app-web.test/assets/img/login/image2.png'
    ],
    autonomo: [
      'https://autonomus-app-web.test/assets/img/login/image1.png',
      'https://autonomus-app-web.test/assets/img/login/image5.png',
      'https://autonomus-app-web.test/assets/img/login/image3.png'
    ]
  };

  // Selección de rol
  roleButtons.forEach(button => {
    button.addEventListener('click', function () {
      roleButtons.forEach(btn => btn.classList.remove('active'));
      this.classList.add('active');
      selectedRole = this.dataset.role;
    });
  });

  continueButton.addEventListener('click', function () {
    if (selectedRole === 'cliente') {
      showForm(clientForm);
      updateStepImage(0);
    } else if (selectedRole === 'autonomo') {
      showForm(freelancerForm);
      updateStepImage(0);
    } else {
      showError('Por favor, selecciona un rol antes de continuar.');
    }
  });

  function showForm(form) {
    initialSection.style.display = 'none';
    mainContent.style.display = 'none';
    imagesContainer.style.display = 'block';
    form.style.display = 'block';
  }

  // Actualizar imagen según el paso
  function updateStepImage(step) {
    if (stepImages[selectedRole] && stepImages[selectedRole][step]) {
      if (stepImage) {
        stepImage.src = stepImages[selectedRole][step];
      }
    }
  }

  // Detectar cambio de paso en el stepper
  stepperElements.forEach(stepperElement => {
    stepperElement.addEventListener('shown.bs-stepper', function (event) {
      const steps = Array.from(stepperElement.querySelectorAll('.step'));
      const currentStepIndex = steps.findIndex(step => step.classList.contains('active'));

      if (currentStepIndex !== -1) {
        updateStepImage(currentStepIndex);
      }
    });
  });

  function showError(message) {
    errorMessage.textContent = message;
    errorMessage.style.display = 'block';
  }

      document.getElementById('privacyPolicyA').addEventListener('change', function () {
        document.getElementById('registerButtonA').disabled = !this.checked;
      });
      document.getElementById('privacyPolicy').addEventListener('change', function () {
        document.getElementById('registerButton').disabled = !this.checked;
      });

});
