<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hotel Paradise | Tu lugar de descanso</title>

    @vite([
        'resources/css/inicio.css',
        'resources/js/inicio.js'
    ])
</head>

<body>

    <!-- ENCABEZADO -->
    <header class="encabezado">
        <div class="contenedor navegacion">

            <a href="/" class="logo">
                HOTEL <span>PARADISE</span>
            </a>

            <nav>
                <ul class="menu">
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#habitaciones">Habitaciones</a></li>
                    <li><a href="#servicios">Servicios</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                </ul>
            </nav>

            <a href="{{ route('login') }}" class="btn-login">
                Iniciar sesión
            </a>

        </div>
    </header>


    <!-- PRESENTACIÓN PRINCIPAL -->
    <main>

        <section class="hero" id="inicio">

            <div class="hero-contenido">

                <h1>Bienvenido a Hotel Paradise</h1>

                <p>
                    Disfruta de una experiencia única de descanso,
                    comodidad y tranquilidad.
                </p>

                <a href="#habitaciones" class="btn-principal">
                    Conocer habitaciones
                </a>

            </div>

        </section>


        <!-- HABITACIONES -->
        <section class="seccion contenedor" id="habitaciones">

            <div class="titulo-seccion">
                <h2>Nuestras habitaciones</h2>

                <p>
                    Encuentra el espacio ideal para tu estadía.
                </p>
            </div>

            <div class="habitaciones-grid" id="lista-habitaciones">

                    <p id="mensaje-habitaciones">cargando habitaciones.....</p>

            </div>

        </section>


        <!-- SERVICIOS -->
        <section class="seccion servicios" id="servicios">

            <div class="contenedor">

                <div class="titulo-seccion">
                    <h2>Nuestros servicios</h2>
                    <p>Todo lo que necesitas para una estadía agradable.</p>
                </div>

                <div class="servicios-grid">

                    <article>
                        <h3>Atención personalizada</h3>
                        <p>Atención durante tu estadía.</p>
                    </article>

                    <article>
                        <h3>Reservas en línea</h3>
                        <p>Solicita tu habitación desde nuestra página web.</p>
                    </article>

                    <article>
                        <h3>Comodidad</h3>
                        <p>Habitaciones adaptadas a tus necesidades.</p>
                    </article>

                </div>

            </div>

        </section>


        <!-- CONTACTO -->
        <section class="seccion contenedor" id="contacto">

            <div class="titulo-seccion">
                <h2>Contáctanos</h2>

                <p>
                    Estamos disponibles para ayudarte a planificar tu estadía.
                </p>
            </div>

            <a href="{{ route('login') }}" class="btn-principal">
                Acceder al sistema
            </a>

        </section>

    </main>


    <!-- PIE DE PÁGINA -->
    <footer class="pie-pagina">

        <p>
            © {{ date('Y') }} Hotel Paradise.
            Todos los derechos reservados.
        </p>

    </footer>

</body>

</html>