# Documentación de Cumplimiento de Requisitos

## 1. Especificaciones HTML y CSS

### HTML Semántico
- **Ubicación**: `index.php` y `admin.php`
- **Implementación**:
  ```html
  <header>
    <h1>Mi Diario de Lectura</h1>
    <nav>...</nav>
  </header>
  <main>
    <section>...</section>
  </main>
  ```

### CSS Externo y Flexbox
- **Ubicación**: `/css/common.css`, `/css/index.css`, `/css/admin.css`
- **Implementación de Flexbox**:
  ```css
  .book-container {
    display: flex;
    flex-wrap: wrap;
    gap: 25px;
    justify-content: center;
  }
  ```

## 2. Especificaciones JavaScript

### Funciones con 2+ Parámetros
- **Ubicación**: `/js/admin.js`
- **Implementación**:
  ```javascript
  handleSubmit(e, context) {
    e.preventDefault();
    console.log('BookManager: Manejando envío de nuevo libro...');
    // ...
  }

  handleSave(e, context) {
    e.preventDefault();
    console.log('BookManager: Guardando cambios en libro...');
    // ...
  }

  loadBooks(context) {
    console.log('BookManager: Cargando libros...');
    // ...
  }
  ```

### Uso de this como Parámetro
- **Ubicación**: `/js/admin.js`
- **Implementación**:
  ```javascript
  init() {
    this.loadBooks(this);
  }

  bindEvents() {
    this.addForm.addEventListener('submit', (e) => this.handleSubmit(e, this));
    this.saveBtn.addEventListener('click', (e) => this.handleSave(e, this));
  }
  ```

### Eventos con addEventListener
- **Ubicación**: `/js/admin.js` y `/js/index.js`
- **Implementación**:
  ```javascript
  // Evento 1: DOMContentLoaded
  document.addEventListener('DOMContentLoaded', () => {
    new BookManager();
  });

  // Evento 2: Submit del formulario
  this.addForm.addEventListener('submit', (e) => this.handleSubmit(e, this));

  // Evento 3: Click en botón save
  this.saveBtn.addEventListener('click', (e) => this.handleSave(e, this));
  ```

### Console.log en Funciones
- **Ubicación**: Todas las funciones en `/js/admin.js` y `/js/index.js`
- **Ejemplo**:
  ```javascript
  init() {
    console.log('BookManager: Iniciando...');
    // ...
  }

  loadBooks() {
    console.log('BookManager: Cargando libros...');
    // ...
  }
  ```

## 3. Especificaciones FETCH

### Implementación de Fetch
- **Ubicación**: `/js/admin.js` y `/js/index.js`
- **Implementación**:
  ```javascript
  loadBooks(context) {
    fetch('php/list_books.php')
      .then(res => res.json())
      .then(data => {
        context.books = data;
        context.renderBooks();
      })
      // ...
  }
  ```

## 4. Especificaciones PHP y Base de Datos

### Recepción de Datos de Formulario
- **Ubicación**: `/php/save_book.php` y `/php/save_contact.php`
- **Implementación**:
  ```php
  // En save_book.php
  $data = json_decode(file_get_contents('php://input'), true);
  ```

### Guardado en Base de Datos
- **Ubicación**: `/php/save_book.php`
- **Implementación**:
  ```php
  $sql = "INSERT INTO books (titulo, autor, genero, imagen, calificacion) 
          VALUES (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  ```

### Notificaciones al Usuario
- **Ubicación**: Todos los archivos PHP
- **Implementación**:
  ```php
  echo json_encode([
    "success" => true,
    "message" => "Libro guardado exitosamente"
  ]);
  ```

### Listado de Datos
- **Ubicación**: `/php/list_books.php`
- **Implementación**:
  ```php
  $sql = "SELECT * FROM books ORDER BY id DESC";
  $result = $conn->query($sql);
  ```

## 5. Requisitos no Funcionales

### Estructura del Proyecto
```
Mi_Diario/
├── index.php           # Página principal
├── admin.php          # Panel de administración
├── imagenes/         # Carpeta de imágenes
├── css/             # Archivos CSS externos
├── js/              # Archivos JavaScript externos
└── php/
    └── conex.php    # Conexión a BD separada
```

### Documentación
- **Ubicación**: Comentarios en todos los archivos
- **Ejemplo**:
  ```javascript
  /**
   * Inicializa el gestor de libros
   */
  init() {
    console.log('BookManager: Iniciando...');
    this.loadBooks(this);
    this.saveBtn.style.display = "none";
  }
  ```

## 6. Características Adicionales Implementadas

1. **Seguridad**
   - Uso de consultas preparadas
   - Validación de datos
   - Manejo de errores

2. **UX/UI**
   - Diseño responsive
   - Feedback visual
   - Animaciones y transiciones

3. **Funcionalidades**
   - CRUD completo de libros
   - Sistema de calificación
   - Tabla comparativa
   - Búsqueda de libros

4. **Arquitectura**
   - Programación orientada a objetos
   - Código modular
   - Separación de responsabilidades