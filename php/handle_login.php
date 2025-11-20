<?php
session_start();

require_once 'conex.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

// 1. Validar datos
if (!isset($data['email']) || !isset($data['password']) || empty($data['email']) || empty($data['password'])) {
    echo json_encode(['success' => false, 'error' => 'Todos los campos son obligatorios.']);
    exit;
}

$email = $data['email'];
// Per spec, use MD5. For modern applications, password_verify() with hashes from password_hash() is strongly recommended.
$password_md5 = md5($data['password']);

try {
    // 2. Buscar usuario por email
    $sql = "SELECT id, username, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // User not found
        echo json_encode(['success' => false, 'error' => 'Email o contraseña incorrectos.']);
        exit;
    }

    $user = $result->fetch_assoc();

    // 3. Verificar contraseña
    if ($password_md5 === $user['password']) {
        // Contraseña correcta, iniciar sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        
        echo json_encode(['success' => true]);
    } else {
        // Contraseña incorrecta
        echo json_encode(['success' => false, 'error' => 'Email o contraseña incorrectos.']);
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
