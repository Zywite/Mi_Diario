<?php
require_once 'conex.php';

// Recibir datos del formulario
$nombre = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$mensaje = $_POST['mensaje'] ?? '';

if (empty($nombre) || empty($email) || empty($mensaje)) {
    die('Por favor, complete todos los campos');
}

// Preparar la consulta SQL
$sql = "INSERT INTO contactos (nombre, email, mensaje) VALUES (?, ?, ?)";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $mensaje);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>
                alert('Mensaje enviado exitosamente');
                window.location.href = '../index.php';
              </script>";
    } else {
        throw new Exception($conn->error);
    }

} catch (Exception $e) {
    echo "<script>
            alert('Error al enviar el mensaje: " . addslashes($e->getMessage()) . "');
            window.location.href = '../index.php';
          </script>";
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}
?>