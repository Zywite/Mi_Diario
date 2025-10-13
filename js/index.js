/**
 * Clase para gestionar la visualización de libros
 */
class BookViewer {
    constructor() {
        this.books = [];
        this.container = document.getElementById("book-list");
        this.tbody = document.querySelector("#compare-table tbody");
        
        // Inicializar
        this.init();
        
        console.log('BookViewer: Instancia creada');
    }

    /**
     * Inicializa el visor de libros
     */
    init() {
        console.log('BookViewer: Iniciando...');
        this.loadBooks();
    }

    /**
     * Muestra un indicador de carga
     */
    showLoading() {
        console.log('BookViewer: Mostrando indicador de carga...');
        this.container.innerHTML = '<p class="loading-message">Cargando libros...</p>';
    }

    /**
     * Carga los libros desde el servidor
     */
    loadBooks() {
        console.log('BookViewer: Cargando libros...');
        this.showLoading();
        fetch('php/list_books.php')
            .then(res => res.json())
            .then(data => {
                this.books = data;
                this.renderBooks();
            })
            .catch(err => {
                console.error('Error al cargar libros:', err);
                this.showError('Error al cargar los libros. Por favor, recarga la página.');
            });
    }

    /**
     * Renderiza los libros en tarjetas y tabla
     */
    renderBooks() {
        console.log('BookViewer: Renderizando libros...');
        
        // Limpiar contenedores
        this.container.innerHTML = "";
        if(this.tbody) this.tbody.innerHTML = "";

        if (this.books.length === 0) {
            this.container.innerHTML = '<p>No hay libros disponibles en este momento.</p>';
            return;
        }

        this.books.forEach(book => {
            this.renderCard(book);
            this.renderTableRow(book);
        });
    }

    /**
     * Renderiza una tarjeta de libro
     * @param {Object} book - Datos del libro
     */
    renderCard(book) {
        console.log('BookViewer: Renderizando tarjeta para:', book.titulo);
        const card = document.createElement("div");
        card.className = "book-card";
        card.innerHTML = `
            <figure>
                <img src="imagenes/${book.imagen}" alt="${book.titulo}">
                <figcaption>${book.titulo}</figcaption>
            </figure>
            <p><b>Autor:</b> ${book.autor}</p>
            <p><b>Género:</b> ${book.genero}</p>
            <p><i>Calificación: ${"★".repeat(book.calificacion)}${"☆".repeat(5-book.calificacion)}</i></p>
        `;
        this.container.appendChild(card);
    }

    /**
     * Renderiza una fila en la tabla comparativa
     * @param {Object} book - Datos del libro
     */
    renderTableRow(book) {
        if (!this.tbody) return;
        
        console.log('BookViewer: Renderizando fila de tabla para:', book.titulo);
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${book.titulo}</td>
            <td>${book.autor}</td>
            <td>${book.genero}</td>
            <td>${"★".repeat(book.calificacion)}${"☆".repeat(5-book.calificacion)}</td>
        `;
        this.tbody.appendChild(tr);
    }

    /**
     * Muestra un mensaje de error
     * @param {string} message - Mensaje de error
     */
    showError(message) {
        console.error('BookViewer Error:', message);
        this.container.innerHTML = ''; // Limpiar el indicador de carga
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        this.container.appendChild(errorDiv);
    }
}

// Iniciar el visor de libros cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    new BookViewer();
});
