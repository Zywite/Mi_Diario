# Ejemplos de Código para Video - Con jQuery (Entrega 3)

## SECCIÓN 1: CRUD - UPDATE Y DELETE

### Código Backend (PHP)

#### php/update_message.php
```php
<?php
session_start();
header('Content-Type: application/json');

// Verificar autenticación
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'No autenticado']);
    exit;
}

require_once 'conex.php';

$data = json_decode(file_get_contents('php://input'), true);

// Obtener el mensaje original para verificar propiedad
$sql = "SELECT usuario_id FROM messages WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $data['id']);
$stmt->execute();
$result = $stmt->get_result();
$message = $result->fetch_assoc();

// Validar que sea el autor
if ($message['usuario_id'] !== $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
}

// Actualizar el mensaje
$sql = "UPDATE messages SET contenido = ?, fecha_update = NOW() WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $data['contenido'], $data['id']);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'mensaje' => 'Actualizado correctamente']);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
?>
```

#### php/delete_message.php
```php
<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'No autenticado']);
    exit;
}

require_once 'conex.php';

$data = json_decode(file_get_contents('php://input'), true);

// Verificar propiedad del mensaje
$sql = "SELECT usuario_id FROM messages WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $data['id']);
$stmt->execute();
$result = $stmt->get_result();
$message = $result->fetch_assoc();

if ($message['usuario_id'] !== $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
}

// Eliminar el mensaje
$sql = "DELETE FROM messages WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $data['id']);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'mensaje' => 'Eliminado correctamente']);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
?>
```

### Código Frontend - COMPARATIVA (Vanilla JS vs jQuery)

#### SIN jQuery (Vanilla JavaScript)
```javascript
// Obtener formulario de edición
const editForm = document.getElementById('edit-message-form');

// Evento de envío
editForm.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Obtener valores
    const messageId = document.getElementById('message-id').value;
    const messageContent = document.getElementById('message-content').value;
    
    // Validación simple
    if (!messageContent.trim()) {
        document.getElementById('error-msg').textContent = 'El contenido es requerido';
        return;
    }
    
    // AJAX con fetch
    fetch('php/update_message.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: messageId,
            contenido: messageContent
        })
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            // Mostrar éxito
            const successMsg = document.getElementById('success-msg');
            successMsg.style.display = 'block';
            successMsg.textContent = response.mensaje;
            
            // Limpiar después de 3 segundos
            setTimeout(() => {
                successMsg.style.display = 'none';
                document.location.reload();
            }, 3000);
        } else {
            document.getElementById('error-msg').textContent = response.error;
        }
    })
    .catch(error => console.error('Error:', error));
});

// Eliminar mensaje
const deleteButtons = document.querySelectorAll('.delete-btn');
deleteButtons.forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        
        if (!confirm('¿Seguro que deseas eliminar este mensaje?')) {
            return;
        }
        
        const messageId = this.dataset.id;
        
        fetch('php/delete_message.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: messageId })
        })
        .then(response => response.json())
        .then(response => {
            if (response.success) {
                // Remover elemento del DOM
                const messageElement = document.getElementById('message-' + messageId);
                messageElement.remove();
            }
        });
    });
});
```

#### CON jQuery (Código mejorado)
```javascript
// Con jQuery - Mucho más limpio

$('#edit-message-form').on('submit', function(e) {
    e.preventDefault();
    
    const messageId = $('#message-id').val();
    const messageContent = $('#message-content').val().trim();
    
    // Validación
    if (!messageContent) {
        $('#error-msg').text('El contenido es requerido').fadeIn();
        return;
    }
    
    // AJAX con jQuery
    $.ajax({
        url: 'php/update_message.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            id: messageId,
            contenido: messageContent
        }),
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#success-msg').text(response.mensaje).fadeIn().delay(3000).fadeOut(function() {
                    location.reload();
                });
            } else {
                $('#error-msg').text(response.error).fadeIn();
            }
        },
        error: function() {
            $('#error-msg').text('Error en la solicitud').fadeIn();
        }
    });
});

// Eliminar mensaje con jQuery
$(document).on('click', '.delete-btn', function(e) {
    e.preventDefault();
    
    if (!confirm('¿Seguro que deseas eliminar este mensaje?')) {
        return;
    }
    
    const messageId = $(this).data('id');
    
    $.ajax({
        url: 'php/delete_message.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ id: messageId }),
        success: function(response) {
            if (response.success) {
                $('#message-' + messageId).fadeOut('slow', function() {
                    $(this).remove();
                });
            }
        }
    });
});
```

**Diferencias principales**:
- jQuery: `-40% líneas de código`
- jQuery: Menos sintaxis compleja
- jQuery: Animaciones integradas (`.fadeIn()`, `.fadeOut()`)
- jQuery: Encadenamiento de métodos (chainable)

---

## SECCIÓN 2: BOOTSTRAP COMPONENTS

### 1. Grid System (Responsive)

