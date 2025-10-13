<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Mi Diario de Lectura</title>
<link rel="stylesheet" href="css/common.css"> <!-- Hoja de estilos externa comun -->
<link rel="stylesheet" href="css/admin.css"> <!-- Hoja de estilos externa solo para admin html -->
</head>
<body>

<header>
  <h1>Administrar Libros</h1>
  <!-- Botón centrado debajo del header -->
  <nav>
    <ul class="menu">
      <li><a href="index.html">Volver a Biblioteca</a></li>
    </ul>
  </nav>
</header>

<main class="main-container">
  <!-- Sección para agregar o editar libros -->
  <section id="add-book-section">
    <h2>Agregar / Editar Libro</h2>
    <form id="add-book-form">
      <input type="text" id="titulo" placeholder="Título" required>
      <input type="text" id="autor" placeholder="Autor" required>
      <input type="text" id="genero" placeholder="Género" required>
      <input type="text" id="imagen" placeholder="Nombre de la imagen" required>
      <input type="number" id="calificacion" placeholder="Calificación 0-5" min="0" max="5" required>
      <button type="submit" id="submit-btn">Agregar Libro</button>
      <button type="button" id="save-btn" style="display:none;">Guardar Cambios</button>
    </form>
  </section>

  <!-- Sección para listar libros -->
  <section>
    <h2>Libros Existentes</h2>
    <ul id="book-list-admin"></ul>
  </section>
</main>

<script src="js/admin.js"></script>
</body>
</html>
