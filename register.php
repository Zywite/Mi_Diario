<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Mi Diario de Lectura</title>
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
                        <h1 class="h3 mb-0">Registro de Usuario</h1>
                    </div>
                    <div class="card-body">
                        <form id="register-form">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                                <small class="form-text text-muted">Mínimo 3 caracteres</small>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <small class="form-text text-muted">Mínimo 6 caracteres</small>
                            </div>
                            <div id="error-message" class="alert alert-danger d-none"></div>
                            <div id="success-message" class="alert alert-success d-none"></div>
                            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">¿Ya tienes una cuenta? <a href="login.php">Inicia Sesión</a></p>
                        <p class="mt-2"><a href="index.php">Volver al inicio</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script de Registro con jQuery -->
    <script>
        /**
         * Script de Registro usando jQuery Framework
         * 
         * Beneficios de jQuery vs Vanilla JavaScript:
         * 1. Código más limpio y legible
         * 2. Selectores CSS más potentes
         * 3. Métodos de animación (fadeIn, fadeOut, etc.)
         * 4. $.ajax() más simple que fetch
         * 5. Encadenamiento de métodos (method chaining)
         */

        $(document).ready(function() {
            console.log('jQuery: Inicializando formulario de registro');

            /**
             * Evento submit del formulario de registro
             * jQuery: .on('submit') captura el evento
             */
            $('#register-form').on('submit', function(e) {
                e.preventDefault();
                console.log('jQuery: Evento submit del formulario capturado');

                // jQuery: Obtener valores de los campos de forma simplificada
                const username = $('#username').val().trim();
                const email = $('#email').val().trim();
                const password = $('#password').val();
                const errorMessage = $('#error-message');
                const successMessage = $('#success-message');

                console.log('jQuery: Datos del formulario:', { username, email });

                // Validación básica en el cliente
                if (username.length < 3) {
                    console.log('jQuery: Username muy corto');
                    errorMessage.text('❌ El nombre de usuario debe tener al menos 3 caracteres');
                    errorMessage.removeClass('d-none').fadeIn();
                    return;
                }

                if (password.length < 6) {
                    console.log('jQuery: Password muy corta');
                    errorMessage.text('❌ La contraseña debe tener al menos 6 caracteres');
                    errorMessage.removeClass('d-none').fadeIn();
                    return;
                }

                // Preparar datos para enviar
                const data = {
                    username: username,
                    email: email,
                    password: password
                };

                /**
                 * $.ajax() - Alternativa moderna a fetch
                 * jQuery: Maneja automáticamente JSON
                 */
                $.ajax({
                    url: 'php/handle_register.php',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    dataType: 'json',
                    success: function(response) {
                        console.log('jQuery: Respuesta exitosa del servidor:', response);

                        if (response.success) {
                            // jQuery: Ocultar error y mostrar éxito con animación
                            errorMessage.fadeOut();
                            successMessage.text('✅ ¡Registro exitoso! Redirigiendo a login...');
                            successMessage.removeClass('d-none').fadeIn();

                            // jQuery: delay() para esperar antes de redirigir
                            setTimeout(function() {
                                window.location.href = 'login.php';
                            }, 2000);
                        } else {
                            // jQuery: Mostrar mensaje de error con animación
                            console.log('jQuery: Error en respuesta:', response.error);
                            errorMessage.text('❌ ' + (response.error || 'Ocurrió un error desconocido.'));
                            errorMessage.removeClass('d-none').fadeIn();
                            successMessage.fadeOut();
                        }
                    },
                    error: function(xhr, status, error) {
                        // jQuery: Manejar errores de red
                        console.error('jQuery: Error en AJAX:', error);
                        errorMessage.text('❌ Error de conexión. Por favor, intenta de nuevo.');
                        errorMessage.removeClass('d-none').fadeIn();
                    }
                });
            });

            /**
             * Bonus con jQuery: Limpiar mensajes cuando el usuario interactúa
             * jQuery: Listeners múltiples con selectores
             */
            $('#username, #email, #password').on('focus', function() {
                console.log('jQuery: Campo enfocado');
                errorMessage.fadeOut();
                $('#success-message').fadeOut();
            });

            /**
             * Bonus: Validación en tiempo real del username
             * jQuery: Evento 'input' para validación mientras se escribe
             */
            $('#username').on('input', function() {
                const value = $(this).val();
                if (value.length < 3 && value.length > 0) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            /**
             * Bonus: Validación en tiempo real de la contraseña
             */
            $('#password').on('input', function() {
                const value = $(this).val();
                if (value.length < 6 && value.length > 0) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
        });
    </script>

</body>
</html>