```html
<!-- header.php: Navbar responsiva -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            📚 Mi Diario de Lectura
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin.php">Admin</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- index.php: Grid de libros -->
<div class="container mt-5">
    <div class="row g-4">
        <!-- En desktop: 3 columnas, tablet: 2, móvil: 1 -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
                <img src="imagenes/1984.jpg" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">1984</h5>
                    <p class="card-text">George Orwell</p>
                </div>
            </div>
        </div>
        <!-- ... más columnas ... -->
    </div>
</div>
```

**Propiedades demostradas**:
- `container`: Ancho máximo responsivo
- `row g-4`: Gap de 1.5rem entre items
- `col-lg-4 col-md-6 col-sm-12`: Responsive en 3 breakpoints

---

### 2. Flexbox Utilities

```html
<!-- admin.php: Encabezado con flexbox -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0">Panel de Administración</h1>
    <button class="btn btn-success" onclick="location.href='admin.php?action=new'">
        + Nuevo Libro
    </button>
</div>

<!-- Propiedades demostradas -->
<div class="d-flex">              <!-- Display: flex -->
    justify-content-between      <!-- Distribuir a extremos -->
    align-items-center           <!-- Centrar verticalmente -->
    mb-4                         <!-- Margen inferior -->
</div>
```

**Resultado visual**:
```
|  Panel de Administración  [+ Nuevo Libro]  |
← Izquierda               Derecha →
```

---

### 3. Spacing Utilities

```html
<!-- index.php: Espaciado consistente -->
<section class="py-5">  <!-- Padding vertical: 3rem -->
    <div class="container">
        <h2 class="mb-4">Últimos Mensajes</h2>  <!-- Margen inferior: 1.5rem -->
        
        <div class="row g-3">  <!-- Gap entre items: 1rem -->
            <div class="col-md-6">
                <div class="card p-3">  <!-- Padding interno: 1rem -->
                    <h5 class="card-title mb-2">Título</h5>  <!-- mb: margen inferior -->
                    <p class="card-text mb-0">Contenido</p>   <!-- mb-0: sin margen -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Escala de Bootstrap (1 = 0.25rem):
    m/p-0  = 0
    m/p-1  = 0.25rem
    m/p-2  = 0.5rem
    m/p-3  = 1rem
    m/p-4  = 1.5rem
    m/p-5  = 3rem
-->
```

---

### 4. Components (Card, Table, Form, Button)

```html
<!-- Tarjeta de libro (Card) -->
<div class="card shadow-sm">
    <img src="imagenes/hp1.jpg" class="card-img-top" alt="Harry Potter">
    <div class="card-body">
        <h5 class="card-title">Harry Potter y la Piedra Filosofal</h5>
        <p class="card-text">J.K. Rowling</p>
        <a href="#" class="btn btn-primary">Ver detalles</a>
    </div>
    <div class="card-footer bg-light">
        <small class="text-muted">Agregado: 2024-01-15</small>
    </div>
</div>

<!-- Tabla de libros -->
<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>1984</td>
            <td>George Orwell</td>
            <td>
                <button class="btn btn-sm btn-warning">Editar</button>
                <button class="btn btn-sm btn-danger">Eliminar</button>
            </td>
        </tr>
    </tbody>
</table>

<!-- Formulario Bootstrap -->
<form class="needs-validation">
    <div class="mb-3">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="email" required>
        <div class="invalid-feedback">
            Por favor ingresa un email válido
        </div>
    </div>
    
    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" required>
    </div>
    
    <button type="submit" class="btn btn-primary">Enviar</button>
</form>

<!-- Botones Bootstrap -->
<button class="btn btn-primary">Primary</button>
<button class="btn btn-success">Success</button>
<button class="btn btn-danger">Danger</button>
<button class="btn btn-warning">Warning</button>
<button class="btn btn-secondary">Secondary</button>
```

---

## SECCIÓN 3: JQUERY IMPLEMENTATION

### jQuery en header.php

```html
<!-- php/header.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Diario de Lectura</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- jQuery - Disponible en TODAS las páginas -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Navbar aquí -->
</body>
</html>
```

### Verificación de jQuery en Browser Console

```javascript
// En la consola del navegador (F12):
$.fn.jquery
// Respuesta: "3.6.0"  ✅ jQuery está cargado

// Probar un selector jQuery
$('h1').length
// Respuesta: 1  ✅ Encontró el elemento

// Probar cambio de contenido
$('h1').text('Nuevo Título')
// ✅ El título cambió en la pantalla
```

---

### jQuery en login.php

