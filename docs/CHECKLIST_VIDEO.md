# Checklist para Video de Entrega

## Antes de Grabar

### Preparación Técnica
- [ ] Verificar que el micrófono funciona bien
- [ ] Hacer una prueba de grabación corta
- [ ] Cerrar notificaciones del sistema (Teams, Discord, etc.)
- [ ] Tener la página web abierta y lista
- [ ] Tener el editor de código abierto
- [ ] Tener la consola del navegador visible (F12)
- [ ] Aumentar el zoom del navegador para que se vea bien

### Preparación de Contenido
- [ ] Leer el guión completamente
- [ ] Practicar la presentación (mínimo 2 veces)
- [ ] Asignar claramente quién habla en cada parte
- [ ] Tener datos de prueba listos (un mensaje para editar/eliminar)
- [ ] Verificar que el sitio funciona correctamente

---

## PARTE 1: ACTUALIZAR Y ELIMINAR (2 minutos) ✓

### Demostración en Sitio
- [ ] Mostrar un mensaje en el muro
- [ ] Hacer clic en "Editar"
- [ ] Cambiar el contenido del mensaje
- [ ] Guardar (mostrar que se actualiza)
- [ ] Hacer clic en "Eliminar"
- [ ] Confirmar que se elimina

### Explicación de Código
**Persona 1 debe mostrar**:
- [ ] Archivo `php/update_message.php`
- [ ] Validación: solo el autor puede editar
- [ ] SQL UPDATE
- [ ] Respuesta JSON

**Persona 2 debe mostrar**:
- [ ] Archivo `js/messages.js`
- [ ] Fetch al endpoint update_message.php
- [ ] JSON enviado
- [ ] JSON recibido
- [ ] Archivo `php/delete_message.php`
- [ ] SQL DELETE

### Puntos a Enfatizar
- [ ] Explicar que solo el autor puede editar/eliminar (sesión)
- [ ] Mostrar que se usa FETCH
- [ ] Mostrar que se intercambia JSON
- [ ] Mostrar que en BD se actualiza/elimina

---

## PARTE 2: BOOTSTRAP - 4 PROPIEDADES (2 minutos) ✓

### Propiedad 1: Grid System (Container, Row, Col)
- [ ] Mostrar código en `index.php`
- [ ] Explicar container, row, col-md-4
- [ ] Redimensionar navegador para mostrar responsividad
- [ ] Mostrar en móvil (1 columna), tablet (2), desktop (3)

### Propiedad 2: Flexbox Utilities
- [ ] Mostrar `d-flex`
- [ ] Mostrar `justify-content-between`
- [ ] Mostrar `align-items-center`
- [ ] Mostrar en sitio cómo se ve el layout

### Propiedad 3: Spacing Utilities
- [ ] Mostrar `mb-4` (margin-bottom)
- [ ] Mostrar `p-3` (padding)
- [ ] Mostrar `g-4` (gap entre columnas)
- [ ] Explicar cómo da consistencia

### Propiedad 4: Components
- [ ] Mostrar card en tarjetas de libros
- [ ] Mostrar table (tabla comparativa)
- [ ] Mostrar btn (botones)
- [ ] Mostrar form-control (campos de formulario)

### Comentarios en Código
- [ ] Mostrar comentarios tipo: `<!-- Bootstrap: Grid de 12 columnas -->`
- [ ] Cada propiedad debe estar comentada

---

## PARTE 3: FRAMEWORK - VALIDACIÓN JAVASCRIPT (4 minutos) ✓

### Explicación General
- [ ] **Persona 1**: ¿Por qué elegimos validación JavaScript?
  - [ ] Mejora UX
  - [ ] Reduce tráfico a BD
  - [ ] Feedback inmediato
  
- [ ] **Persona 2**: ¿Cómo funciona?
  - [ ] Listeners en los campos
  - [ ] Validación en tiempo real
  - [ ] Alertas visuales

### Demostración en Sitio
- [ ] Abrir formulario de registro
- [ ] Escribir email inválido y mostrar error
- [ ] Escribir email válido y mostrar que desaparece el error
- [ ] Escribir contraseña corta y mostrar error
- [ ] Escribir contraseña válida y mostrar que está OK

### Explicación de Código
- [ ] **Persona 1**: Mostrar clase `AuthValidator`
  - [ ] Constructor
  - [ ] `setupValidation()` - cómo configura listeners
  
- [ ] **Persona 2**: Mostrar métodos individuales
  - [ ] `validateEmail()` - explicar regex
  - [ ] `validatePassword()` - explicar lógica
  - [ ] `validateRegister()` - validación completa
  
