<?php
require_once 'conex.php';

try {
    // Consulta para obtener todos los libros
    $sql = "SELECT * FROM books ORDER BY id DESC";
    $result = $conn->query($sql);
    
    if ($result === false) {
        throw new Exception($conn->error);
    }
    
    $books = [];
    while ($row = $result->fetch_assoc()) {
        $books[] = [
            'id' => $row['id'],
            'titulo' => $row['titulo'],
            'autor' => $row['autor'],
            'genero' => $row['genero'],
            'imagen' => $row['imagen'],
            'calificacion' => (int)$row['calificacion']
        ];
    }
    
    // Devolver los libros en formato JSON
    header('Content-Type: application/json');
    echo json_encode($books);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
} finally {
    if (isset($result)) {
        $result->close();
    }
    $conn->close();
}
?>