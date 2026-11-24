<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Realizar reserva | Hotel Paradise</title>

    @vite([
    'resources/css/inicio.css',
    'resources/js/reserva.js'
    ])
</head>

<body>

    <header class="encabezado">
        <div class="contenedor navegacion">
            <a href="/" class="logo">
                HOTEL <span>PARADISE</span>
            </a>

            <a href="/" class="btn-login">Volver al inicio</a>
        </div>
    </header>

    <main class="seccion contenedor">

        <div class="titulo-seccion">
            <h2>Solicitar una reserva</h2>
            <p>Completa tus datos para solicitar tu habitación.</p>
        </div>

        <section class="formulario-reserva">

            <h3>Habitación seleccionada</h3>

            <p>
                Tipo: {{ $tipoHabitacion->nombre }}
            </p>

            <p>
                Capacidad: {{ $tipoHabitacion->capacidad_maxima }} personas
            </p>

            <p>
                Precio por noche: Bs. {{ $tipoHabitacion->precio_base }}
            </p>

            <hr>

            <h3>Datos del huésped</h3>

            <form id="formulario-reserva"
                  action="{{ route('reservas.guardar', $tipoHabitacion->id_tipo_habitacion) }}"
                  method="POST">
                    @csrf
                    @if ($errors->any())
                   <div class="errores">
                        <ul>
                           @foreach ($errors->all() as $error)
                           <li>{{ $error }}</li>
                           @endforeach
                        </ul>
                    </div>
                    @endif

                <label>Nombre:</label>
                <input type="text" name="nombres" required>

                <label>Apellido:</label>
                <input type="text" name="apellidos" required>

                <label>Documento de identidad:</label>
                <input type="text" name="numero_documento" required>

                <label>Tipo de documento:</label>
                <select name="tipo_documento" required>
                    <option value="">Seleccione</option>
                    <option value="CI">Cédula de identidad</option>
                    <option value="Pasaporte">Pasaporte</option>
                </select>

                <label>Teléfono:</label>
                <input type="tel" name="telefono" required>

                <label>Correo electrónico:</label>
                <input type="email" name="correo_contacto">

                <h3>Datos de estadía</h3>

                <label>Fecha de entrada:</label>
                <input type="date" name="fecha_entrada" required>

                <label>Fecha de salida:</label>
                <input type="date" name="fecha_salida" required>

                <label>Cantidad de huéspedes:</label>
                <input
                    type="number"
                    name="cantidad_huespedes"
                    min="1"
                    max="{{ $tipoHabitacion->capacidad_maxima }}"
                    required
                >

                <button type="submit" class="btn-principal">
                    Enviar solicitud
                </button>

            </form>

        </section>

    </main>

</body>
</html>