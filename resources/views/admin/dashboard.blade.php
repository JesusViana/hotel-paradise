<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administrador | Hotel Paradise</title>
    @vite('resources/css/admin.css')
</head>

<body>

    <header>
        <h1>HOTEL PARADISE</h1>
        <p>Panel de administración</p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
    </header>

    <main>

        <!-- GESTIÓN DE RESERVAS -->

        <section>
            <h2>Gestión de reservas</h2>

            <p>Consulta y administra las solicitudes de reserva.</p>

            <table border="1" cellpadding="10" cellspacing="0">

                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Categoría</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Huéspedes</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody id="lista-reservas">
                    <tr>
                        <td colspan="9">Cargando reservas...</td>
                    </tr>
                </tbody>

            </table>
        </section>


        <hr>


        <!-- GESTIÓN DE HABITACIONES -->

        <section>

            <h2>Gestión de habitaciones</h2>

            <p>Registra, consulta, edita y elimina habitaciones del hotel.</p>

            <h3 id="titulo-formulario">Registrar habitación</h3>

            <form id="formulario-habitacion">

                 <input type="hidden" id="id_habitacion">

                <div class="campo">
                    <label for="numero">Número de habitación:</label>
                    <input type="text" id="numero" required maxlength="10">
                </div>

                <div class="campo">
                    <label for="piso">Piso:</label>
                    <input type="number" id="piso" min="1" required>
                </div>

    <div class="campo">
        <label for="id_tipo_habitacion">Categoría:</label>
        <select id="id_tipo_habitacion" required>
            <option value="">Seleccione una categoría</option>
            <option value="1">Individual</option>
            <option value="2">Doble</option>
            <option value="3">Matrimonial</option>
            <option value="4">Familiar</option>
        </select>
    </div>

    <div class="campo">
        <label for="estado">Estado:</label>
        <select id="estado" required>
            <option value="Disponible">Disponible</option>
            <option value="Mantenimiento">Mantenimiento</option>
            <option value="Inactiva">Inactiva</option>
        </select>
    </div>

    <div class="campo campo-completo">
        <label for="observaciones">Observaciones:</label>
        <textarea id="observaciones"></textarea>
    </div>

    <div class="acciones-formulario">
        <button type="submit" id="btn-guardar">
            Registrar habitación
        </button>

        <button type="button" id="btn-cancelar" hidden>
            Cancelar edición
        </button>
    </div>

