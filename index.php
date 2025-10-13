<?php
// Verificar conexión a la base de datos
require_once 'php/conex.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mi Diario de Lectura - Consulta libros disponibles y envía mensajes de contacto.">
    <title>Mi Diario de Lectura</title>
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <header>
        <h1>Mi Diario de Lectura</h1>
        <nav>
            <ul class="menu">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="index.php#contacto">Contacto</a></li>
                <li><a href="admin.php">Administrar Libros</a></li>
            </ul>
        </nav>
    </header>

    <main class="main-container">
        <section>
            <h2>Libros Disponibles</h2>
            <div class="search-container">
                <input type="text" id="search-input" placeholder="Buscar por título o autor...">
            </div>
            <div class="book-container" id="book-list"></div>
        </section>

        <section>
            <h2>Comparativa de Libros</h2>
            <table id="compare-table">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Género</th>
                        <th>Calificación</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </section>

        <section id="contacto">
            <h2>Contacto</h2>
            <form id="contact-form" action="php/save_contact.php" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" required></textarea>
                </div>
                <button type="submit">Enviar Mensaje</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Mi Diario de Lectura. Todos los derechos reservados.</p>
    </footer>

    <script src="js/index.js"></script>
</body>
</html>