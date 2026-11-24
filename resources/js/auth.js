// Esperar a que el documento HTML esté completamente cargado
document.addEventListener("DOMContentLoaded", function () {

    // Obtener elementos del formulario
    const formulario = document.getElementById("form-login");
    const usuario = document.getElementById("usuario");
    const password = document.getElementById("password");
    const botonLogin = document.getElementById("btn-login");

    // Escuchar el evento de envío del formulario
    formulario.addEventListener("submit", function (event) {

        // Obtener los valores ingresados
        const nombreUsuario = usuario.value.trim();
        const clave = password.value.trim();

        // Validar que los campos no estén vacíos
        if (nombreUsuario === "" || clave === "") {

            event.preventDefault();

            alert("Por favor, completa todos los campos.");

            return;
        }

        // Cambiar el texto del botón mientras se envía
        botonLogin.textContent = "Ingresando...";
        botonLogin.disabled = true;

    });

});