<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cliente | Hotel Paradise</title>
</head>

<body>

    <header>
        <h1>HOTEL PARADISE</h1>
        <p>Panel del cliente</p>
    </header>

    <main>
        <h2>¡Bienvenido, Cliente!</h2>

        <p>Has iniciado sesión correctamente.</p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
    </main>

</body>

</html>