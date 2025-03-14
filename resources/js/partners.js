const track = document.getElementById("partnersTrack");
const slides = Array.from(track.children);

// Función para recalcular el ancho del slide según el tamaño de la ventana
function getSlideWidth() {
    const slideWidth = slides[0].offsetWidth; // Calcula el ancho del primer slide
    return slideWidth;
}

// Función para mover el carrusel
function autoSlide() {
    const slideWidth = getSlideWidth(); // Obtener el nuevo ancho de la imagen

    // Aplica la transición para mover la imagen
    track.style.transition = "transform 1s ease";
    track.style.transform = `translateX(-${slideWidth}px)`; // Mueve el carrusel a la izquierda

    // Después de 1 segundo (tiempo de la transición), mueve el primer slide al final
    setTimeout(() => {
        track.style.transition = "none"; // Desactiva la transición temporalmente
        track.appendChild(slides.shift()); // Mueve la primera imagen al final
        track.style.transform = "translateX(0)"; // Resetea la posición
        slides.push(track.children[track.children.length - 1]); // Añade la última imagen al array de slides
    }, 1000); // Espera a que la transición termine antes de reordenar los slides
}

// Cambiar de imagen cada 5 segundos
setInterval(autoSlide, 5000);

// Ajustar el carrusel al cambiar el tamaño de la ventana
window.addEventListener("resize", () => {
    track.style.transition = "none"; // Evita la transición durante el ajuste
    track.style.transform = "translateX(0)"; // Reinicia la posición del carrusel
    setTimeout(() => {
        track.style.transition = "transform 1s ease"; // Reestablece la transición
    }, 100);
});
