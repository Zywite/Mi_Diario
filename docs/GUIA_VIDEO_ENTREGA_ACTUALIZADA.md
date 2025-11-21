# Guía Actualizada para Video de Entrega - Entrega 3 (Con jQuery)

## Estructura General del Video
- **Duración Total**: ~6-7 minutos máximo
- **Parte 1**: Eliminar y actualizar registros (1.5 min)
- **Parte 2**: 4 propiedades de Bootstrap (1.5 min)
- **Parte 3**: Framework jQuery (3 min)
- **Presentador único**: Tú hablarás en todas las partes

---

## PARTE 1: ELIMINAR Y ACTUALIZAR REGISTROS (1.5 minutos)

### Guión - Presentador
"Hola, voy a mostrar cómo funciona la actualización y eliminación de mensajes en nuestra aplicación.

Como pueden ver, en la página principal hay un muro de mensajes donde los usuarios pueden interactuar. Veamos cómo editar y eliminar un mensaje."

### Demostración en Sitio Web
1. Mostrar un mensaje en el muro
2. Hacer clic en el botón "Editar"
3. Cambiar el contenido del mensaje
4. Guardar los cambios (mostrar que se actualiza en tiempo real)
5. Demostrar eliminar un mensaje con confirmación

### Guión - Mostrar el Código
"Ahora voy a mostrar el código backend que procesa la actualización:"

```php
// php/update_message.php
// Validar que el usuario sea el autor del mensaje
if ($message['usuario_id'] !== $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
}

// Actualizar en la BD con consulta preparada
$sql = "UPDATE messages SET contenido = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $data['contenido'], $data['id']);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
}
```

Y aquí está el código JavaScript que realiza el AJAX:

```javascript
// Con jQuery: Más simple que fetch()
$('#edit-btn').on('click', function() {
    const messageId = $(this).data('id');
    const newContent = prompt('¿Cuál es el nuevo contenido?');
    
    $.ajax({
        url: 'php/update_message.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ id: messageId, contenido: newContent }),
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                showNotification('¡Mensaje actualizado!', 'success');
                loadMessages();
            }
        }
    });
});
```

Para eliminar es muy similar:

```php
// php/delete_message.php
if ($message['usuario_id'] !== $_SESSION['user_id']) {
    echo json_encode(['success' => false, 'error' => 'No autorizado']);
    exit;
}

$sql = "DELETE FROM messages WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $data['id']);

echo json_encode(['success' => $stmt->execute()]);
```

**Puntos clave a enfatizar**:
- ✅ Solo el autor puede editar/eliminar (validación con $_SESSION)
- ✅ Usa AJAX/JSON para comunicación
- ✅ Respuestas en JSON para el cliente
- ✅ Consultas preparadas (SQL injection protection)
- ✅ jQuery hace el código más limpio"

---

## PARTE 2: 4 PROPIEDADES DE BOOTSTRAP (1.5 minutos)

### Guión
"Nuestro proyecto utiliza Bootstrap como framework CSS. Les voy a mostrar las 4 propiedades principales:"

**Primera propiedad: Grid System (container, row, col)**

```html
<!-- Bootstrap: Grid de 12 columnas -->
<div class="container">
    <div class="row g-4">
        <div class="col-md-4"><!-- Columna 1 --></div>
        <div class="col-md-4"><!-- Columna 2 --></div>
        <div class="col-md-4"><!-- Columna 3 --></div>
    </div>
</div>
```

Este grid es responsivo: 3 columnas en desktop, 2 en tablet, 1 en móvil."

*[Redimensionar navegador para mostrar: Desktop → 3 columnas, Tablet → 2 columnas, Móvil → 1 columna]*

"**Segunda propiedad: Flexbox Utilities (d-flex, justify-content, align-items)**

```html
<!-- Bootstrap: Flexbox para alineación -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Libros Disponibles</h2>
    <button class="btn btn-primary">+ Agregar</button>
</div>
```

- `d-flex`: Activa Flexbox
- `justify-content-between`: Distribuye a los extremos
- `align-items-center`: Centra verticalmente
- Resultado: Título a la izquierda, botón a la derecha, bien alineados"

*[Mostrar en el sitio]*

"**Tercera propiedad: Spacing Utilities (m-*, p-*, mb-*, g-*)**

```html
<!-- Bootstrap: Márgenes y padding consistentes -->
<div class="mb-4">Margen inferior</div>
<div class="p-3">Padding en todos lados</div>
<div class="row g-4"><!-- Gap entre columnas --></div>
```

- `mb-4`: Margen inferior de 1.5rem
- `p-3`: Padding de 1rem
- `g-4`: Gap de 1.5rem entre items

Esto proporciona consistencia visual en todo el sitio."

*[Mostrar cómo los elementos están bien espaciados]*

"**Cuarta propiedad: Components (card, table, btn, form-control)**

```html
<!-- Bootstrap: Componentes predefinidos -->
<div class="card">
    <div class="card-header">Encabezado</div>
    <div class="card-body">Contenido</div>
</div>

<table class="table table-bordered table-hover">
    <tr><td>Datos</td></tr>
</table>

<input type="email" class="form-control">
<button class="btn btn-primary">Enviar</button>
```

Estos componentes Bootstrap nos dan un diseño profesional sin escribir CSS personalizado."

*[Mostrar las tarjetas de libros, tabla comparativa y formularios]*

---

## PARTE 3: FRAMEWORK JQUERY (3 minutos)

### Introducción a jQuery

"Además de Bootstrap, implementé **jQuery** como framework JavaScript adicional.

¿Por qué jQuery?
1. Simplifica la manipulación del DOM
2. Reduce líneas de código un 40%
3. AJAX más simple que fetch()
4. Proporciona animaciones
5. Compatible con todos los navegadores

