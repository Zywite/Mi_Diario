# Mi Diario de Lectura

## Descripción
"Mi Diario de Lectura" es una aplicación web para registrar y visualizar libros. Permite:

- Mostrar libros en tarjetas con título, autor, género, imagen y calificación.
- Comparar libros en una tabla dinámica.
- Administrar libros desde un panel de administración (agregar, editar y eliminar).
- Contactar a través de un formulario con validación local.

---

## Estructura de Archivos

mi-diario-lectura/
├── index.html # Página principal con tarjetas y tabla comparativa
├── admin.html # Panel de administración de libros
├── css/
│ ├── style-index.css # Estilos de la página principal
│ └── style-admin.css # Estilos del panel de administración
├── js/
│ ├── index.js # Lógica principal para renderizar libros en index.html
│ └── admin.js # Funcionalidades de agregar, editar y eliminar libros
├── data/
│ └── books.json # Base de datos inicial de libros
└── img/
└── libros/ # Imágenes de los libros


---

## Tecnologías Utilizadas

- **HTML5**: Estructura semántica (`<header>`, `<nav>`, `<section>`, `<main>`, `<footer>`).
- **CSS3**: Flexbox para maquetación, estilos personalizados, pseudo-clases `:hover` y `:focus`.
- **JavaScript**: Manipulación del DOM, manejo de `localStorage`, eventos interactivos (`onmouseover`, `click`, `submit`).

---

## Funcionalidades

### Página Principal (`index.html`)
- Renderiza libros desde `localStorage`.
- Muestra tarjetas con información de cada libro.
- Genera una tabla comparativa con título, autor, género y calificación.
- Permite visualizar estrellas según la calificación.
- Formulario de contacto con validación local y alerta al enviar.

### Panel de Administración (`admin.html`)
- Lista todos los libros con botones de **Editar** y **Eliminar**.
- Permite agregar nuevos libros al `localStorage`.
- Al editar, se actualiza automáticamente la vista en `index.html`.
- Botones de administración están alineados y separados correctamente.

---

## Uso

1. Abrir `index.html` en el navegador.
2. Visualizar libros y tabla comparativa.
3. Ir a `admin.html` para agregar, editar o eliminar libros.
4. Utilizar `contacto.html` para probar el formulario de contacto.

---

## Consideraciones

- Todos los datos de libros se guardan en **localStorage**, por lo que se mantiene entre sesiones.
- Las imágenes deben estar en `img/libros/` con el mismo nombre que en `books.json`.

---

## Autores
Proyecto desarrollado en conjunto por Joaquin Carrasco  y Martin Fuentealba como parte de un proyecto para la práctica de HTML, CSS y JavaScript.
