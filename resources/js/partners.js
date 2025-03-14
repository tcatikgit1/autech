 const track = document.getElementById('carouselTrack');
    const slides = Array.from(track.children);
    const slideWidth = slides[0].offsetWidth;

    function autoSlide() {
        track.style.transition = 'transform 1s ease';
        track.style.transform = `translateX(-${slideWidth}px)`;

        setTimeout(() => {
            track.style.transition = 'none';
            track.appendChild(slides.shift());
            track.style.transform = 'translateX(0)';
            slides.push(track.children[track.children.length - 1]);
        }, 1000);
    }

    setInterval(autoSlide, 5000);