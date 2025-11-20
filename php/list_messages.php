<?php
session_start();
require_once 'conex.php';

header('Content-Type: application/json');

$logged_in_user_id = $_SESSION['user_id'] ?? null;

try {
    // Consulta para obtener mensajes, uniendo con la tabla de usuarios para obtener el nombre de usuario.
    $sql = "SELECT m.id, m.mensaje, m.fecha_envio, m.user_id, u.username 
            FROM contactos m
            JOIN users u ON m.user_id = u.id
            ORDER BY m.fecha_envio DESC";
    
    $result = $conn->query($sql);
    
    if ($result === false) {
        throw new Exception($conn->error);
    }
    
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        // Añadir un campo booleano para saber si el usuario logueado es el dueño del mensaje
        $is_owner = ($logged_in_user_id !== null && $row['user_id'] == $logged_in_user_id);

        $messages[] = [
            'id' => $row['id'],
            'mensaje' => htmlspecialchars($row['mensaje']),
            'fecha_envio' => $row['fecha_envio'],
            'user_id' => $row['user_id'],
            'username' => htmlspecialchars($row['username']),
            'is_owner' => $is_owner
        ];
    }
    
    echo json_encode($messages);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
} finally {
    if (isset($result)) {
        $result->close();
    }
    $conn->close();
}
?>
