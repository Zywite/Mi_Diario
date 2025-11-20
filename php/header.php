<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Estilos comunes -->
    <link rel="stylesheet" href="css/common.css">
    <!-- jQuery Framework: Simplifica manipulación del DOM y eventos -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title><?php echo $page_title ?? 'Mi Diario de Lectura'; ?></title>
</head>
<body>

<!-- Bootstrap: Navbar responsiva que se colapsa en pantallas pequeñas -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Bootstrap: Marca de la barra de navegación -->
        <a class="navbar-brand" href="index.php">Mi Diario de Lectura</a>
        
        <!-- Bootstrap: Botón para el menú hamburguesa en móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Bootstrap: Contenedor del menú que se colapsa -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Bootstrap: Alineación de items a la izquierda (ms-auto los alinea a la derecha) -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Si el usuario ha iniciado sesión -->
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Administrar Libros</a>
                    </li>
                    <li class="nav-item dropdown">
                        <!-- Bootstrap: Dropdown para el menú de usuario -->
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- Bootstrap: Icono de persona y padding -->
                            <i class="bi bi-person-fill me-1"></i>
                            Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="php/logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Si el usuario no ha iniciado sesión -->
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Registro</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-4">
