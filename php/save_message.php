<?php
session_start();
require_once 'conex.php';

header('Content-Type: application/json');

// 1. Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Debes iniciar sesión para enviar un mensaje.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

// 2. Validar datos
if (!isset($data['mensaje']) || trim($data['mensaje']) === '') {
    echo json_encode(['success' => false, 'error' => 'El mensaje no puede estar vacío.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$mensaje = $data['mensaje'];

try {
    // 3. Insertar nuevo mensaje
    $sql = "INSERT INTO contactos (user_id, mensaje) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $mensaje);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception("Error al guardar el mensaje.");
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}
?>
