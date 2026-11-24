const contenedor = document.getElementById('lista-habitaciones');

async function cargarHabitaciones() {
    try {
        const respuesta = await fetch('/api/habitaciones');

        if (!respuesta.ok) {
            throw new Error('Error al obtener las habitaciones');
        }

        const habitaciones = await respuesta.json();

        contenedor.innerHTML = '';

        habitaciones.forEach(habitacion => {
            const tarjeta = document.createElement('article');

            tarjeta.classList.add('tarjeta-habitacion');

            tarjeta.innerHTML = `
                <h3>${habitacion.nombre}</h3>
                <p>${habitacion.descripcion}</p>
                <p>Capacidad: ${habitacion.capacidad_maxima} personas</p>
                <p>Desde Bs. ${habitacion.precio_base} por noche</p>

                <a href="/reservas/crear/${habitacion.id_tipo_habitacion}"
                    class="btn-reservar">
                    Reservar
                </a> 
            `;

            contenedor.appendChild(tarjeta);
        });

    } catch (error) {
        contenedor.innerHTML = '<p>No se pudieron cargar las habitaciones.</p>';
        console.error(error);
    }
}

cargarHabitaciones();