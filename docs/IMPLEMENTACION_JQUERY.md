# Implementación de jQuery - Framework Frontend

## ¿Qué es jQuery?

jQuery es un framework JavaScript que simplifica la manipulación del DOM, manejo de eventos y AJAX.

**Sitio oficial**: https://jquery.com/

**Versión utilizada**: 3.6.0

---

## Por qué elegimos jQuery

1. ✅ **Simplifica el código**: Menos líneas, más legibilidad
2. ✅ **Compatible**: Funciona en todos los navegadores
3. ✅ **Comunidad activa**: Mucha documentación disponible
4. ✅ **Funcionalidades potentes**: AJAX, animaciones, selectores CSS
5. ✅ **Mejora la experiencia del usuario**: Animaciones y feedback visual

---

## Dónde se implementó jQuery

### 1. **header.php** - Inclusión global
```html
<!-- jQuery Framework: Simplifica manipulación del DOM y eventos -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
```

**Efecto**: jQuery está disponible en TODAS las páginas que usan header.php

---

### 2. **login.php** - Autenticación con jQuery

#### Comparación: Vanilla JS vs jQuery

**ANTES (Vanilla JavaScript)**:
```javascript
document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    
    fetch('php/handle_login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(response => {
        if (response.success) {
            window.location.href = 'index.php';
        } else {
            document.getElementById('error-message').textContent = response.error;
            document.getElementById('error-message').classList.remove('d-none');
        }
    });
});
```

**DESPUÉS (Con jQuery)**:
```javascript
// jQuery: Más limpio y legible
$('#login-form').on('submit', function(e) {
    e.preventDefault();
    
    const email = $('#email').val();
    const password = $('#password').val();
    
    $.ajax({
        url: 'php/handle_login.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ email, password }),
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#error-message').fadeOut();
                window.location.href = 'index.php';
            } else {
                $('#error-message').text(response.error).fadeIn();
            }
        }
    });
});
```

**Ventajas de jQuery aquí**:
- Selectores simplificados: `$('#id')` en lugar de `document.getElementById()`
- Métodos encadenados: `.val()`, `.fadeOut()`, `.text()`
- AJAX más simple: `$.ajax()` en lugar de `fetch()`

---

### 3. **register.php** - Registro de usuario

**Características jQuery implementadas**:

#### 1. Selección de elementos
```javascript
// jQuery
const username = $('#username').val();

// Vanilla
const username = document.getElementById('username').value;
```

#### 2. Manipulación del DOM
```javascript
// jQuery: Agregar/remover clases
$('#password').addClass('is-invalid');
$('#password').removeClass('is-invalid');

// jQuery: Animar
$('#error-message').fadeIn();
$('#success-message').fadeOut();

// Vanilla
element.classList.add('is-invalid');
element.classList.remove('is-invalid');
```

#### 3. Manejo de eventos
```javascript
// jQuery
$('#username').on('input', function() {
    console.log('Usuario escribiendo');
});

// Vanilla
document.getElementById('username').addEventListener('input', function() {
    console.log('Usuario escribiendo');
});
```

#### 4. AJAX
```javascript
// jQuery
$.ajax({
    url: 'php/handle_register.php',
    type: 'POST',
    data: JSON.stringify(data),
    success: function(response) {
        // ...
    }
});

// Vanilla
fetch('php/handle_register.php', {
    method: 'POST',
    body: JSON.stringify(data)
}).then(res => res.json()).then(response => {
    // ...
});
```

---

### 4. **main.js** - Funcionalidades globales

Archivo principal con jQuery que proporciona funcionalidades a TODAS las páginas:

#### Funcionalidad 1: Scroll suave
```javascript
$('a[href^="#"]').on('click', function(e) {
    e.preventDefault();
    const target = $(this).attr('href');
    $('html, body').animate({
        scrollTop: $(target).offset().top
    }, 800);
});
```

#### Funcionalidad 2: Cerrar alertas
```javascript
$('.alert .close').on('click', function() {
    $(this).closest('.alert').fadeOut();
});
```

#### Funcionalidad 3: Efectos en botones
```javascript
$('button').on('click', function() {
    $(this).css('opacity', '0.7');
    setTimeout(() => $(this).css('opacity', '1'), 200);
});
```

#### Funcionalidad 4: Validación de campos
```javascript
function validateField(selector, type) {
    const field = $(selector);
    const value = field.val().trim();
    
    let isValid = false;
    
    if (type === 'email') {
        isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }
    
    if (isValid) {
        field.removeClass('is-invalid').addClass('is-valid');
    }
    
    return isValid;
}
```

