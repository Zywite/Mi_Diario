# Checklist Video Entrega 3 - Con jQuery

## PARTE 1: CRUD - Eliminar y Actualizar (2 min)

### Antes de Grabar
- [ ] Base de datos está actualizada
- [ ] Datos de prueba listos (mensajes para editar)
- [ ] Navegador abierto en index.php
- [ ] F12 abierto (DevTools)

### Durante la grabación
- [ ] Persona 1: Explica qué es CRUD (Create, Read, Update, Delete)
- [ ] Mostrar un mensaje existente en la página
- [ ] **Hacer clic en "Editar" del mensaje**
  - [ ] Se abre formulario
  - [ ] Cambiar contenido del mensaje
  - [ ] Hacer clic en "Guardar"
  - [ ] ✅ Verificar que se actualiza en tiempo real
  - [ ] Mostrar en console: `console.log('Mensaje actualizado')` 
- [ ] **Hacer clic en "Eliminar" de otro mensaje**
  - [ ] Sale cuadro de confirmación
  - [ ] Confirmar eliminación
  - [ ] ✅ Verificar que desaparece de la página con animación
  - [ ] Mostrar que jQuery lo hizo con `.fadeOut()`
- [ ] Persona 2: Explicar código PHP (update_message.php, delete_message.php)
  - [ ] Mostrar validación: `if ($message['usuario_id'] !== $_SESSION['user_id'])`
  - [ ] Mostrar consulta preparada: `$stmt = $conn->prepare($sql)`
  - [ ] Mostrar respuesta JSON
- [ ] Persona 2: Explicar código JavaScript
  - [ ] Mostrar diferencia: Vanilla JS vs jQuery
  - [ ] Resaltar que jQuery es más limpio
  - [ ] Mostrar `$.ajax()` en lugar de `fetch()`
  - [ ] Mostrar `.fadeOut()` para animación

### Validación Técnica
- [ ] Network tab muestra POST a update_message.php
- [ ] Response JSON contiene `success: true`
- [ ] Console sin errores
- [ ] Página se actualiza sin recargar

### Puntos clave a mencionar
- [ ] "Solo el autor puede editar/eliminar"
- [ ] "jQuery simplifica el código en un 40%"
- [ ] "AJAX permite actualizar sin recargar la página"
- [ ] "Consultas preparadas evitan SQL injection"

---

## PARTE 2: BOOTSTRAP - 4 Propiedades (2 min)

### Propiedad 1: Grid System (container, row, col)
- [ ] Mostrar index.php con libros
- [ ] Abrir DevTools → Inspeccionar
- [ ] Resaltar: `<div class="container">`
- [ ] Resaltar: `<div class="row g-4">`
- [ ] Resaltar: `<div class="col-lg-4 col-md-6 col-sm-12">`
- [ ] **Redimensionar la ventana**
  - [ ] Desktop (1200px+): 3 columnas
  - [ ] Tablet (768px-1199px): 2 columnas
  - [ ] Móvil (< 768px): 1 columna
- [ ] Mencionar: "Bootstrap tiene 12 columnas, nosotros usamos 4+4+4"
- [ ] Código visible en pantalla (aumentar zoom)

### Propiedad 2: Flexbox Utilities (d-flex, justify-content, align-items)
- [ ] Ir a admin.php
- [ ] Mostrar encabezado: "Panel de Administración" + "Nuevo Libro"
- [ ] Explicar: `d-flex` = Display Flex
- [ ] Explicar: `justify-content-between` = Un elemento a cada lado
- [ ] Explicar: `align-items-center` = Centrado verticalmente
- [ ] Abrir DevTools y mostrar CSS
- [ ] Mencionar: "Facilita mucho la alineación de elementos"

### Propiedad 3: Spacing Utilities (m-*, p-*, mb-*, g-*)
- [ ] Mostrar cualquier sección con margen/padding
- [ ] Explicar: `mb-4` = Margen inferior 1.5rem
- [ ] Explicar: `p-3` = Padding 1rem
- [ ] Explicar: `g-4` = Gap entre elementos 1.5rem
- [ ] Resaltar que todos los elementos tienen espaciado consistente
- [ ] Mencionar: "Bootstrap usa una escala: 1=0.25rem, 2=0.5rem, 3=1rem, 4=1.5rem, 5=3rem"

### Propiedad 4: Components (card, table, btn, form-control)
- [ ] Mostrar tarjeta de libro:
  - [ ] Resaltar `<div class="card">`
  - [ ] Resaltar `<div class="card-header">`
  - [ ] Resaltar `<div class="card-body">`
  - [ ] Resaltar `<button class="btn btn-primary">`
- [ ] Mostrar tabla en admin.php:
  - [ ] Resaltar `<table class="table">`
  - [ ] Resaltar `<thead class="table-dark">`
  - [ ] Resaltar `<button class="btn btn-sm btn-warning">`
- [ ] Mencionar: "Bootstrap proporciona componentes predefinidos, no necesitamos CSS personalizado"

