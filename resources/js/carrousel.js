document.addEventListener('DOMContentLoaded', function () {
    // Variables iniciales
    const track = document.getElementById('carouselTrack');
    const slides = document.querySelectorAll('.carousel-slide');
    const totalSlides = slides.length; // Número de diapositivas
    let currentSlide = 0;

    // Verificar si totalSlides es correcto
    console.log("Total de diapositivas:", totalSlides);

    // Configuración de los botones
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');

    // Cálculo del ancho de las diapositivas sin margen
    const slideWidth = slides[0].clientWidth + parseInt(getComputedStyle(slides[0]).marginRight, 10); // Incluir margen

    let autoplayInterval;

    // Función para mover el carrusel hacia la izquierda
    function moveToSlide(index) {
        track.style.transform = `translateX(-${slideWidth * index}px)`;
    }

    // Función para ir a la siguiente imagen
    function nextSlide() {
        // Si llegamos al límite de las 3 imágenes, volvemos al principio
        if (currentSlide < 2) {
            currentSlide++;
        } else {
            currentSlide = 0; // Volver al principio (índice 0)
        }
        moveToSlide(currentSlide);
    }

    // Función para ir a la imagen anterior
    function prevSlide() {
        if (currentSlide > 0) {
            currentSlide--;
        } else {
            currentSlide = 2; // Volver a la última imagen (índice 2)
        }
        moveToSlide(currentSlide);
    }

    // Autoplay
    function startAutoplay() {
        autoplayInterval = setInterval(nextSlide, 3000); // Cambiar cada 3 segundos
    }

    function stopAutoplay() {
        clearInterval(autoplayInterval); // Detener el autoplay
    }

    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);

    // Empezamos el autoplay cuando el documento está listo
    startAutoplay();

    // Detener el autoplay al pasar el ratón por encima del carrusel
    const carousel = document.querySelector('.carousel');
    carousel.addEventListener('mouseover', stopAutoplay);
    carousel.addEventListener('mouseout', startAutoplay);
});
