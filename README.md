# Mi Diario de Lectura - Instrucciones de Instalación

## Requisitos Previos
- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)

## Pasos de Instalación Local (XAMPP)

1. **Instalar XAMPP**
   - Descarga XAMPP desde: https://www.apachefriends.org/
   - Instala con las opciones Apache y MySQL

2. **Configurar el Proyecto**
   - Coloca la carpeta del proyecto en: `C:\xampp\htdocs\Mi_Diario_Lectura`
   - Asegúrate de que la estructura de carpetas sea:
     ```
     Mi_Diario_Lectura/
     ├── php/
     │   ├── conex.php
     │   ├── save_book.php
     │   └── ...
     ├── js/
     ├── css/
     ├── imagenes/
     ├── database.sql
     ├── index.php
     └── admin.php
     ```

3. **Configurar la Base de Datos**
   - Inicia XAMPP Control Panel
   - Inicia Apache y MySQL
   - Abre http://localhost/phpmyadmin
   - Crea una nueva base de datos llamada `mi_diario_lectura`
   - Importa el archivo `database.sql`

4. **Configurar la Conexión**
   - Edita el archivo `php/conex.php`
   - Usa estas credenciales para desarrollo local:
     ```php
     $servername = "localhost";
     $username = "root";
     $password = "";
     $dbname = "mi_diario_lectura";
     ```

5. **Probar el Proyecto**
   - Abre http://localhost/Mi_Diario_Lectura
   - Verifica que puedas:
     - Ver la lista de libros
     - Agregar nuevos libros
     - Editar libros existentes
     - Eliminar libros
     - Enviar mensajes de contacto

## Preparación para Entrega

1. **Respaldo de Base de Datos**
   - Exporta la base de datos desde phpMyAdmin
   - Incluye el archivo SQL con la estructura y datos

2. **Documentación**
   - Incluye este README
   - Documenta cualquier configuración específica
   - Lista de funcionalidades implementadas

3. **Credenciales para Producción**
   - Crea un archivo `conex.prod.php` con la configuración del servidor final
   - Documenta los cambios necesarios

## Funcionalidades Implementadas

- [x] Visualización de libros en tarjetas
- [x] Tabla comparativa de libros
- [x] Panel de administración (CRUD)
- [x] Formulario de contacto
- [x] Manejo de imágenes
- [x] Validación de datos
- [x] Notificaciones al usuario

## Especificaciones Técnicas Cumplidas

1. **JavaScript**
   - 3+ funciones implementadas
   - 2+ parámetros en funciones
   - Uso de `this` como parámetro
   - 3+ eventos con addEventListener
   - console.log en cada función
   - Código en archivos externos

2. **FETCH**
   - Implementado para cargar datos
   - Manejo de respuestas JSON
   - Actualización dinámica de contenido

3. **PHP y Base de Datos**
   - Procesamiento de formularios
   - Almacenamiento en MySQL
   - Notificaciones de éxito/error
   - Listado dinámico de datos

## Solución de Problemas

Si encuentras algún problema:

1. **Error de conexión a la base de datos**
   - Verifica que MySQL esté corriendo
   - Confirma las credenciales en conex.php
   - Asegúrate de que la base de datos existe

2. **Problemas con las imágenes**
   - Verifica que la carpeta `imagenes/` tenga permisos correctos
   - Confirma que las rutas sean correctas

3. **Errores de PHP**
   - Revisa los logs de Apache
   - Habilita la visualización de errores en desarrollo