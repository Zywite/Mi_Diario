<?php 
$page_title = 'Inicio - Mi Diario de Lectura';
require_once 'php/header.php'; 
?>

<!-- Bootstrap: Título de la sección con margen inferior -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Libros Disponibles</h2>
</div>

<!-- Bootstrap: Campo de búsqueda con grupo de input para estilo -->
<div class="input-group mb-4">
    <span class="input-group-text"><i class="bi bi-search"></i></span>
    <input type="text" id="search-input" class="form-control" placeholder="Buscar por título o autor...">
</div>

<!-- Bootstrap: Contenedor de fila para las tarjetas de libros, con espaciado entre columnas (g-4) -->
<div class="row g-4" id="book-list">
    <!-- Las tarjetas de libros se insertarán aquí dinámicamente -->
</div>

<hr class="my-5">

<h2 class="mb-4">Comparativa de Libros</h2>
<!-- Bootstrap: Tabla con estilo de bordes y hover -->
<div class="table-responsive">
    <table id="compare-table" class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Género</th>
                <th>Calificación</th>
            </tr>
        </thead>
        <tbody>
            <!-- Las filas de la tabla se insertarán aquí dinámicamente -->
        </tbody>
    </table>
</div>

<hr class="my-5">

<div class="row">
    <div class="col-md-8">
        <h2 class="mb-4">Muro de Mensajes</h2>
        <!-- Bootstrap: Alerta para cuando no hay mensajes -->
        <div id="message-wall" class="d-flex flex-column gap-3">
            <!-- Los mensajes se cargarán aquí -->
        </div>
    </div>
    <div class="col-md-4">
        <h2 class="mb-4">Dejar un Mensaje</h2>
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Bootstrap: Formulario con estilo -->
            <form id="contact-form">
                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea id="mensaje" name="mensaje" class="form-control" rows="4" required></textarea>
                </div>
                <!-- Bootstrap: Botón de ancho completo -->
                <button type="submit" class="btn btn-primary w-100">Enviar Mensaje</button>
            </form>
        <?php else: ?>
            <!-- Bootstrap: Alerta para animar al usuario a iniciar sesión -->
            <div class="alert alert-info">
                <a href="login.php">Inicia sesión</a> para dejar un mensaje.
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="js/index.js"></script>

<?php require_once 'php/footer.php'; ?>