</form>


            <h3>Habitaciones registradas</h3>

            <table border="1" cellpadding="10" cellspacing="0">

                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Piso</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody id="lista-habitaciones">
                    <tr>
                        <td colspan="6">Cargando habitaciones...</td>
                    </tr>
                </tbody>

            </table>

        </section>

    </main>


    <script>

        // =====================================
        // GESTIÓN DE RESERVAS
        // =====================================

        async function cargarReservas() {

            const tabla = document.getElementById('lista-reservas');

            try {

                const respuesta = await fetch('/admin/api/reservas', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!respuesta.ok) {
                    throw new Error('No se pudieron consultar las reservas.');
                }

                const reservas = await respuesta.json();

                tabla.innerHTML = '';

                if (reservas.length === 0) {
                    tabla.innerHTML = `
                        <tr>
                            <td colspan="9">No existen reservas registradas.</td>
                        </tr>
                    `;
                    return;
                }

                reservas.forEach(reserva => {

                    const fila = document.createElement('tr');

                    const datos = [
                        reserva.codigo_reserva,
                        `${reserva.titular.nombres} ${reserva.titular.apellidos}`,
                        reserva.tipo_habitacion.nombre,
                        reserva.fecha_entrada.substring(0, 10),
                        reserva.fecha_salida.substring(0, 10),
                        reserva.cantidad_huespedes,
                        `Bs ${reserva.total}`,
                        reserva.estado
                    ];

                    datos.forEach(dato => {
                        const celda = document.createElement('td');
                        celda.textContent = dato;
                        fila.appendChild(celda);
                    });

                    const acciones = document.createElement('td');

                    if (reserva.estado === 'Pendiente') {

                        const btnConfirmar = document.createElement('button');
                        btnConfirmar.textContent = 'Confirmar';

                        btnConfirmar.addEventListener('click', () => {
                            actualizarEstado(reserva.id_reserva, 'Confirmada');
                        });

                        const btnCancelar = document.createElement('button');
                        btnCancelar.textContent = 'Cancelar';

                        btnCancelar.addEventListener('click', () => {
                            actualizarEstado(reserva.id_reserva, 'Cancelada');
                        });

                        acciones.appendChild(btnConfirmar);
                        acciones.appendChild(btnCancelar);

                    } else {
                        acciones.textContent = 'Sin acciones';
                    }

                    fila.appendChild(acciones);
                    tabla.appendChild(fila);

                });

            } catch (error) {

                console.error(error);

                tabla.innerHTML = `
                    <tr>
                        <td colspan="9">Error al cargar las reservas.</td>
                    </tr>
                `;
            }
        }


        async function actualizarEstado(id, estado) {

            if (estado === 'Cancelada') {
                if (!confirm('¿Estás seguro de cancelar esta reserva?')) {
                    return;
                }
            }

            try {

                const respuesta = await fetch(`/admin/api/reservas/${id}/estado`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        estado: estado
                    })
                });

                const resultado = await respuesta.json();

                if (!respuesta.ok) {
                    throw new Error(resultado.message || 'No se pudo actualizar la reserva.');
                }

                alert(resultado.message);

                cargarReservas();

            } catch (error) {

                alert(error.message);
                console.error(error);
            }
        }


        // =====================================
        // GESTIÓN DE HABITACIONES
        // =====================================

        const formulario = document.getElementById('formulario-habitacion');


        // Consultar habitaciones mediante GET

        async function cargarHabitaciones() {

            const tabla = document.getElementById('lista-habitaciones');

            try {

                const respuesta = await fetch('/admin/api/habitaciones', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!respuesta.ok) {
                    throw new Error('No se pudieron consultar las habitaciones.');
                }

                const habitaciones = await respuesta.json();

                tabla.innerHTML = '';

                if (habitaciones.length === 0) {
                    tabla.innerHTML = `
                        <tr>
                            <td colspan="6">No existen habitaciones registradas.</td>
                        </tr>
                    `;
                    return;
                }

                habitaciones.forEach(habitacion => {

                    const fila = document.createElement('tr');

                    const datos = [
                        habitacion.numero,
                        habitacion.piso,
                        habitacion.tipo_habitacion.nombre,
                        habitacion.estado,
                        habitacion.observaciones || 'Sin observaciones'
                    ];

                    datos.forEach(dato => {

                        const celda = document.createElement('td');
                        celda.textContent = dato;
                        fila.appendChild(celda);

                    });

                    const acciones = document.createElement('td');

                    // Botón editar

                    const btnEditar = document.createElement('button');
                    btnEditar.textContent = 'Editar';

                    btnEditar.addEventListener('click', () => {
                        prepararEdicion(habitacion);
                    });

                    // Botón eliminar

                    const btnEliminar = document.createElement('button');
                    btnEliminar.textContent = 'Eliminar';

                    btnEliminar.addEventListener('click', () => {
                        eliminarHabitacion(habitacion.id_habitacion);
                    });

                    acciones.appendChild(btnEditar);
                    acciones.appendChild(btnEliminar);

                    fila.appendChild(acciones);
                    tabla.appendChild(fila);

                });

            } catch (error) {

                console.error(error);

                tabla.innerHTML = `
                    <tr>
                        <td colspan="6">Error al cargar las habitaciones.</td>
                    </tr>
                `;
            }
        }


        // Registrar o editar habitación

        formulario.addEventListener('submit', async function(event) {

            event.preventDefault();

            const id = document.getElementById('id_habitacion').value;

            const datos = {
                numero: document.getElementById('numero').value,
                piso: document.getElementById('piso').value,
                id_tipo_habitacion: document.getElementById('id_tipo_habitacion').value,
                estado: document.getElementById('estado').value,
                observaciones: document.getElementById('observaciones').value
            };

            const metodo = id ? 'PUT' : 'POST';

            const url = id
                ? `/admin/api/habitaciones/${id}`
                : '/admin/api/habitaciones';

            try {

                const respuesta = await fetch(url, {
                    method: metodo,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(datos)
                });

                const resultado = await respuesta.json();

                if (!respuesta.ok) {

                    const errores = resultado.errors
                        ? Object.values(resultado.errors).flat().join('\n')
                        : resultado.message;

                    throw new Error(errores || 'No se pudo guardar la habitación.');
                }

                alert(resultado.message);

                formulario.reset();
                cancelarEdicion();

                cargarHabitaciones();

            } catch (error) {

                alert(error.message);
                console.error(error);
            }
        });


        // Preparar formulario para editar

        function prepararEdicion(habitacion) {

            document.getElementById('id_habitacion').value = habitacion.id_habitacion;
            document.getElementById('numero').value = habitacion.numero;
            document.getElementById('piso').value = habitacion.piso;
            document.getElementById('id_tipo_habitacion').value = habitacion.id_tipo_habitacion;
            document.getElementById('estado').value = habitacion.estado;
            document.getElementById('observaciones').value = habitacion.observaciones || '';

            document.getElementById('titulo-formulario').textContent = 'Editar habitación';
            document.getElementById('btn-guardar').textContent = 'Guardar cambios';
            document.getElementById('btn-cancelar').hidden = false;

            formulario.scrollIntoView({
                behavior: 'smooth'
            });
        }


        // Cancelar edición

        function cancelarEdicion() {

            document.getElementById('id_habitacion').value = '';

            formulario.reset();

            document.getElementById('titulo-formulario').textContent = 'Registrar habitación';
            document.getElementById('btn-guardar').textContent = 'Registrar habitación';
            document.getElementById('btn-cancelar').hidden = true;
        }

        document.getElementById('btn-cancelar')
            .addEventListener('click', cancelarEdicion);


        // Eliminar habitación mediante DELETE

        async function eliminarHabitacion(id) {

            if (!confirm('¿Estás seguro de eliminar esta habitación?')) {
                return;
            }

            try {

                const respuesta = await fetch(`/admin/api/habitaciones/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const resultado = await respuesta.json();

                if (!respuesta.ok) {
                    throw new Error(resultado.message || 'No se pudo eliminar la habitación.');
                }

                alert(resultado.message);

                cargarHabitaciones();

            } catch (error) {

                alert(error.message);
                console.error(error);
            }
        }


        // =====================================
        // INICIAR DASHBOARD
        // =====================================

        cargarReservas();
        cargarHabitaciones();

    </script>

</body>

</html>