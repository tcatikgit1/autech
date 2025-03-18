<div class="contacto" id="contacto">
    <!-- Formulario (Div 1) -->
    <div class="formulario div1">
        <h2 class="d-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-address-book">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M20 6v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2z" />
                <path d="M10 16h6" />
                <path d="M13 11m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M4 8h3" />
                <path d="M4 12h3" />
                <path d="M4 16h3" />
            </svg>
            Contacta con nosotros
        </h2>
        <form>
            <label for="email">Email:</label>
            <input type="email" id="email" placeholder="Tu correo">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" placeholder="Tu nombre">
            <label for="mensaje">Mensaje:</label>
            <textarea id="mensaje" rows="5" placeholder="¿En qué podemos ayudarte?"></textarea>
            <!-- Contenedor para checkbox y texto en la misma fila -->
            <div class="checkbox-container">
                <input type="checkbox" id="terminos">
                <label for="terminos">He leído y acepto las <a href="" target="_blank"
                        class="text-primary">condiciones
                        de uso</a> y las <a href="" target="_blank" class="text-primary">políticas de
                        privacidad</a>.</label>
            </div>
            <div class="button-container">
                <button type="submit" class="button">Enviar mensaje</button>
            </div>
        </form>
    </div>
    <!-- WhatsApp (Div 2) -->
    <div class="contacto-info div2">
        <div class="whatsapp">
            <p><strong> O también envíanos un Whatsapp:</strong></p>
            <a href="https://wa.me/123456789" target="_blank" class="whatsapp-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-whatsapp">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                    <path
                        d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                </svg>
                <span>Iniciar chat</span>
            </a>
            <p><b>Email:</b> info@autech.es</p>
            <p><b>Tel:</b> 928 123 123</p>
            <img src="{{ 'assets/img/whatsapp.png' }}" alt="img1" id="w">
        </div>
    </div>
</div>
