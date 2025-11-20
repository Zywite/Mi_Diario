# Guía para Video de Entrega - Entrega 3

## Estructura General del Video
- **Duración Total**: ~8 minutos máximo
- **Parte 1**: Eliminar y actualizar registros (2 min)
- **Parte 2**: 4 propiedades de Bootstrap (2 min)
- **Parte 3**: Framework seleccionado (4 min)
- **Ambos integrantes** deben hablar en cada punto

---

## PARTE 1: ELIMINAR Y ACTUALIZAR REGISTROS (2 minutos)

### Guión - Persona 1
"Hola, voy a mostrar cómo funciona la actualización y eliminación de mensajes en nuestra aplicación.

Como pueden ver, en la página principal hay un muro de mensajes donde los usuarios pueden interactuar. Veamos cómo editar y eliminar un mensaje."

### Demostración en Sitio Web
1. Mostrar un mensaje en el muro
2. Hacer clic en el botón "Editar"
3. Cambiar el contenido del mensaje
4. Guardar los cambios
5. Volver atrás y mostrar el mensaje actualizado

### Guión - Persona 2
"Ahora voy a mostrar el código que hace posible esto. Abrimos el archivo update_message.php que es donde se procesa la actualización:

```php
// php/update_message.php
// 1. Validar que el usuario sea el autor del mensaje
if ($message['usuario_id'] !== $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
}

// 2. Actualizar el mensaje en la base de datos
$sql = "UPDATE messages SET contenido = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $data['contenido'], $data['id']);

// 3. Retornar respuesta JSON
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
}
```

Después mostrar el JavaScript que realiza el fetch:

```javascript
// js/messages.js
fetch('php/update_message.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify({
        id: messageId,
        contenido: newContent
    })
})
.then(res => res.json())
.then(data => {
    if (data.success) {
        // Actualizar el mensaje en la interfaz
        loadMessages();
    }
});
```

Para eliminar, el proceso es similar:

```php
// php/delete_message.php
// 1. Verificar que es el autor
if ($message['usuario_id'] !== $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
}

// 2. Eliminar de la BD
$sql = "DELETE FROM messages WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $data['id']);

// 3. Retornar confirmación
echo json_encode(['success' => true]);
```

Mostrar en el sitio cómo se elimina el mensaje al hacer clic en el botón "Eliminar"."

---

## PARTE 2: 4 PROPIEDADES DE BOOTSTRAP (2 minutos)

### Guión - Persona 1
"Nuestro proyecto utiliza Bootstrap como framework principal. Les voy a mostrar las 4 propiedades principales que hemos implementado:

Primera propiedad: **Sistema de Grid (Container, Row, Col)**

```html
<div class="container">
    <div class="row g-4">
        <div class="col-md-4">
            <!-- Tarjeta de libro -->
        </div>
        <div class="col-md-4">
            <!-- Tarjeta de libro -->
        </div>
        <div class="col-md-4">
            <!-- Tarjeta de libro -->
        </div>
    </div>
</div>
```

Este grid permite que el sitio sea responsivo. En pantallas grandes muestra 3 columnas, en medianas 2, y en móviles 1. Veamos cómo se ve en diferentes tamaños."

*[Redimensionar navegador para mostrar responsividad]*

### Guión - Persona 2
"Segunda propiedad: **Flexbox Utilities (d-flex, justify-content, align-items)**

```html
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Libros Disponibles</h2>
    <button class="btn btn-primary">+ Agregar</button>
</div>
```

Estos utilidades de Flexbox nos permiten distribuir los elementos de forma flexible. En este caso, el título y el botón están alineados a los extremos (justify-content-between) y centrados verticalmente (align-items-center).

Veamos en el navegador cómo se adapta."

*[Mostrar en el sitio cómo los elementos están bien alineados]*

### Guión - Persona 1
"Tercera propiedad: **Spacing Utilities (m-*, p-*, mb-*, g-*)**

```html
<div class="mb-4">
    <!-- Margen inferior de 4 unidades -->
</div>

<div class="p-3">
    <!-- Padding de 3 unidades en todos lados -->
</div>

<div class="row g-4">
    <!-- Gap (separación) de 4 unidades entre columnas -->
</div>
```

Esto proporciona consistencia en el espaciado del sitio. Todos los márgenes y paddings siguen una escala estándar de Bootstrap."

*[Mostrar cómo los elementos están bien espaciados en el sitio]*

### Guión - Persona 2
"Cuarta propiedad: **Components (Card, Table, Button, Form)**

