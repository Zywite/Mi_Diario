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
if (!isset($data['id']) || !isset($data['mensaje']) || trim($data['mensaje']) === '') {
    echo json_encode(['success' => false, 'error' => 'Datos incompletos o mensaje vacío.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$message_id = $data['id'];
$new_mensaje = $data['mensaje'];

try {
    // 3. Intentar actualizar el mensaje, asegurando que el user_id coincida
    $sql = "UPDATE contactos SET mensaje = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $new_mensaje, $message_id, $user_id);

    $stmt->execute();

    // 4. Verificar si la actualización fue exitosa
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        // Si no se afectaron filas, puede ser porque el texto no cambió, o porque el usuario no es el propietario.
        // Para simplificar, devolveremos éxito si el mensaje existe y pertenece al usuario, incluso si el texto no cambió.
        $check_sql = "SELECT id FROM contactos WHERE id = ? AND user_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ii", $message_id, $user_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        if ($check_result->num_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'No se detectaron cambios.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'No tienes permiso para editar este mensaje.']);
        }
        $check_stmt->close();
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