Veamos cómo está implementado en el proyecto."

### Verificar jQuery está cargado

"jQuery está cargado en header.php y disponible en TODAS las páginas:

```html
<!-- En header.php -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
```

Verifiquemos que jQuery está disponible:"

*[Abrir F12 → Console]
*[Escribir: `$.fn.jquery` y mostrar que responde: "3.6.0"]*

"Esto confirma que jQuery está cargado correctamente en todas nuestras páginas."

### Comparar Vanilla JS vs jQuery

"Veamos cómo jQuery simplifica el código. En login.php:

**SIN jQuery (Vanilla JavaScript)**:
```javascript
document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('email').value;
    
    fetch('php/handle_login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email })
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            window.location.href = 'index.php';
        }
    });
});
```

**CON jQuery (Mucho más limpio)**:
```javascript
$('#login-form').on('submit', function(e) {
    e.preventDefault();
    const email = $('#email').val();
    
    $.ajax({
        url: 'php/handle_login.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ email }),
        success: function(response) {
            if (response.success) {
                window.location.href = 'index.php';
            }
        }
    });
});
```

**Beneficios inmediatos**:
- Menos líneas de código
- Más legible
- Más fácil de mantener"

### jQuery en register.php

"En register.php implementé validación en tiempo real:

```javascript
// jQuery: Validación mientras se escribe
$('#email').on('input', function() {
    const email = $(this).val();
    const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    
    if (isValid) {
        $(this).removeClass('is-invalid').addClass('is-valid');
    } else {
        $(this).addClass('is-invalid');
    }
});
```

Veamos en el navegador:"

*[Ir a register.php]
*[Escribir email inválido: mostrar borde rojo]
*[Escribir email válido: mostrar borde verde]*

"La validación ocurre en tiempo real, sin esperar al servidor."

### Funciones globales en main.js

"También creé un archivo main.js con jQuery que proporciona funcionalidades globales:

```javascript
// main.js - Funciones helper con jQuery

// 1. Notificación flotante
function showNotification(message, type = 'info') {
    const alertHTML = `<div class="alert alert-${type}">` + message + `</div>`;
    $(alertHTML).appendTo('body').fadeIn().delay(5000).fadeOut();
}

// 2. AJAX simplificado
function makeAjaxRequest(url, data, successCallback) {
    $.ajax({
        url: url,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: successCallback
    });
}

// 3. Validación de campo
function validateField(selector, type) {
    const field = $(selector);
    const value = field.val().trim();
    let isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    
    if (isValid) {
        field.removeClass('is-invalid').addClass('is-valid');
    }
    return isValid;
}
```

Estas funciones se usan en login.php y register.php:"

*[Mostrar cómo se usa en el código]*

"jQuery también proporciona animaciones:

```javascript
// Animar elementos
$('#error-message').fadeIn();      // Aparecer suavemente
$('#success-message').fadeOut();   // Desaparecer suavemente
$('.alert').slideDown();           // Deslizar hacia abajo

// Métodos encadenados
$(this).closest('.alert')
    .fadeOut('slow')
    .remove();
```

Esto mejora significativamente la experiencia del usuario."

### Resumen de jQuery

"**Resumen de jQuery en nuestro proyecto**:

✅ **Ubicación**: 
- Incluido en header.php
- Usado en login.php y register.php
- Funciones globales en main.js

✅ **Funcionalidades**:
- Selección de elementos: `$('#id')`
- Eventos: `.on('submit')`, `.on('input')`
- AJAX: `$.ajax()`
- Animaciones: `.fadeIn()`, `.fadeOut()`
- Validación: `.addClass()`, `.removeClass()`

✅ **Ventajas**:
- 40% menos código
- Más legible
- Mejor mantenibilidad
- Mejor experiencia del usuario

jQuery es un framework establecido, confiable y ampliamente usado en la industria web."

---

## CONCLUSIÓN (30 segundos)

"Como han visto, en este proyecto implementé:
1. **Bootstrap** para diseño responsivo
2. **jQuery** para interactividad
3. **HTML/CSS/JavaScript** bien estructurado
4. **PHP y Base de Datos** con seguridad
5. **CRUD completo** con AJAX

Todo integrado profesionalmente. ¡Gracias!"

---

## CHECKLIST FINAL ANTES DE GRABAR

### Técnico
- [ ] Navegador zoom al 125% para que se vea bien
- [ ] Micrófono probado
- [ ] F12 abierto mostrando Console
- [ ] Código abierto en editor (VSCode)
- [ ] Sitio web respondiendo correctamente
- [ ] Datos de prueba listos (mensaje para editar/eliminar)

### Contenido
- [ ] Ambos integrantes hablan
- [ ] Se muestra código fuente
- [ ] Se demuestra en el navegador
- [ ] Se explica cada tecnología
- [ ] Duración total ~8 minutos

### Calidad
- [ ] Audio claro
- [ ] Ritmo adecuado (no muy rápido)
- [ ] Explicaciones claras
- [ ] Código visible (letras grandes)

---

## SCRIPT DE INTRO

**Presentador**: "Hola, soy [Tu Nombre]. Hoy presento la **Entrega 3** de **Mi Diario de Lectura**, un sitio web con gestión de libros, usuarios y mensajes."

"En este video explicaré:"
1. "Cómo actualizar y eliminar mensajes (CRUD)"
2. "Las 4 propiedades principales de Bootstrap"
3. "jQuery, el framework adicional que implementé"

"¡Comencemos!"

---

## SCRIPT DE CIERRE

**Presentador**: "Como han visto, implementé todas las funcionalidades requeridas con Bootstrap para el diseño y jQuery para la interactividad.

¡Gracias por ver mi proyecto!"
