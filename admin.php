<?php
// Proteger la página. El usuario debe haber iniciado sesión para poder verla.
session_start();
if (!isset($_SESSION['user_id'])) {
    // Si no ha iniciado sesión, redirigir a la página de login.
    header('Location: login.php');
    exit;
}

$page_title = 'Administrar Libros';
require_once 'php/header.php'; 
?>

<div class="row">
    <!-- Columna para el formulario -->
    <div class="col-lg-4 mb-4">
        <!-- Bootstrap: Tarjeta para enmarcar el formulario -->
        <div class="card shadow">
            <div class="card-header">
                <h2 class="h4 mb-0">Agregar / Editar Libro</h2>
            </div>
            <div class="card-body">
                <form id="add-book-form">
                    <!-- Campo oculto para el ID del libro durante la edición -->
                    <input type="hidden" id="book_id" name="book_id">

                    <!-- Bootstrap: Margen inferior para los campos del formulario -->
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" placeholder="Título del libro" required>
                    </div>
                    <div class="mb-3">
                        <label for="autor" class="form-label">Autor</label>
                        <input type="text" class="form-control" id="autor" placeholder="Autor del libro" required>
                    </div>
                    <div class="mb-3">
                        <label for="genero" class="form-label">Género</label>
                        <input type="text" class="form-control" id="genero" placeholder="Género literario" required>
                    </div>
                    <div class="mb-3">
                        <label for="imagen" class="form-label">Nombre de la Imagen</label>
                        <input type="text" class="form-control" id="imagen" placeholder="ej: hp1.jpg" required>
                    </div>
                    <div class="mb-3">
                        <label for="calificacion" class="form-label">Calificación (1-5)</label>
                        <input type="number" class="form-control" id="calificacion" placeholder="5" min="1" max="5" required>
                    </div>
                    
                    <!-- Bootstrap: Botones con ancho completo y colores distintos -->
                    <div class="d-grid gap-2">
                        <button type="submit" id="submit-btn" class="btn btn-primary">Agregar Libro</button>
                        <button type="button" id="save-btn" class="btn btn-success" style="display:none;">Guardar Cambios</button>
                        <button type="button" id="cancel-btn" class="btn btn-secondary" style="display:none;">Cancelar Edición</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Columna para la lista de libros -->
    <div class="col-lg-8">
        <h2 class="h4">Libros Existentes</h2>
        <!-- Bootstrap: Grupo de lista para mostrar los libros -->
        <ul id="book-list-admin" class="list-group">
            <!-- Los libros se cargarán aquí dinámicamente -->
        </ul>
    </div>
</div>

<script src="js/admin.js"></script>

<?php require_once 'php/footer.php'; ?>