# Hotel Paradise

Sistema web de gestión de reservas hoteleras desarrollado con Laravel. Permite a los visitantes consultar categorías de habitaciones y enviar solicitudes de reserva, mientras que el administrador puede gestionar las habitaciones y supervisar las solicitudes recibidas.

## Características principales

### Módulo público
- Página principal del hotel.
- Consulta de categorías de habitaciones.
- Formulario para solicitar reservas.
- Registro de datos personales, fechas y cantidad de huéspedes.
- Generación de un código de reserva.
- Registro de solicitudes con estado pendiente.

### Módulo administrativo
- Inicio de sesión para administradores.
- Panel principal de administración.
- Consulta y gestión de solicitudes de reserva.
- Actualización del estado de las reservas.
- Administración de habitaciones.
- Control de acceso mediante roles.

> **Importante:** enviar una solicitud desde el sitio público no significa que la reserva esté confirmada. La solicitud queda pendiente de revisión por parte del administrador. El sistema no realiza asignaciones automáticas de habitaciones.

## Tecnologías utilizadas

- **Backend:** PHP y Laravel 13.
- **Frontend:** Blade, HTML, CSS y JavaScript.
- **Base de datos:** MySQL 8.
- **Herramientas frontend:** Vite y npm.
- **Contenedores:** Docker y Laravel Sail.

## Requisitos

- Docker Desktop o Docker Engine con Docker Compose.
- Git.
- Node.js y npm.
- Conexión a Internet para descargar las dependencias.

No es necesario instalar PHP, Composer ni MySQL directamente en el sistema anfitrión si se utiliza el procedimiento de instalación con Docker indicado a continuación.

## Instalación

### 1. Clonar el repositorio

```bash
git clone URL_DEL_REPOSITORIO
cd mi-proyecto
```

Reemplaza `URL_DEL_REPOSITORIO` por la dirección del repositorio de GitHub.

### 2. Crear el archivo de configuración

```bash
cp .env.example .env
```

Edita el archivo `.env` y configura los datos de la aplicación y del administrador.

```bash
nano .env
```

Configura especialmente las siguientes variables:

- `APP_NAME`
- `APP_URL`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `ADMIN_NOMBRES`
- `ADMIN_APELLIDOS`
- `ADMIN_TIPO_DOCUMENTO`
- `ADMIN_DOCUMENTO`
- `ADMIN_TELEFONO`
- `ADMIN_USUARIO`
- `ADMIN_CORREO`
- `ADMIN_PASSWORD`

**Seguridad:** reemplaza todos los valores de ejemplo del administrador, especialmente `ADMIN_PASSWORD`, por datos propios y una contraseña segura. No publiques tu archivo `.env`.

### 3. Instalar dependencias de PHP

Como Composer se ejecutará mediante Docker, utiliza:

```bash
docker run --rm \
  -u "$(id -u):$(id -g)" \
  -v "$PWD":/app \
  -w /app \
  composer:2 install
```

### 4. Instalar dependencias frontend

```bash
npm install
npm run build
```

### 5. Iniciar los contenedores

```bash
./vendor/bin/sail up -d --build
```

### 6. Generar la clave de la aplicación

```bash
./vendor/bin/sail artisan key:generate
```

### 7. Crear las tablas y los datos iniciales

```bash
./vendor/bin/sail artisan migrate --seed
```

Este comando prepara la estructura de la base de datos y ejecuta los seeders. El administrador inicial se crea utilizando las variables `ADMIN_*` configuradas previamente en `.env`.

### 8. Acceder al sistema

Abre el navegador en:

```text
http://localhost
```

Para acceder al módulo administrativo:

```text
http://localhost/login
```

Utiliza el usuario y la contraseña definidos en las variables `ADMIN_USUARIO` y `ADMIN_PASSWORD`.

## Estructura general del proyecto

```text
mi-proyecto/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   └── Models/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── schema/
├── public/
├── resources/
│   └── views/
├── routes/
│   └── web.php
├── storage/
├── tests/
├── compose.yaml
├── composer.json
├── package.json
└── README.md
```

## Base de datos

El sistema utiliza MySQL para almacenar la información relacionada con:

- Personas.
- Roles y usuarios.
- Tipos de habitación.
- Habitaciones.
- Reservas.
- Huéspedes asociados a las reservas.
- Asignaciones de habitaciones.
- Pagos.

La existencia de tablas en la base de datos no implica que todos esos módulos estén implementados funcionalmente en la aplicación.

## Alcance del sistema

El proyecto contempla la consulta de habitaciones, el registro de solicitudes de reserva y su administración básica.

No incluye actualmente:
- Procesamiento funcional de pagos.
- Asignación automática de habitaciones.
- Confirmación automática de reservas.
- Automatización de notificaciones por WhatsApp.

## Autoría

Proyecto académico desarrollado como parte de la formación en Ingeniería de Sistemas.