- [ ] **Persona 1**: Mostrar cómo se inicializa
  - [ ] `DOMContentLoaded`
  - [ ] `new AuthValidator()`

### Beneficios Demostrados
- [ ] Validación inmediata (no espera a enviar)
- [ ] Feedback visual (alertas Bootstrap)
- [ ] Previene envío de datos inválidos
- [ ] Mejor experiencia del usuario

### Integración con Bootstrap
- [ ] Mostrar que usa clases de Bootstrap (`alert-danger`, `is-invalid`)
- [ ] Mostrar que se ve profesional y consistente

---

## Asuntos Generales a Cubrir

### Para Todos los Puntos
- [ ] **Ambos integrantes hablan en cada punto**
- [ ] Mostrar código fuente
- [ ] Mostrar sitio web en funcionamiento
- [ ] Explicar claramente cada concepto

### Duración
- [ ] Parte 1: ~2 minutos
- [ ] Parte 2: ~2 minutos
- [ ] Parte 3: ~4 minutos
- [ ] Total: ~8 minutos

### Calidad
- [ ] Audio claro y audible
- [ ] Código visible (zoom suficiente)
- [ ] Ritmo adecuado (no muy rápido)
- [ ] Lenguaje técnico pero comprensible

### Accesibilidad
- [ ] Link público (YouTube o Google Drive)
- [ ] Video accesible para cualquiera con el link
- [ ] Audio en español (o en el idioma acordado)
- [ ] Subtítulos recomendados (opcional)

---

## Rúbrica de Auto-evaluación

### HTML, JS y CSS (15%)
- [ ] 4+ propiedades Bootstrap mostradas ✓ (Grid, Flexbox, Spacing, Components)
- [ ] Sitio responsivo ✓ (mostrado redimensionando)
- [ ] CSS coherente ✓
- [ ] Manejador de eventos en archivo externo ✓

### Otros Frameworks (15%)
- [ ] Framework funcional ✓ (Validación JavaScript)
- [ ] Visible en sitio ✓ (se ve al probar formularios)
- [ ] Explicación detallada ✓ (cómo funciona)
- [ ] Código mostrado ✓

### Fetch y JSON (20%)
- [ ] UPDATE usa FETCH ✓ (mostrado en código)
- [ ] DELETE usa FETCH ✓ (mostrado en código)
- [ ] Datos en JSON ✓ (mostrado en código)

### Sesiones (15%)
- [ ] Login funciona ✓
- [ ] Password encriptado MD5 ✓
- [ ] Sesión activa ✓ (solo autor puede editar/eliminar)
- [ ] Formulario registro funcional ✓

### CRUD (25%)
- [ ] CREATE ✓ (crear mensajes)
- [ ] READ ✓ (listar mensajes)
- [ ] UPDATE ✓ (editar mensajes - mostrado)
- [ ] DELETE ✓ (eliminar mensajes - mostrado)
- [ ] Restricción permisos ✓ (solo autor)

### Documentación (10%)
- [ ] Código comentado ✓ (mostrar comentarios)
- [ ] Funciones documentadas ✓
- [ ] Legibilidad clara ✓

---

## Tips Finales

### Durante la Grabación
1. Habla despacio y clara
2. Si cometes error, puedes pausar y corregir
3. Deja tiempo para que se vea bien cada demostración
4. Alterna entre código y sitio web
5. Señala con el cursor los puntos importantes

### Si Algo Sale Mal
1. Puedes parar, corregir y retomar
2. La edición puede limpiar errores menores
3. Lo importante es explicar correctamente

### Mejora Post-Producción
1. Agrega un intro con nombre de integrantes
2. Agrega títulos para cada sección (Parte 1, 2, 3)
3. Resalta con zoom las partes importantes del código
4. Añade subtítulos (recomendado)
5. Verifica audio (sin ruido de fondo)

---

## Plantilla de Intro para Video

**[INTRO - 30 segundos]**

"Hola, somos [NOMBRE 1] y [NOMBRE 2]. Presentamos la **Entrega 3** de nuestro proyecto **Mi Diario de Lectura**.

En los próximos minutos les mostraremos:
1. Cómo actualizar y eliminar registros de la base de datos
2. Las propiedades de Bootstrap que implementamos
3. El framework de validación que mejora nuestro sitio

¡Comencemos!"

---

## Plantilla de Cierre para Video

**[CIERRE - 30 segundos]**

[NOMBRE 1]: "Como han visto, nuestra aplicación implementa todas las funcionalidades requeridas..."

[NOMBRE 2]: "Con un diseño profesional usando Bootstrap y validación avanzada..."

**AMBOS**: "¡Gracias por ver nuestro proyecto!"
