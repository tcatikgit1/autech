<!-- Título de la sección con logo -->
<section class="section-title">
    <div class="title-container" id="servicios">
        <img src="{{ 'assets/img/caroussel/logoService.png' }}" alt="Logo de la sección" class="logo1">
        <h1>Nuestros servicios</h1>
    </div>
</section>
<!-- Carrusel -->
<section uk-slider="finite: true" class="custom-carousel">
    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" >
        <div class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m">
            <!-- Slide 1 -->
            <div class="carousel-slide">
                <a href="#ciberseguridad"><img src="{{ 'assets/img/caroussel/img1.png' }}" class="carousel-image" alt="Imagen 1"></a>
                <div class="carousel-text-container">
                    <h1>Auditoría y soluciones en Ciberseguridad</h1>
                    <h4>Auditorías certificadas y soluciones en ciberseguridad y protección de redes...</h4>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-slide">
                <a href="#peritaje"><img src="{{ 'assets/img/caroussel/img2.png' }}" class="carousel-image" alt="Imagen 2"></a>
                <div class="carousel-text-container">
                    <h1>Peritajes informáticos Judiciales</h1>
                    <h4>Peritajes judiciales del ámbito informático, redes, servidores y correo electrónico.</h4>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="carousel-slide">
                <a href="#wifi"><img src="{{ 'assets/img/caroussel/img3.png' }}" class="carousel-image" alt="Imagen 3"></a>
                <div class="carousel-text-container">
                    <h1>Soluciones y servicios IT</h1>
                    <h4>Soporte y atención técnica especializada, mejoras de servicios IT, Mantenimientos IT...</h4>
                </div>
            </div>
            <!-- Slide 4 -->
            <div class="carousel-slide">
                <a href="#wifi"><img src="{{ 'assets/img/caroussel/img4.png' }}" class="carousel-image" alt="Imagen 4"></a>
                <div class="carousel-text-container">
                    <h1>Instalaciones de sistemas e internet wifi profesional</h1>
                    <h4>Instalaciones, cableados de redes y configuraciones de redes wifi y cableadas.</h4>
                </div>
            </div>
            <!-- Slide 5 -->
            <div class="carousel-slide">
                <a href="#industria"><img src="{{ 'assets/img/caroussel/img5.png' }}" class="carousel-image" alt="Imagen 5"></a>
                <div class="carousel-text-container">
                    <h1>Consultoría técnica</h1>
                    <h4>Consultoría especializada en mejoras de producción, mejoras de procesos laborales y atención técnica</h4>
                </div>
            </div>
        </div>

        <!-- Controles de navegación -->
        <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
        <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>
    </div>

    <!-- Puntos de navegación -->
    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
</section>