```html
<!-- Card Component -->
<div class="card">
    <div class="card-header">...</div>
    <div class="card-body">...</div>
</div>

<!-- Table Component -->
<table class="table table-bordered table-hover">
    <!-- Tabla con bordes y hover -->
</table>

<!-- Button Component -->
<button class="btn btn-primary">Enviar</button>

<!-- Form Component -->
<input type="email" class="form-control">
```

Estos componentes Bootstrap nos permiten tener un diseño profesional y consistente sin escribir CSS personalizado. Veamos cómo se ven en el sitio."

*[Mostrar tarjetas de libros, tabla comparativa, botones y formularios]*

---

## PARTE 3: FRAMEWORK SELECCIONADO - VALIDACIÓN JAVASCRIPT (4 minutos)

### Guión - Persona 1
"Como framework adicional, implementamos un sistema de **Validación JavaScript avanzada**. 

¿Por qué elegimos esto? Porque:
1. Mejora la experiencia del usuario con validación inmediata
2. Reduce el tráfico innecesario a la BD
3. Proporciona feedback instantáneo

Veamos cómo funciona. En el formulario de registro:"

*[Mostrar el formulario de registro en el sitio]*

"Cuando ingreso un email inválido como 'test', inmediatamente recibo un mensaje de error:"

*[Escribir en el campo de email un valor inválido y mostrar el error]*

"Cuando escribo un email válido, el error desaparece."

*[Escribir un email válido y mostrar que el error se oculta]*

### Guión - Persona 2
"Ahora les muestro el código que hace esto posible. Abrimos el archivo js/auth.js:

```javascript
/**
 * Clase para validar formularios de autenticación
 */
class AuthValidator {
    constructor() {
        this.registerForm = document.getElementById('register-form');
        this.loginForm = document.getElementById('login-form');
        this.setupValidation();
    }

    /**
     * Configura los eventos de validación
     */
    setupValidation() {
        // Validación en tiempo real del registro
        const emailInput = document.getElementById('email');
        if (emailInput) {
            emailInput.addEventListener('blur', (e) => this.validateEmail(e));
        }

        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.addEventListener('input', (e) => this.validatePassword(e));
        }

        // Validación al enviar formulario
        if (this.registerForm) {
            this.registerForm.addEventListener('submit', (e) => this.validateRegister(e));
        }
        if (this.loginForm) {
            this.loginForm.addEventListener('submit', (e) => this.validateLogin(e));
        }
    }

    /**
     * Valida el formato del email
     * @param {Event} e - Evento del campo
     */
    validateEmail(e) {
        const email = e.target.value;
        const emailRegex = /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/;
        const errorDiv = document.getElementById('email-error');

        if (!emailRegex.test(email) && email !== '') {
            if (!errorDiv) {
                const div = document.createElement('div');
                div.id = 'email-error';
                div.className = 'alert alert-danger mt-2';
                div.textContent = 'Email inválido';
                e.target.parentElement.appendChild(div);
            }
        } else if (errorDiv) {
            errorDiv.remove();
        }
    }

    /**
     * Valida que la contraseña tenga mínimo 6 caracteres
     * @param {Event} e - Evento del campo
     */
    validatePassword(e) {
        const password = e.target.value;
        if (password.length < 6 && password !== '') {
            e.target.classList.add('is-invalid');
        } else {
            e.target.classList.remove('is-invalid');
        }
    }

    /**
     * Valida todo el formulario de registro
     * @param {Event} e - Evento del formulario
     */
    validateRegister(e) {
        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        if (!username || username.length < 3) {
            alert('El nombre de usuario debe tener al menos 3 caracteres');
            e.preventDefault();
            return;
        }

        if (!email || !/^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/.test(email)) {
            alert('Ingresa un email válido');
            e.preventDefault();
            return;
        }

        if (!password || password.length < 6) {
            alert('La contraseña debe tener al menos 6 caracteres');
            e.preventDefault();
            return;
        }

        console.log('Validación completada, enviando registro...');
    }

    /**
     * Valida el formulario de login
     * @param {Event} e - Evento del formulario
     */
    validateLogin(e) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        if (!email || !password) {
            alert('Por favor, completa todos los campos');
            e.preventDefault();
        }
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    new AuthValidator();
});
```

Como ven, el framework de validación funciona de varias maneras:

1. **Validación en tiempo real (blur)**: Cuando el usuario sale del campo de email, se valida
2. **Validación visual (input)**: Al escribir la contraseña, se muestra si es válida o no
3. **Validación al enviar**: Antes de enviar el formulario, se validan todos los datos
4. **Feedback al usuario**: Se muestran alertas claras indicando qué está mal"

### Guión - Persona 1
"¿Por qué es útil este framework?