### Validación Visual
- [ ] Todos los 4 elementos Bootstrap visibles
- [ ] DevTools muestra clases Bootstrap
- [ ] Código legible (zoom al 125%)
- [ ] Puntos clave marcados/resaltados

---

## PARTE 3: JQUERY - Framework Adicional (4 min)

### 3.1 Introducción a jQuery

- [ ] Persona 1: Explicar por qué jQuery
  - [ ] "Simplifica la manipulación del DOM"
  - [ ] "Reduce código en un 40%"
  - [ ] "AJAX más simple que fetch()"
  - [ ] "Proporciona animaciones"
  - [ ] "Es ampliamente usado en la industria"

- [ ] Verificar que jQuery está cargado
  - [ ] Abrir F12 → Console
  - [ ] Escribir: `$.fn.jquery`
  - [ ] ✅ Debe mostrar: `"3.6.0"`
  - [ ] Escribir: `jQuery.noConflict()`
  - [ ] ✅ Debe estar disponible globalmente

### 3.2 Comparación: Vanilla JS vs jQuery

**Mostrar en pantalla (lado a lado):**

**SIN jQuery:**
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

**CON jQuery:**
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
            if (response.success) window.location.href = 'index.php';
        }
    });
});
```

- [ ] Destacar: jQuery tiene `-40% líneas de código`
- [ ] Mencionar: "Más legible y más fácil de mantener"
- [ ] Resaltar diferencias:
  - `document.getElementById()` vs `$('#id')`
  - `.addEventListener()` vs `.on()`
  - `fetch()` vs `$.ajax()`

### 3.3 jQuery en login.php

- [ ] Ir a login.php
- [ ] Abrir DevTools → Network
- [ ] Llenar formulario con email/password válidos
- [ ] Hacer clic en "Iniciar Sesión"
- [ ] En Network: Mostrar que se hace POST a `handle_login.php`
- [ ] Mostrar que es JSON en Request Payload
- [ ] Mostrar Response como JSON
- [ ] ✅ Verificar que redirige a index.php
- [ ] Persona 1: "jQuery hace el AJAX y la redirección"
- [ ] Mostrar en código:
  - [ ] `$('#login-form').on('submit', function(e)`
  - [ ] `$.ajax({ url: '...', type: 'POST' })`
  - [ ] `.success()` con manejo de respuesta

### 3.4 jQuery en register.php

- [ ] Ir a register.php
- [ ] Mostrar validación en tiempo real:
  - [ ] Escribir email INVÁLIDO (ej: "correo")
  - [ ] ✅ Campo se pone rojo (`is-invalid`)
  - [ ] Escribir email VÁLIDO (ej: "user@example.com")
  - [ ] ✅ Campo se pone verde (`is-valid`)
- [ ] Mencionar: "jQuery detecta cambios con `.on('input')`"
- [ ] Mostrar en código:
  - [ ] `$('#email').on('input', function() { })`
  - [ ] `$(this).addClass('is-invalid')`
  - [ ] `$(this).removeClass('is-invalid').addClass('is-valid')`
- [ ] Completar registro:
  - [ ] Llenar todos los campos
  - [ ] Hacer clic en Registrar
  - [ ] ✅ Ver animación de éxito
  - [ ] Mostrar que jQuery lo hizo con `.fadeIn()` y `.delay()`

### 3.5 jQuery en main.js

- [ ] Abrir archivo `js/main.js`
- [ ] Mostrar funciones globales:

**Función 1: showNotification**
```javascript
function showNotification(message, type = 'info') {
    $(alertHTML).appendTo('body').fadeIn().delay(5000).fadeOut();
}
```
- [ ] Explicar: Crea notificaciones flotantes con animación

**Función 2: makeAjaxRequest**
```javascript
function makeAjaxRequest(url, data, callback) {
    $.ajax({
        url: url,
        type: 'POST',
        data: JSON.stringify(data),
        success: callback
    });
}
```
- [ ] Explicar: Simplifica todas las llamadas AJAX

**Función 3: validateField**
```javascript
function validateField(selector, type) {
    const field = $(selector);
    const isValid = regex.test(field.val());
    if (isValid) field.addClass('is-valid');
    return isValid;
}
```
- [ ] Explicar: Valida campos de forma reutilizable

- [ ] Mencionar: "Estas funciones jQuery están disponibles en TODAS las páginas"

### 3.6 Métodos jQuery demostrados

Mostrar y explicar estos métodos jQuery usados en el proyecto:

| Método | Ejemplo | Explicación |
|--------|---------|-------------|
| `.on()` | `$('#form').on('submit', ...)` | Event listener |
| `.val()` | `$('#email').val()` | Obtener/establecer valor |
| `.ajax()` | `$.ajax({...})` | Realizar AJAX |
| `.fadeIn()` | `$('.msg').fadeIn()` | Aparecer suavemente |
| `.fadeOut()` | `$('.msg').fadeOut()` | Desaparecer suavemente |
| `.addClass()` | `$(this).addClass('is-valid')` | Agregar clase |
| `.removeClass()` | `$(this).removeClass('is-invalid')` | Quitar clase |
| `.delay()` | `$('.msg').delay(2000)` | Esperar ms |
| `.appendTo()` | `$('<div>').appendTo('body')` | Agregar al DOM |

- [ ] Resaltar al menos 5 métodos en el código
- [ ] Explicar qué hace cada uno
- [ ] Mostrar el resultado visual

### 3.7 jQuery vs Bootstrap

- [ ] Mencionar: "Bootstrap es CSS, jQuery es JavaScript"
- [ ] Bootstrap: Proporciona diseño responsivo
- [ ] jQuery: Proporciona interactividad
- [ ] Ambos juntos crean una experiencia completa

### Validación Técnica jQuery
- [ ] `$.fn.jquery` retorna "3.6.0"
- [ ] Métodos jQuery funcionan en Console
- [ ] Animaciones se ven suaves
- [ ] AJAX actualiza datos sin recargar
- [ ] Sin errores en Console

### Puntos clave a mencionar
- [ ] "jQuery reduce código un 40%"
- [ ] "jQuery es un framework, así como Bootstrap"
- [ ] "jQuery simplifica AJAX"
- [ ] "jQuery proporciona animaciones suaves"
- [ ] "jQuery está disponible en todas las páginas"
- [ ] "Nuestro proyecto ahora tiene 2 frameworks: Bootstrap + jQuery"

---

## PARTE 4: Conclusión (30 segundos)

- [ ] Ambos integrantes hablan
- [ ] Se mencionan todas las tecnologías:
  - [ ] HTML5 / CSS3
  - [ ] Bootstrap 5.3.3 (CSS Framework)
  - [ ] jQuery 3.6.0 (JavaScript Framework)
  - [ ] PHP 7.4+
  - [ ] MySQL 5.7+
  - [ ] CRUD completo
  - [ ] Autenticación con sesiones
  - [ ] AJAX sin recargar página
  - [ ] Diseño responsivo

- [ ] Mencionar: "Proyecto profesional con todas las tecnologías requeridas"
- [ ] Final agradecimiento

---

## CHECKLIST TÉCNICO GENERAL

### Equipo
- [ ] Micrófono probado
- [ ] Cámara (si la hay) probada
- [ ] Pantalla limpia de notificaciones
- [ ] Modo no molestar activado
- [ ] WiFi estable

### Navegador
- [ ] Zoom al 125% (legible pero natural)
- [ ] Devtools en Console visible
- [ ] Network tab limpio
- [ ] Sin pestañas innecesarias
- [ ] Borrador de navegación limpio

### Aplicación
- [ ] Servidor PHP corriendo
- [ ] Base de datos conectada
- [ ] Datos de prueba listos
- [ ] Sin errores de conexión
- [ ] Todas las páginas cargadas

### Código
- [ ] VSCode abierto (para mostrar código)
- [ ] Fuente aumentada (14pt+)
- [ ] Sintaxis highlighting activo
- [ ] Archivos clave listos para mostrar

### Video
- [ ] Duración total ~8 minutos
- [ ] Ambos integrantes hablan
- [ ] Párrafos clave practicados
- [ ] Transiciones suaves entre partes

---

## ORDEN DE GRABACIÓN RECOMENDADO

1. **Intro** (30 seg): "Hola somos... presentamos Entrega 3"
2. **CRUD** (2 min): Editar y eliminar mensajes
3. **Bootstrap** (2 min): 4 propiedades demostradas
4. **jQuery** (4 min): Framework, comparativa, funciones
5. **Conclusión** (30 seg): "Gracias por ver nuestro proyecto"

**Total: ~8.5 minutos**

---

## PROBLEMAS COMUNES Y SOLUCIONES

| Problema | Solución |
|----------|----------|
| jQuery no carga | Verificar que header.php tiene CDN |
| AJAX no funciona | F12 → Network → Ver error |
| Base de datos sin datos | Insertar datos de prueba |
| Código no visible | Aumentar zoom a 125% |
| Animaciones lentas | Verificar Network tab (no hay lag) |
| Bootstrap no funciona | Verificar CDN en header.php |
| Micrófono bajo | Probar en Configuración de Windows |
| Navegador lento | Cerrar pestañas, reiniciar navegador |

---

## Última revisión antes de grabar

- [ ] ¿Todos los archivos actualizados? ✅ GUIA_VIDEO_ENTREGA_ACTUALIZADA.md, EJEMPLOS_CODIGO_VIDEO_ACTUALIZADO.md
- [ ] ¿jQuery funcionando? ✅ Verificado en Console
- [ ] ¿Bootstrap visibles? ✅ Clases en DevTools
- [ ] ¿CRUD completo? ✅ Update y Delete funcionan
- [ ] ¿Ambos integrantes preparados? ⬜ Practicar guión
- [ ] ¿Audio y video listos? ⬜ Probar equipo
- [ ] ¿Git actualizado? ✅ Commit hecho

**¡LISTO PARA GRABAR!** 🎥
