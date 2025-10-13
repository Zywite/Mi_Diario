// Clase principal para gestionar libros
class BookManager {
    constructor() {
        this.books = [];
        this.editIndex = null;
        this.list = document.getElementById("book-list-admin");
        this.addForm = document.getElementById("add-book-form");
        this.submitBtn = document.getElementById("submit-btn");
        this.saveBtn = document.getElementById("save-btn");
        
        // Inicializar
        this.init();
        
        // Vincular eventos
        this.bindEvents();
        
        console.log('BookManager: Instancia creada');
    }

    /**
     * Inicializa el gestor de libros
     */
    init() {
        console.log('BookManager: Iniciando...');
        this.loadBooks(this);
        this.saveBtn.style.display = "none";
    }

    /**
     * Vincula los eventos del formulario
     */
    bindEvents() {
        console.log('BookManager: Vinculando eventos...');
        this.addForm.addEventListener('submit', (e) => this.handleSubmit(e, this));
        this.saveBtn.addEventListener('click', (e) => this.handleSave(e, this));
    }

    /**
     * Carga los libros desde el servidor
     * @param {BookManager} context - Contexto del BookManager
     */
    loadBooks(context) {
        console.log('BookManager: Cargando libros...');
        fetch('php/list_books.php')
            .then(res => res.json())
            .then(data => {
                context.books = data;
                context.renderBooks();
            })
            .catch(err => {
                console.error('Error al cargar libros:', err);
                alert('Error al cargar los libros. Por favor, intenta de nuevo.');
            });
    }

    /**
     * Renderiza la lista de libros
     */
    renderBooks() {
        console.log('BookManager: Renderizando libros...');
        this.list.innerHTML = "";

        this.books.forEach((book) => {
            const li = document.createElement("li");
            li.innerHTML = `<span>${book.titulo} (${book.autor}) - Cal: ${book.calificacion}</span>`;

            // Botón Editar
            const editBtn = document.createElement("button");
            editBtn.textContent = "Editar";
            editBtn.addEventListener("click", () => this.handleEdit(book));

            // Botón Eliminar
            const deleteBtn = document.createElement("button");
            deleteBtn.textContent = "Eliminar";
            deleteBtn.addEventListener("click", () => this.handleDelete(book.id));

            // Contenedor para alinear botones
            const btnContainer = document.createElement("div");
            btnContainer.className = "btn-container";
            btnContainer.appendChild(editBtn);
            btnContainer.appendChild(deleteBtn);

            li.appendChild(btnContainer);
            this.list.appendChild(li);
        });
    }

    /**
     * Maneja el envío del formulario para nuevo libro
     * @param {Event} e - Evento del formulario
     * @param {BookManager} context - Contexto del BookManager
     */
    handleSubmit(e, context) {
        e.preventDefault();
        console.log('BookManager: Manejando envío de nuevo libro...');

        const bookData = {
            titulo: document.getElementById("titulo").value,
            autor: document.getElementById("autor").value,
            genero: document.getElementById("genero").value,
            imagen: document.getElementById("imagen").value,
            calificacion: parseInt(document.getElementById("calificacion").value)
        };

        fetch('php/save_book.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(bookData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Libro guardado exitosamente');
                context.addForm.reset();
                context.loadBooks(context);
                this.updateIndex();
            } else {
                throw new Error(data.error || 'Error al guardar el libro');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Error al guardar el libro. Por favor, intenta de nuevo.');
        });
    }

    /**
     * Maneja la edición de un libro
     * @param {Object} book - Libro a editar
     */
    handleEdit(book) {
        console.log('BookManager: Preparando edición de libro:', book);
        
        // Llenar el formulario con los datos del libro
        document.getElementById("titulo").value = book.titulo;
        document.getElementById("autor").value = book.autor;
        document.getElementById("genero").value = book.genero;
        document.getElementById("imagen").value = book.imagen;
        document.getElementById("calificacion").value = book.calificacion;

        // Guardar el ID del libro que se está editando
        this.editIndex = book.id;
        
        // Cambiar visibilidad de botones
        this.submitBtn.style.display = "none";
        this.saveBtn.style.display = "inline-block";
    }

    /**
     * Maneja el guardado de cambios en un libro existente
     * @param {Event} e - Evento del botón
     * @param {BookManager} context - Contexto del BookManager
     */
    handleSave(e, context) {
        e.preventDefault();
        console.log('BookManager: Guardando cambios en libro...');

        const bookData = {
            id: context.editIndex,
            titulo: document.getElementById("titulo").value,
            autor: document.getElementById("autor").value,
            genero: document.getElementById("genero").value,
            imagen: document.getElementById("imagen").value,
            calificacion: parseInt(document.getElementById("calificacion").value)
        };

        fetch('php/update_book.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(bookData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Libro actualizado exitosamente');
                context.addForm.reset();
                context.editIndex = null;
                context.submitBtn.style.display = "inline-block";
                context.saveBtn.style.display = "none";
                context.loadBooks(context);
                this.updateIndex();
            } else {
                throw new Error(data.error || 'Error al actualizar el libro');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Error al actualizar el libro. Por favor, intenta de nuevo.');
        });
    }

    /**
     * Maneja la eliminación de un libro
     * @param {number} id - ID del libro a eliminar
     */
    handleDelete(id) {
        console.log('BookManager: Eliminando libro ID:', id);
        
        if (confirm('¿Estás seguro de que deseas eliminar este libro?')) {
            fetch('php/delete_book.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Libro eliminado exitosamente');
                    this.loadBooks(this);
                    this.updateIndex();
                } else {
                    throw new Error(data.error || 'Error al eliminar el libro');
                }
            })
            .catch(err => {
                console.error('Error:', err);
                alert('Error al eliminar el libro. Por favor, intenta de nuevo.');
            });
        }
    }

    /**
     * Actualiza index.php si está abierto
     */
    updateIndex() {
        console.log('BookManager: Actualizando index.php si está abierto');
        if (window.opener && !window.opener.closed) {
            window.opener.location.reload();
        }
    }
}

// Iniciar el gestor de libros cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    new BookManager();
});