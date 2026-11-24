<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión | Hotel Paradise</title>

    @vite(['resources/css/auth.css', 'resources/js/auth.js'])
</head>

<body>

    <main class="contenedor-login">

        <section class="login-card">

            <header class="login-header">
                <h1>HOTEL PARADISE</h1>
                <p>Bienvenido nuevamente</p>
                <h2>Iniciar sesión</h2>
            </header>

            <form id="form-login" action="{{ route('login.post') }}" method="POST">

                @csrf

                <div class="form-group">
                    <label for="usuario">Usuario o correo electrónico</label>

                    <input
                        type="text"
                        id="usuario"
                        name="usuario"
                        placeholder="Ingresa tu usuario o correo"
                        value="{{ old('usuario') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Ingresa tu contraseña"
                        required
                    >
                </div>

                @if ($errors->any())
                    <div class="mensaje-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <button type="submit" id="btn-login">
                    Iniciar sesión
                </button>

            </form>

            <footer class="login-footer">
                <a href="{{ route('inicio') }}">Volver al inicio</a>
            </footer>

        </section>

    </main>

</body>
</html>