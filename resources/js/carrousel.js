$(".custom-carousel").owlCarousel({
    autoWidth: true,
    loop: true
});
$(document).ready(function () {
    $(".custom-carousel .item").click(function () {
        $(".custom-carousel .item").not($(this)).removeClass("active");
        $(this).toggleClass("active");
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const items = document.querySelectorAll(".game-section .item");

    items.forEach((item) => {
        item.addEventListener("click", function () {
            const targetId = this.getAttribute("data-target");
            if (targetId) {
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({ behavior: "smooth" });
                }
            }
        });
    });
});
