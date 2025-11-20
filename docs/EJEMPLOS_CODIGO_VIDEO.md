# Ejemplos de Código para Mostrar en el Video

## PARTE 1: UPDATE Y DELETE

### Archivo: php/update_message.php

```php
<?php
/**
 * update_message.php
 * 
 * Actualiza un mensaje existente en la base de datos
 * 
 * Validaciones:
 * 1. Verifica que haya sesión activa
 * 2. Verifica que el usuario sea el autor del mensaje
 * 3. Encripta y actualiza los datos en la BD
 * 
 * @method POST (JSON)
 * @param {int} id - ID del mensaje a actualizar
 * @param {string} contenido - Nuevo contenido del mensaje
 * 
 * @returns {json} success: true/false
 */

session_start();
require_once 'conex.php';

header('Content-Type: application/json');

// 1. VALIDACIÓN: ¿Hay usuario en sesión?
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'No hay sesión activa']);
    exit;
}

// 2. RECIBIR DATOS (JSON)
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id']) || !isset($data['contenido'])) {
    echo json_encode(['success' => false, 'error' => 'Faltan datos']);
    exit;
}

try {
    // 3. VERIFICAR QUE EL USUARIO SEA EL AUTOR
    // Esto es importante para seguridad: solo el dueño puede editar
    $sql_check = "SELECT usuario_id FROM messages WHERE id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $data['id']);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    $message = $result->fetch_assoc();

    // Si no es el autor, rechazar
    if ($message['usuario_id'] !== $_SESSION['user_id']) {
        echo json_encode(['success' => false, 'error' => 'No autorizado']);
        exit;
    }

    // 4. ACTUALIZAR EL MENSAJE EN LA BD
    $sql = "UPDATE messages SET contenido = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $data['contenido'], $data['id']);

    if ($stmt->execute()) {
        // 5. RESPONDER CON JSON
        echo json_encode(['success' => true, 'message' => 'Mensaje actualizado']);
    } else {
        throw new Exception($conn->error);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    $conn->close();
}
?>
```

### Archivo: php/delete_message.php

```php
<?php
/**
 * delete_message.php
 * 
 * Elimina un mensaje de la base de datos
 * 
 * Validaciones:
 * 1. Verifica que haya sesión activa
 * 2. Verifica que el usuario sea el autor del mensaje
 * 3. Elimina el mensaje de la BD
 * 
 * @method POST (JSON)
 * @param {int} id - ID del mensaje a eliminar
 * 
 * @returns {json} success: true/false
 */

session_start();
require_once 'conex.php';

header('Content-Type: application/json');

// 1. VALIDACIÓN: ¿Hay usuario en sesión?
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'No hay sesión activa']);
    exit;
}

// 2. RECIBIR DATOS (JSON)
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'error' => 'Falta el ID del mensaje']);
    exit;
}

try {
    // 3. VERIFICAR QUE EL USUARIO SEA EL AUTOR
    $sql_check = "SELECT usuario_id FROM messages WHERE id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $data['id']);
    $stmt_check->execute();
    $result = $stmt_check->get_result();
    $message = $result->fetch_assoc();

    // Si no es el autor, rechazar
    if ($message['usuario_id'] !== $_SESSION['user_id']) {
        echo json_encode(['success' => false, 'error' => 'No autorizado']);
        exit;
    }

    // 4. ELIMINAR EL MENSAJE DE LA BD
    $sql = "DELETE FROM messages WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $data['id']);

    if ($stmt->execute()) {
        // 5. RESPONDER CON JSON
        echo json_encode(['success' => true, 'message' => 'Mensaje eliminado']);
    } else {
        throw new Exception($conn->error);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    $conn->close();
}
?>
```

### Archivo: js/messages.js (Fetch)

