<?php
require_once 'conex.php';

// Recibir datos del formulario
$data = json_decode(file_get_contents('php://input'), true);

// Preparar la consulta SQL
$sql = "INSERT INTO books (titulo, autor, genero, imagen, calificacion) VALUES (?, ?, ?, ?, ?)";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", 
        $data['titulo'],
        $data['autor'],
        $data['genero'],
        $data['imagen'],
        $data['calificacion']
    );

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Libro guardado exitosamente"
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