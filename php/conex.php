<?php
// Archivo de conexión a la base de datos
// NOTA: Deberás modificar estos valores con tus credenciales reales
$servername = "localhost";
$username = "root"; 
$password = "";      
$dbname = "mi_diario_lectura";

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