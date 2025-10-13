<?php
// Archivo de ejemplo para la conexión a la base de datos
// Copia este archivo como conex.php y ajusta los valores

$servername = "localhost";     // Tu servidor de base de datos
$username = "tu_usuario";      // Tu usuario de MySQL
$password = "tu_password";     // Tu contraseña de MySQL
$dbname = "mi_diario_lectura"; // Nombre de tu base de datos

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Verificar conexión
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    // Establecer charset
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>