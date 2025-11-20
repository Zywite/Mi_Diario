<?php
require_once 'conex.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

// 1. Validar datos
if (!isset($data['username']) || !isset($data['email']) || !isset($data['password']) || empty($data['username']) || empty($data['email']) || empty($data['password'])) {
    echo json_encode(['success' => false, 'error' => 'Todos los campos son obligatorios.']);
    exit;
}

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'El formato del email no es válido.']);
    exit;
}

$username = $data['username'];
$email = $data['email'];
// Per spec, use MD5. For modern applications, password_hash() is strongly recommended.
$password_md5 = md5($data['password']);

try {
    // 2. Verificar si el usuario o email ya existen
    $sql_check = "SELECT id FROM users WHERE username = ? OR email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $username, $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo json_encode(['success' => false, 'error' => 'El nombre de usuario o el email ya están en uso.']);
        $stmt_check->close();
        $conn->close();
        exit;
    }
    $stmt_check->close();

    // 3. Insertar nuevo usuario
    $sql_insert = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sss", $username, $email, $password_md5);

    if ($stmt_insert->execute()) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception("Error al registrar el usuario.");
    }

    $stmt_insert->close();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    $conn->close();
}
?>