```javascript
/**
 * messages.js
 * 
 * Gestiona la funcionalidad de mensajes (crear, listar, editar, eliminar)
 * Usa FETCH para comunicarse con el servidor y JSON para intercambiar datos
 */

class MessageManager {
    constructor() {
        this.setupEventListeners();
        this.loadMessages();
        console.log('MessageManager: Inicializado');
    }

    /**
     * Configura los listeners de eventos del formulario
     */
    setupEventListeners() {
        console.log('MessageManager: Configurando listeners...');
        
        // Listener para editar mensaje
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-edit-message')) {
                console.log('MessageManager: Evento click en editar');
                const messageId = e.target.dataset.id;
                this.editMessage(messageId);
            }
        });

        // Listener para eliminar mensaje
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('btn-delete-message')) {
                console.log('MessageManager: Evento click en eliminar');
                const messageId = e.target.dataset.id;
                this.deleteMessage(messageId);
            }
        });
    }

    /**
     * Edita un mensaje existente
     * 
     * Pasos:
     * 1. Recibe el ID del mensaje
     * 2. Prepara los datos a enviar (JSON)
     * 3. Hace un FETCH POST al servidor
     * 4. Actualiza la lista de mensajes
     * 
     * @param {int} messageId - ID del mensaje a editar
     */
    editMessage(messageId) {
        console.log('MessageManager: Editando mensaje ID:', messageId);

        // Obtener nuevo contenido del usuario
        const newContent = prompt('¿Cuál es el nuevo contenido?');
        
        if (!newContent) {
            return;
        }

        // Preparar datos en formato JSON
        const data = {
            id: messageId,
            contenido: newContent
        };

        console.log('MessageManager: Enviando JSON:', data);

        // FETCH al servidor
        fetch('php/update_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'  // Indicar que es JSON
            },
            body: JSON.stringify(data)  // Convertir objeto a JSON
        })
        .then(res => res.json())  // Parsear respuesta JSON
        .then(response => {
            console.log('MessageManager: Respuesta del servidor:', response);
            
            if (response.success) {
                alert('¡Mensaje actualizado!');
                // Recargar la lista de mensajes
                this.loadMessages();
            } else {
                alert('Error: ' + response.error);
            }
        })
        .catch(err => {
            console.error('MessageManager: Error en FETCH:', err);
            alert('Error al actualizar el mensaje');
        });
    }

    /**
     * Elimina un mensaje
     * 
     * Pasos:
     * 1. Solicita confirmación al usuario
     * 2. Prepara JSON con el ID
     * 3. Hace FETCH DELETE al servidor
     * 4. Actualiza la lista
     * 
     * @param {int} messageId - ID del mensaje a eliminar
     */
    deleteMessage(messageId) {
        console.log('MessageManager: Eliminando mensaje ID:', messageId);

        // Pedir confirmación
        if (!confirm('¿Seguro que deseas eliminar este mensaje?')) {
            return;
        }

        // Preparar datos
        const data = {
            id: messageId
        };

        console.log('MessageManager: Enviando JSON para eliminar:', data);

        // FETCH al servidor
        fetch('php/delete_message.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(response => {
            console.log('MessageManager: Respuesta del servidor:', response);
            
            if (response.success) {
                alert('¡Mensaje eliminado!');
                // Recargar la lista de mensajes
                this.loadMessages();
            } else {
                alert('Error: ' + response.error);
            }
        })
        .catch(err => {
            console.error('MessageManager: Error en FETCH:', err);
            alert('Error al eliminar el mensaje');
        });
    }

    /**
     * Carga la lista de mensajes desde el servidor
     */
    loadMessages() {
        console.log('MessageManager: Cargando mensajes...');

        fetch('php/list_messages.php')
            .then(res => res.json())
            .then(messages => {
                console.log('MessageManager: Mensajes cargados:', messages);
                this.renderMessages(messages);
            })
            .catch(err => {
                console.error('MessageManager: Error al cargar:', err);
            });
    }

    /**
     * Renderiza los mensajes en la página
     * @param {array} messages - Array de mensajes
     */
    renderMessages(messages) {
        console.log('MessageManager: Renderizando', messages.length, 'mensajes');
        // ... código de renderizado
    }
}

// Inicializar cuando el documento esté listo
document.addEventListener('DOMContentLoaded', () => {
    new MessageManager();
});
```

---

## PARTE 2: BOOTSTRAP - CÓDIGO COMENTADO

### index.php - Bootstrap Grid

