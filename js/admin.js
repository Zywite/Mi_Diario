class BookManager {
    constructor() {
        // Formulario y botones
        this.form = document.getElementById('add-book-form');
        this.bookIdInput = document.getElementById('book_id');
        this.tituloInput = document.getElementById('titulo');
        this.autorInput = document.getElementById('autor');
        this.generoInput = document.getElementById('genero');
        this.imagenInput = document.getElementById('imagen');
        this.calificacionInput = document.getElementById('calificacion');
        this.submitBtn = document.getElementById('submit-btn');
        this.saveBtn = document.getElementById('save-btn');
        this.cancelBtn = document.getElementById('cancel-btn');

        // Lista de libros
        this.bookListContainer = document.getElementById('book-list-admin');

        this.init();
    }

    init() {
        this.bindEvents();
        this.loadBooks();
    }

    bindEvents() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        this.saveBtn.addEventListener('click', () => this.handleSave());
        this.cancelBtn.addEventListener('click', () => this.resetForm());
    }

    loadBooks() {
        fetch('php/list_books.php')
            .then(res => res.json())
            .then(books => {
                this.renderBooks(books);
            })
            .catch(err => {
                console.error('Error al cargar libros:', err);
                alert('Error al cargar los libros.');
            });
    }

    renderBooks(books) {
        this.bookListContainer.innerHTML = '';
        if (books.length === 0) {
            this.bookListContainer.innerHTML = '<li class="list-group-item">No hay libros para mostrar.</li>';
            return;
        }

        books.forEach(book => {
            const li = document.createElement('li');
            // Bootstrap: Item de grupo de lista con flexbox para alinear contenido
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            
            const stars = '★'.repeat(book.calificacion) + '☆'.repeat(5 - book.calificacion);

            li.innerHTML = `
                <div>
                    <h5 class="mb-1">${book.titulo}</h5>
                    <small class="text-muted">${book.autor}</small>
                </div>
                <div>
                    <!-- Bootstrap: Badge para la calificación -->
                    <span class="badge bg-primary rounded-pill me-3">Cal: ${stars}</span>
                    <!-- Bootstrap: Botones pequeños para las acciones -->
                    <button class="btn btn-sm btn-outline-secondary me-1">Editar</button>
                    <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                </div>
            `;

            // Asignar eventos a los botones creados
            li.querySelector('.btn-outline-secondary').addEventListener('click', () => this.handleEdit(book));
            li.querySelector('.btn-outline-danger').addEventListener('click', () => this.handleDelete(book.id));

            this.bookListContainer.appendChild(li);
        });
    }

    resetForm() {
        this.form.reset();
        this.bookIdInput.value = ''; // Limpiar el ID oculto
        this.submitBtn.style.display = 'block';
        this.saveBtn.style.display = 'none';
        this.cancelBtn.style.display = 'none';
    }

    handleEdit(book) {
        // Llenar el formulario
        this.bookIdInput.value = book.id;
        this.tituloInput.value = book.titulo;
        this.autorInput.value = book.autor;
        this.generoInput.value = book.genero;
        this.imagenInput.value = book.imagen;
        this.calificacionInput.value = book.calificacion;

        // Cambiar visibilidad de botones
        this.submitBtn.style.display = 'none';
        this.saveBtn.style.display = 'block';
        this.cancelBtn.style.display = 'block';
        
        // Scroll hacia el formulario
        this.form.scrollIntoView({ behavior: 'smooth' });
    }

    handleDelete(bookId) {
        if (!confirm('¿Estás seguro de que deseas eliminar este libro?')) return;

        fetch('php/delete_book.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: bookId })
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                this.loadBooks();
            } else {
                alert(response.error || 'No se pudo eliminar el libro.');
            }
        })
        .catch(err => console.error('Error al eliminar:', err));
    }

    handleSubmit(e) {
        e.preventDefault();
        this.saveBook('php/save_book.php');
    }

    handleSave() {
        this.saveBook('php/update_book.php');
    }

    saveBook(url) {
        const bookData = {
            id: this.bookIdInput.value,
            titulo: this.tituloInput.value,
            autor: this.autorInput.value,
            genero: this.generoInput.value,
            imagen: this.imagenInput.value,
            calificacion: parseInt(this.calificacionInput.value)
        };

        // Validar que los campos no estén vacíos
        if (!bookData.titulo || !bookData.autor || !bookData.genero || !bookData.imagen || !bookData.calificacion) {
            alert('Todos los campos son obligatorios.');
            return;
        }

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(bookData)
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                this.resetForm();
                this.loadBooks();
            } else {
                alert(response.error || 'Ocurrió un error al guardar el libro.');
            }
        })
        .catch(err => console.error('Error al guardar:', err));
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new BookManager();
});
