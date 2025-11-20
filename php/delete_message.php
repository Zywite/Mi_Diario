<?php
session_start();
require_once 'conex.php';

header('Content-Type: application/json');

// 1. Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'No tienes permiso para realizar esta acción.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

// 2. Validar datos
if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'error' => 'No se proporcionó el ID del mensaje.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$message_id = $data['id'];

try {
    // 3. Intentar eliminar el mensaje, asegurando que el user_id coincida
    // Esta es la comprobación de propiedad clave.
    $sql = "DELETE FROM contactos WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $message_id, $user_id);

    $stmt->execute();

    // 4. Verificar si la eliminación fue exitosa
    if ($stmt->affected_rows > 0) {
        // Se eliminó una fila, lo que significa que el usuario era el propietario
        echo json_encode(['success' => true]);
    } else {
        // No se eliminó ninguna fila, ya sea porque el mensaje no existe o porque el usuario no es el propietario
        echo json_encode(['success' => false, 'error' => 'No tienes permiso para eliminar este mensaje.']);
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