```html
<!-- 
    Bootstrap: PROPIEDAD 1 - GRID SYSTEM
    
    Estructura:
    - .container: Contiene el contenido con márgenes a los lados
    - .row: Crea una fila que contiene columnas (12 unidades)
    - .col-md-4: Columna que ocupa 4 unidades en pantallas medianas (50% ancho)
    - .g-4: Gap (separación) de 4 unidades entre columnas
    
    Responsividad:
    - Móvil: col (ocupa toda la fila, 1 libro por fila)
    - Tablet: col-md-6 (ocupa media fila, 2 libros por fila)
    - Desktop: col-lg-4 (ocupa 1/3, 3 libros por fila)
-->
<div class="container mt-5">
    <div class="row g-4">
        <div class="col-md-4">
            <!-- Tarjeta de libro 1 -->
        </div>
        <div class="col-md-4">
            <!-- Tarjeta de libro 2 -->
        </div>
        <div class="col-md-4">
            <!-- Tarjeta de libro 3 -->
        </div>
    </div>
</div>

<!-- 
    Bootstrap: PROPIEDAD 2 - FLEXBOX UTILITIES
    
    - d-flex: Display flex (habilita flexbox)
    - justify-content-between: Distribuye elementos a los extremos
    - align-items-center: Centra verticalmente
    - mb-4: Margin-bottom de 4 unidades
    
    En pantalla: el título a la izquierda, botón a la derecha, alineados verticamente
-->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Libros Disponibles</h2>
    <button class="btn btn-primary">+ Agregar Libro</button>
</div>

<!-- 
    Bootstrap: PROPIEDAD 3 - SPACING UTILITIES
    
    - m-* : margin (exterior)
    - p-* : padding (interior)
    - mb-* : margin-bottom (margen inferior)
    - mt-* : margin-top (margen superior)
    - g-* : gap (en grid/flex, separación entre items)
    
    Escalas: 0, 1, 2, 3, 4, 5
    - mb-4: margen inferior de 1.5rem (24px)
    - p-3: padding de 1rem (16px) en todos lados
-->
<div class="mb-4">
    <input type="text" class="form-control p-3" placeholder="Buscar...">
</div>

<!-- 
    Bootstrap: PROPIEDAD 4 - COMPONENTS
    
    Componentes reutilizables de Bootstrap que dan estilo profesional:
    
    a) CARD: Contenedor con header, body, footer
    b) TABLE: Tabla con bordes y hover
    c) BTN: Botones con clases predefinidas
    d) FORM-CONTROL: Campos de entrada de formulario
-->

<!-- Card Component -->
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5>Información del Libro</h5>
    </div>
    <div class="card-body">
        <p>Contenido del libro</p>
    </div>
    <div class="card-footer">
        <button class="btn btn-success">Guardar</button>
        <button class="btn btn-danger">Cancelar</button>
    </div>
</div>

<!-- Table Component -->
<div class="table-responsive mt-5">
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Género</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Harry Potter</td>
                <td>J.K. Rowling</td>
                <td>Ficción</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Form Component -->
<form class="mt-4">
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <!-- form-control: Estilo de input Bootstrap -->
        <input type="email" class="form-control" id="email" placeholder="Tu email">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="password" placeholder="Tu contraseña">
    </div>
    <!-- btn btn-primary: Botón con estilo Bootstrap -->
    <button type="submit" class="btn btn-primary w-100">Enviar</button>
</form>
```

---

## PARTE 3: VALIDACIÓN JAVASCRIPT (Framework)

### js/auth.js - Clase de Validación

