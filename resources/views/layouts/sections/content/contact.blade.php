<div class="contacto">
    <!-- Formulario (Div 1) -->
    <div class="formulario div1">
        <h2><i class="fa-regular fa-address-book"></i>      Contacta con nosotros</h2>
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
                <label for="terminos">He leído y acepto las <a href="" target="_blank" class="text-primary">condiciones
                        de uso</a> y las <a href="" target="_blank" class="text-primary">políticas de
                        privacidad</a>.</label>
            </div>

            <button type="submit">Enviar mensaje</button>
        </form>
    </div>

    <!-- WhatsApp (Div 2) -->
    <div class="contacto-info div2">
        <div class="whatsapp">
            <p>O también envíanos un Whatsapp:</p>
            <a href="https://wa.me/123456789" target="_blank">
                <i class="fab fa-whatsapp"></i> Iniciar chat
            </a>
            <p><b>Email:</b> info@autech.es</p>
            <p><b>Tel:</b> 928 123 123</p>

        </div>

    </div>
    <img src="{{'assets/img/whatsapp.png'}}" alt="img1" id="w">
</div>
