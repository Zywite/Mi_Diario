class PageManager {
    constructor() {
        this.bookContainer = document.getElementById('book-list');
        this.compareTbody = document.querySelector('#compare-table tbody');
        this.messageWall = document.getElementById('message-wall');
        this.contactForm = document.getElementById('contact-form');
        
        this.init();
    }

    init() {
        this.loadBooks();
        this.loadMessages();

        if (this.contactForm) {
            this.contactForm.addEventListener('submit', (e) => this.handleMessageSubmit(e));
        }
        
        // Implement search
        const searchInput = document.getElementById('search-input');
        searchInput.addEventListener('keyup', (e) => this.filterBooks(e.target.value));
    }

    // ==================
    // Métodos de Libros
    // ==================

    loadBooks() {
        fetch('php/list_books.php')
            .then(res => res.json())
            .then(data => {
                this.allBooks = data; // Guardar todos los libros
                this.renderBooks(this.allBooks);
            })
            .catch(err => console.error('Error al cargar libros:', err));
    }

    renderBooks(books) {
        this.bookContainer.innerHTML = '';
        this.compareTbody.innerHTML = '';

        if (books.length === 0) {
            this.bookContainer.innerHTML = '<p class="col-12">No se encontraron libros que coincidan con la búsqueda.</p>';
            return;
        }

        books.forEach(book => {
            this.renderCard(book);
            this.renderTableRow(book);
        });
    }

    renderCard(book) {
        const col = document.createElement('div');
        col.className = 'col-lg-3 col-md-4 col-sm-6 mb-4';

        const stars = '★'.repeat(book.calificacion) + '☆'.repeat(5 - book.calificacion);

        col.innerHTML = `
            <!-- Bootstrap: Tarjeta con altura 100% y sombra -->
            <div class="card h-100 shadow-sm">
                <img src="imagenes/${book.imagen}" class="card-img-top" alt="${book.titulo}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">${book.titulo}</h5>
                    <p class="card-text text-muted">${book.autor}</p>
                    <div class="mt-auto">
                        <p class="card-text mb-1"><small>${book.genero}</small></p>
                        <p class="card-text text-warning">${stars}</p>
                    </div>
                </div>
            </div>
        `;
        this.bookContainer.appendChild(col);
    }

    renderTableRow(book) {
        const tr = document.createElement('tr');
        const stars = '★'.repeat(book.calificacion) + '☆'.repeat(5 - book.calificacion);
        tr.innerHTML = `
            <td>${book.titulo}</td>
            <td>${book.autor}</td>
            <td>${book.genero}</td>
            <td class="text-warning">${stars}</td>
        `;
        this.compareTbody.appendChild(tr);
    }
    
    filterBooks(query) {
        const lowerCaseQuery = query.toLowerCase();
        const filteredBooks = this.allBooks.filter(book => {
            return book.titulo.toLowerCase().includes(lowerCaseQuery) || 
                   book.autor.toLowerCase().includes(lowerCaseQuery);
        });
        this.renderBooks(filteredBooks);
    }

    // ===================
    // Métodos de Mensajes
    // ===================

    loadMessages() {
        fetch('php/list_messages.php')
            .then(res => res.json())
            .then(messages => {
                this.messageWall.innerHTML = '';
                if (messages.length === 0) {
                    this.messageWall.innerHTML = '<div class="alert alert-secondary">Aún no hay mensajes. ¡Sé el primero!</div>';
                    return;
                }
                messages.forEach(msg => this.renderMessage(msg));
            })
            .catch(err => console.error('Error al cargar mensajes:', err));
    }

    renderMessage(message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = 'card shadow-sm';
        messageDiv.setAttribute('data-message-id', message.id);

        const formattedDate = new Date(message.fecha_envio).toLocaleString();

        let buttons = '';
        if (message.is_owner) {
            buttons = `
                <div>
                    <button class="btn btn-sm btn-outline-primary me-2" onclick="pageManager.editMessage(this)">Editar</button>
                    <button class="btn btn-sm btn-outline-danger" onclick="pageManager.deleteMessage(${message.id})">Eliminar</button>
                </div>
            `;
        }

        messageDiv.innerHTML = `
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="card-text">${message.mensaje}</p>
                        <small class="text-muted">Enviado por <strong>${message.username}</strong> el ${formattedDate}</small>
                    </div>
                    ${buttons}
                </div>
            </div>
        `;
        this.messageWall.appendChild(messageDiv);
    }

    handleMessageSubmit(e) {
        e.preventDefault();
        const textarea = this.contactForm.querySelector('textarea[name="mensaje"]');
        const message = textarea.value;

        if (!message.trim()) {
            alert('El mensaje no puede estar vacío.');
            return;
        }

        fetch('php/save_message.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ mensaje: message })
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                textarea.value = '';
                this.loadMessages();
            } else {
                alert(response.error || 'No se pudo enviar el mensaje.');
            }
        })
        .catch(err => console.error('Error al enviar mensaje:', err));
    }

    deleteMessage(messageId) {
        if (!confirm('¿Estás seguro de que deseas eliminar este mensaje?')) return;

        fetch('php/delete_message.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: messageId })
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                this.loadMessages();
            } else {
                alert(response.error || 'No se pudo eliminar el mensaje.');
            }
        })
        .catch(err => console.error('Error al eliminar mensaje:', err));
    }
    
    editMessage(button) {
        const cardBody = button.closest('.card-body');
        const messageId = cardBody.closest('.card').dataset.messageId;
        const p = cardBody.querySelector('p');
        const currentText = p.textContent;

        cardBody.innerHTML = `
            <textarea class="form-control mb-2">${currentText}</textarea>
            <button class="btn btn-sm btn-success me-2" onclick="pageManager.saveEdit(${messageId})">Guardar</button>
            <button class="btn btn-sm btn-secondary" onclick="pageManager.loadMessages()">Cancelar</button>
        `;
    }

    saveEdit(messageId) {
        const cardBody = document.querySelector(`[data-message-id='${messageId}'] .card-body`);
        const newText = cardBody.querySelector('textarea').value;

        fetch('php/update_message.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: messageId, mensaje: newText })
        })
        .then(res => res.json())
        .then(response => {
            if (response.success) {
                this.loadMessages();
            } else {
                alert(response.error || 'No se pudo actualizar el mensaje.');
            }
        })
        .catch(err => console.error('Error al actualizar mensaje:', err));
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Exponer la instancia para que los onclick en el HTML puedan acceder a ella
    window.pageManager = new PageManager();
});