```javascript
/**
 * auth.js
 * 
 * FRAMEWORK PERSONALIZADO: Sistema de Validación JavaScript
 * 
 * ¿Por qué lo usamos?
 * 1. Validación inmediata (sin esperar respuesta del servidor)
 * 2. Feedback visual al usuario
 * 3. Previene datos inválidos en la BD
 * 4. Mejora la experiencia del usuario
 * 
 * ¿Cómo funciona?
 * 1. Se configura con listeners en los campos
 * 2. Al escribir/perder foco, valida el campo
 * 3. Muestra errores en tiempo real
 * 4. Valida todo antes de enviar
 */

class AuthValidator {
    constructor() {
        console.log('AuthValidator: Inicializando...');
        this.registerForm = document.getElementById('register-form');
        this.loginForm = document.getElementById('login-form');
        this.setupValidation();
    }

    /**
     * Configura los listeners de validación
     * NOTA: Aquí usamos addEventListener para manejar eventos
     */
    setupValidation() {
        console.log('AuthValidator: Configurando listeners de eventos...');

        // Obtener campos del formulario de registro
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const usernameInput = document.getElementById('username');

        // LISTENER 1: Validar email al perder foco
        if (emailInput) {
            emailInput.addEventListener('blur', (e) => {
                console.log('AuthValidator: Evento blur en email');
                this.validateEmail(e);
            });
        }

        // LISTENER 2: Validar contraseña mientras se escribe
        if (passwordInput) {
            passwordInput.addEventListener('input', (e) => {
                console.log('AuthValidator: Evento input en password');
                this.validatePassword(e);
            });
        }

        // LISTENER 3: Validar nombre de usuario
        if (usernameInput) {
            usernameInput.addEventListener('input', (e) => {
                console.log('AuthValidator: Evento input en username');
                this.validateUsername(e);
            });
        }

        // LISTENER 4: Validar formulario al enviar
        if (this.registerForm) {
            this.registerForm.addEventListener('submit', (e) => {
                console.log('AuthValidator: Evento submit en formulario de registro');
                this.validateRegister(e);
            });
        }
    }

    /**
     * Valida el formato del email
     * 
     * Validación: debe tener formato xxx@xxx.xxx
     * 
     * @param {Event} e - Evento del campo
     */
    validateEmail(e) {
        console.log('AuthValidator: Validando email...');
        const email = e.target.value;
        
        // Expresión regular para validar email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        // Buscar elemento de error (si existe)
        let errorDiv = document.getElementById('email-error');

        // Si el email es inválido Y el campo no está vacío
        if (!emailRegex.test(email) && email !== '') {
            console.log('AuthValidator: Email inválido:', email);
            
            // Crear o actualizar mensaje de error
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.id = 'email-error';
                errorDiv.className = 'alert alert-danger mt-2';  // Bootstrap: clase de alerta roja
                errorDiv.textContent = '❌ Email inválido';
                e.target.parentElement.appendChild(errorDiv);
            }
            
            // Marcar campo como inválido
            e.target.classList.add('is-invalid');  // Bootstrap: borde rojo
        } else {
            // Email es válido
            console.log('AuthValidator: Email válido');
            
            // Eliminar mensaje de error si existe
            if (errorDiv) {
                errorDiv.remove();
            }
            
            // Remover clase de error
            e.target.classList.remove('is-invalid');
        }
    }

    /**
     * Valida que la contraseña tenga mínimo 6 caracteres
     * 
     * @param {Event} e - Evento del campo
     */
    validatePassword(e) {
        console.log('AuthValidator: Validando contraseña...');
        const password = e.target.value;

        // Si tiene menos de 6 caracteres y no está vacía, mostrar error
        if (password.length < 6 && password !== '') {
            console.log('AuthValidator: Contraseña muy corta');
            e.target.classList.add('is-invalid');  // Bootstrap: borde rojo
        } else if (password.length >= 6) {
            console.log('AuthValidator: Contraseña válida');
            e.target.classList.remove('is-invalid');
        }
    }

    /**
     * Valida que el nombre de usuario tenga al menos 3 caracteres
     * 
     * @param {Event} e - Evento del campo
     */
    validateUsername(e) {
        console.log('AuthValidator: Validando username...');
        const username = e.target.value;

        if (username.length < 3 && username !== '') {
            e.target.classList.add('is-invalid');
        } else if (username.length >= 3) {
            e.target.classList.remove('is-invalid');
        }
    }

    /**
     * Valida TODO el formulario de registro antes de enviar
     * 
     * Comprueba:
     * 1. Username: mínimo 3 caracteres
     * 2. Email: formato válido
     * 3. Password: mínimo 6 caracteres
     * 
     * @param {Event} e - Evento del formulario
     */
    validateRegister(e) {
        console.log('AuthValidator: Validando formulario completo...');
        
        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Validación 1: Username
        if (!username || username.length < 3) {
            console.log('AuthValidator: Username inválido');
            alert('❌ El nombre de usuario debe tener al menos 3 caracteres');
            e.preventDefault();
            return;
        }

        // Validación 2: Email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email || !emailRegex.test(email)) {
            console.log('AuthValidator: Email inválido');
            alert('❌ Ingresa un email válido (ej: user@example.com)');
            e.preventDefault();
            return;
        }

        // Validación 3: Password
        if (!password || password.length < 6) {
            console.log('AuthValidator: Password inválida');
            alert('❌ La contraseña debe tener al menos 6 caracteres');
            e.preventDefault();
            return;
        }

        console.log('AuthValidator: Todas las validaciones pasaron');
        // Si llegamos aquí, todas las validaciones pasaron
        // El formulario se puede enviar
    }
}

// Inicializar cuando el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOMContentLoaded: Iniciando AuthValidator');
    new AuthValidator();
});
```

---

## DATOS IMPORTANTES A RECORDAR PARA EL VIDEO

### Para la Parte 1 (Update/Delete)
- Mostrar que `$_SESSION['user_id']` valida al usuario
- Explicar que solo el autor puede editar/eliminar
- Mostrar el JSON que se envía y recibe
- Mostrar cómo se actualiza en la BD

### Para la Parte 2 (Bootstrap)
- **Grid**: 12 columnas, responsive
- **Flexbox**: Distribución flexible de elementos
- **Spacing**: Márgenes y padding consistentes
- **Components**: Tarjetas, tablas, botones, formularios

### Para la Parte 3 (Validación)
- **Listeners**: addEventListener en cada campo
- **Validación real-time**: Al escribir/perder foco
- **Feedback visual**: Mensajes de error en Bootstrap
- **Prevención**: No permite enviar datos inválidos
