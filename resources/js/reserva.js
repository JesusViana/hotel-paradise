// Seleccionar elementos del DOM
const formulario = document.getElementById('formulario-reserva');
const contenedor = document.querySelector('.formulario-reserva');

// Escuchar el evento submit
formulario.addEventListener('submit', async (evento) => {

    // Evitar el envío tradicional del formulario
    evento.preventDefault();

    // Capturar los datos del formulario
    const datosFormulario = new FormData(formulario);

    try {

        // Realizar petición HTTP POST
        const respuesta = await fetch(formulario.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json'
            },
            body: datosFormulario
        });

        // Convertir respuesta a JSON
        const resultado = await respuesta.json();

        // Comprobar si Laravel respondió correctamente
        if (!respuesta.ok) {

            if (resultado.errors) {
                const errores = Object.values(resultado.errors).flat();

                alert(errores.join('\n'));
                return;
            }

            throw new Error('No se pudo registrar la reserva.');
        }

        // Actualizar el DOM
        contenedor.innerHTML = `
            <div class="confirmacion-reserva">
                <h2>¡Solicitud registrada!</h2>

                <p>${resultado.message}</p>

                <h3>Código de reserva:</h3>

                <strong>${resultado.codigo_reserva}</strong>

                <p>Tu solicitud está pendiente de confirmación.</p>

                <a href="/" class="btn-principal">
                    Volver al inicio
                </a>
            </div>
        `;

    } catch (error) {

        console.error('Error:', error);

        alert('Ocurrió un error al enviar la solicitud.');
    }
});