```javascript
// js/login.js (Incluido en login.php)

$(document).ready(function() {
    
    // Manejar envío del formulario
    $('#login-form').on('submit', function(e) {
        e.preventDefault();
        
        // Obtener valores con jQuery
        const email = $('#email').val().trim();
        const password = $('#password').val();
        
        // Validación básica
        if (!email || !password) {
            showNotification('Por favor completa todos los campos', 'warning');
            return;
        }
        
        // AJAX con jQuery (más limpio que fetch)
        $.ajax({
            url: 'php/handle_login.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                email: email,
                password: password
            }),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Animación de éxito
                    $('#success-msg').text('¡Ingreso exitoso!').fadeIn().delay(1500).fadeOut(function() {
                        window.location.href = 'index.php';
                    });
                } else {
                    // Mostrar error con animación
                    $('#error-msg').text(response.error).fadeIn();
                    $('#password').addClass('is-invalid');
                }
            },
            error: function() {
                showNotification('Error de conexión', 'danger');
            }
        });
    });
    
    // Limpiar error al escribir
    $('#email, #password').on('input', function() {
        $('#error-msg').fadeOut();
        $(this).removeClass('is-invalid');
    });
});
```

---

### jQuery en register.php

```javascript
// js/register.js (Incluido en register.php)

$(document).ready(function() {
    
    // Validación en tiempo real
    $('#email').on('input', function() {
        validateField($(this), 'email');
    });
    
    $('#password').on('input', function() {
        validateField($(this), 'password');
    });
    
    $('#confirm-password').on('input', function() {
        if ($(this).val() !== $('#password').val()) {
            $(this).addClass('is-invalid').removeClass('is-valid');
        } else {
            $(this).removeClass('is-invalid').addClass('is-valid');
        }
    });
    
    // Enviar formulario
    $('#register-form').on('submit', function(e) {
        e.preventDefault();
        
        // Revalidar todos los campos
        let isValid = true;
        
        if (!validateField($('#email'), 'email')) isValid = false;
        if (!validateField($('#password'), 'password')) isValid = false;
        
        if (!isValid) {
            showNotification('Por favor corrige los errores', 'danger');
            return;
        }
        
        // AJAX para registrar
        $.ajax({
            url: 'php/handle_register.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                email: $('#email').val(),
                password: $('#password').val(),
                name: $('#name').val()
            }),
            success: function(response) {
                if (response.success) {
                    $('#success-msg')
                        .text('¡Registro exitoso! Redirigiendo...')
                        .slideDown()
                        .delay(2000)
                        .fadeOut(function() {
                            window.location.href = 'login.php';
                        });
                } else {
                    showNotification(response.error, 'danger');
                }
            }
        });
    });
    
    // Función helper
    function validateField(field, type) {
        const value = field.val().trim();
        let regex;
        
        if (type === 'email') {
            regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        } else if (type === 'password') {
            regex = /.{8,}/; // Mínimo 8 caracteres
        }
        
        const isValid = regex.test(value);
        
        if (isValid) {
            field.removeClass('is-invalid').addClass('is-valid');
        } else {
            field.removeClass('is-valid').addClass('is-invalid');
        }
        
        return isValid;
    }
});
```

---

### Funciones Globales en js/main.js

```javascript
// js/main.js - Funciones jQuery disponibles globalmente

// 1. Notificaciones con animación
function showNotification(message, type = 'info') {
    const alertHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 1050; min-width: 300px;">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $(alertHTML)
        .appendTo('body')
        .fadeIn()
        .delay(5000)
        .fadeOut(function() {
            $(this).remove();
        });
}

// 2. Wrapper para AJAX
function makeAjaxRequest(url, data, callback) {
    $.ajax({
        url: url,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: 'json',
        success: callback,
        error: function(error) {
            console.error('AJAX Error:', error);
            showNotification('Error en la solicitud', 'danger');
        }
    });
}

// 3. Inicializar tooltips Bootstrap
function initTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// Ejecutar al cargar la página
$(document).ready(function() {
    console.log('jQuery versión: ' + $.fn.jquery);
    
    // Inicializar tooltips
    initTooltips();
    
    // Cerrar alertas con animación
    $('.alert').on('close.bs.alert', function() {
        $(this).slideUp('slow');
    });
});
```

---

## COMPARATIVA FINAL: jQuery vs Vanilla JS

| Feature | Vanilla JS | jQuery | Ganador |
|---------|-----------|--------|--------|
| Selección DOM | `document.getElementById()` | `$('#id')` | jQuery |
| Event Listeners | `.addEventListener()` | `.on()` | jQuery |
| AJAX | `fetch()` (verbose) | `$.ajax()` | jQuery |
| Animaciones | `CSS + requestAnimationFrame` | `.fadeIn()`, `.slideDown()` | jQuery |
| Encadenamiento | No | Sí | jQuery |
| Líneas de código | ~200 líneas | ~120 líneas | jQuery (-40%) |
| Legibilidad | Compleja | Simple | jQuery |
| Experiencia usuario | Animaciones básicas | Animaciones suaves | jQuery |

---

## Conclusión para el Video

"jQuery proporciona una capa de abstracción sobre JavaScript que:
1. **Reduce código** en un 40%
2. **Mejora legibilidad** con sintaxis más clara
3. **Añade animaciones** sin complejidad
4. **Simplifica AJAX** con $.ajax()
5. **Es ampliamente usado** en la industria web"