#### Helpers globales
```javascript
// Notificación flotante
showNotification('¡Éxito!', 'success');

// AJAX simplificado
makeAjaxRequest('php/endpoint.php', data, function(response) {
    // Callback
});

// Validación de campo
validateField('#email', 'email');
```

---

## Comparativa: Líneas de código

| Función | Vanilla JS | Con jQuery | Ahorro |
|---------|-----------|-----------|--------|
| Obtener valor | 1 línea | 1 línea | - |
| Agregar clase | 1 línea | 1 línea | - |
| AJAX básico | 8 líneas | 5 líneas | 37% |
| Animar | 2 líneas | 1 línea | 50% |
| Evento + acción | 2 líneas | 1 línea | 50% |
| **TOTAL** | ~50 líneas | ~30 líneas | **40% menos código** |

---

## Métodos jQuery más utilizados en el proyecto

### Selectores
```javascript
$('#id')              // Por ID
$('.class')           // Por clase
$('[attribute]')      // Por atributo
$('element')          // Por elemento
$('parent > child')   // Hijo directo
```

### Manipulación del DOM
```javascript
.val()                // Obtener/establecer valor
.text()               // Obtener/establecer texto
.html()               // Obtener/establecer HTML
.addClass()           // Agregar clase CSS
.removeClass()        // Remover clase CSS
.toggleClass()        // Alternar clase CSS
.css()                // Aplicar estilos CSS
.attr()               // Obtener/establecer atributo
```

### Eventos
```javascript
.on('click', fn)      // Clic
.on('submit', fn)     // Envío de formulario
.on('input', fn)      // Mientras se escribe
.on('focus', fn)      // Al enfocar
.on('blur', fn)       // Al desenfoque
.on('change', fn)     // Al cambiar
```

### Animaciones
```javascript
.fadeIn()             // Aparecer suavemente
.fadeOut()            // Desaparecer suavemente
.slideDown()          // Deslizar hacia abajo
.slideUp()            // Deslizar hacia arriba
.animate()            // Animación personalizada
.delay(ms)            // Esperar antes de ejecutar
```

### AJAX
```javascript
$.ajax()              // Petición AJAX
$.get()               // GET
$.post()              // POST
```

### Utilidades
```javascript
$.each()              // Iterar sobre elementos
$.map()               // Mapear elementos
$.trim()              // Eliminar espacios
$.type()              // Obtener tipo de dato
```

---

## Ventajas de jQuery vs Vanilla JavaScript

| Aspecto | jQuery | Vanilla JS |
|--------|--------|-----------|
| **Compatibilidad** | Todos los navegadores | Requiere polyfills |
| **Sintaxis** | Corta y legible | Más verbose |
| **AJAX** | Muy simple | Más complejo (fetch) |
| **Selectores** | Potentes | Limitados |
| **Animaciones** | Integradas | Requiere CSS |
| **Curva de aprendizaje** | Baja | Media |
| **Tamaño** | 87KB (minificado) | N/A |
| **Performance** | Bueno | Mejor |

---

## En el video de entrega

### Cómo mostrar jQuery

1. **Abrir la página de login/register en el navegador**
   - Mostrar que funciona

2. **Abrir el inspector del navegador (F12)**
   - Ir a Console
   - Escribir: `$('#email').val()`
   - Mostrar que jQuery está disponible

3. **Mostrar el código fuente**
   - Abrir login.php/register.php
   - Mostrar cómo se usa jQuery:
     - Selectores: `$('#email')`
     - Eventos: `.on('submit')`
     - AJAX: `$.ajax()`
     - Animaciones: `.fadeIn()`, `.fadeOut()`

4. **Explicar las ventajas**
   - Código más limpio
   - Menos líneas
   - Más legible
   - Mejor mantenibilidad

---

## Instalación/Inclusión

### CDN (Lo que usamos)
```html
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
```

### Verifica que jQuery está cargado
```javascript
// En la consola del navegador
console.log($.fn.jquery);  // Muestra: 3.6.0
```

---

## Recursos para aprender más

- **Documentación oficial**: https://api.jquery.com/
- **Tutorial**: https://learn.jquery.com/
- **Referencia rápida**: https://oscarotero.com/jquery/

---

## Conclusión

jQuery fue elegido como framework adicional porque:

1. ✅ **Simplifica significativamente el código**
2. ✅ **Mejora la experiencia del usuario** con animaciones
3. ✅ **Es fácil de usar** y aprender
4. ✅ **Integra perfectamente con Bootstrap**
5. ✅ **Es una tecnología establecida y confiable**

El proyecto ahora usa dos frameworks principales:
- **Bootstrap** (CSS/Layout)
- **jQuery** (JavaScript/Interactividad)

Esto proporciona una arquitectura moderna y profesional.