1. **Experiencia mejorada**: El usuario sabe inmediatamente si algo está mal
2. **Evita solicitudes inválidas**: No enviamos datos incorrectos al servidor
3. **Reduce carga del servidor**: El servidor solo procesa datos válidos
4. **Interfaz amigable**: Los mensajes de error son claros y contextuales

Veamos cómo se integra con Bootstrap. Cuando el email es inválido, mostramos un mensaje de error con la clase 'alert alert-danger' de Bootstrap, lo que le da un aspecto profesional y consistente."

*[Mostrar el sitio con un error de validación y resaltar cómo se ve con Bootstrap]*

"Además, usamos la clase 'is-invalid' de Bootstrap para resaltar campos problemáticos en rojo."

### Guión - Persona 2
"En resumen, este framework de validación proporciona:

- **Reactividad**: Los cambios se reflejan inmediatamente
- **Prevención de errores**: Evita que datos inválidos lleguen al servidor
- **Consistencia**: Usa Bootstrap para mantener un aspecto profesional
- **Escalabilidad**: Se puede aplicar a cualquier formulario en el sitio

El código está bien documentado, cada función tiene comentarios explicando qué hace, y usa console.log() para debugging."

---

## CONSEJOS PARA LA GRABACIÓN

### Aspectos Técnicos
1. **Calidad de video**: Mínimo 1080p
2. **Audio claro**: Usa micrófono de buena calidad
3. **Pantalla visible**: Zoom lo suficiente para que se vea el código
4. **Ritmo**: No muy rápido, da tiempo para que entienda

### Estructura Visual
1. **Mostrar código**: Abre los archivos en el editor
2. **Mostrar sitio**: Muestra cómo funciona en el navegador
3. **Contrastar**: Alterna entre código y demostración

### Recomendaciones de Herramientas
- **OBS Studio**: Grabación de pantalla gratis
- **Camtasia**: Más profesional (de pago)
- **ScreenFlow** (Mac): Simple y efectivo
- **Kdenlive**: Edición de video gratis

### Estructura Sugerida del Video
```
0:00-0:30   - Intro: "Hola, somos [Nombre 1] y [Nombre 2]..."
0:30-2:30   - Parte 1: Actualizar/Eliminar (Persona 1 y 2)
2:30-4:30   - Parte 2: Bootstrap (Persona 1 y 2)
4:30-8:30   - Parte 3: Framework (Persona 1 y 2)
8:30-9:00   - Conclusión: "Gracias por ver nuestro proyecto"
```

---

## PUNTOS CLAVE A ENFATIZAR

### Para la Rúbrica HTML, JS y CSS (15%)
- Mostrar las 4 propiedades de Bootstrap claramente
- Demostrar responsividad redimensionando la ventana
- Mostrar código JavaScript en archivo externo
- Comentarios en el código indicando Bootstrap

### Para la Rúbrica Otros Frameworks (15%)
- Explicar POR QUÉ elegimos validación JavaScript
- Mostrar cómo mejora el sistema
- Demostrar ejemplos claros en el sitio
- Mostrar el código fuente

### Para la Rúbrica Fetch y JSON (20%)
- Al explicar Update/Delete, mostrar que usa FETCH
- Mostrar en la consola el JSON que se envía
- Explicar que la respuesta es JSON

### Para la Rúbrica Sesiones (15%)
- Si es relevante, mencionar que solo el autor puede editar/eliminar
- Esto se controla con `$_SESSION['user_id']`

### Para la Rúbrica CRUD (25%)
- Mostrar claramente los 4 operaciones
- Aclarar restricción de permisos

### Para la Rúbrica Documentación (10%)
- Mostrar comentarios en el código
- Explicar cada sección

---

## SCRIPT DE INTRODUCCIÓN

**Persona 1**: "Hola a todos, somos [Nombre 1] y [Nombre 2]. Hoy presentamos la **Entrega 3** de nuestro proyecto **Mi Diario de Lectura**. Un sitio web para gestionar libros personales con funcionalidades avanzadas."

**Persona 2**: "En este video explicaremos:"
1. "Cómo actualizar y eliminar mensajes de la base de datos"
2. "Las principales propiedades de Bootstrap que usamos"
3. "El framework de validación que implementamos"

**Ambos**: "¡Comencemos!"

---

## SCRIPT DE CONCLUSIÓN

**Persona 1**: "Como han visto, implementamos todas las funcionalidades requeridas..."

**Persona 2**: "Utilizamos Bootstrap para un diseño profesional y responsivo..."

**Ambos**: "¡Gracias por ver nuestro proyecto!"
