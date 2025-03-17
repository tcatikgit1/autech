$(document).ready(function () {
  $(".custom-carousel").owlCarousel({
    autoWidth: true,
    loop: true,
    margin: 20,
    responsiveClass: true,
    nav: false,
    dots: true,
  });

  $(".custom-carousel .item").click(function () {
    $(".custom-carousel .item").removeClass("active");
    $(this).addClass("active");
  });
});
