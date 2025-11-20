/**
 * main.js
 * 
 * Archivo principal con jQuery para funcionalidades globales
 * Este archivo se ejecuta en todas las páginas que usan header.php
 * 
 * jQuery Framework: Simplifica manipulación del DOM, eventos y AJAX
 * Documentación: https://jquery.com/
 */

$(document).ready(function() {
    console.log('jQuery: main.js cargado correctamente');

    /**
     * FUNCIONALIDAD 1: Animaciones suaves al hacer scroll
     * jQuery: Detecta cuando el usuario scrollea y anima elementos
     */
    initSmoothScroll();

    /**
     * FUNCIONALIDAD 2: Cerrar mensajes de alerta con animación
     * jQuery: Permite cerrar alertas con efecto fadeOut
     */
    initAlertDismiss();

    /**
     * FUNCIONALIDAD 3: Agregar feedback visual a botones
     * jQuery: Efectos visuales en clics
     */
    initButtonEffects();

    /**
     * FUNCIONALIDAD 4: Manejo de tooltips y popovers
     * jQuery: Inicializa tooltips de Bootstrap
     */
    initTooltips();
});

/**
 * Función: Scroll suave para enlaces internos
 * jQuery: Captura clics en enlaces y anima el scroll
 */
function initSmoothScroll() {
    console.log('jQuery: Inicializando smooth scroll');

    $('a[href^="#"]').on('click', function(e) {
        e.preventDefault();

        const target = $(this).attr('href');
        const targetElement = $(target);

        if (targetElement.length) {
            // jQuery: Animar scroll a la posición del elemento
            $('html, body').animate({
                scrollTop: targetElement.offset().top - 100
            }, 800, 'easeInOutQuad');

            console.log('jQuery: Scroll animado a:', target);
        }
    });
}

/**
 * Función: Permitir cerrar alertas Bootstrap con jQuery
 * jQuery: Detecta botones de cierre y anima el desvanecimiento
 */
function initAlertDismiss() {
    console.log('jQuery: Inicializando cierre de alertas');

    // jQuery: Selectores para alertas con botón de cierre
    $('.alert .close, .alert [data-dismiss="alert"]').on('click', function() {
        console.log('jQuery: Cerrando alerta con animación');

        // jQuery: Animar desvanecimiento
        $(this).closest('.alert').fadeOut('slow', function() {
            $(this).remove();
        });
    });
}

/**
 * Función: Efectos visuales en botones
 * jQuery: Feedback al usuario cuando hace clic
 */
function initButtonEffects() {
    console.log('jQuery: Inicializando efectos de botones');

    $('button').on('click', function() {
        const button = $(this);

        // jQuery: Cambiar opacidad temporalmente
        button.css('opacity', '0.7');
        setTimeout(function() {
            button.css('opacity', '1');
        }, 200);

        console.log('jQuery: Efecto visual en botón');
    });
}

/**
 * Función: Inicializar tooltips de Bootstrap
 * jQuery: Activa tooltips automáticamente
 */
function initTooltips() {
    console.log('jQuery: Inicializando tooltips');

    // jQuery: Selectores para elementos con data-bs-toggle="tooltip"
    $('[data-bs-toggle="tooltip"]').each(function() {
        new bootstrap.Tooltip(this);
    });
}

/**
 * FUNCIÓN HELPER: Mostrar notificación flotante
 * jQuery: Crea un elemento de notificación temporal
 * 
 * @param {string} message - Mensaje a mostrar
 * @param {string} type - Tipo de notificación (success, danger, warning, info)
 */
function showNotification(message, type = 'info') {
    console.log('jQuery: Mostrando notificación:', message);

    const alertClass = `alert-${type}`;

    // jQuery: Crear elemento de alerta dinámicamente
    const alertHTML = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
             role="alert" style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;

    // jQuery: Insertar en el DOM y animar
    $(alertHTML)
        .appendTo('body')
        .fadeIn()
        .delay(5000)
        .fadeOut('slow', function() {
            $(this).remove();
        });
}

/**
 * FUNCIÓN HELPER: Hacer una petición AJAX con jQuery
 * jQuery: Wrapper para $.ajax() con manejo común de errores
 * 
 * @param {string} url - URL del endpoint
 * @param {object} data - Datos a enviar
 * @param {function} successCallback - Callback en caso de éxito
 */
function makeAjaxRequest(url, data, successCallback) {
    console.log('jQuery: AJAX a', url, 'con datos:', data);

    $.ajax({
        url: url,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        dataType: 'json',
        success: function(response) {
            console.log('jQuery: AJAX exitoso, respuesta:', response);
            if (successCallback) {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            console.error('jQuery: AJAX error:', error);
            showNotification('Error en la solicitud. Intenta de nuevo.', 'danger');
        }
    });
}

/**
 * FUNCIÓN HELPER: Validar campos de formulario
 * jQuery: Valida campos comunes (email, password, etc.)
 * 
 * @param {string} selector - Selector jQuery del campo
 * @param {string} type - Tipo de validación (email, password, etc.)
 * @returns {boolean} true si es válido, false si no
 */
function validateField(selector, type) {
    console.log('jQuery: Validando campo:', selector, 'tipo:', type);

    const field = $(selector);
    const value = field.val().trim();

    let isValid = false;

    switch(type) {
        case 'email':
            isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
            break;
        case 'password':
            isValid = value.length >= 6;
            break;
        case 'username':
            isValid = value.length >= 3;
            break;
        case 'required':
            isValid = value.length > 0;
            break;
        default:
            isValid = true;
    }

    // jQuery: Añadir o remover clase de validación
    if (isValid) {
        field.removeClass('is-invalid').addClass('is-valid');
    } else {
        field.removeClass('is-valid').addClass('is-invalid');
    }

    console.log('jQuery: Campo válido:', isValid);
    return isValid;
}

/**
 * Exportar funciones para uso global
 * Estos helpers se pueden usar en cualquier página que cargue main.js
 */
window.jQueryHelpers = {
    showNotification,
    makeAjaxRequest,
    validateField
};

console.log('jQuery: Helpers globales registrados en window.jQueryHelpers');
