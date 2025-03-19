# SYSCOM-USUARIOS

Este es un proyecto desarrollado en **PHP** utilizando el framework **Laravel**. A continuación, se describen los requisitos, la configuración y los pasos para ejecutar la aplicación.

## 📌 Requisitos
- PHP 8.x
- Composer
- MySQL
- Laravel

## 🔧 Instalación y configuración
### 1️⃣ Clonar el repositorio
```bash
  git clone <URL_DEL_REPOSITORIO>
  cd syscom-usuarios
```

### 2️⃣ Instalar dependencias
```bash
  composer install
```

### 3️⃣ Configurar la base de datos
Modificar el archivo `.env` con los siguientes datos:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=syscom_usuarios
DB_USERNAME=root
DB_PASSWORD=Root
```

### 4️⃣ Ejecutar migraciones
```bash
  php artisan migrate
```

### 5️⃣ Iniciar el servidor
```bash
  php artisan serve
```
La aplicación estará disponible en `http://127.0.0.1:8000`

## 📦 Librerías utilizadas
Este proyecto usa las siguientes librerías principales:

- **barryvdh/laravel-dompdf** - Generación de PDFs
- **brick/math** - Cálculos de precisión arbitraria
- **doctrine/inflector** - Manipulación de cadenas de texto
- **fakerphp/faker** - Generación de datos falsos
- **guzzlehttp/guzzle** - Cliente HTTP
- **laravel/framework** - Laravel Framework
- **laravel/sanctum** - Autenticación para APIs
- **laravel/tinker** - Consola interactiva para Laravel
- **monolog/monolog** - Manejo de logs
- **nesbot/carbon** - Manipulación de fechas y tiempos
- **spatie/laravel-ignition** - Página de errores amigable en Laravel
- **symfony/console** - Herramientas CLI de Symfony
- **symfony/http-foundation** - Capa de abstracción HTTP
- **vlucas/phpdotenv** - Manejo de variables de entorno

Para ver la lista completa de librerías:
```bash
  composer show
```

## 📜 Licencia
Este proyecto está bajo la licencia [MIT](https://opensource.org/licenses/MIT).

