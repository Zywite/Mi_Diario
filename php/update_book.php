<?php
require_once 'conex.php';

// Recibir datos del formulario
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    echo json_encode([
        "success" => false,
        "error" => "No se proporcionó el ID del libro"
    ]);
    exit;
}

// Preparar la consulta SQL
$sql = "UPDATE books SET titulo = ?, autor = ?, genero = ?, imagen = ?, calificacion = ? WHERE id = ?";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", 
        $data['titulo'],
        $data['autor'],
        $data['genero'],
        $data['imagen'],
        $data['calificacion'],
        $data['id']
    );

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Libro actualizado exitosamente"
        ]);
    } else {
        throw new Exception($conn->error);
    }

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}
?>