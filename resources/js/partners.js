const track = document.getElementById("partnersTrack");
const slides = Array.from(track.children);

// Función para recalcular el ancho del slide según el tamaño de la ventana
function getSlideWidth() {
    const slideWidth = slides[0].offsetWidth;
    return slideWidth;
}

// Función para mover el carrusel
function autoSlide() {
    const slideWidth = getSlideWidth();

    track.style.transition = "transform 1s ease";
    track.style.transform = `translateX(-${slideWidth}px)`;

    setTimeout(() => {
        track.style.transition = "none";
        track.appendChild(slides.shift());
        track.style.transform = "translateX(0)";
        slides.push(track.children[track.children.length - 1]);
    }, 1000);
}

// Cambiar de imagen cada 5 segundos
setInterval(autoSlide, 5000);

// Ajustar el carrusel al cambiar el tamaño de la ventana
window.addEventListener("resize", () => {
    track.style.transition = "none";
    track.style.transform = "translateX(0)";
    setTimeout(() => {
        track.style.transition = "transform 1s ease";
    }, 100);
});
