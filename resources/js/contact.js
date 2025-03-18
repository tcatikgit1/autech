document.getElementById("contactForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Evita recargar la página

    let formData = new FormData(this);

    fetch(enviarCorreoUrl, {  // Usamos la variable definida en el Blade
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
});
