<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mi Diario de Lectura</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/common.css">
    <!-- jQuery Framework: Simplifica manipulación del DOM y eventos -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h1 class="h3 mb-0">Iniciar Sesión</h1>
                    </div>
                    <div class="card-body">
                        <form id="login-form">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div id="error-message" class="alert alert-danger d-none"></div>
                            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">¿No tienes una cuenta? <a href="register.php">Regístrate</a></p>
                        <p class="mt-2"><a href="index.php">Volver al inicio</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script de Login con jQuery -->
    <script>
        /**
         * Script de Login usando jQuery Framework
         * 
         * jQuery simplifica:
         * - Selección de elementos: $('#login-form') en lugar de document.getElementById()
         * - Manejo de eventos: .on() en lugar de addEventListener()
         * - Manipulación del DOM: .val(), .fadeOut(), .addClass(), etc.
         * - AJAX: $.ajax() como alternativa a fetch (más legible)
         */

        $(document).ready(function() {
            console.log('jQuery: Inicializando formulario de login');

            /**
             * Evento submit del formulario de login
             * jQuery: Usa .on('submit') para capturar el evento
             */
            $('#login-form').on('submit', function(e) {
                e.preventDefault();
                console.log('jQuery: Evento submit del formulario capturado');

                // jQuery: Obtener datos del formulario de forma simplificada
                const email = $('#email').val();
                const password = $('#password').val();
                const errorMessage = $('#error-message');

                console.log('jQuery: Email ingresado:', email);

                // Preparar datos para enviar
                const data = {
                    email: email,
                    password: password
                };

                /**
                 * AJAX con jQuery: Alternativa a fetch()
                 * jQuery.ajax() es más legible y automáticamente parsea JSON
                 */
                $.ajax({
                    url: 'php/handle_login.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: 'json',
                    success: function(response) {
                        console.log('jQuery: Respuesta exitosa del servidor:', response);

                        if (response.success) {
                            // jQuery: Mostrar mensaje de éxito con fadeOut
                            errorMessage.addClass('alert-success').removeClass('alert-danger');
                            errorMessage.text('¡Login exitoso! Redirigiendo...');
                            errorMessage.removeClass('d-none').fadeIn();

                            // Redirigir después de 1 segundo
                            setTimeout(function() {
                                window.location.href = 'index.php';
                            }, 1000);
                        } else {
                            // jQuery: Mostrar mensaje de error
                            console.log('jQuery: Error en respuesta:', response.error);
                            errorMessage.text(response.error || 'Ocurrió un error desconocido.');
                            errorMessage.removeClass('d-none').fadeIn();
                        }
                    },
                    error: function(xhr, status, error) {
                        // jQuery: Manejar errores de conexión
                        console.error('jQuery: Error en AJAX:', error);
                        errorMessage.text('Error de conexión. Por favor, intenta de nuevo.');
                        errorMessage.removeClass('d-none').fadeIn();
                    }
                });
            });

            /**
             * Bonus con jQuery: Limpiar mensaje de error cuando el usuario empieza a escribir
             * jQuery: Listeners adicionales para mejorar UX
             */
            $('#email, #password').on('focus', function() {
                console.log('jQuery: Campo enfocado, limpiando mensajes de error');
                $('#error-message').fadeOut();
            });
        });
    </script>

</body>
</html>
